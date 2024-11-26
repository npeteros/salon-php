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
                    <form method="POST" action="./treatment-alternative.php" style="display: flex; gap: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%;">
                            <div
                                style="display: grid; 	grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; width: 100%;">
                                <span
                                    style="grid-column: span 2 / span 2; font-weight: bold; font-size: 1.125rem; line-height: 1.75rem;">Previous
                                    Treatment Requirements</span>
                                <?php
                                if ($treatments):
                                    foreach ($treatments as $treatment): ?>
                                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                            <label for="rebond"><?php echo $treatment['name']; ?> <span
                                                    style="font-size: 0.75rem; line-height: 1rem;">(Leave blank if
                                                    NA)</span></label>
                                            <input type="number" name="min_time[<?php echo $treatment['treatment_id']; ?>]"
                                                style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                                placeholder="Minimum time span (in months)" />
                                        </div>
                                    <?php endforeach;
                                else: ?>
                                <span>No existing treatments found</span>
                                <?php endif; ?>
                                <input type="hidden" name="service_id"
                                    value="<?php echo $_POST['service_id']; ?>">
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span
                                    style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                    id="treatment-error"></span>
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