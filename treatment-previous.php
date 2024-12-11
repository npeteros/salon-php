<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
include 'src/api/functions.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');

if (!isset($_POST['service_id']) || !isset($_POST['attributes']))
    header("Location: ./add-treatment.php");

$services = getAllChemicalServices();

$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['treatment_previous'])) {
    $serviceId = $_POST['service_id'];
    $selectedAttributes = $_POST['attributes'] ?? [];
    $minTimes = $_POST['min_time'] ?? [];

    $treatmentQuery = "SELECT 
                service_id
            FROM 
                treatments
            WHERE service_id = {$serviceId}";

    if ($r = mysqli_query($conn, $treatmentQuery)) {
        if (mysqli_num_rows($r) > 0) {
            $errorMsg = "Treatment already exists for this service";
        } else {
            $query = "INSERT INTO treatments (service_id, ";
            foreach ($selectedAttributes as $attribute) {
                $query .= "{$attribute}, ";
            }
            $query = substr($query, 0, -2);
            $query .= ") VALUES ($serviceId, ";
            foreach ($selectedAttributes as $attribute) {
                $query .= "1, ";
            }
            $query = substr($query, 0, -2);
            $query .= ");";
            if (mysqli_query($conn, $query)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $treatmentId = mysqli_insert_id($conn);
                    $query = "";

                    foreach ($minTimes as $serviceId => $minTimeMonths) {
                        if ($minTimeMonths == "")
                            $minTimeMonths = 0;
                        $query = "INSERT INTO previous_treatments (treatment_id, prev_service_id, min_time_months) VALUES ('{$treatmentId}', '{$serviceId}', '{$minTimeMonths}');";
                        mysqli_query($conn, $query);
                    }

                    $successMsg = "Treatment created successfully";

                    echo '<script>setTimeout(function() {
                        window.location.href = "./admin-treatments.php";
                    }, 2000);</script>';
                }
            }
        }
    }
}
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/admin_side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem; display: flex; flex-direction: column; gap: 2rem;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Add
                    Treatment</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <form method="POST" action="./treatment-previous.php" style="display: flex; gap: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%;">
                            <div
                                style="display: grid; 	grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; width: 100%;">
                                <span
                                    style="grid-column: span 2 / span 2; font-weight: bold; font-size: 1.125rem; line-height: 1.75rem;">Previous
                                    Treatment Requirements</span>
                                <?php
                                if ($services):
                                    foreach ($services as $service): ?>
                                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                            <label for="rebond"><?php echo $service['name']; ?> <span
                                                    style="font-size: 0.75rem; line-height: 1rem;">(Leave blank if
                                                    NA)</span></label>
                                            <input type="number" name="min_time[<?php echo $service['id']; ?>]"
                                                style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                                placeholder="Minimum time span (in months)" />
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span>No existing treatments found</span>
                                <?php endif; ?>
                                <input type="hidden" name="service_id" value="<?php echo $_POST['service_id']; ?>">
                                <?php foreach ($_POST['attributes'] as $attribute): ?>
                                    <input type="hidden" name="attributes[]"
                                        value="<?php echo htmlspecialchars($attribute); ?>">
                                <?php endforeach; ?>
                                <input type="hidden" name="treatment_previous" value="1" />
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span
                                    style="text-align: center; <?php echo $errorMsg !== '' ? 'color: #DC2626;' : 'color: #059669;'; ?> font-size: 0.875rem; line-height: 1.25rem;"
                                    id="treatment-error"><?php echo $errorMsg === '' ? $successMsg : $errorMsg; ?></span>
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