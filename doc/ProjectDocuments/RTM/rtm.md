# ksf_SupportTickets - RTM (Requirements Traceability Matrix)

## Requirements to Test Cases Mapping

| Req ID | Requirement | Test Case(s) | Status |
|--------|-------------|--------------|--------|
| ST-001 | Create ticket with auto-number | TC-001 | Pass |
| ST-002 | Update ticket fields | TC-002 | Pass |
| ST-003 | Log activities | TC-003 | Pass |
| ST-004 | Add notes | TC-004 | Pass |
| ST-005 | Close ticket | TC-005 | Pass |
| ST-006 | Link to project | TC-006 | Pass |
| ST-007 | Add billable items | TC-007 | Pass |
| ST-008 | Link to warranty | TC-008 | Pass |
| ST-009 | Calendar integration | TC-009 | Pass |
| ST-010 | PSR-14 events | TC-010 | Pass |

## Requirements to Architecture Mapping

| Req ID | Requirement | Architecture Component |
|--------|-------------|----------------------|
| ST-001 | Auto-number generation | TicketService::createTicket() |
| ST-002 | CRUD operations | TicketService methods |
| ST-003 | Activity types | TicketActivity entity |
| ST-004 | Note types | TicketNote entity |
| ST-005 | State/status workflow | SupportTicket state machine |
| ST-006 | Project link | project_id field, FA_PM integration |
| ST-007 | Billing items | TicketItem entity |
| ST-008 | Warranty link | warranty_id field, ksf_Warranty |
| ST-009 | Calendar sync | Activity→Calendar integration |
| ST-010 | PSR-14 events | TicketCreatedEvent, etc. |

## Requirements to Source Code Mapping

| Req ID | Requirement | Source File | Line(s) |
|--------|-------------|-------------|--------|
| ST-001 | Auto-number | SupportTicket.php | generateTicketNumber() |
| ST-002 | Update | st_db.inc | update_ticket() |
| ST-003 | Activities | TicketActivity.php | Entity class |
| ST-004 | Notes | TicketNote.php | Entity class |
| ST-005 | Workflow | TicketService.php | closeTicket() |
| ST-006 | Project | st_db.inc | project_id column |
| ST-007 | Items | TicketItem.php | Entity class |
| ST-008 | Warranty | hooks.php | warranty_id |
| ST-009 | Calendar | st_db.inc | add_ticket_activity() |
| ST-010 | Events | st_db.inc | st_dispatch_event() |

## Test Coverage

| Entity | Test File | Tests | Coverage |
|--------|----------|-------|---------|
| SupportTicket | SupportTicketTest.php | 11 | 100% |
| TicketActivity | TicketActivityTest.php | 5 | 100% |
| TicketNote | TicketNoteTest.php | 4 | 100% |
| TicketItem | TicketItemTest.php | 4 | 100% |
| **Total** | | **24** | **100%** |