<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if (!isset($_GET['appointment_id']))
    header('Location: ./appointments.php');
include 'src/api/functions.php';

$appointment = getAppointmentById($_GET['appointment_id']);
if ($appointment['appointment_status'] !== 'completed') {
    header('Location: ./view-appointment.php?id=' . $_GET['appointment_id']);
}
$date = new DateTime($appointment['appointment_date']);

$formattedDate = $date->format('d M Y, g:i A');

$color = 'background-color: rgb(115 115 115);';

switch ($appointment['appointment_status']) {
    case 'pending':
        $color = 'background-color: rgb(115 115 115);';
        break;
    case 'confirmed':
        $color = 'background-color: rgb(14 165 233);';
        break;
    case 'completed':
        $color = 'background-color: rgb(34 197 94);';
        break;
    case 'rescheduled':
        $color = 'background-color: rgb(234 179 8);';
        break;
    case 'cancelled':
    case 'no show':
        $color = 'background-color: rgb(239 68 68);';
        break;
    default:
        $color = 'background-color: rgb(115 115 115);';
        break;
}
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem; display: flex; flex-direction: column; gap: 2rem;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Appointment
                    Details (#<?php echo $appointment['appointment_id']; ?>)</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <div style="display: grid; grid-template-columns: repeat(11, minmax(0, 1fr));">
                        <div style="display: flex; gap: 1rem; align-items: start; grid-column: span 4 / span 4;">
                            <div
                                style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem;">
                                <img src="./uploads/<?php echo $_SESSION['user']['role'] == 'user' ? $appointment['stylist_image'] : $appointment['customer_image']; ?>"
                                    alt="Image" style="width: 100%; height: 100%; border-radius: 0.5rem;">
                            </div>
                            <div
                                style="display: flex; flex-direction: column; gap: 0.25rem; width: 12rem; align-items: start;">
                                <span
                                    style="font-weight: 700; font-size: 1.875rem;"><?php echo $_SESSION['user']['role'] == 'user' ? $appointment['stylist_name'] : $appointment['customer_name']; ?></span>
                                <span
                                    style="opacity: 50%;"><?php echo $_SESSION['user']['role'] == 'user' ? $appointment['stylist_email'] : $appointment['customer_email']; ?></span>
                            </div>
                        </div>
                        <div
                            style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); grid-column: span 4 / span 4;">
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span
                                    style="opacity: 50%; font-weight: 500; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 0.85rem;">Service</span>
                                <span><?php echo $appointment['service_name']; ?></span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span
                                    style="opacity: 50%; font-weight: 500; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 0.85rem;">Service
                                    Duration</span>
                                <span><?php echo formatTime($appointment['service_duration']); ?></span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span
                                    style="opacity: 50%; font-weight: 500; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 0.85rem;">Scheduled
                                    Date</span>
                                <span><?php echo $formattedDate; ?></span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span
                                    style="opacity: 50%; font-weight: 500; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 0.85rem;">Total
                                    Payment</span>
                                <span>&#x20B1; <?php echo $appointment['service_price']; ?></span>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: end; grid-column: span 3 / span 3;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                                <div
                                    style="display: flex; justify-content: space-between; padding: 0.5rem 1.5rem; border-radius: 9999px; color: white; height: fit-content; width: fit-content; <?php echo $color; ?>">
                                    <?php echo ucfirst($appointment['appointment_status']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Add Review</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <form id="add-review" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div>
                            <div
                                style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; width: 100%;">
                                <label for="rating" style="font-size: 1.5rem;">Overall Rating</label>
                                <div class="rating-container">
                                    <svg id="star-1" class="star" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 22 20">
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <svg id="star-2" class="star" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 22 20">
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <svg id="star-3" class="star" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 22 20">
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <svg id="star-4" class="star" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 22 20">
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <svg id="star-5" class="star" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 22 20">
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                </div>
                                <input type="hidden" name="rating" id="rating" value="0" />
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                <label for="rating" style="font-size: 1.5rem;">Comments</label>
                                <textarea name="review" placeholder="Additional comments"></textarea>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <span style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                id="review-error"></span>
                            <input type="hidden" name="customer_id" value="<?php echo $_SESSION['user']['id']; ?>">
                            <input type="hidden" name="appointment_id"
                                value="<?php echo $appointment['appointment_id']; ?>">
                            <button class="next-button" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>