<?php
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';
if (!$_POST['treatment'])
    return header("Location: ./consultation-treatment.php");
$treatmentId = $_POST['treatment'];
$monthTime = isset($_POST['month_time']) ? $_POST['month_time'] : null;
$previous = isset($_POST['previous']) ? $_POST['previous'] : [];

include './src/api/functions.php';

function validatePreviousTreatments($conn, $treatmentId, $previous, $monthTime)
{
    foreach ($previous as $prevTreatmentId) {
        $submittedMinTimeMonths = isset($monthTime[$prevTreatmentId]) ? (int) $monthTime[$prevTreatmentId] : 0;

        $query = "
            SELECT min_time_months 
            FROM previous_treatments 
            WHERE treatment_id = {$treatmentId} 
              AND prev_treatment_id = {$prevTreatmentId}";

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
                        style="font-size: 1rem; font-weight: bold; line-height: 1.25rem; text-align: center; color: <?php echo $suitable ? 'green' : 'red'; ?>;"><?php echo $suitable ? "Note: This treatment is suitable for your hair." : "Note: This treatment is NOT suitable for your hair."; ?></span>

                    <?php if (!$suitable): ?>
                        <div class="divider"></div>
                        <div style="display: flex; flex-direction: column; align-items: start; gap: 1rem; width: 100%;">
                            <span style="font-weight: 700; font-size: 1.25rem; text-align: center;">Alternative Recommended Treatments:</span>
                            <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; width: 100%;">
                                <?php foreach ($alternativeTreatments as $alternativeTreatment): ?>
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
                                            style="font-size: 1rem; font-weight: bold; line-height: 1.25rem; text-align: center; opacity: 80%;">Note:
                                            <?php echo $alternativeTreatment['reason']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div style="display: flex; flex-direction: column; margin-top: -1rem; width: 100%;">
                        <form id="submit-consultation" method="post"
                            style="display: flex; flex-direction: column; gap: 1rem;">
                            <input type="hidden" name="customer" id="customer"
                                value="<?php echo $_SESSION['user']['id']; ?>">
                            <input type="hidden" name="treatment" value="<?php echo $_POST['treatment']; ?>">
                            <?php if (isset($_POST['month_time'])): ?> <input type="hidden" name="month_time"
                                    value="<?php echo $_POST['month_time']; ?>"> <?php endif; ?>
                            <?php if (isset($_POST['previous'])): ?> <input type="hidden" name="previous"
                                    value="<?php echo $_POST['previous']; ?>"> <?php endif; ?>
                            <span style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                id="reservation-error"></span>
                            <button class="next-button" type="button" id="redirect-appointment" style="display: none;"
                                onclick="window.location.href='./reserve-schedule.php'">Reserve an
                                Appointment</button>
                            <button class="cancel-button" type="button" id="back-dashboard" style="display: none;"
                                onclick="window.location.href='./dashboard.php'">Back to Dashboard</button>
                            <span style="font-size: 0.875rem; line-height: 1.25rem; text-align: center; color: #DC2626;"
                                id="consultation-error"></span>
                            <button class="next-button" type="submit" id="submit-consultation-btn">Submit</button>
                        </form>
                        <form action="./consultation-confirm.php" method="POST">
                            <button class="cancel-button" style="width: 100%;" type="submit"
                                id="back-consultation-btn">Back</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>