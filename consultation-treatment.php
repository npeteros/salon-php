<?php 
if (!isset($_POST['texture']) || !isset($_POST['hair']) || !isset($_POST['scalp']))
    return header("Location: ./consultation-scalp.php");
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
                    <li class="next">
                        <span
                            class="progress inactive">
                            2
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Scalp</h3>
                        </span>
                    </li>
                    <li class="next active">
                        <span
                            class="progress active">
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
                    <form method="post" action="./consultation-confirm.php" style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                <div style="display: flex; flex-direction: column;">
                                    <label for="name" style="font-weight: 700;">Scalp Condition</label>
                                    <span style="font-size: 0.75rem; line-height: 1rem; font-style: italic;">How long have you been using the following:</span>
                                </div>
                                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem;">
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Straightening</span>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="straightening" type="radio" value="less" required
                                                        name="straightening"
                                                        <?php echo isset($_POST['straightening']) ? $_POST['straightening'] == "less" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="straightening-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Less
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="straightening" type="radio" value="more"
                                                        name="straightening"
                                                        <?php echo isset($_POST['straightening']) ? $_POST['straightening'] == "more" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="straightening-more"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">More
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="straightening" type="radio" value="none"
                                                        name="straightening"
                                                        <?php echo isset($_POST['straightening']) ? $_POST['straightening'] == "none" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="straightening-none"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span
                                            style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Perming</span>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="perming" type="radio" value="less" required
                                                        name="perming"
                                                        <?php echo isset($_POST['perming']) ? $_POST['perming'] == "less" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="perming-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Less
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="perming" type="radio" value="more" name="perming"
                                                        <?php echo isset($_POST['perming']) ? $_POST['perming'] == "more" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="perming-more"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">More
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="perming" type="radio" value="none" name="perming"
                                                        <?php echo isset($_POST['perming']) ? $_POST['perming'] == "none" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="perming-none"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span
                                            style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Relax</span>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="relax" type="radio" value="less" required name="relax"
                                                        <?php echo isset($_POST['relax']) ? $_POST['relax'] == "less" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="relax-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Less
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="relax" type="radio" value="more" name="relax"
                                                        <?php echo isset($_POST['relax']) ? $_POST['relax'] == "more" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="relax-more"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">More
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="relax" type="radio" value="none" name="relax"
                                                        <?php echo isset($_POST['relax']) ? $_POST['relax'] == "none" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="relax-none"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span
                                            style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Coloring</span>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="coloring" type="radio" value="less" required
                                                        name="coloring"
                                                        <?php echo isset($_POST['coloring']) ? $_POST['coloring'] == "less" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="coloring-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Less
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="coloring" type="radio" value="more" name="coloring"
                                                        <?php echo isset($_POST['coloring']) ? $_POST['coloring'] == "more" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="coloring-more"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">More
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="coloring" type="radio" value="none" name="coloring"
                                                        <?php echo isset($_POST['coloring']) ? $_POST['coloring'] == "none" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="coloring-none"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span
                                            style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Rebonding</span>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="rebonding" type="radio" value="less" required
                                                        name="rebonding"
                                                        <?php echo isset($_POST['rebonding']) ? $_POST['rebonding'] == "less" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="rebonding-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Less
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="rebonding" type="radio" value="more" name="rebonding"
                                                        <?php echo isset($_POST['rebonding']) ? $_POST['rebonding'] == "more" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="rebonding-more"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">More
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="rebonding" type="radio" value="none" name="rebonding"
                                                        <?php echo isset($_POST['rebonding']) ? $_POST['rebonding'] == "none" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="rebonding-none"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span
                                            style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Hair
                                            Bleaching</span>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="bleaching" type="radio" value="less" required
                                                        name="bleaching"
                                                        <?php echo isset($_POST['bleaching']) ? $_POST['bleaching'] == "less" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="bleaching-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Less
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="bleaching" type="radio" value="more" name="bleaching"
                                                        <?php echo isset($_POST['bleaching']) ? $_POST['bleaching'] == "more" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="bleaching-more"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">More
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="bleaching" type="radio" value="none" name="bleaching"
                                                        <?php echo isset($_POST['bleaching']) ? $_POST['bleaching'] == "none" ? "checked" : "" : null; ?>
                                                        class="form-input"">
                                                    <label for="bleaching-none"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                                <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                                <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
                            </div>
                        </div>
                        <button class="next-button" type="submit">Next</button>
                    </form>
                    <form action="./consultation-scalp.php" method="POST">
                        <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                        <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                        <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
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