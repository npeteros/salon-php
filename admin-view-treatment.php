<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if (!isset($_GET['id']))
    header('Location: ./appointments.php');
include 'src/api/functions.php';
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');

$treatment = getTreatmentById($_GET['id']);
$treatments = getAllTreatments() ?? [];
$service = getPopularServiceById($treatment['id']);
$services = getAllServices();
$previousTreatments = getPreviousTreatmentsById($_GET['id']) ?? [];
if (!$treatment)
    return header('Location: ./treatments.php');
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/admin_side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Treatment
                    Details (#<?php echo $treatment['treatment_id']; ?>)</span>
                <div style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <div style="display: flex; gap: 1rem;">
                            <div style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem;">
                                <img src="./uploads/services/<?php echo $treatment['img_path']; ?>" alt="Image" style="width: 100%; height: 100%;">
                            </div>
                            <div
                                style="display: flex; flex-direction: column; gap: 0.25rem; width: 12rem; align-items: start;">
                                <span
                                    style="font-weight: 700; font-size: 1.875rem;"><?php echo $treatment['name'] ?></span>
                                    <span style="opacity: 50%;">Used in <?php echo $service['appointment_count'] ?>
                                        appointment<?php echo $service['appointment_count'] <= 1 ? '' : 's' ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem">
                            <button
                                style="padding-top: 0.625rem; padding-bottom: 0.625rem; padding-left: 1.25rem; padding-right: 1.25rem; margin-bottom: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #ffffff; height: fit-content; background-color: #E53C37; border: none; cursor: pointer;"
                                onclick="window.location.href = './edit-treatment.php?id=<?php echo $treatment['treatment_id']; ?>'">Edit Treatment</button>
                            <button
                                style="padding-top: 0.625rem; padding-bottom: 0.625rem; padding-left: 1.25rem; padding-right: 1.25rem; margin-bottom: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #E53C37; height: fit-content; background-color: white; border: 1px solid #E53C37; cursor: pointer;"
                                id="delete-treatment" data-id="<?php echo $treatment['treatment_id']; ?>">Delete Treatment</button>
                            <span style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                id="treatment-error"></span>
                        </div>
                    </div>
                    <div style=" grid-column: span 2 / span 2; margin: 1rem 0;" class="divider"></div>
                    <div style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%;">
                            <div style="display: grid; 	grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; width: 100%;">
                                <input type="hidden" name="service_id" value="<?php echo $treatment['service_id']; ?>">
                                <span style="grid-column: span 2 / span 2; font-weight: bold; font-size: 1.125rem; line-height: 1.75rem;">Previous Treatment Requirements</span>
                                <?php foreach ($services as $service):
                                    $previousTreatmentIndex = array_search($service['id'], array_column($previousTreatments, 'prev_service_id'));
                                ?>
                                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                        <label for="rebond"><?php echo $service['name']; ?></label>
                                        <span style="margin-left: 1rem; font-size: 0.875rem; line-height: 1.25rem;"><?php echo $previousTreatments[$previousTreatmentIndex]['min_time_months']; ?> month<?php echo $previousTreatments[$previousTreatmentIndex]['min_time_months'] <= 1 ? '' : 's' ?> minimum time span</span>
                                    </div>
                                <?php endforeach; ?>
                                <div style=" grid-column: span 2 / span 2; margin: 1rem 0;" class="divider"></div>
                                    <span style="grid-column: span 2 / span 2; font-weight: bold; font-size: 1.125rem; line-height: 1.75rem;">Alternative Treatments</span>
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

                                        foreach ($services as $service): 
                                            if (isset($alternativeTreatments[$service['id']])): ?>
                                            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                                <div style="display: flex; align-items: center; gap: 0.25rem; margin-top: 0.5rem;">
                                                    <label for="checkbox-<?php echo $service['id']; ?>">
                                                        <?php echo htmlspecialchars($service['name']); ?>
                                                    </label>
                                                </div>
                                                <div style="display: flex; flex-direction: column; gap: 0.5rem; grid-column: span 2 / span 2;">
                                                <span style="margin-left: 1rem; font-size: 0.75rem; line-height: 1.25rem;">
                                                    Reason: <?php echo htmlspecialchars($alternativeTreatments[$service['id']]); ?>
                                                </span>
                                                </div>
                                            </div>
                                        <?php endif; endforeach; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>