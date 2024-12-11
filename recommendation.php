<?php
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';
if (!$_POST['treatment'] || !isset($_POST['type']) || !isset($_POST['texture']) || !isset($_POST['hair']))
    print_r($_POST);
// return header("Location: ./consultation-hair.php");
$treatmentId = $_POST['treatment'];
$monthTime = isset($_POST['month_time']) ? $_POST['month_time'] : null;
$previous = isset($_POST['previous']) ? $_POST['previous'] : [];

include './src/api/functions.php';
$treatment = getTreatmentById($treatmentId);

function validatePreviousTreatments($conn, $treatmentId, $previous, $monthTime)
{
    foreach ($previous as $prevServiceId) {
        $submittedMinTimeMonths = isset($monthTime[$prevServiceId]) ? (int) $monthTime[$prevServiceId] : 0;

        $query = "
            SELECT min_time_months 
            FROM previous_treatments 
            WHERE treatment_id = {$treatmentId} 
              AND prev_service_id = {$prevServiceId}";

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $storedMinTimeMonths = (int) $row['min_time_months'];
            if ($submittedMinTimeMonths < $storedMinTimeMonths) {
                return false;
            }
        } else {
            return false;
        }
    }

    return true;
}

$suitable = validatePreviousTreatments($conn, $treatmentId, $previous, $monthTime);
$created = true;

function createNewConsultation($conn, $treatmentId, $postData, $suitable)
{
    $query = "INSERT INTO consultations (customer_id, type, texture, hair) VALUES ({$_SESSION['user']['id']}, '{$postData['type']}', '{$postData['texture']}', '{$postData['hair']}')";
    if (mysqli_query($conn, $query)) {
        $consultationId = mysqli_insert_id($conn);
        if (mysqli_affected_rows($conn) > 0) {
            $status = $suitable ? "Suitable" : "Unsuitable";
            $query = "INSERT INTO client_treatments (consultation_id, treatment_id, status) VALUES ($consultationId, $treatmentId, '$status')";
            if (mysqli_query($conn, $query)) {
                return $consultationId;
            }
        }
    }
    return -1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($suitable) {
        $consultationId = createNewConsultation($conn, $treatmentId, $_POST, $suitable);
        if ($consultationId == -1)
            $created = false;
    }
}

$selectedTreatment = getTreatmentById($treatmentId);
$alternativeTreatments = getAlternativeTreatments($selectedTreatment['service_id']) ?? [];
// print_r($suitable ? "Note: This treatment is suitable for your hair." : "Note: This treatment is NOT suitable for your hair.");
?>
<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Hair Treatment
                    Recommendation</span>
                <?php if (!$created): ?>
                    <div
                        style="display: flex; flex-direction: column; align-items: center; gap: 2rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                        <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: #E53C37;">
                            There was an error in saving your consultation data. Please contact an administrator.
                        </span>
                    </div>
                <?php else: ?>
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
                        <span
                            style="font-size: 1rem; font-weight: bold; line-height: 1.25rem; text-align: center; color: <?php echo $suitable ? 'green' : 'red'; ?>;"><?php echo $suitable ? "Note: This treatment is suitable for your hair." : "Note: This treatment is not suitable. Please select another recommended treatment."; ?></span>

                        <div class="divider"></div>
                        <span style="font-weight: 700; font-size: 1.25rem">Hair Profile Information (For Stylist&apos;s
                            reference)</span>
                        <div style="display: flex; flex-direction: column; align-items: start; gap: 1rem; width: 100%;">
                            <div style="display: flex; gap: 0.5rem;">
                                <span style="font-weight: 700;">
                                    Hair Type:
                                </span>
                                <span><?php echo ucwords($_POST['type']); ?></span>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <span style="font-weight: 700;">
                                    Hair Texture:
                                </span>
                                <span><?php echo ucwords($_POST['texture']); ?></span>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <span style="font-weight: 700;">
                                    Hair Condition:
                                </span>
                                <span><?php echo ucwords($_POST['hair']); ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; margin-top: -1rem; width: 100%; gap: 1rem;">
                            <?php if ($suitable): ?>
                                <button class="next-button"
                                    onclick="window.location.href='./reserve-schedule.php?id=<?php echo $treatment['service_id']; ?>'">Reserve
                                    an
                                    Appointment</button>
                            <?php else: ?>
                                <button class="next-button" onclick="window.location.href='./consultation-hair.php'">Select
                                    Another Treatment</button>
                            <?php endif; ?>
                            <button class="cancel-button" style="width: 100%;"
                                onclick="window.location.href='./dashboard.php'" y>Back to Dashboard</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>