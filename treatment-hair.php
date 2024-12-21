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
                    <form method="post" action="./treatment-previous.php" style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                                <label for="name" style="font-weight: 700;">Hair Type</label>
                                <div style="display: grid; grid-template-rows: repeat(3, minmax(0, 1fr)); grid-auto-flow: column; height: 100%;">
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="checkbox" name="attributes[]" id="ty-straight" value="straight" 
                                            <?php echo isset($_POST['type']) ? $_POST['type'] == "Straight" ? "checked" : "" : null; ?>
                                            class="form-input"  />
                                        <label for="straight">Straight</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="checkbox" name="attributes[]" id="ty-wavy" value="wavy"
                                            <?php echo isset($_POST['type']) ? $_POST['type'] == "Wavy" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="wavy">Wavy</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="checkbox" name="attributes[]" id="ty-curly" value="curly"
                                            <?php echo isset($_POST['type']) ? $_POST['type'] == "Curly" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="curly">Curly</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="checkbox" name="attributes[]" id="ty-kinky" value="kinky"
                                            <?php echo isset($_POST['type']) ? $_POST['type'] == "Kinky" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="kinky">Kinky</label>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                                <label for="name" style="font-weight: 700;">Hair Texture</label>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="checkbox" name="attributes[]" id="t-fine" value="fine" 
                                        <?php echo isset($_POST['texture']) ? $_POST['texture'] == "Fine" ? "checked" : "" : null; ?>
                                        class="form-input"  />
                                    <label for="fine">Fine</label>
                                </div>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="checkbox" name="attributes[]" id="t-medium" value="medium"
                                        <?php echo isset($_POST['texture']) ? $_POST['texture'] == "Medium" ? "checked" : "" : null; ?>
                                        class="form-input" />
                                    <label for="medium">Medium</label>
                                </div>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="checkbox" name="attributes[]" id="t-thick" value="thick"
                                        <?php echo isset($_POST['texture']) ? $_POST['texture'] == "Thick" ? "checked" : "" : null; ?>
                                        class="form-input" />
                                    <label for="thick">Thick</label>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <label for="name" style="font-weight: 700;">Hair Condition</label>
                                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); height: 100%;">
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="checkbox" name="attributes[]" id="h-damaged" value="damaged"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Damaged" ? "checked" : "" : null; ?>
                                            class="form-input"  />
                                        <label for="damaged">Damaged</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="checkbox" name="attributes[]" id="h-dry" value="dry"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Dry" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="dry">Dry</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="checkbox" name="attributes[]" id="h-oily" value="oily"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Oily" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="oily">Oily</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="checkbox" name="attributes[]" id="h-normal" value="normal"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Normal" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="normal">Normal</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="checkbox" name="attributes[]" id="h-chemical" value="chemical"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "chemical" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="chemical">Chemically Treated</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($_POST['service_id'])) { ?>
                            <input type="hidden" name="service_id" value="<?php echo $_POST['service_id']; ?>">
                        <?php } ?>
                        <button class="next-button"
                            type="submit">Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>