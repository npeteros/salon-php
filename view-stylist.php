<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if (!isset($_GET['id']))
    header('Location: ./stylists.php');
include 'src/api/functions.php';

$stylist = getStylistById((int) $_GET['id']);
if (!$stylist)
    return header('Location: ./stylists.php');

$stylistSpecialties = getStylistSpecialtiesByStylistId($_GET['id']) ? getStylistSpecialtiesByStylistId($_GET['id']) : [];
$reviews = getReviewsByStylistId($_GET['id']);
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/side_nav.php'; ?>

        <div class="parent-container">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Stylist
                    Details (#<?php echo $_GET['id']; ?>)</span>
                <div class="stylist-container">
                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div
                            style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem;">
                            <img src="./uploads/<?php echo $stylist['stylist_img']; ?>" alt="Image"
                                style="width: 100%; height: 100%; border-radius: 0.5rem;">
                        </div>
                        <div class="info-container">
                            <div
                                style="display: flex; flex-direction: column; gap: 0.25rem; width: 100%; align-items: start;">
                                <div style="display: flex; gap: 1rem;">
                                    <span
                                        style="font-weight: 700; font-size: 1.875rem;"><?php echo $stylist['stylist_name']; ?></span>

                                    <div style="display: flex; height: fit-content;">
                                        <div
                                            style="border: 1px solid rgb(212 212 212); border-radius: 1rem; padding: 0.25rem 1.5rem; display: flex; gap: 0.25rem">
                                            <?php for ($i = 0; $i < round(number_format($stylist['average_rating'], 1)); $i++) { ?>
                                                <svg width="16" height="16" fill="yellow" stroke="black" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27Z">
                                                    </path>
                                                </svg>
                                            <?php } ?>
                                            <span style="width: 100%;"><?php echo round(number_format($stylist['average_rating'], 1)); ?>
                                                Overall</span>
                                        </div>
                                    </div>
                                </div>
                                <span style="opacity: 50%;"><?php echo $stylist['stylist_email'] ?></span>
                                <span style="opacity: 50%;">Handled <?php echo $stylist['total_appointments'] ?>
                                    appointment<?php echo $stylist['total_appointments'] > 1 ? 's' : ''; ?></span>
                                <div style="opacity: 100%;display: flex; flex-direction: column; margin: 1rem 0rem;">
                                    Specialities:
                                    <div style="display: flex; gap: 0.5rem;">
                                        <?php if ($stylistSpecialties) {
                                            foreach ($stylistSpecialties as $speciality): ?>
                                                <span style="font-weight: 600; background: #E53C37; color: white; padding: 0.25rem 0.5rem; border-radius: 1rem;"><?php echo $speciality['service_name']; ?></span>
                                            <?php endforeach;
                                        } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.5rem; background-color: #E53C37; border: 1px solid #E53C37; border-radius: 0.5rem; height: fit-content; padding: 0.5rem 1rem; align-items: center; cursor: pointer;"
                        onclick="window.location.href = 'mailto:<?php echo $stylist['stylist_email']; ?>';">
                        <svg width="16" height="16" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6Zm-2 0-8 5-8-5h16Zm0 12H4V8l8 5 8-5v10Z">
                            </path>
                        </svg>
                        <span style="color: white;">Send Email</span>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
                <?php if ($reviews) {
                    foreach ($reviews as $review): ?>
                        <div style="background-color: white; border-radius: 1rem; padding: 1rem;">
                            <div style="display: flex; justify-content: space-between;">
                                <div style="display: flex; gap: 1rem;">
                                    <div style="width: 5rem; height: 5rem;">
                                        <img src="./uploads/<?php echo $review['customer_image']; ?>" alt="Image"
                                            style="width: 100%; height: 100%; border-radius: 0.5rem;">
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span
                                            style="font-weight: 600; font-size: 1.25rem;"><?php echo $review['customer_name']; ?></span>
                                        <span style="opacity: 50%"><?php echo $review['customer_email']; ?></span>
                                    </div>
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: end;">
                                    <span>
                                        <?php echo printStars($review['rating']); ?>
                                    </span>
                                    <span>
                                        <?php echo date('M d', strtotime($review['created_at'])); ?>
                                    </span>
                                </div>
                            </div>
                            <p><?php echo $review['review']; ?></p>
                        </div>
                    <?php endforeach;
                } ?>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>