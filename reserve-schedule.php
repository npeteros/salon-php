<?php
define('FILE_CSS', 'src/styles/reserve-appointment.css');
include './src/includes/header.php';
include './src/api/functions.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');

$appointment = getPendingAppointment($_SESSION['user']['id']);
if ($appointment) {
    header('Location: ./view-appointment.php?id=' . (int) $appointment[0]['id']);
}

// $consultation = getConsultationByCustomer($_SESSION['user']['id']);
// if (!$consultation)
//     header('Location: ./consultation-hair.php');

date_default_timezone_set('Asia/Manila');
?>

<div style="min-height: 100lvh; background: #D9D9D9">
    <?php include './src/includes/dash_nav.php'; ?>
    <div style="display: flex; height: 100%; gap: 1rem;">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;">
            <div
                style="display: flex; padding: 1rem; flex-direction: column; gap: 1rem; border-radius: 1rem; width: 100%; background-color: #ffffff;">
                <ol>
                    <li class="next active">
                        <span class="progress active">
                            1
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Schedule</h3>
                        </span>
                    </li>
                    <li class="next">
                        <span class="progress inactive">
                            2
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Service</h3>
                        </span>
                    </li>
                    <li class="next">
                        <span class="progress inactive">
                            3
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Stylist</h3>
                        </span>
                    </li>
                    <li class="">
                        <span class="progress inactive">
                            4
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Confirm</h3>
                        </span>
                    </li>
                </ol>
                <div
                    style="display: flex; padding-left: 1rem; padding-right: 1rem; flex-direction: column; border-radius: 1rem;">
                    <form method="post" action="./reserve-service.php<?php if (isset($_GET['id'])) echo '?id=' . $_GET['id']; ?>"
                        style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                                <label for="name" style="font-weight: 700;">Confirm Date</label>
                                <input type="date" name="date" id="date"
                                    style="padding: 0.5rem 1rem; border-radius: 0.5rem; border-width: 1px;"
                                    min="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>"
                                    value="<?php echo isset($_POST['date']) ? $_POST['date'] : date('Y-m-d', strtotime('tomorrow')); ?>" required />
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                                <label for="name" style="font-weight: 700;">Confirm Time</label>
                                <input type="time" name="time" id="time"
                                    style="padding: 0.5rem 1rem; border-radius: 0.5rem; border-width: 1px;" min="08:00"
                                    max="20:00" title="Please select a time between 08:00 AM and 08:00 PM" required />
                            </div>
                        </div>
                        <button class="next-button" type="submit">Next</button>
                    </form>
                    <button class="cancel-button" type="button"
                        onclick="window.location.href = './dashboard.php'">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>