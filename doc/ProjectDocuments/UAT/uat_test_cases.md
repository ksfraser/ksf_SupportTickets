# ksf_SupportTickets - UAT Test Cases

## Test Setup
- FA installed with modules: FA_CRM, FA_SupportTickets, FA_ProjectManagement
- Test user with SA_CRM permissions

---

## TC-001: Create New Support Ticket

**Preconditions**: User logged in with ST_MANAGE_TICKET permission

**Steps**:
1. Navigate to Support → All Tickets
2. Click "Create Ticket" button
3. Fill in Subject: "Cannot login to portal"
4. Select Type: "Issue"
5. Select Priority: "High"
6. Select Account: "Test Customer Inc"
7. Fill in Description: "Customer reports error when logging in"
8. Click "Create Ticket"

**Expected Result**:
- Ticket created with number TKT-YYYYMMDD-XXXXXX
- Ticket appears in list with status "New"
- Success notification displayed

---

## TC-002: Update Ticket Priority

**Preconditions**: Ticket exists with ID #1

**Steps**:
1. Find ticket in list
2. Click Edit button
3. Change Priority to "Critical"
4. Click "Update"

**Expected Result**:
- Priority changed to "Critical"
- Updated in list view

---

## TC-003: Log Activity Against Ticket

**Preconditions**: Ticket #1 exists

**Steps**:
1. Open ticket #1
2. Click "Add Activity"
3. Select Type: "Call"
4. Enter Subject: "Follow up call"
5. Enter Duration: "15" minutes
6. Click "Save Activity"

**Expected Result**:
- Activity appears in ticket activities list
- Activity synced to calendar (if module active)

---

## TC-004: Add Note to Ticket

**Preconditions**: Ticket #1 exists

**Steps**:
1. Open ticket #1
2. Click "Add Note"
3. Enter Note: "Customer called, issue resolved"
4. Select Type: "Resolution"
5. Click "Save Note"

**Expected Result**:
- Note appears in notes section

---

## TC-005: Close Ticket with Resolution

**Preconditions**: Ticket #1 exists, activities logged

**Steps**:
1. Open ticket #1
2. Change Status to "Resolved"
3. Enter Resolution note
4. Click "Close Ticket"

**Expected Result**:
- State changed to "Closed"
- Status changed to "Resolved"
- Resolution note saved

---

## TC-006: Link Ticket to Project

**Preconditions**: Ticket #1 exists, FA_PM module installed

**Steps**:
1. Open ticket #1
2. Click "Link Project"
3. Create new project or select existing

**Expected Result**:
- project_id populated in ticket
- Project appears linked in ticket view

---

## TC-007: Add Billable Item to Ticket

**Preconditions**: Ticket #1 exists

**Steps**:
1. Open ticket #1
2. Click "Add Item"
3. Select Type: "Labor"
4. Enter Description: "Support call"
5. Enter Quantity: "1"
6. Enter Unit Price: "75.00"
7. Click "Save"

**Expected Result**:
- Line item added
- Total calculated (75.00)

---

## TC-008: Integrate Warranty with Ticket

**Preconditions**: Warranty #1 exists, Ticket #1 exists

**Steps**:
1. Open ticket #1
2. Enter Warranty ID: "1"
3. Click "Link Warranty"

**Expected Result**:
- warranty_id populated
- Warranty details appear in ticket

---

## TC-009: View Ticket Activities in Calendar

**Preconditions**: Ticket #1 with activity, FA_Calendar installed

**Steps**:
1. Navigate to Calendar
2. Filter by tickets

**Expected Result**:
- Activities appear as calendar events
- Filterable by ticket

---

## TC-010: PSR-14 Event Reception

**Preconditions**: Custom module listening for events

**Steps**:
1. Create ticket #2
2. Observe event emission

**Expected Result**:
- Event "ticket.created" dispatched
- Custom listener can receive event data