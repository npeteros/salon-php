<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
include 'src/api/functions.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');

if (!isset($_POST['service_id']))
    header("Location: ./add-treatment.php");

$services = getAllServices();
$treatments = getAllTreatments();

$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['treatment_alternative'])) {
    $serviceId = $_POST['service_id'];
    $minTimes = $_POST['min_time'] ?? [];
    $alternatives = $_POST['treatments'] ?? [];

    $treatmentQuery = "SELECT 
                service_id
            FROM 
                treatments
            WHERE service_id = {$serviceId}";

    if ($r = mysqli_query($conn, $treatmentQuery)) {
        if (mysqli_num_rows($r) > 0) {
            $errorMsg = "Treatment already exists for this service";
        } else {
            $query = "INSERT INTO treatments (service_id) VALUES ($serviceId);";
            if (mysqli_query($conn, $query)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $treatmentId = mysqli_insert_id($conn);
                    $query = "";
                    
                    foreach ($minTimes as $prevTreatmentId => $minTimeMonths) {
                        if ($minTimeMonths == "")
                            $minTimeMonths = 0;
                        $query = "INSERT INTO previous_treatments (treatment_id, prev_treatment_id, min_time_months) VALUES ('{$treatmentId}', '{$prevTreatmentId}', '{$minTimeMonths}');";
                        mysqli_query($conn, $query);
                    }

                    $query = "";
                    foreach ($alternatives as $alternativeServiceId => $reason) {
                        $query = "INSERT INTO alternative_treatments (treatment_service_id, alternative_service_id, reason) VALUES ({$serviceId}, {$alternativeServiceId}, '{$reason}');";
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

<script>
    function toggleTextarea(treatmentId) {
        const checkbox = document.getElementById(`checkbox-${treatmentId}`);
        const textarea = document.getElementById(`textarea-${treatmentId}`);
        textarea.disabled = !checkbox.checked;
        textarea.value = "";
    }
</script>

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
                    <form method="POST" action="./treatment-alternative.php" style="display: flex; gap: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%;">
                            <div
                                style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; width: 100%;">
                                <span
                                    style="grid-column: span 2 / span 2; font-weight: bold; font-size: 1.125rem; line-height: 1.75rem;">Select
                                    Alternative Treatments</span>
                                <?php
                                if ($treatments):
                                    foreach ($treatments as $treatment): ?>
                                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                            <div style="display: flex; gap: 0.25rem; margin-top: 0.5rem;">
                                                <input type="checkbox"
                                                    name="treatments[<?php echo $treatment['service_id']; ?>]" value="1"
                                                    id="checkbox-<?php echo $treatment['treatment_id']; ?>"
                                                    onclick="toggleTextarea(<?php echo $treatment['treatment_id']; ?>)">
                                                <label for="checkbox-<?php echo $treatment['treatment_id']; ?>">
                                                    <?php echo htmlspecialchars($treatment['name']); ?>
                                                </label>
                                            </div>
                                            <div
                                                style="display: flex; flex-direction: column; gap: 0.5rem; grid-column: span 2 / span 2;">
                                                <textarea name="treatments[<?php echo $treatment['service_id']; ?>]"
                                                    id="textarea-<?php echo $treatment['treatment_id']; ?>"
                                                    placeholder="This alternative treatment is recommended due to the following reasons:"
                                                    disabled></textarea>
                                            </div>
                                        </div>
                                    <?php endforeach;
                                else: ?>
                                    <span>No existing treatments found</span>
                                <?php endif; ?>
                                <input type="hidden" name="service_id" value="<?php echo $_POST['service_id']; ?>">
                                <?php if (isset($_POST['min_time'])): ?>
                                    <?php foreach ($_POST['min_time'] as $index => $value): ?>
                                        <input type="hidden" name="min_time[<?php echo $index; ?>]"
                                            value="<?php echo htmlspecialchars($value); ?>">
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <input type="hidden" name="treatment_alternative" value="1" />
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span
                                    style="text-align: center; <?php echo $errorMsg !== '' ? 'color: #DC2626;' : 'color: #059669;'; ?> font-size: 0.875rem; line-height: 1.25rem;"
                                    id="treatment-error"><?php echo $errorMsg === '' ? $successMsg : $errorMsg; ?></span>
                                <button class="next-button" type="submit">Next</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>