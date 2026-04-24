# ksf_SupportTickets - Architecture

## Package Hierarchy

```
┌─────────────────────────────────────────────────────────────┐
│              ksf_FA_SupportTickets                        │
│              (FA module - UI, hooks, pages)               │
│                                                              │
│  hooks.php, pages/tickets.php, includes/st_db.inc          │
│  ComposerDependencyManager in vendor-src/                 │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ requires
                            ▼
┌─────────────────────────────────────────────────────────────┐
│              ksf_FA_SupportTicketsUI                      │
│              (UI Presenter components)                    │
│                                                              │
│  TicketListPresenter.php                                  │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ requires
                            ▼
┌─────────────────────────────────────────────────────────────┐
│              ksfraser/ksf-supporttickets                  │
│              (Composer package - logic)                  │
│                                                              │
│  Entity: SupportTicket, TicketActivity, TicketNote,        │
│         TicketItem                                         │
│  Service: TicketService                                    │
│  Events: TicketCreatedEvent, TicketUpdatedEvent           │
│  PSR-4, PSR-14                                            │
└─────────────────────────────────────────────────────────────┘
```

## Database Schema

### fa_st_tickets
```
id, ticket_number, subject, description,
type (Question/Issue/Request/Bug),
state (Open/Closed),
status (New/InProgress/Waiting/Resolved/Closed),
priority (Low/Medium/High/Critical),
debtor_no, contact_id, warranty_id,
assigned_to, team_id, project_id, invoice_id,
resolution, created_by, created_at, updated_at
```

### fa_st_tickets_activities
```
id, ticket_id (FK),
activity_type (Email/Call/Text/Task/Meeting/Note),
direction, subject, message,
email_from, email_to, phone_number,
duration_minutes, assigned_to,
scheduled_at, completed_at, status, created_at
```

### fa_st_tickets_notes
```
id, ticket_id (FK), note, note_type,
created_by, created_at
```

### fa_st_tickets_items
```
id, ticket_id (FK),
item_type, item_description,
quantity, unit_price, unit,
invoice_id, created_at
```

## Event Flow

```
User Action → TicketService → Entity → PSR-14 Event Dispatcher
                ↓                        ↓
           db_query()           FA_hooks → Cross-module
```

## Integration Points

| Module | Integration | Direction |
|--------|-------------|-----------|
| ksf_FA_SupportTickets | FA hooks | In |
| ksf_SupportTicketsUI | Presenter | Out |
| ksf_WarrantyManagement | warranty_id FK | Bidirectional |
| ksf_FA_ProjectManagement | project_id FK | Bidirectional |
| ksf_FA_Calendar | Activities sync | Bidirectional |
| ksf_FA_CRM | debtor_no FK | Read |