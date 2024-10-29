<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if (!isset($_GET['id']))
    header('Location: ./appointments.php');
include 'src/api/functions.php';
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');

$service = getPopularServiceById($_GET['id']);
if (!$service)
    return header('Location: ./services.php');
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/admin_side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Service
                    Details (#<?php echo $service['id']; ?>)</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <div style="display: grid; grid-template-columns: repeat(9, minmax(0, 1fr));">
                        <div style="display: flex; gap: 1rem; align-items: start; grid-column: span 4 / span 4;">
                            <div
                                style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem;">
                                <img src="./uploads/services/<?php echo $service['img_path']; ?>" alt="Image" style="width: 100%; height: 100%;">
                            </div>
                            <div
                                style="display: flex; flex-direction: column; gap: 0.25rem; width: 12rem; align-items: start;">
                                <span
                                    style="font-weight: 700; font-size: 1.875rem;"><?php echo $service['name'] ?></span>
                                <span style="opacity: 50%;">Used in <?php echo $service['appointment_count'] ?>
                                    appointment<?php echo $service['appointment_count'] <= 1 ? '' : 's' ?></span>
                            </div>
                        </div>
                        <div
                            style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); grid-column: span 4 / span 4; gap: 1.5rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span
                                    style="opacity: 50%; font-weight: 500; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 0.85rem;">Service</span>
                                <span><?php echo $service['description']; ?></span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span
                                    style="opacity: 50%; font-weight: 500; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 0.85rem;">Service
                                    Duration</span>
                                <span><?php echo formatTime($service['duration']); ?></span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span
                                    style="opacity: 50%; font-weight: 500; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 0.85rem;">Follow
                                    Up Duration</span>
                                <span><?php echo formatTime($service['followup_duration']); ?></span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span
                                    style="opacity: 50%; font-weight: 500; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 0.85rem;">Total
                                    Payment</span>
                                <span>&#x20B1; <?php echo $service['price']; ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem">
                            <button
                                style="padding-top: 0.625rem; padding-bottom: 0.625rem; padding-left: 1.25rem; padding-right: 1.25rem; margin-bottom: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #ffffff; height: fit-content; background-color: #E53C37; border: none; cursor: pointer;"
                                onclick="window.location.href = './edit-service.php?id=<?php echo $service['id']; ?>'">Edit
                                Service</button>
                            <button
                                style="padding-top: 0.625rem; padding-bottom: 0.625rem; padding-left: 1.25rem; padding-right: 1.25rem; margin-bottom: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #E53C37; height: fit-content; background-color: white; border: 1px solid #E53C37; cursor: pointer;"
                                id="delete-service" data-id="<?php echo $service['id']; ?>">Delete
                                Service</button>
                            <span style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                id="service-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>