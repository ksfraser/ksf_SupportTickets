# ksf_SupportTickets - Requirements

## Project Overview

**Name**: ksf_SupportTickets (ksfraser/ksf-supporttickets)
**Type**: Composer-installable PHP library / FrontAccounting Support Tickets module
**Purpose**: Support ticket/case management system similar to SuiteCRM Cases, iTop Incidents

---

## 1. Scope

### 1.1 Core Entities
- **SupportTicket**: Main ticket with number, subject, description, type, state, status, priority
- **TicketActivity**: Activities linked to tickets (Email, Call, Text, Task, Meeting, Note)
- **TicketNote**: Notes on tickets (General, Internal, Resolution)
- **TicketItem**: Line items for billing (Product, Service, Parts, Labor, Travel)

### 1.2 Relationships
- Ticket → Account (debtor_no via FA debtors)
- Ticket → Contact (fa_crm_contacts)
- Ticket → Warranty (via ksf_WarrantyManagement)
- Ticket → Invoice (FA sales invoice)
- Ticket → Project (optional mini-project via ksf_FA_ProjectManagement)
- Activity → Ticket (many-to-one)
- Note → Ticket (many-to-one)
- Item → Ticket (many-to-one)

### 1.3 Business Logic
- Ticket number auto-generation (TKT-YYYYMMDD-XXXXXX)
- State transitions (Open ↔ Closed)
- Status workflow (New → InProgress → Waiting → Resolved → Closed)
- Priority levels (Low, Medium, High, Critical)
- Type classification (Question, Issue, Request, Bug)
- Assign to employee/team
- Link to warranty claims
- Activity logging (calendar events)
- Billable items tracking

---

## 2. Functional Requirements

### 2.1 Ticket Management
- [ ] Create new ticket with auto-generated number
- [ ] Update ticket details (subject, description, priority, status, type)
- [ ] Assign ticket to employee
- [ ] Assign ticket to team
- [ ] Link to account (debtor)
- [ ] Link to contact
- [ ] Link to warranty
- [ ] Link to invoice
- [ ] Link to project (optional)
- [ ] Close ticket with resolution note

### 2.2 Activity Logging
- [ ] Log email activity
- [ ] Log call activity (with duration)
- [ ] Log text/SMS activity
- [ ] Log task assignment
- [ ] Log meeting
- [ ] Log general note

### 2.3 Notes
- [ ] Add general note
- [ ] Add internal note (not visible to customer)
- [ ] Add resolution note

### 2.4 Billing
- [ ] Add line item (product/service/parts/labor/travel)
- [ ] Calculate line totals
- [ ] Link item to invoice
- [ ] Generate invoice from ticket items

### 2.5 Workflow
- [ ] Email notification on ticket creation
- [ ] Email notification on assignment
- [ ] Email notification on status change
- [ ] Auto-create project on ticket close (configurable per type)
- [ ] Timesheet integration with linked project

---

## 3. Integration Requirements

### 3.1 External Modules
- ksf_FA_SupportTickets - FA module wrapper
- ksf_SupportTicketsUI - UI presenter components
- ksf_WarrantyManagement - Warranty link
- ksf_FA_ProjectManagement - Optional mini-project
- ksf_FA_Calendar - Activity calendar view/filter
- ksf_FA_CRM - Account/contact integration

### 3.2 Events (PSR-14)
- ticket.created
- ticket.updated  
- ticket.deleted
- ticket.closed

### 3.3 Database Hooks
- db_postinsert (fa_st_tickets)
- db_postupdate
- db_postdelete

---

## 4. Acceptance Criteria

### 4.1 Ticket CRUD
- Can create ticket with all required fields
- Ticket number is auto-generated in format TKT-YYYYMMDD-XXXXXX
- Can update any ticket field
- Can delete ticket (with cascade to activities/notes/items)

### 4.2 Relationships
- Ticket can be linked to account
- Ticket can be linked to contact
- Ticket can be linked to warranty

### 4.3 Activities
- Can log any activity type against ticket
- Activities appear in list view
- Activities can be synced to calendar

### 4.4 Workflow
- Status can be changed
- Ticket can be closed
- Closure triggers resolution note

### 4.5 Events
- PSR-14 events dispatched on CRUD operations
- FA hooks triggered for cross-module communication