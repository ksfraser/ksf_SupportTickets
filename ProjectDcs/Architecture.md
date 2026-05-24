# Architecture - ksf_SupportTickets

## Document Information
- **Module**: ksf_SupportTickets
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Proposed

## 1. Directory Structure

```
ksf_SupportTickets/
├── src/Ksfraser/SupportTickets/
│   ├── TicketService.php
│   ├── Contract/
│   │   ├── TicketRepositoryInterface.php
│   │   └── SLACalculatorInterface.php
│   ├── Entity/
│   │   ├── Ticket.php
│   │   ├── TicketComment.php
│   │   ├── Queue.php
│   │   └── TicketAttachment.php
│   ├── Event/
│   │   ├── TicketCreatedEvent.php
│   │   ├── TicketUpdatedEvent.php
│   │   └── TicketEscalationEvent.php
│   └── Exception/
└── composer.json
```

## 2. Core Design

### Ticket Entity
```php
class Ticket {
    private string $id;
    private string $ticketNumber;  // TKT-XXXX format
    private string $subject;
    private ?string $customerId;
    private Priority $priority;
    private Status $status;
    private ?string $assignedTo;
    private ?DateTime $slaResponseDue;
    private ?DateTime $slaResolutionDue;
}
```

### Status Workflow
```
New → Open → Pending → Resolved → Closed
         ↓        ↑
         └────────┘
      (On Hold)
```

## 3. Integration Points

| Module | Integration |
|--------|-------------|
| ksf_CRM | Customer linking, timeline |
| ksf_Workflow | Escalation automation |
| ksf_EmailManager | Email notifications |
| ksf_Calendar | Meeting scheduling |

## 4. Composer Dependencies

| Package | Version |
|---------|---------|
| ksfraser/exceptions | ^1.3 |
| psr/event-dispatcher | ^2.0 |

---

## 5. RBAC Integration (ksfraser/rbac)

### 5.1 Module Registration

ksf_SupportTickets registers with ksfraser/rbac:
- record_types: 'ticket', 'ticket_comment', 'ticket_attachment'
- projections: 'public' (ticket_number, subject, status, priority, created_at), 'full' (all fields including internal notes, SLA data, customer data)
- allow_invite: false
- children: ticket_comment, ticket_attachment (child of ticket)

### 5.2 Entity Projections

| Entity | PUBLIC Fields | FULL Fields |
|--------|---------------|-------------|
| Ticket | ticket_number, subject, status, priority, created_at, customer_id | + assigned_to, sla_response_due, sla_resolution_due, internal_notes, escalation_history |
| TicketComment | author, created_at, visibility (public) | All fields including internal-only comments |
| TicketAttachment | filename, uploaded_by, created_at | All fields including file_path |

### 5.3 Access Model

- **Support Agent**: FULL access to assigned tickets, can edit/update status
- **Support Manager**: FULL access to all tickets, SLA monitoring, assignment management
- **Customer (via portal)**: PUBLIC to own tickets (view only), can add public comments
- **Sales/Account Manager**: PUBLIC view of linked customer's tickets

### 5.4 SQL Enforcement

All ticket-fetching queries MUST JOIN against 0_rbac_record_access:
```sql
JOIN 0_rbac_record_access ra
  ON ra.record_id    = t.id
 AND ra.record_type  = 'ticket'
 AND ra.module       = 'support_tickets'
 AND ra.inactive     = 0
 AND ra.can_view     = 1
JOIN 0_rbac_team_members tm
  ON tm.team_id  = ra.team_id
 AND tm.user_id  = :currentUserId
 AND tm.inactive = 0
```

### 5.5 Access Inheritance

When a team is granted access to a ticket:
- Access cascades to ticket_comments (inherit parent caps)
- Access cascades to ticket_attachments (inherit parent caps)
- Comments with visibility='internal' require FULL projection to view

### 5.6 Soft Delete

- Tickets use soft delete: `deleted = 1`, `deleted_by`, `deleted_at`
- Hard delete is super-admin only
- Deleted ticket records have visibility gated by can_view_deleted type-level permission

### 5.7 CRM Integration

Support tickets linked to customers (via customer_id) may inherit visibility from the parent CRM Customer record as a module-specific business rule. This is NOT automatic RBAC inheritance — it's implemented as a query-level rule in TicketRepository.

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-24*