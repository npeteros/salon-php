<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');
include 'src/api/functions.php';

$user = getUser($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMsg = '';
    $successMsg = '';
    $query = 'UPDATE users SET ';
    if (isset($_POST['name'])) {
        $query .= 'name = "' . $_POST['name'] . '", ';
    }
    if (isset($_POST['email'])) {
        $query .= 'email = "' . $_POST['email'] . '", ';
    }
    if (isset($_POST['password']) && isset($_POST['confirm-password']) && !empty($_POST['password']) && !empty($_POST['confirm-password'])) {
        if ($_POST['password'] != $_POST['confirm-password'])
            $errorMsg = 'Passwords do not match';
        else $query .= 'password = "' . sha1(trim($_POST['password'])) . '", ';
    }
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && empty($errorMsg)) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $uploadDir = 'uploads/';

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $query .= 'img_path = "' . $fileName . '", ';
        } else {
            $errorMsg = 'Failed to upload image';
        }
    }

    $query = rtrim($query, ', ');
    $query .= ' WHERE id = ' . $_GET['id'] . ';';

    if (empty($errorMsg)) {
        if (mysqli_query($conn, $query)) {
            $successMsg = 'User updated successfully';
        } else {
            $errorMsg = 'Failed to update user';
        }
    }

    echo '<script>setTimeout(function() {
        window.location.href = "./edit-user.php?id=' . $_GET['id'] . '";
    }, 2000);</script>';
}
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/admin_side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem; display: flex; flex-direction: column; gap: 2rem;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Edit User</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <form id="edit-user" style="display: flex; gap: 1.5rem;" method="POST" enctype="multipart/form-data">
                        <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                            <div style="width: 8rem; height: 8rem;">
                                <img src="./uploads/<?php echo $user['img_path']; ?>" alt="Image"
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
                                        value="<?php echo $user['name']; ?>" required>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="price">Email Address</label>
                                    <input type="email" name="email"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        value="<?php echo $user['email']; ?>" required>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="duration">New Password</label>
                                    <input type="password" name="password"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;">
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="duration">Confirm Password</label>
                                    <input type="password" name="confirm-password"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;">
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <span
                                    style="text-align: center; <?php echo empty($errorMsg) ? 'color: #059669;' : 'color: #DC2626;'; ?> font-size: 0.875rem; line-height: 1.25rem;">
                                    <?php echo empty($errorMsg) ? empty($successMsg) ? '' : $successMsg : $errorMsg; ?>
                                </span>
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