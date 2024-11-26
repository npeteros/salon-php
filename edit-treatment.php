<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] != 'owner' && $_SESSION['user']['role'] != 'manager')
    header('Location: ./index.php');
include 'src/api/functions.php';

$treatment = getTreatmentEditInfo($_GET['id']);
$treatments = getAllTreatments() ?? [];
$previousTreatments = getPreviousTreatmentsById($_GET['id']) ?? [];
$services = getAllServices();
if (!isset($_GET['id']) && !$treatment)
    return header('Location: ./admin-treatments.php');

$errorMsg = '';
$successMsg = '';

function editTreatment($conn, $treatmentId, $postData)
{

    $treatmentInfo = getTreatmentEditInfo($_GET['id']);

    // Ensure $postData contains valid data
    if (!isset($postData['service_id']) || !isset($postData['min_time'])) {
        $errorMsg = "Missing required data.";
        return $errorMsg;
    }

    $serviceId = intval($postData['service_id']);
    $minTime = $postData['min_time'];
    $alternatives = $postData['alternatives'] ?? null;

    if ($treatmentInfo['service_id'] != $serviceId) {
        $query = "UPDATE treatments SET service_id = {$serviceId} WHERE id = {$treatmentId};";
        if (!mysqli_query($conn, $query)) {
            $errorMsg = "Error updating treatment's service ID";
            return $errorMsg;
        }
    }

    // Handle the previous treatments (min_time)
    foreach ($minTime as $prevTreatmentId => $minTimeMonths) {
        $minTimeMonths = ($minTimeMonths == "") ? 0 : intval($minTimeMonths);

        // Check if the previous treatment record exists
        $query = "SELECT COUNT(*) AS count FROM previous_treatments WHERE treatment_id = {$treatmentId} AND prev_treatment_id = {$prevTreatmentId};";
        $count = mysqli_fetch_array(mysqli_query($conn, $query))['count'];

        if ($count == 0) {
            // Insert a new record if it doesn't exist
            $query = "INSERT INTO previous_treatments (treatment_id, prev_treatment_id, min_time_months) VALUES ({$treatmentId}, {$prevTreatmentId}, {$minTimeMonths});";
            if (!mysqli_query($conn, $query)) {
                $errorMsg = "Error inserting previous treatment";
                return $errorMsg;
            }
        } else {
            // Update the existing record
            $query = "UPDATE previous_treatments SET min_time_months = {$minTimeMonths} WHERE treatment_id = {$treatmentId} AND prev_treatment_id = {$prevTreatmentId};";
            if (!mysqli_query($conn, $query)) {
                $errorMsg = "Error updating previous treatment";
                return $errorMsg;
            }
        }
    }
        // Handle the alternative treatments (alternatives)
    if ($alternatives !== null) {
        foreach ($alternatives as $altServiceId => $reason) {
            if ($reason == "") {
                $query = "DELETE FROM alternative_treatments WHERE treatment_service_id = {$serviceId} AND alternative_service_id = {$altServiceId};";
                if(mysqli_query($conn, $query)) {
                    if (mysqli_affected_rows($conn) > 0) {
                        $successMsg = "Alternative treatment deleted successfully!";
                        return $successMsg;
                    }
                }
            }

            // Check if the alternative treatment record exists
            $query = "SELECT COUNT(*) AS count FROM alternative_treatments WHERE treatment_service_id = {$serviceId} AND alternative_service_id = {$altServiceId};";
            $count = mysqli_fetch_array(mysqli_query($conn, $query))['count'];
            $altReason = mysqli_real_escape_string($conn, $reason);

            if ($count == 0) {
                // Insert a new alternative treatment record if it doesn't exist
                $query = "INSERT INTO alternative_treatments (treatment_service_id, alternative_service_id, reason) VALUES ({$serviceId}, {$altServiceId}, '{$altReason}');";
                if (!mysqli_query($conn, $query)) {
                    $errorMsg = "Error inserting alternative treatment";
                    return $errorMsg;
                }
            } else {
                // Update the existing record with the reason
                $query = "UPDATE alternative_treatments SET reason = '{$altReason}' WHERE treatment_service_id = {$serviceId} AND alternative_service_id = {$altServiceId};";
                if (!mysqli_query($conn, $query)) {
                    $errorMsg = "Error updating alternative treatment";
                    return $errorMsg;
                }
            }
        }
    }

    // Success message
    $successMsg = "Treatment updated successfully!";
    return $successMsg;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = editTreatment($conn, $_GET['id'], $_POST);
    if (strpos($result, 'success') !== false) {
        $successMsg = $result;
        
        echo '<script>setTimeout(function() {
            window.location.href = "./admin-view-treatment.php?id=' . $_GET['id'] . '";
        }, 2000);</script>';
    } else {
        $errorMsg = $result;
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
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Edit Treatment
                    (#<?php echo $treatment['id']; ?>)</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <form id="edit-treatment" style="display: flex; gap: 1.5rem;" method="POST">
                        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%;">
                            <div
                                style="display: grid; 	grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; width: 100%;">
                                <input type="hidden" name="service_id" value="<?php echo $treatment['service_id']; ?>">
                                <span
                                    style="grid-column: span 2 / span 2; font-weight: bold; font-size: 1.125rem; line-height: 1.75rem;">Previous
                                    Treatment Requirements</span>
                                <?php
                                foreach ($treatments as $prevTreatment):
                                    $previousTreatmentIndex = array_search($prevTreatment['treatment_id'], array_column($previousTreatments, 'prev_treatment_id'));
                                    // if ($prevTreatment['treatment_id'] == $treatment['treatment_id'])
                                    //     continue;
                                    ?>
                                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                        <label for="rebond"><?php echo $prevTreatment['name']; ?> <span
                                                style="font-size: 0.75rem; line-height: 1rem;">(Leave blank if
                                                NA)</span></label>
                                        <input type="number" name="min_time[<?php echo $prevTreatment['treatment_id']; ?>]"
                                            <?php if (is_numeric($previousTreatmentIndex)) { ?>
                                                value="<?php echo $previousTreatments[$previousTreatmentIndex]['min_time_months']; ?>"
                                            <?php } ?>
                                            style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                            placeholder="Minimum time span (in months)" />
                                    </div>
                                <?php endforeach; ?>
                                <div style=" grid-column: span 2 / span 2; margin: 1rem 0;" class="divider"></div>
                                <span
                                    style="grid-column: span 2 / span 2; font-weight: bold; font-size: 1.125rem; line-height: 1.75rem;">Select
                                    Alternative Treatments</span>
                                <?php 
                                
                                $treatmentIds = array_column($treatments, 'treatment_id');
                                $serviceIds = array_column($treatments, 'service_id');
                                
                                $query = "SELECT treatment_service_id, alternative_service_id, reason 
                                          FROM alternative_treatments 
                                          WHERE treatment_service_id IN (" . implode(',', $serviceIds) . ")";
                                
                                $result = $conn->query($query);
                                $alternativeTreatments = [];
                                
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $alternativeTreatments[$row['alternative_service_id']] = $row['reason'];
                                }

                                foreach ($treatments as $treatment): ?>
                                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                        <div style="display: flex; align-items: center; gap: 0.25rem; margin-top: 0.5rem;">
                                            <input type="checkbox"
                                                name="alternatives[<?php echo $treatment['service_id']; ?>]" 
                                                value="1"
                                                id="checkbox-<?php echo $treatment['treatment_id']; ?>"
                                                <?php if (isset($alternativeTreatments[$treatment['service_id']])): ?> checked <?php endif; ?>
                                                onclick="toggleTextarea(<?php echo $treatment['treatment_id']; ?>)">
                                            <label for="checkbox-<?php echo $treatment['treatment_id']; ?>">
                                                <?php echo htmlspecialchars($treatment['name']); ?>
                                            </label><span
                                                style="font-size: 0.75rem; line-height: 1rem;">(Leave blank to remove alternative treatment)</span></label>
                                        </div>
                                        <div style="display: flex; flex-direction: column; gap: 0.5rem; grid-column: span 2 / span 2;">
                                            <textarea name="alternatives[<?php echo $treatment['service_id']; ?>]"
                                                id="textarea-<?php echo $treatment['treatment_id']; ?>"
                                                placeholder="This alternative treatment is recommended due to the following reasons:"
                                                <?php if (!isset($alternativeTreatments[$treatment['service_id']])): ?> disabled <?php endif; ?>><?php echo isset($alternativeTreatments[$treatment['service_id']]) ? htmlspecialchars($alternativeTreatments[$treatment['service_id']]) : ''; ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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