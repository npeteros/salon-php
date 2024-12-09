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
$stylists = getUnspecialistStylists($_GET['id']);
if (!$service)
    return header('Location: ./admin-services.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMsg = '';
    $successMsg = '';
    $query = "INSERT INTO stylist_specialties (stylist_id, service_id) VALUES ({$_POST['stylist']}, {$_GET['id']})";
    if (mysqli_query($conn, $query)) {
        if(mysqli_affected_rows($conn) > 0)
            $successMsg = 'Stylist specialty added successfully';
        else 
            $errorMsg = 'Failed to add stylist';
    }

    echo '<script>setTimeout(function() {
            window.location.href = "./admin-view-service.php?id=' . $_GET['id'] . '";
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
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Add Specialist
                    (Service #<?php echo $service['id']; ?>)</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <form id="edit-service" style="display: flex; gap: 1.5rem;" method="POST"
                        enctype="multipart/form-data">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div
                                style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem; display: flex; align-items: center;">
                                <img src="./uploads/services/<?php echo $service['img_path']; ?>" alt="Image"
                                    style="width: 100%; height: 100%;">
                            </div>
                        </div>
                        <div
                            style="display: flex; flex-direction: column; justify-content: space-between; gap: 1rem; width: 100%;">
                            <div class="add-service-container">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="name">Stylist</label>
                                    <select name="stylist" id="stylist"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;">
                                        <?php foreach ($stylists as $stylist): ?>
                                            <option value="<?php echo $stylist['id']; ?>"><?php echo $stylist['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
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