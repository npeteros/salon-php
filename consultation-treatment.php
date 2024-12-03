<?php
define("FILE_CSS", "src/styles/consultation-hair.css");
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if(!isset($_POST['type']) || !isset($_POST['texture']) || !isset($_POST['hair']))
    header("Location: ./consultation-hair.php");

include 'src/api/functions.php';

$consultation = getConsultationByCustomer($_SESSION['user']['id']);
if ($consultation)
    header('Location: ./consultations.php');

$treatments = getAllTreatmentsByCharacteristics($_POST['type'], $_POST['texture'], $_POST['hair']);
?>

<div style="min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div style="display: flex; height: 100%; gap: 1rem;">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;;">
            <div
                style="display: flex; padding: 1rem; flex-direction: column; gap: 1rem; border-radius: 1rem; background-color: #ffffff;">
                <ol>
                    <li class="next">
                        <span class="progress inactive">
                            1
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Hair</h3>
                        </span>
                    </li>
                    <li class="next active">
                        <span class="progress active">
                            2
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Treatment</h3>
                        </span>
                    </li>
                    <li class="next">
                        <span class="progress inactive">
                            3
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">History</h3>
                        </span>
                    </li>
                    <li class="next">
                        <span class="progress inactive">
                            4
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Timeline</h3>
                        </span>
                    </li>
                </ol>
                <div
                    style="display: flex; padding-left: 1rem; padding-right: 1rem; flex-direction: column; border-radius: 1rem;">
                    <form method="post" action="./consultation-previous.php"
                        style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label for="treatment">Recommended Treatments:</label>
                            <select name="treatment"
                                style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                required>
                                <?php
                                foreach ($treatments as $treatment) {
                                    echo '<option value="' . $treatment['treatment_id'] . '">' . $treatment['name'] . '</option>';
                                }
                                ?>
                            </select>
                            <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
                            <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                            <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                        </div>
                        <button class="next-button" type="submit">Next</button>
                    </form>
                    <button class="cancel-button" type="button"
                        onclick="window.location.href = './dashboard.php'">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>