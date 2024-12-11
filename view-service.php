<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if (!isset($_GET['id']))
    header('Location: ./appointments.php');
include 'src/api/functions.php';

$service = getPopularServiceById($_GET['id']);
if (!$service)
    return header('Location: ./services.php');
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Service
                    Details (#<?php echo $service['id']; ?>)</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <div style="display: grid; grid-template-columns: repeat(8, minmax(0, 1fr));">
                        <div style="display: flex; gap: 1rem; align-items: start; grid-column: span 4 / span 4;">
                            <div
                                style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem;">
                                <img src="./uploads/services/<?php echo $service['img_path']; ?>" alt="Image"
                                    style="width: 100%; height: 100%;">
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
                                <span><?php echo $service['description'] ? $service['description'] : "No description"; ?></span>
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
                    </div>
                    <?php if ($service['chemical']): ?>
                        <span style="font-weight: 700; font-size: 1rem; text-align: center; color: #E53C37;">This service
                            needs consultation.</span>
                        <button type="button"
                            onclick="window.location.href = './consultation-hair.php?id=<?php echo $service['id']; ?>'"
                            style="cursor: pointer; background-color: #E53C37; display: flex; justify-content: center; border: 1px solid white; border-radius: 0.25rem; color: white; padding: 0.5rem 0;">Proceed
                            to Consultation</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>