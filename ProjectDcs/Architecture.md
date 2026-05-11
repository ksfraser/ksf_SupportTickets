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

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*