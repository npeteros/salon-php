<?php
define("FILE_CSS", "src/styles/consultation-hair.css");
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if (!isset($_POST['type']) || !isset($_POST['texture']) || !isset($_POST['hair']))
    header("Location: ./consultation-hair.php");

include 'src/api/functions.php';

$consultation = getConsultationByCustomer($_SESSION['user']['id']);
if ($consultation)
    header('Location: ./consultations.php');

$treatments = getAllTreatmentsByCharacteristics($_POST['type'], $_POST['texture'], $_POST['hair']);


if (isset($_GET['id']) && in_array($_GET['id'], array_column($treatments, 'service_id')) && isset($_POST['type']) && isset($_POST['texture']) && isset($_POST['hair'])) {

    $id = $_GET['id'];
    echo '<form method="post" action="./consultation-previous.php" id="redirectForm">
            <input type="hidden" name="treatment" value="' . $id . '">
            <input type="hidden" name="type" value="' . htmlspecialchars($_POST['type']) . '">
            <input type="hidden" name="texture" value="' . htmlspecialchars($_POST['texture']) . '">
            <input type="hidden" name="hair" value="' . htmlspecialchars($_POST['hair']) . '">
    </form>';

    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("redirectForm").submit();
    });
    </script>';
}
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
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <?php if (count($treatments)): ?>
                                <label for="treatment">Recommended Treatments:</label>
                                <div id="consultationList">
                                    <?php
                                    foreach ($treatments as $treatment):
                                        ?>
                                        <div
                                            style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: white; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <img src="./uploads/services/<?php echo $treatment['img_path']; ?>" alt="Image"
                                                    style="width: 3rem; height: 3rem; border-radius: 9999px;">
                                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                                    <span
                                                        style="font-size: 1.125rem; line-height: 1.75rem;"><?php echo $treatment['name']; ?></span>
                                                    <span style="font-size: 0.875rem; line-height: 1.25rem;">
                                                        <?php echo $treatment['description'] && strlen($treatment['description']) > 35 ? substr($treatment['description'], 0, 35) . '...' : $treatment['description']; ?></span>
                                                </div>
                                            </div>
                                            <div
                                                style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                                                <span style="color: #49454F; text-align: right;">&#x20B1;
                                                    <?php echo $treatment['price']; ?></span>
                                                <form method="post" action="./consultation-previous.php">
                                                    <input type="hidden" name="treatment"
                                                        value="<?php echo $treatment['treatment_id']; ?>">
                                                    <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
                                                    <input type="hidden" name="texture"
                                                        value="<?php echo $_POST['texture']; ?>">
                                                    <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                                                    <button type="submit"
                                                        style="background-color: #A80011; border: 0px; color: white; padding: 0.5rem; border-radius: 0.5rem; cursor: pointer;">Select</button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach;
                                    ?>
                                </div>
                                <!-- <select name="treatment"
                                style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                required>
                                <?php
                                foreach ($treatments as $treatment) {
                                    echo '<option value="' . $treatment['treatment_id'] . '">' . $treatment['name'] . '</option>';
                                }
                                ?>
                            </select> -->
                            <?php else: ?>
                                <label for="name" style="font-weight: 700; text-align: center; color: red;">There are no
                                    available treatments for your hair type.</label>
                            <?php endif; ?>
                        </div>
                        <button class=" next-button" type="submit" <?php echo count($treatments) == 0 ? 'disabled' : ''; ?>
                            style="<?php echo count($treatments) == 0 ? 'cursor: not-allowed; color: #6B7280; background: #D9D9D9;' : ''; ?>">Next</button>
                    </div>
                    <button class="cancel-button" style="margin-top: 1rem;" type="button"
                        onclick="window.location.href = './consultation-hair.php'">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>