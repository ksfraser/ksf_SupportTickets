# Use Cases - ksf_SupportTickets

## UC-ST-001: Create Support Ticket
**Actor**: Support Agent, Customer (via portal), System

**Flow**:
1. Ticket created via:
   - Manual creation by support agent
   - Customer portal submission
   - Email to support address (ksf_EmailManager)
   - Chat transcript (future)
2. System captures:
   - Subject, description
   - Customer (ksf_CRM)
   - Contact
   - Priority (auto-assigned or manual)
   - Type (Bug, Feature, Question, Complaint)
3. If linked to customer:
   - Auto-populate customer info
   - Show recent tickets, opportunities
   - Check for similar open tickets
4. System:
   - Assigns ticket ID
   - Sets status to 'New'
   - Routes to appropriate queue
   - Sets SLA timers

**Auto-assignment**:
1. System checks queue rules:
   - Type-based: Bugs → Engineering queue
   - Product-based: Product X → Team X
   - Region-based: EMEA → EMEA team
2. If round-robin: Assign to next available agent
3. Assignee notified

---

## UC-ST-002: Update Ticket Status
**Actor**: Support Agent, Customer (via portal)

**Flow**:
1. Agent opens ticket
2. Updates status:
   - New → Open (when working)
   - Open → Pending (waiting for customer/info)
   - Open → Resolved (solution provided)
   - Resolved → Closed (customer confirmed)
   - Any → On Hold
3. With status change:
   - Add comment/note
   - Update resolution details
   - Link KB article (if resolved)
4. System:
   - Logs timestamp
   - Updates SLA timers
   - Notifies relevant parties
   - Updates CRM customer timeline

---

## UC-ST-003: Ticket Escalation
**Actor**: System, Support Manager

**Trigger**: SLA breach or manual escalation

**Flow**:
1. System detects SLA violation:
   - First response time exceeded
   - Resolution time exceeded
2. System emits `ticket.escalation` event (ksf_Workflow)
3. Escalation actions:
   - Reassign to senior agent
   - Notify manager
   - Increase priority
   - Create calendar reminder
4. Manager reviews:
   - Can adjust SLA
   - Can reassign
   - Can add resources
5. Escalation logged in audit trail

---

## UC-ST-004: Link Ticket to CRM Customer
**Actor**: Support Agent, System

**Flow**:
1. When ticket created:
   - System attempts auto-match by:
     - Email domain
     - Customer ID if portal
     - Previous tickets from same email
2. Agent confirms/selects customer:
   - Links to customer record (ksf_CRM)
   - Links to contact
3. Agent sees in ticket view:
   - Customer details
   - Account manager
   - Lifetime value
   - Recent communications
   - Open opportunities
   - Previous tickets
4. Updates flow to CRM customer timeline

---

## UC-ST-005: Add Ticket Comment/Note
**Actor**: Support Agent, Customer (portal), Internal (note)

**Flow**:
1. Agent adds comment:
   - Visible to customer (if portal enabled)
   - Public reply
   - Include attachments (ksf_Documents)
2. Agent adds internal note:
   - Only visible internally
   - For collaboration
   - Flag for colleague
3. Customer adds reply:
   - Via portal
   - Via email reply (ksf_EmailManager)
4. System:
   - Posts to ticket thread
   - Updates last activity
   - Resets SLA timer if needed
   - Emails internal users of note

---

## UC-ST-006: Resolve Ticket with KB Article
**Actor**: Support Agent

**Flow**:
1. Agent identifies solution:
   - From own knowledge
   - From KB article (ksf_Notes/KnowledgeBase)
2. Agent links KB article to ticket
3. Agent marks ticket as 'Resolved'
4. Customer notified:
   - Solution provided
   - Link to KB article
   - Request for confirmation
5. If customer confirms:
   - Status → 'Closed'
6. If customer replies with issue:
   - Status → 'Open'
   - Continue troubleshooting

---

## UC-ST-007: Ticket Time Tracking
**Actor**: Support Agent

**Flow**:
1. Agent starts timer on ticket
2. Works on issue
3. Stops timer:
   - Time logged to ticket
   - Can be linked to project (ksf_ProjectManagement) if billable
4. Time entries aggregated for:
   - Reporting
   - Billing (if applicable)
   - Agent productivity

---

## UC-ST-008: Customer Portal Ticket View
**Actor**: Customer

**Preconditions**: Customer has portal access (ksf_WP_CustomerPortal)

**Flow**:
1. Customer logs into portal
2. Sees ticket list:
   - Open tickets
   - Recent tickets
   - Status
3. Can:
   - View ticket details
   - Add comments/replies
   - Upload attachments
   - View KB articles
   - Submit new ticket
4. Sees SLA status:
   - Time remaining
   - SLA breach warning
5. Receives email notifications on updates

---

## UC-ST-009: Email Integration for Tickets
**Actor**: Customer, Support Agent, System

**Flow**:
1. Customer emails support@company.com
2. System parses email (ksf_EmailManager):
   - Subject becomes ticket subject
   - Body becomes ticket description
   - Attachments linked
3. Creates new ticket or:
   - Links to existing by subject match
   - Links by ticket ID in subject
4. Auto-reply sent to customer with ticket ID
5. Agent responds via system:
   - Email sent to customer (ksf_EmailManager)
   - Appears in ticket thread
6. Customer replies:
   - Updates ticket
   - Notifies agent

---

## UC-ST-010: Bulk Ticket Actions
**Actor**: Support Manager

**Flow**:
1. Manager selects multiple tickets
2. Bulk actions:
   - Reassign to agent/queue
   - Change priority
   - Change status
   - Add tag
   - Merge tickets
3. System applies action to all selected
4. Audit log records bulk action
5. Notifications sent

---

## UC-ST-011: Ticket Reporting
**Actor**: Support Manager, Management

**Flow**:
1. Navigate to Reports > Tickets
2. Select report type:
   - Ticket volume (by day/week/month)
   - Response time average
   - Resolution time average
   - First contact resolution rate
   - Customer satisfaction
   - Agent productivity
   - SLA compliance
3. Filter by:
   - Date range
   - Queue
   - Priority
   - Type
   - Agent
   - Customer
4. Generate report
5. Export: PDF, Excel
6. Schedule recurring reports

---

## UC-ST-012: Merge Duplicate Tickets
**Actor**: Support Agent, System

**Trigger**: Agent or system detects duplicates

**Flow**:
1. Agent identifies duplicate tickets:
   - Same customer, similar issue
   - System suggestion based on:
     - Subject similarity
     - Same customer+contact
2. Agent initiates merge:
   - Selects primary ticket
   - Selects tickets to merge
3. System:
   - Combines comments from all
   - Links attachments
   - Preserves all history
   - Marks duplicates as 'Merged'
   - Closes duplicate tickets
4. Primary ticket retains:
   - Original ticket ID
   - All combined info

---

## UC-ST-013: Create KB from Resolved Ticket
**Actor**: Support Agent, Knowledge Manager

**Trigger**: Ticket resolved, KB article creation suggested

**Flow**:
1. Agent marks ticket as resolved
2. System suggests: "Create KB article?"
3. If yes:
   - Opens KB editor (ksf_Notes)
   - Pre-fills:
     - Title from ticket subject
     - Content from resolution
     - Attachments
     - Related products/types
4. Agent edits/formats article
5. Saves as draft or publishes
6. Links article to ticket
7. Future tickets can link to article

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*