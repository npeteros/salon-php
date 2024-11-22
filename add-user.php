<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');
include 'src/api/functions.php';
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/admin_side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem; display: flex; flex-direction: column; gap: 2rem;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Add User</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <form id="add-user" style="display: flex; gap: 1.5rem;" method="POST" enctype="multipart/form-data">
                        <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                            <div style="width: 8rem; height: 8rem;">
                                <img src="./uploads/default.png" alt="Image"
                                    style="width: 100%; height: 100%; border-radius: 9999px;">
                            </div>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%;">
                            <div class="add-service-container">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        placeholder="John Doe" required>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="price">Email Address</label>
                                    <input type="email" name="email"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        placeholder="johndoe@example.com" required>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="duration">Password</label>
                                    <input type="password" name="password"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        placeholder="johndoe123" required>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="followup_duration">Role</label>
                                    <select name="role"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        required>
                                        <option value="user">User</option>
                                        <option value="stylist">Stylist</option>
                                        <?php if ($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'owner') { ?>
                                            <option value="manager">Manager</option>
                                            <?php if ($_SESSION['user']['role'] == 'owner') { ?>
                                                <option value="owner">Owner</option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span
                                    style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                    id="user-error"></span>
                                <button class="next-button" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>