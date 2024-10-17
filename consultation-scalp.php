<?php 
if(!isset($_POST['type']) || !isset($_POST['texture']) || !isset($_POST['hair'])) return header("Location: ./consultation-hair.php");
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';
?>

<div style="min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div style="display: flex; height: 100%; gap: 1rem;">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;;">
            <div style="display: flex; padding: 1rem; flex-direction: column; gap: 1rem; border-radius: 1rem; background-color: #ffffff;">
                <ol>
                    <li class="next">
                        <span
                            class="progress inactive">
                            1
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Hair</h3>
                        </span>
                    </li>
                    <li class="next active">
                        <span
                            class="progress active">
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
                    <form method="post" action="./consultation-treatment.php" style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <label for="name" style="font-weight: 700;">Scalp Condition</label>
                                <div style="display: flex; justify-content: space-between; gap: 1rem;">
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="scalp" id="s-normal" value="Normal"
                                            <?php echo isset($_POST['scalp']) ? $_POST['scalp'] == "Normal" ? "checked" : "" : null; ?>
                                            class="form-input" required />
                                        <label for="normal">Normal</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="scalp" id="s-oily" value="Oily"
                                            <?php echo isset($_POST['scalp']) ? $_POST['scalp'] == "Oily" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="oily">Oily</label>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="radio" name="scalp" id="s-dry" value="Dry"
                                            <?php echo isset($_POST['scalp']) ? $_POST['scalp'] == "Dry" ? "checked" : "" : null; ?>
                                            class="form-input" />
                                        <label for="dry">Dry</label>
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
                                <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                                <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                                <?php if(isset($_POST['straightening'])) { ?>
                                        <input type="hidden" name="straightening" value="<?php echo $_POST['straightening']; ?>">
                                        <input type="hidden" name="perming" value="<?php echo $_POST['perming']; ?>">
                                        <input type="hidden" name="relax" value="<?php echo $_POST['relax']; ?>">
                                        <input type="hidden" name="coloring" value="<?php echo $_POST['coloring']; ?>">
                                        <input type="hidden" name="rebonding" value="<?php echo $_POST['rebonding']; ?>">
                                        <input type="hidden" name="bleaching" value="<?php echo $_POST['bleaching']; ?>">
                                <?php } ?>
                            </div> 
                        </div>
                        <button class="next-button" type="submit">Next</button>
                    </form>
                    <form action="./consultation-hair.php" method="POST">
                        <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
                        <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                        <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
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
                        <button class="cancel-button" style="width: 100%;" type="submit">Back</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>