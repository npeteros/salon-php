<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] != 'owner' && $_SESSION['user']['role'] != 'manager')
    header('Location: ./index.php');
if (!isset($_GET['id']))
    header("Location: ./admin-services.php");
include 'src/api/functions.php';

$service = getServiceById($_GET['id']);
if (!$service)
    return header('Location: ./admin-services.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMsg = '';
    $successMsg = '';
    $query = 'UPDATE services SET ';
    if (isset($_POST['name'])) {
        $query .= 'name = "' . $_POST['name'] . '", ';
    }
    if (isset($_POST['price'])) {
        $query .= 'price = "' . $_POST['price'] . '", ';
    }
    if (isset($_POST['duration'])) {
        $query .= 'duration = "' . $_POST['duration'] . '", ';
    }
    if (isset($_POST['followup_duration'])) {
        $query .= 'followup_duration = "' . $_POST['followup_duration'] . '", ';
    }
    if (isset($_POST['description'])) {
        $query .= 'description = "' . $_POST['description'] . '", ';
    }
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && empty($errorMsg)) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $uploadDir = 'uploads/services';

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
            $successMsg = 'Service updated successfully';
        } else {
            $errorMsg = 'Failed to update user';
        }
    }

    echo '<script>setTimeout(function() {
            window.location.href = "./edit-service.php?id=' . $_GET['id'] . '";
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
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Edit Service
                    (#<?php echo $service['id']; ?>)</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <form id="edit-service" style="display: flex; gap: 1.5rem;" method="POST" enctype="multipart/form-data">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div
                                style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem; display: flex; align-items: center;">
                                <img src="./uploads/services/<?php echo $service['img_path']; ?>" alt="Image"
                                    style="width: 100%; height: 100%;">
                            </div>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%;">
                            <div class="add-service-container">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="name">Service Name</label>
                                    <input type="text" name="name"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        value="<?php echo $service['name']; ?>">
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="price">Service Price</label>
                                    <div style="position: relative;">
                                        <div
                                            style="display: flex; position: absolute; top: 0; left: 0.5rem; bottom: 0; align-items: center; pointer-events: none;">
                                            <span style="color: #6B7280;">&#x20B1;</span>
                                        </div>
                                        <input type="number" name="price" step="0.01"
                                            style="display: block; padding: 0.625rem; padding-left: 2.5rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                            value="<?php echo $service['price']; ?>">
                                    </div>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="duration">Service Duration (by minutes)</label>
                                    <input type="number" name="duration"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        value="<?php echo $service['duration']; ?>">
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="followup_duration">Follow Up Duration (by minutes)</label>
                                    <input type="number" name="followup_duration"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        value="<?php echo $service['followup_duration']; ?>">
                                </div>
                                <div
                                    style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%; grid-column: span 2 / span 2;">
                                    <label for="description">Service Description</label>
                                    <textarea name="description"><?php echo $service['description']; ?></textarea>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span
                                    style="text-align: center; <?php echo empty($errorMsg) ? 'color: #059669;' : 'color: #DC2626;'; ?> font-size: 0.875rem; line-height: 1.25rem;">
                                    <?php echo empty($errorMsg) ? empty($successMsg) ? '' : $successMsg : $errorMsg; ?>
                                </span>
                                <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
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