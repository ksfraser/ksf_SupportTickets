# Functional Requirements - ksf_SupportTickets

## Document Information
- **Module**: ksf_SupportTickets
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Proposed
- **Author**: KSFII Development Team

## 1. Overview

### 1.1 Purpose
ksf_SupportTickets provides helpdesk and support case management with CRM integration.

### 1.2 Scope
- Ticket creation and tracking
- Customer linking
- Priority and status workflow
- SLA management
- Knowledge base integration

## 2. Core Entities

### 2.1 Ticket

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| ticket_number | string | Yes | Auto-generated (TKT-XXXX) |
| subject | string | Yes | Ticket subject |
| description | text | Yes | Issue description |
| customer_id | string | No | FK to CRM Customer |
| contact_id | string | No | FK to CRM Contact |
| priority | string | Yes | Critical/High/Medium/Low |
| status | string | Yes | New/Open/Pending/Resolved/Closed |
| type | string | Yes | Bug/Feature/Question/Complaint |
| assigned_to | string | No | Support agent user ID |
| queue_id | string | No | FK to Queue |
| resolution | text | No | Resolution description |
| sla_response_due | DateTime | No | Response SLA due |
| sla_resolution_due | DateTime | No | Resolution SLA due |
| closed_at | DateTime | No | Closure timestamp |
| created_at | DateTime | Yes | Auto |
| updated_at | DateTime | Yes | Auto |

### 2.2 TicketComment

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| ticket_id | string | Yes | FK to Ticket |
| user_id | string | Yes | Comment author |
| comment | text | Yes | Comment content |
| is_internal | bool | Yes | Internal note flag |
| created_at | DateTime | Yes | Auto |

### 2.3 Queue

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| name | string | Yes | Queue name |
| description | string | No | Description |
| assignment_type | string | Yes | manual/round_robin/skills |
| is_active | bool | Yes | Default true |

## 3. Functional Requirements

### FR-ST-001: Ticket CRUD
**Requirement**: System shall create and manage support tickets.

**Features**:
- Create ticket with subject, description
- Link to CRM customer/contact
- Set priority and type
- Auto-assign ticket number
- Update status
- Close/reopen tickets

### FR-ST-002: Ticket Assignment
**Requirement**: System shall assign tickets to agents.

**Features**:
- Manual assignment
- Round-robin distribution
- Skills-based routing
- Queue-based assignment
- Auto-assignment to queue

### FR-ST-003: Status Workflow
**Requirement**: System shall manage ticket status progression.

**Status Flow**:
- New → Open (when working)
- Open → Pending (waiting for customer)
- Open → Resolved (solution provided)
- Pending → Open (customer reply)
- Resolved → Closed (customer confirms)
- Any → On Hold

### FR-ST-004: SLA Management
**Requirement**: System shall track and enforce SLAs.

**Features**:
- First response SLA
- Resolution SLA
- SLA based on priority:
  - Critical: 1 hour response, 4 hour resolution
  - High: 4 hour response, 24 hour resolution
  - Medium: 8 hour response, 72 hour resolution
  - Low: 24 hour response, 1 week resolution
- Escalation on breach

### FR-ST-005: Ticket Threading
**Requirement**: System shall maintain ticket conversation thread.

**Features**:
- Add public comments (visible to customer)
- Add internal notes (agents only)
- Email reply integration
- Attachments
- Link KB articles

### FR-ST-006: CRM Integration
**Requirement**: System shall integrate with CRM.

**Features**:
- Link ticket to customer
- View customer history in ticket
- Show open tickets on customer page
- Update customer timeline

## 4. Integration Events (PSR-14)

| Event | Trigger |
|-------|---------|
| `ticket.created` | New ticket |
| `ticket.updated` | Ticket updated |
| `ticket.assigned` | Ticket assigned |
| `ticket.priority_changed` | Priority changed |
| `ticket.escalation` | SLA breach |
| `ticket.resolved` | Resolution provided |
| `ticket.closed` | Ticket closed |

## 5. Composer Dependencies

| Package | Version | Purpose |
|---------|---------|---------|
| ksfraser/exceptions | ^1.3 | Exception hierarchy |
| psr/event-dispatcher | ^2.0 | PSR-14 events |

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*