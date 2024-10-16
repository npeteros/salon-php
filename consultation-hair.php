<?php 
define("FILE_CSS", "src/styles/consultation-hair.css");
include 'src/includes/header.php';
if(!isset($_SESSION['user'])) header('Location: ./login.php');
?>

<div style="min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div style="display: flex; height: 100%; gap: 1rem;">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;;">
            <div style="display: flex; padding: 1rem; flex-direction: column; gap: 1rem; border-radius: 1rem; background-color: #ffffff;">
                <ol>
                    <li class="next active">
                        <span
                            class="progress active">
                            1
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Hair</h3>
                        </span>
                    </li>
                    <li class="next">
                        <span
                            class="progress inactive">
                            2
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Scalp</h3>
                        </span>
                    </li>
                    <li class="next">
                        <span
                            class="progress inactive">
                            3
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Treatment</h3>
                        </span>
                    </li>
                    <li class="">
                        <span
                            class="progress inactive">
                            4
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Confirm</h3>
                        </span>
                    </li>
                </ol>
                <div style="display: flex; padding-left: 1rem; padding-right: 1rem; flex-direction: column; border-radius: 1rem;">
                    <form method="post" action="./consultation-scalp.php" style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; gap: 1rem;">
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
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                                <label for="name" style="font-weight: 700;">Hair Condition</label>
                                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));">
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
                        <?php if(isset($_POST['straightening'])) { ?>
                                <input type="hidden" name="straightening" value="<?php echo $_POST['straightening']; ?>">
                                <input type="hidden" name="perming" value="<?php echo $_POST['perming']; ?>">
                                <input type="hidden" name="relax" value="<?php echo $_POST['relax']; ?>">
                                <input type="hidden" name="coloring" value="<?php echo $_POST['coloring']; ?>">
                                <input type="hidden" name="rebonding" value="<?php echo $_POST['rebonding']; ?>">
                                <input type="hidden" name="bleaching" value="<?php echo $_POST['bleaching']; ?>">
                        <?php } ?>
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