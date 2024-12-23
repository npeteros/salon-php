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
        <?php include 'src/includes/admin_side_nav.php'; ?>
        <div style="display: flex; margin: 1.5rem; flex-direction: column; gap: 1rem; width: 100%;">
            <div style="display: flex;">
                <input type="text" id="appointments-search" class="search-button" placeholder="Search Appointments..."
                    required />
                <div style="position: relative;">
                    <button
                        style="position: relative; height: 4rem; background-color: #A80011; border: 0px; color: white; padding: 2rem 2.5rem; border-top-right-radius: 0.5rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;"
                        class="filter-button" id="dropdownFilter">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg>
                    </button>

                    <div id="dropdown"
                        style="display: none; position: absolute; z-index: 10; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border-top-width: 1px; border-color: #F3F4F6; width: 6rem; background-color: #ffffff; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
                        <div style="padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; color: #374151;"
                            aria-labelledby="dropdown-button">
                            <button type="button" class="filterAppointments" data-id="all">All</button>
                            <button type="button" class="filterAppointments" data-id="Pending">Pending</button>
                            <button type="button" class="filterAppointments" data-id="Confirmed">Confirmed</button>
                            <button type="button" class="filterAppointments" data-id="Rescheduled">Rescheduled</button>
                            <button type="button" class="filterAppointments" data-id="Completed">Completed</button>
                            <button type="button" class="filterAppointments" data-id="Cancelled">Cancelled</button>
                            <button type="button" class="filterAppointments" data-id="Noshow">No show</button>
                        </div>
                    </div>
                </div>
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