<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if (!isset($_GET['id']))
    header('Location: ./stylists.php');
if ($_SESSION['user']['role'] != 'owner' && $_SESSION['user']['role'] != 'manager')
    header('Location: ./index.php');
include 'src/api/functions.php';

$user = getUser($_GET['id']);
if (!$user)
    return header('Location: ./admin-dashboard.php');

$consultation = getConsultationByCustomer($_GET['id']) ? getConsultationByCustomer($_GET['id']) : [];

$selectedTreatment = getTreatmentById($consultation['treatment_id']);
$suitable = $consultation['status'] == 'Suitable' ? true : false;

?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include 'src/includes/admin_side_nav.php'; ?>

        <div class="parent-container">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Stylist
                    Details (#<?php echo $_GET['id']; ?>)</span>
                <div class="stylist-container">
                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div
                            style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem;">
                            <img src="./uploads/<?php echo $user['img_path']; ?>" alt="Image"
                                style="width: 100%; height: 100%; border-radius: 0.5rem;">
                        </div>
                        <div class="info-container">
                            <div
                                style="display: flex; flex-direction: column; gap: 1rem; width: 12rem; align-items: start;">
                                <div
                                    style="display: flex; flex-direction: column; gap: 0.25rem; width: 12rem; align-items: start;">
                                    <span
                                        style="font-weight: 700; font-size: 1.875rem;"><?php echo $user['name']; ?></span>
                                    <span style="opacity: 50%;"><?php echo $user['email'] ?></span>
                                </div>
                                <div
                                    style="display: flex; flex-direction: column; gap: 0.25rem; width: 12rem; align-items: start;">
                                    <span style="font-weight: 700;" id="role"
                                        data-id="<?php echo $user['id']; ?>"><?php echo ucfirst($user['role']); ?></span>
                                    <select style="display: none;" id="change-role-select">
                                        <?php if ($_SESSION['user']['role'] == "owner") { ?>
                                            <option value="owner" <?php echo $user['role'] == "owner" ? "selected" : null; ?>>
                                                Owner</option>
                                            <option value="manager" <?php echo $user['role'] == "manager" ? "selected" : null; ?>>Manager</option>
                                        <?php } ?>
                                        <option value="stylist" <?php echo $user['role'] == "stylist" ? "selected" : null; ?>>Stylist</option>
                                        <option value="user" <?php echo $user['role'] == "user" ? "selected" : null; ?>>
                                            Customer</option>
                                    </select>
                                    <span
                                        style="font-size: 0.875rem; text-decoration: underline; cursor: pointer; opacity: 50%;"
                                        id="change-role">Change role</span>
                                    <span
                                        style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                        id="change-role-error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.5rem">
                        <button
                            style="padding-top: 0.625rem; padding-bottom: 0.625rem; padding-left: 1.25rem; padding-right: 1.25rem; margin-bottom: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #ffffff; height: fit-content; background-color: #E53C37; border: none; cursor: pointer;"
                            onclick="window.location.href = './edit-user.php?id=<?php echo $user['id']; ?>'">Edit
                            User</button>
                        <button
                            style="padding-top: 0.625rem; padding-bottom: 0.625rem; padding-left: 1.25rem; padding-right: 1.25rem; margin-bottom: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #E53C37; height: fit-content; background-color: white; border: 1px solid #E53C37; cursor: pointer;"
                            id="delete-user" data-id="<?php echo $user['id']; ?>">Delete
                            User</button>
                        <span style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                            id="user-error"></span>
                    </div>
                </div>
            </div>
            <?php if (isset($consultation)) { ?>
                <div
                    style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                    <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Hair Treatment
                        Recommendation</span>
                    <div
                        style="display: flex; flex-direction: column; align-items: center; gap: 2rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                        <div style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: rgb(229 229 229); width: 50%; cursor: pointer;"
                            onclick="window.open('./view-service.php?id=<?php echo $selectedTreatment['service_id']; ?>', '_blank');"
                            target="_blank">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <img src="./uploads/services/<?php echo $selectedTreatment['img_path']; ?>" alt="Image"
                                    style="width: 3rem; height: 3rem; border-radius: 9999px;">
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    <span
                                        style="font-size: 1.125rem; line-height: 1.75rem;"><?php echo $selectedTreatment['name']; ?></span>
                                    <span
                                        style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo strlen($selectedTreatment['description']) > 35 ? substr($selectedTreatment['description'], 0, 35) . '...' : $selectedTreatment['description']; ?></span>
                                </div>
                            </div>
                            <span style="color: #49454F;">&#x20B1; <?php echo $selectedTreatment['price']; ?></span>
                        </div>

                        <?php if (!$suitable): ?>
                            <div class="divider"></div>
                            <div style="display: flex; flex-direction: column; align-items: start; gap: 1rem; width: 100%;">
                                <span style="font-weight: 700; font-size: 1.25rem; text-align: center;">Alternative Recommended
                                    Treatments:</span>
                                <div
                                    style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; width: 100%;">
                                    <?php
                                    if (empty($alternativeTreatments)) {
                                        echo "<span style='font-size: 0.875rem; line-height: 1.25rem; text-align: center;'>No alternative treatments found. Please wait until a few months have passed.</span>";
                                    }

                                    foreach ($alternativeTreatments as $alternativeTreatment): ?>
                                        <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                            <div style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: rgb(229 229 229); cursor: pointer;"
                                                onclick="window.open('./view-service.php?id=<?php echo $alternativeTreatment['id']; ?>', '_blank');"
                                                target="_blank">
                                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <img src="./uploads/services/<?php echo $alternativeTreatment['img_path']; ?>"
                                                        alt="Image" style="width: 3rem; height: 3rem; border-radius: 9999px;">
                                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                                        <span
                                                            style="font-size: 1.125rem; line-height: 1.75rem;"><?php echo $alternativeTreatment['name']; ?></span>
                                                        <span
                                                            style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo strlen($alternativeTreatment['description']) > 35 ? substr($alternativeTreatment['description'], 0, 35) . '...' : $alternativeTreatment['description']; ?></span>
                                                    </div>
                                                </div>
                                                <span style="color: #49454F;">&#x20B1;
                                                    <?php echo $alternativeTreatment['price']; ?></span>
                                            </div>
                                            <span
                                                style="font-size: 1rem; font-weight: bold; line-height: 1.25rem; opacity: 80%;">Note:
                                                <?php echo $alternativeTreatment['reason']; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="divider"></div>
                        <span style="font-weight: 700; font-size: 1.25rem">Hair Profile Information (For Stylist&apos;s
                            reference)</span>
                        <div style="display: flex; flex-direction: column; align-items: start; gap: 1rem; width: 100%;">
                            <div style="display: flex; gap: 0.5rem;">
                                <span style="font-weight: 700;">
                                    Hair Type:
                                </span>
                                <span><?php echo ucwords($consultation['type']); ?></span>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <span style="font-weight: 700;">
                                    Hair Texture:
                                </span>
                                <span><?php echo ucwords($consultation['texture']); ?></span>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <span style="font-weight: 700;">
                                    Hair Condition:
                                </span>
                                <span><?php echo ucwords($consultation['hair']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>