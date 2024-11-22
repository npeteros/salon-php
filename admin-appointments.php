<?php
define('FILE_CSS', 'src/styles/appointments.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');
include 'src/api/functions.php';
$appointments = getAllAppointments() ? array_slice(getAllAppointments(), 0, 8) : null;
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="main-container">
        <div class="modal" id="filterModal">
            <div class="modal-content">
                <span class="modal-close" id="closeModal">&times;</span>
                <div class="modal-header">Filter Options</div>
                <form id="filterAppointments">
                    <label class="modal-label" for="staff">Staff</label>
                    <input type="text" id="staff" class="modal-input" placeholder="Enter staff name">

                    <label class="modal-label" for="customer">Customer</label>
                    <input type="text" id="customer" class="modal-input" placeholder="Enter customer name">

                    <label class="modal-label" for="service">Service</label>
                    <input type="text" id="service" class="modal-input" placeholder="Enter service">

                    <label class="modal-label" for="date">Date</label>
                    <input type="date" id="date" class="modal-input">

                    <label class="modal-label" for="time">Time</label>
                    <input type="time" id="time" class="modal-input">

                    <label class="modal-label" for="status">Status</label>
                    <select id="status" class="modal-input">
                        <option value="">Select status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="rescheduled">Rescheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="noshow">No Show</option>
                    </select>

                    <div class="modal-actions">
                        <button type="button" class="clear-filters">Clear Filters</button>
                        <button type="submit" class="apply-button">Apply</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include 'src/includes/admin_side_nav.php'; ?>
        <div style="display: flex; margin: 1.5rem; flex-direction: column; gap: 1rem; width: 100%;">
            <div style="display: flex;">
                <button
                    style="background-color: #A80011; border: 0px; color: white; padding: 0rem 2rem; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;" class="filter-button">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.5 5h13a1 1 0 0 1 .5 1.5L14 12v7l-4-3v-4L5 6.5A1 1 0 0 1 5.5 5Z"></path>
                    </svg>
                    Filter
                </button>
                <input type="text" id="appointments-search" class="search-button" placeholder="Search Appointments..."
                    required />
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.5rem">
                <span
                    style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Appointments</span>
                <table style="width: 100%; background: #A80011;">
                    <thead style="color: white;">
                        <tr>
                            <th style="padding: 0.5rem 0rem; font-weight: 400;">Staff</th>
                            <th style="font-weight: 400;">Customer</th>
                            <th style="font-weight: 400;">Service</th>
                            <th style="font-weight: 400;">Date</th>
                            <th style="font-weight: 400;">Time</th>
                            <th style="font-weight: 400;">Status</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white; text-align: center;" id="appointmentsList">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>