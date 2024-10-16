<?php
define('FILE_CSS', 'src/styles/appointments.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
include 'src/api/functions.php';
$appointments = getAppointmentsByCustomer($_SESSION['user']['id']) ? array_slice(getAppointmentsByCustomer($_SESSION['user']['id']), 0, 3) : null;
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="main-container">
        <?php include 'src/includes/side_nav.php'; ?>
        <div style="display: flex; margin: 1.5rem; flex-direction: column; gap: 1rem; width: 100%;">
            <div style="display: flex; flex-direction: column;">
                <div>
                    <div style="position: relative;">
                        <div
                            style="position: absolute; display: flex; top: 0; bottom: 0; padding-left: 0.75rem; align-items: center; pointer-events: none;">
                            <svg class="w-4 h-4 text-gray-500 dark:text-neutral-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="appointments-search"
                            class="search-button"
                            placeholder="Search Appointments..." required />
                    </div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.5rem">
                <span style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Appointments</span>
                <table style="width: 100%; background: #A80011;">
                    <thead style="color: white;">
                        <tr>
                            <th style="font-weight: 400; padding: 0.5rem 0rem;">Staff</th>
                            <th style="font-weight: 400;">Service</th>
                            <th style="font-weight: 400;">Date</th>
                            <th style="font-weight: 400;">Time</th>
                            <th style="font-weight: 400;">Status</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white; text-align: center;" id="appointmentsList"
                        data-userid="<?php echo $_SESSION['user']['id']; ?>">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>