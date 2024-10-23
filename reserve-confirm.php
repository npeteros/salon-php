<?php
if ($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST['date']) || !isset($_POST['time']) || !isset($_POST['service']) || !isset($_POST['stylist']))
    header("Location: ./reserve-service.php");
define('FILE_CSS', 'src/styles/reserve-appointment.css');
include './src/includes/header.php';
include './src/api/functions.php';
$service = getServiceById($_POST['service']);
$stylist = getUser($_POST['stylist']);
$formattedDate = date('l, F j, Y', strtotime($_POST['date']));
$formattedTime = date('g:i A', strtotime($_POST['time']));
$formattedDuration = formatTime($service['duration']);
$stylistReviewSummary = getStylistReviewSummary($_POST['stylist']);
?>

<div style="min-height: 100lvh; background: #D9D9D9">
    <?php include './src/includes/dash_nav.php'; ?>
    <div style="display: flex; height: 100%; gap: 1rem;">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;">
            <div
                style="display: flex; padding: 1rem; flex-direction: column; gap: 1rem; border-radius: 1rem; width: 100%; background-color: #ffffff;">
                <ol>
                    <li class="next">
                        <span class="progress inactive">
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
                    <li class="active">
                        <span class="progress active">
                            4
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Confirm</h3>
                        </span>
                    </li>
                </ol>
                <div
                    style="display: flex; padding-left: 1rem; padding-right: 1rem; flex-direction: column; border-radius: 1rem;">
                    <div class="confirmation-grid">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem">
                            <div style="display: flex; flex-direction: column;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Personal
                                        Information</span>
                                    <a
                                        style="color: #3B82F6; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem;">Edit</a>
                                </div>
                                <hr style="margin: 0.5rem 0rem; border-width: 1px; background-color: #E5E7B;" />
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span style="font-weight: 700;"><?php echo $_SESSION['user']['name']; ?></span>
                                <span
                                    style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo $_SESSION['user']['email']; ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem">
                            <div style="display: flex; flex-direction: column;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Stylist
                                        Information</span>
                                    <a
                                        style="color: #3B82F6; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem;">Edit</a>
                                </div>
                                <hr style="margin: 0.5rem 0rem; border-width: 1px; background-color: #E5E7B;" />
                            </div>
                            <div style="display: flex; flex-direction: column;">
                                <span style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-weight: 700;"><?php echo $stylist['name']; ?></span>
                                    <p
                                        style="display: flex; align-items: center; font-size: 0.75rem; line-height: 1rem; gap: 0.25rem;">
                                        <span
                                            style="display: flex; align-items: center;"><?php echo printStars(isset($stylistReviewSummary) ? $stylistReviewSummary['average_rating'] : 0) ?></span>
                                        <a
                                            style="color: #3B82F6; text-decoration: underline;">(<?php echo isset($stylistReviewSummary) ? $stylistReviewSummary['total_appointments'] : 0; ?>)</a>
                                    </p>
                                </span>
                                <span
                                    style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo $stylist['email']; ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem">
                            <div style="display: flex; flex-direction: column;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span
                                        style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Appointment
                                        Schedule</span>
                                    <a
                                        style="color: #3B82F6; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem;">Edit</a>
                                </div>
                                <hr style="margin: 0.5rem 0rem; border-width: 1px; background-color: #E5E7B;" />
                            </div>
                            <div style="display: flex; flex-direction: column;  gap: 0.25rem;">
                                <span style="font-weight: 700;"><?php echo $formattedDate; ?></span>
                                <span
                                    style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo $formattedTime; ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem">
                            <div style="display: flex; flex-direction: column;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Service
                                        Details</span>
                                    <a
                                        style="color: #3B82F6; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem;">Edit</a>
                                </div>
                                <hr style="margin: 0.5rem 0rem; border-width: 1px; background-color: #E5E7B;" />
                            </div>
                            <div style="display: flex; flex-direction: column;  gap: 0.25rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-bold"><?php echo $service['name']; ?></span>
                                    <span style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 700;">&#x20B1;
                                        <?php echo $service['price']; ?></span>
                                </div>
                                <span style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 700;"><span
                                        style="font-weight: 700;">Length:</span>
                                    <?php echo $formattedDuration ?></span>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column;">
                        <form id="confirm-reservation" style="display: flex; flex-direction: column; gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <input type="hidden" name="customer" id="customer"
                                    value="<?php echo $_SESSION['user']['id']; ?>">
                                <input type="hidden" name="date" id="date" value="<?php echo $_POST['date'] ?>" />
                                <input type="hidden" name="time" id="time" value="<?php echo $_POST['time'] ?>" />
                                <input type="hidden" name="service" id="service"
                                    value="<?php echo $_POST['service'] ?>" />
                                <input type="hidden" name="stylist" id="stylist"
                                    value="<?php echo $_POST['stylist']; ?>" />
                            </div>
                            <span style="font-size: 0.875rem; line-height: 1.25rem; text-align: center; color: #DC2626;"
                                id="reservation-error"></span>
                            <button class="next-button" type="submit">Submit</button>
                        </form>
                        <form method="post" action="./reserve-stylist.php">
                            <input type="hidden" name="date" id="date" value="<?php echo $_POST['date'] ?>" />
                            <input type="hidden" name="time" id="time" value="<?php echo $_POST['time'] ?>" />
                            <input type="hidden" name="service" id="service" value="<?php echo $_POST['service'] ?>">
                            <input type="hidden" name="stylist" id="stylist" value="<?php echo $_POST['stylist']; ?>">
                            <button class="cancel-button" type="submit">Back</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>