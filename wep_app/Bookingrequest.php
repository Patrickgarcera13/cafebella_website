<?php
require 'includes/auth_check.php';
include '../website_php/database.php';

// kunin lahat ng bookings
$stmt = $pdo->query("SELECT * FROM bookings ORDER BY id DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Request</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Plus Jakarta Sans', 'Segoe UI', Roboto, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  transition: all 0.2s ease-in-out;
}
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background: #f4f6f9;
}
:root {
  --primary: #2e7d32;
  --primary-dark: #1b5e20;
  --bg: #f5f7fa;
  --card-bg: #ffffff;
  --text: #2b2b2b;
  --subtext: #777;
  --border: #e5e7eb;
}

/******************************** SIDEBAR (PRO UI) ********************************/
.sidebar {
  width: 270px;
  height: 100vh;
  background: 
    linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
    url('IMAGES/webapppic.jpg'); 
  background-size: cover;      
  background-position: center;   
  background-repeat: no-repeat;
  display: flex;
  flex-direction: column;
  color: white;
  padding: 20px;
  position: fixed;
  left: 0;
  top: 0;
  box-shadow: 8px 0 25px rgba(0,0,0,0.15);
  z-index: 100;
  transition: all 0.3s ease;
}
.sidebar.hide {
  transform: translateX(-100%);
}

/******************************** MENU BUTTON ********************************/
.menu {
  position: relative;
  margin-top: 20px;
  padding-bottom: 15px;
  border-bottom: 2px solid white;
  z-index: 1;
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.menu button {
  width: 100%;
  padding: 12px 14px;
  border: none;
  border-radius: 12px;
  background: transparent;
  color: #e8f5e9;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.25s ease;
}
.menu button.active {
  background: linear-gradient(135deg, #66bb6a, #43a047);
  color: white;
  box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}
.menu button.active::before {
  content: "";
  position: absolute;
  left: 0;
  height: 20px;
  width: 4px;
  background: #c8facc;
  border-radius: 0 4px 4px 0;
}
.menu button:hover {
  background: rgba(255,255,255,0.08);
  transform: translateX(6px);
}
.menu button img.icon {
  width: 25px;
  height: 25px;
  object-fit: contain;
  display: block;
  filter: brightness(0) invert(1);
}
#menu-btn {
  font-size: 22px;
  background: #114500;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 8px;
  cursor: pointer;
  margin-right: 15px;
}

/*********************************** MAIN ********************************/
.main {
  margin-left: 270px;
  display: flex;
  flex-direction: column;
  height: 100vh;
  overflow: hidden;
  padding: 0;
  background: #f4f6f9;
}
.main.full {
  margin-left: 0;
}

/******************************** TOP BAR ********************************/
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #e9e9e9;
  padding: 15px 25px;
  background: #ffffff;
  box-shadow: 0 4px 10px rgba(0,0,0,0.08);
  border-bottom: 1px solid #eee;
}
.left-section {
  display: flex;
  align-items: center;
  gap: 15px;
}

/******************************** SEARCH BAR ********************************/
.search-container {
  display: flex;
  align-items: center;
  background: #f1f3f6;
  box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
  padding: 8px 15px;
  border-radius: 25px;
  width: 350px;
}

.search-container span {
  margin-right: 10px;
  font-size: 16px;
}
.search-container input {
  border: none;
  background: transparent;
  outline: none;
  width: 100%;
}

/******************************** ADMIN ********************************/
.admin {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  position: relative;
  background: white;
  padding: 8px 15px;
  border-radius: 50px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  transition: 0.3s;
}
.admin:hover {
  background: #f1f1f1;
}
.admin img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2px solid #2e7d32;
  object-fit: cover;
}
.admin-info {
  display: flex;
  flex-direction: column;
  line-height: 1.2;
}
.admin-name {
  font-size: 14px;
  font-weight: 600;
  color: #1b5e20;
}
.admin-role {
  font-size: 11px;
  color: gray;
}
.admin-header {
  display: flex;
  align-items: center;
  gap: 12px;
  padding-bottom: 18px;
  margin-bottom: 15px;
  border-bottom: 1px solid rgba(255,255,255,0.1);
}
.admin-header h2 {
  font-size: 18px;
  font-weight: 600;
}
.admin-header img {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  border: 2px solid #66bb6a;
}
.arrow {
  font-size: 12px;
  color: #555;
}
.dropdown {
  display: none;
  position: absolute;
  top: 55px;
  right: 0;
  background: white;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  overflow: hidden;
  z-index: 100;
}
.dropdown button {
  width: 160px;
  padding: 12px;
  border: none;
  background: white;
  text-align: left;
  cursor: pointer;
  font-size: 14px;
}
.dropdown button:hover {
  background: #2e7d32;
  color: white;
}

/******************************** BOOKING HEADER ********************************/
.booking-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 14px;
  padding: 20px 24px; 
  margin: 20px 25px; 
  box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
.booking-header .header-left h1 {
  font-size: 20px;
  margin: 0;
  color: #114500;
  line-height: 1.2;
}
.booking-header .header-left p {
  font-size: 13px;
  margin-top: 6px; 
  color: #6b7280;
  line-height: 1.4;
}
.booking-header .date-box {
  background: #f4f6f9;
  padding: 10px 14px; 
  border-radius: 10px;
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
  font-weight: 500;
  color: #333;
}

/******************************** CONTENT ********************************/
.content {
  display: flex;
  flex: 1;
  gap: 20px;
  overflow: hidden;
  min-height: 0; 
}
.content-wrapper{
  flex: 1;
  min-height: 0;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  padding: 0; 
}

/******************************** BOOKING TABLE  ********************************/
.booking-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0 10px;
  font-family: 'Inter', sans-serif;
}
/******************************** Table Container ********************************/
.booking-table-container {
  margin: 0 25px 25px;
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 14px;

  height: calc(100vh - 220px); /* 🔥 auto fit sa screen */
  overflow-y: auto;
  overflow-x: auto;
}

.booking-table-container::-webkit-scrollbar {
  width: 8px;
}

.booking-table-container::-webkit-scrollbar-thumb {
  background: #16a34a;
  border-radius: 10px;
}

.booking-table-container::-webkit-scrollbar-track {
  background: #f1f5f9;
}

.booking-table thead th {
  background: #16a34a;
  color: white;
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  font-weight: 600;
  padding: 14px;
  border: none;
  position: sticky;
  top: 0;
  z-index: 10;
}
.booking-table thead th i {
  margin-right: 8px;
  font-size: 12px;
  color: rgba(255,255,255,0.9);
  opacity: 0.9;
  transition: 0.2s ease;
}
.booking-table thead th:hover {
  background: linear-gradient(135deg, #22c55e, #16a34a);
  box-shadow: inset 0 -3px 0 rgba(255,255,255,0.35),
              0 6px 18px rgba(34,197,94,0.18);
  transform: translateY(-1px);
}
.booking-table thead th:hover i {
  color: #ffffff;
  transform: scale(1.05);
}
.booking-table tbody tr {
  background: #ffffff;
  border: 1px solid #e5e7eb;
}
.booking-table td {
  padding: 16px;
  font-size: 13px;
  color: #374151;
  vertical-align: middle;
}
.booking-table tbody tr td:first-child {
  border-radius: 16px 0 0 16px;
}
.booking-table tbody tr td:last-child {
  border-radius: 0 16px 16px 0;
}

/******************************** USER / CUSTOMER NAME BLOCK  ********************************/
.user {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.user strong {
  font-size: 14px;
  font-weight: 600;
  color: #111827;
}
.user .email {
  font-size: 12px;
  color: #6b7280;
  letter-spacing: 0.2px;
}
.user strong {
  font-size: 14px;
  font-weight: 600;
  color: #111827;
}

/******************************** MUTED ********************************/
.muted {
  font-size: 12px;
  color: #9ca3af;
}

/******************************** BADGE ********************************/
.badge {
  padding: 6px 12px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.badge.paid {
  background: linear-gradient(135deg, #dcfce7, #bbf7d0);
  color: #166534;
  box-shadow: 0 0 0 4px rgba(34,197,94,0.08);
}
.badge.pending {
  background: linear-gradient(135deg, #fef9c3, #fde68a);
  color: #854d0e;
  box-shadow: 0 0 0 4px rgba(250,204,21,0.10);
}
.badge.declined {
  background: linear-gradient(135deg, #fee2e2, #fecaca);
  color: #991b1b;
  box-shadow: 0 0 0 4px rgba(239,68,68,0.10);
}

/******************************** ACTIONS ********************************/
.actions {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}
.actions button {
  padding: 7px 12px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 600;
  border: none;
  cursor: pointer;
  transition: 0.2s ease;
}
.actions .accept {
  background: linear-gradient(135deg, #22c55e, #16a34a);
  color: white;
  box-shadow: 0 6px 15px rgba(34,197,94,0.25);
}
.actions .accept:hover {
  transform: scale(1.06);
  box-shadow: 0 10px 22px rgba(34,197,94,0.35);
}
.actions .decline {
  background: linear-gradient(135deg, #ef4444, #dc2626);
  color: white;
  box-shadow: 0 6px 15px rgba(239,68,68,0.25);
}
.actions .decline:hover {
  transform: scale(1.06);
  box-shadow: 0 10px 22px rgba(239,68,68,0.35);
}
.actions .view {
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  color: white;
  box-shadow: 0 6px 15px rgba(59,130,246,0.25);
}

.actions .view:hover {
  transform: scale(1.06);
  box-shadow: 0 10px 22px rgba(59,130,246,0.35);
}

/******************************** NO BOOKING ********************************/
.no-booking {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 200px; 
  color: #555;
  font-size: 16px;
  font-weight: 600;
  gap: 10px;
  border: 2px dashed #ccc;
  border-radius: 10px;
  background: #f9f9f9;
  margin-top: 20px;
}
.no-booking img {
  filter: grayscale(50%);
}

/******************************** INSIDE THE CARD ********************************/
.info-group {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px 15px;
  margin-top: 10px;
}
.full-width {
  grid-column: span 2;
}
.icon-box {
  width: 36px;
  height: 36px;
  min-width: 28px;
  background: #f5f5f5;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.icon-box img {
  width: 22px;
  height: 22px;
  object-fit: contain;
}

/******************************** MODAL ********************************/
.modal {
  display: none;
  position: fixed;
  z-index: 999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.4);
  backdrop-filter: blur(4px);
}
.modal-content {
  background: #ffffff;
  width: 460px;
  margin: 7% auto;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 25px 60px rgba(0,0,0,0.25);
}

@keyframes pop {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
.modal-header {
  padding: 16px 18px;
  background: linear-gradient(135deg, #16a34a, #22c55e);
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.modal-header h2 {
  font-size: 16px;
  font-weight: 600;
}
.modal-body {
  padding: 18px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  font-size: 13px;
  max-height: 60vh;
  overflow-y: auto;
}
.modal-body {
  padding: 18px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  font-size: 13px;
}
.modal-body .full {
  grid-column: span 2;
}
.modal-body::-webkit-scrollbar {
  width: 6px;
}
.modal-body::-webkit-scrollbar-thumb {
  background: #16a34a;
  border-radius: 10px;
}
.modal-body::-webkit-scrollbar-track {
  background: #f3f4f6;
}
.close {
  cursor: pointer;
  font-size: 22px;
}

/******************************** DETAILS ********************************/
.detail {
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  padding: 10px 12px;
  border-radius: 10px;
}
.detail label {
  display: block;
  font-size: 11px;
  color: #6b7280;
  margin-bottom: 3px;
}
.detail span {
  font-weight: 600;
  color: #111827;
}

/******************************** STATUS ********************************/
.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 600;
}
.status-pending {
  background: #fef9c3;
  color: #854d0e;
}
.status-paid {
  background: #dcfce7;
  color: #166534;
}
.status-declined {
  background: #fee2e2;
  color: #991b1b;
}
</style>
</head>
<body>
 
<!--------------------------------------- SIDEBAR ---------------------------------------------> 
    <div class="sidebar">
      <div class="admin-header">
        <img src="IMAGES/cafebella.jpg" alt="Logo">
        <h2>Hello, Admin!</h2>
      </div>

<!--------------------------------------- MENU SIDEBAR ---------------------------------------------> 
    <div class="menu">
      <button data-page="Dashboard.php"><img src="IMAGES/dashboardpic.png" class="icon">Dashboard</button>
      <button data-page="Calendar.php"><img src="IMAGES/calendaricon.png" class="icon">Calendar</button>
      <button data-page="POS.php"><img src="IMAGES/POSicon.png" class="icon">Point of Sale</button>
      <button data-page="Transactionhistory.php"><img src="IMAGES/transactionhistoryicon.png" class="icon">Transaction History</button>
      <button data-page="Bookingrequest.php"><img src="IMAGES/Bookingicon.png" class="icon">Booking Request</button>
      <button data-page="Eventmanagement.php"><img src="IMAGES/eventmanagementicon.png" class="icon">Event Management</button>
      <button data-page="Inventory.php"><img src="IMAGES/inventoryicon.png" class="icon">Inventory</button>
      <button data-page="Feedback.php"><img src="IMAGES/feedbackicon.png" class="icon">Customer Feedback</button>
      <button data-page="Settings.php"><img src="IMAGES/settingsicon.png" class="icon">Settings</button>
    </div>
    </div> 

<!--------------------------------------- MAIN ---------------------------------------------> 
    <div class="main">

<!--------------------------------------- TOPBAR ---------------------------------------------> 
    <div class="topbar">
      <div class="left-section">
        <button id="menu-btn">☰</button>
        <div class="search-container">
          <span>🔍</span>
          <input type="text" placeholder="Search ...">
        </div>
      </div>

    <div class="admin" onclick="toggleDropdown()">
      <img src="IMAGES/cafebella.jpg" alt="Admin">
      <div class="admin-info">
        <span class="admin-name">Admin</span>
        <span class="admin-role">Administrator</span>
      </div>
      <span class="arrow">▼</span>
      <div id="adminDropdown" class="dropdown">
        <button onclick="logout()">Logout</button>
      </div>
    </div>
  </div>

<div class="content-wrapper">

<!--------------------------------------- TITLE ---------------------------------------------> 
<div class="booking-header">
  <div class="header-left">
    <h1>Booking Requests</h1>
    <p>Manage and review event booking requests</p>
  </div>

  <div class="header-right">
    <div class="date-box">
      <i class="fa-solid fa-calendar"></i>
      <span id="todayDate">Today: </span>
    </div>
  </div>
</div>

<!--------------------------------------- BOOKING CONTAINER ---------------------------------------------> 
 <div class="booking-table-container">

  <table class="booking-table">

  <thead>
    <tr data-id="1">
      <th><i class="fa-solid fa-user"></i> Customer</th>
      <th><i class="fa-solid fa-calendar-check"></i> Event</th>
      <th><i class="fa-regular fa-clock"></i> Schedule</th>
      <th><i class="fa-solid fa-phone"></i> Contact</th>
      <th><i class="fa-solid fa-location-dot"></i> Location</th>
      <th><i class="fa-solid fa-credit-card"></i> Payment</th>
      <th><i class="fa-solid fa-circle-info"></i> Status</th>
      <th><i class="fa-solid fa-gear"></i> Actions</th>
    </tr>
  </thead>

    <tbody>
      <?php foreach ($bookings as $row): ?>
      <tr>
        <td>
          <div class="user">
            <strong><?= htmlspecialchars($row['full_name']) ?></strong>
            <div class="muted email"><?= htmlspecialchars($row['email']) ?></div>
          </div>
        </td>

        <td><?= htmlspecialchars($row['service_package']) ?></td>

        <td>
          <?= date("M d, Y", strtotime($row['booking_date'])) ?> • 
          <?= date("h:i A", strtotime($row['booking_time'])) ?>
        </td>

        <td><?= htmlspecialchars($row['phone']) ?></td>

          <td><?= htmlspecialchars($row['event_address']) ?>, <?= htmlspecialchars($row['province']) ?></td>


        <td><?= htmlspecialchars($row['payment_method']) ?></td>

        <td>
    <?php if ($row['status'] == 'pending'): ?>
      <span class="badge pending">Pending</span>
    <?php elseif ($row['status'] == 'approved'): ?>
      <span class="badge paid">Approved</span>
    <?php elseif ($row['status'] == 'declined'): ?>
      <span class="badge declined">Declined</span>
    <?php endif; ?>
       </td>

        <td class="actions">
          <button class="view"
          onclick="viewDetails(this)"
          data-name="<?= htmlspecialchars($row['full_name']) ?>"
          data-email="<?= htmlspecialchars($row['email']) ?>"
          data-phone="<?= htmlspecialchars($row['phone']) ?>"
          data-event="<?= htmlspecialchars($row['service_package']) ?>"
          data-date="<?= $row['booking_date'] ?>"
          data-time="<?= $row['booking_time'] ?>"
          data-guests="<?= $row['guests'] ?>"
          data-address="<?= htmlspecialchars($row['event_address']) ?>"
          data-province="<?= htmlspecialchars($row['province']) ?>"
          data-payment="<?= $row['payment_method'] ?>"
          data-status="<?= $row['status'] ?>"
          data-notes="<?= htmlspecialchars($row['preferences']) ?>"
          >View Details</button>
          <?php if ($row['status'] == 'pending'): ?>
            <button class="accept" onclick="updateStatusDB(<?= $row['id'] ?>, 'approved')">Accept</button>
          <button class="decline" onclick="updateStatusDB(<?= $row['id'] ?>, 'declined')">Decline</button>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>

  </table>
<div id="bookingModal" class="modal">
  <div class="modal-content">

    <div class="modal-header">
      <h2>Booking Details</h2>
      <span class="close" onclick="closeModal()">&times;</span>
    </div>

    <div class="modal-body" id="modalBody">
    </div>

  </div>
</div>
</div>

</body>
</html>

<script>

/******************************** MENU BUTTON ********************************/
    const sidebarButtons = document.querySelectorAll('.sidebar .menu button');

/******************************** GET THE CURRENT PAGE ********************************/
function getCurrentPage() {
  return window.location.pathname.split("/").pop(); 
}

/******************************** HIGHLIGHT THE BUTTON OF THE CURRENT PAGE ********************************/
function highlightSidebar() {
  const currentPage = getCurrentPage().toLowerCase();
    sidebarButtons.forEach(btn => {
      btn.classList.remove('active');
      
      if (btn.dataset.page.toLowerCase() === currentPage) {
          btn.classList.add('active');
      }
  });
}

/******************************** BUTTON HIGHLIGHT ********************************/
    highlightSidebar();

/******************************** SIDEBAR ********************************/
sidebarButtons.forEach(btn => {
   btn.addEventListener('click', () => {
    const targetPage = btn.dataset.page;

    sidebarButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    window.location.href = targetPage;
    });
  });

/******************************** UPDATE THE HIGHLIGHT ON THE BROWSER ********************************/
    window.addEventListener('popstate', () => {
     highlightSidebar();
  });

/******************************** ADMIN DROPDOWN ********************************/
function toggleDropdown() {
  const dropdown = document.getElementById("adminDropdown");
  dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}
function logout() {
  window.location.href = "login.html";
}

window.onclick = function(e) {
  if (!e.target.closest('.admin')) {
    document.getElementById("adminDropdown").style.display = "none";
  }
}

/******************************** SIDEBAR TOGGLE ********************************/
const menuBtn = document.getElementById("menu-btn");
const sidebar = document.querySelector(".sidebar");
const main = document.querySelector(".main");

menuBtn.onclick = function() {
  sidebar.classList.toggle("hide");
  main.classList.toggle("full");
};

/******************************** UPDATE DATE TODAY  ********************************/
function updateTodayDate() {
  const today = new Date();

  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  };

  const formattedDate = today.toLocaleDateString('en-US', options);

  document.getElementById("todayDate").textContent = "Today: " + formattedDate;
}

updateTodayDate();

/******************************** ACCEPT AND DECLINE ********************************/
function updateStatusDB(id, status) {
  fetch('webapp_php/update_booking_status.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `id=${id}&status=${status}`
  })
  .then(res => res.text())
  .then(data => {
    console.log(data);
    location.reload(); // refresh para makita update
  })
  .catch(err => console.error(err));
}

/* Para kita price ng service na napili ni customer */
function formatService(service) {
  if (service === "coffee_booth") return "Coffee Booth";
  if (service === "matcha_booth") return "Matcha Booth";
  if (service === "tattoo_event") return "Tattoo Event";
  return service;
}

function viewDetails(btn) {

  const name = btn.dataset.name;
  const email = btn.dataset.email;
  const contact = btn.dataset.phone;
  const event = btn.dataset.event;
  const date = btn.dataset.date;
  const time = btn.dataset.time;
  const guests = btn.dataset.guests;
  const location = btn.dataset.address;
  const payment = btn.dataset.payment;
  const status = btn.dataset.status;
  const notes = btn.dataset.notes;

  // format date & time
  const schedule = new Date(date).toLocaleDateString('en-US', {
    year: 'numeric', month: 'short', day: 'numeric'
  }) + " • " + time;

  let packagePrice = 0;
  if (event === "coffee_booth") packagePrice = 5000;
  if (event === "matcha_booth") packagePrice = 9000;
  if (event === "tattoo_event") packagePrice = 1000;
  
  const reservationFees = {
  "Coffee Booth": 5000,
  "Matcha Booth": 9000,
  "Tattoo Event": 1000
};

  let reservationFee = 2000; // ✅ same sa Event Management
  let balance = packagePrice - reservationFee;

  let statusClass = "status-pending";

if (status === "approved") statusClass = "status-paid";
if (status === "declined") statusClass = "status-declined";

const html = `
    <div class="detail full">
      <label>Client</label>
      <span>${name}</span>
    </div>

    <div class="detail">
      <label>Email</label>
      <span>${email}</span>
    </div>

    <div class="detail">
      <label>Contact</label>
      <span>${contact}</span>
    </div>

    <div class="detail">
      <label>Date</label>
      <span>${schedule}</span>
    </div>

    <div class="detail">
      <label>Guests</label>
      <span>${guests}</span>
    </div>

    <div class="detail full">
      <label>Location</label>
      <span>${location}</span>
    </div>

    <div class="detail full">
      <label>Service</label>
      <span>${formatService(event)}</span>
    </div>

    <div class="detail full" style="background:#f3f4f6; font-weight:700;">
      <label>Payment Summary</label>
    </div>

    <div class="detail">
      <label>Package Price</label>
      <span>₱${packagePrice}</span>
    </div>

    <div class="detail">
      <label>Reservation Fee</label>
      <span>₱${reservationFee}</span>
    </div>

    <div class="detail">
      <label>Balance</label>
      <span>₱${balance}</span>
    </div>

    <div class="detail full">
      <label>Payment Method</label>
      <span>${payment}</span>
    </div>

    <div class="detail full">
      <label>Status</label>
      <span class="status-badge ${statusClass}">${status}</span>
    </div>

    <div class="detail full">
      <label>Notes</label>
      <span>${notes}</span>
    </div>
  `;

  document.getElementById("modalBody").innerHTML = html;
  document.getElementById("bookingModal").style.display = "block";
}

const modal = document.getElementById("bookingModal");

function closeModal() {
  modal.style.display = "none";
}

window.addEventListener("click", function(e) {
  if (e.target === modal) {
    closeModal();
  }
});
</script>