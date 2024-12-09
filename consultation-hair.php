<?php
define("FILE_CSS", "src/styles/consultation-hair.css");
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');

include 'src/api/functions.php';

$consultation = getConsultationByCustomer($_SESSION['user']['id']);
if ($consultation)
    header('Location: ./consultations.php');

$treatments = getAllTreatments();
?>

<div style="min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div style="display: flex; height: 100%; gap: 1rem;">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;;">
            <div
                style="display: flex; padding: 1rem; flex-direction: column; gap: 1rem; border-radius: 1rem; background-color: #ffffff;">
                <ol>
                    <li class="next active">
                        <span class="progress active">
                            1
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Hair</h3>
                        </span>
                    </li>
                    <li class="next">
                        <span class="progress inactive">
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
                    <form method="post" action="./consultation-treatment.php<?php if(isset($_GET['id'])) echo "?id=" . $_GET['id']; ?>" style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                                <label for="name" style="font-weight: 700;">Hair Type</label>
                                <div style="display: grid; grid-template-rows: repeat(3, minmax(0, 1fr)); grid-auto-flow: column; height: 100%;">
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="type" id="ty-straight" value="Straight" 
                                            <?php echo isset($_POST['type']) ? $_POST['type'] == "Straight" ? "checked" : "" : null; ?>
                                            class="form-input" required />
                                        <label for="straight">Straight</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="type" id="ty-wavy" value="Wavy"
                                            <?php echo isset($_POST['type']) ? $_POST['type'] == "Wavy" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="wavy">Wavy</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="type" id="ty-curly" value="Curly"
                                            <?php echo isset($_POST['type']) ? $_POST['type'] == "Curly" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="curly">Curly</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="type" id="ty-kinky" value="Kinky"
                                            <?php echo isset($_POST['type']) ? $_POST['type'] == "Kinky" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="kinky">Kinky</label>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                                <label for="name" style="font-weight: 700;">Hair Texture</label>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="radio" name="texture" id="t-fine" value="Fine" 
                                        <?php echo isset($_POST['texture']) ? $_POST['texture'] == "Fine" ? "checked" : "" : null; ?>
                                        class="form-input" required />
                                    <label for="fine">Fine</label>
                                </div>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="radio" name="texture" id="t-medium" value="Medium"
                                        <?php echo isset($_POST['texture']) ? $_POST['texture'] == "Medium" ? "checked" : "" : null; ?>
                                        class="form-input" />
                                    <label for="medium">Medium</label>
                                </div>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="radio" name="texture" id="t-thick" value="Thick"
                                        <?php echo isset($_POST['texture']) ? $_POST['texture'] == "Thick" ? "checked" : "" : null; ?>
                                        class="form-input" />
                                    <label for="thick">Thick</label>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <label for="name" style="font-weight: 700;">Hair Condition</label>
                                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); height: 100%;">
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="hair" id="h-damaged" value="Damaged"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Damaged" ? "checked" : "" : null; ?>
                                            class="form-input" required />
                                        <label for="damaged">Damaged</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="hair" id="h-dry" value="Dry"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Dry" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="dry">Dry</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="hair" id="h-oily" value="Oily"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Oily" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="oily">Oily</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="hair" id="h-normal" value="Normal"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Normal" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="normal">Normal</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="hair" id="h-chemical" value="Chemically Treated"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Chemically Treated" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="chemical">Chemically Treated</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($_POST['scalp'])) { ?>
                            <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
                        <?php } ?>
                        <?php if (isset($_POST['perming'])): ?> <input type="hidden" name="perming"
                                    value="<?php echo $_POST['perming']; ?>"> <?php endif; ?>
                            <?php if (isset($_POST['relax'])): ?> <input type="hidden" name="relax"
                                    value="<?php echo $_POST['relax']; ?>"> <?php endif; ?>
                            <?php if (isset($_POST['rebonding'])): ?> <input type="hidden" name="rebonding"
                                    value="<?php echo $_POST['rebonding']; ?>"> <?php endif; ?>
                            <?php if (isset($_POST['bleaching'])): ?> <input type="hidden" name="bleaching"
                                    value="<?php echo $_POST['bleaching']; ?>"> <?php endif; ?>
                        <button class="next-button"
                            type="submit">Next</button>
                    </form>
                    <button class="cancel-button" type="button"
                        onclick="window.location.href = './dashboard.php'">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>