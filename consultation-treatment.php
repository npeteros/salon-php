<?php 
if (!isset($_POST['type']) || !isset($_POST['texture']) || !isset($_POST['hair']))
    return header("Location: ./consultation-hair.php");
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';
?>

<script>
    function clearRadio(name) {
        $('input[name="' + name + '"]').prop("checked", false);
        $('input[name="' + name + '"]').change();
    }
</script>

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
                            <h3 style="font-weight: 500; line-height: 1.25;">Treatment</h3>
                        </span>
                    </li>
                    <li class="next">
                        <span
                            class="progress inactive">
                            3
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Confirm</h3>
                        </span>
                    </li>
                    <li class="">
                        <span
                            class="progress inactive">
                            4
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Recommendation</h3>
                        </span>
                    </li>
                </ol>
                <div style="display: flex; padding-left: 1rem; padding-right: 1rem; flex-direction: column; border-radius: 1rem;">
                    <form method="post" action="./consultation-confirm.php" style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                <div style="display: flex; flex-direction: column;">
                                    <label for="name" style="font-weight: 700;">Previous Hair Treatment</label>
                                    <span style="font-size: 0.75rem; line-height: 1rem; font-style: italic;">How long have you been using the following:</span>
                                </div>
                                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem;">
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span
                                                style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Perming</span>
                                            <span style="color: #E53C37; font-size: 0.875rem; cursor: pointer;" onclick="clearRadio('perming')">Clear</span>
                                        </div>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="perming" type="radio" value="less"
                                                        name="perming"
                                                        <?php echo isset($_POST['perming']) ? $_POST['perming'] == "less" ? "checked" : "" : null; ?>
                                                        class="form-input">
                                                    <label for="perming-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Less
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="perming" type="radio" value="more" name="perming"
                                                        <?php echo isset($_POST['perming']) ? $_POST['perming'] == "more" ? "checked" : "" : null; ?>
                                                        class="form-input">
                                                    <label for="perming-more"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">More
                                                        than 6 months</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span
                                                style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Rebonding</span>
                                            <span style="color: #E53C37; font-size: 0.875rem; cursor: pointer;" onclick="clearRadio('rebonding')">Clear</span>
                                        </div>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="rebonding" type="radio" value="less"
                                                        name="rebonding"
                                                        <?php echo isset($_POST['rebonding']) ? $_POST['rebonding'] == "less" ? "checked" : "" : null; ?>
                                                        class="form-input">
                                                    <label for="rebonding-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Less
                                                        than 6 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="rebonding" type="radio" value="more" name="rebonding"
                                                        <?php echo isset($_POST['rebonding']) ? $_POST['rebonding'] == "more" ? "checked" : "" : null; ?>
                                                        class="form-input">
                                                    <label for="rebonding-more"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">More
                                                        than 6 months</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span
                                                style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Relax</span>
                                            <span style="color: #E53C37; font-size: 0.875rem; cursor: pointer;" onclick="clearRadio('relax')">Clear</span>
                                        </div>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="relax" type="radio" value="less" name="relax"
                                                        <?php echo isset($_POST['relax']) ? $_POST['relax'] == "less" ? "checked" : "" : null; ?>
                                                        class="form-input">
                                                    <label for="relax-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Less
                                                        than 2 months</label>
                                                </div>
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="relax" type="radio" value="more" name="relax"
                                                        <?php echo isset($_POST['relax']) ? $_POST['relax'] == "more" ? "checked" : "" : null; ?>
                                                        class="form-input">
                                                    <label for="relax-more"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">More
                                                        than 2 months</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span
                                                style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500;">Hair Bleaching</span>
                                            <span style="color: #E53C37; font-size: 0.875rem; cursor: pointer;" onclick="clearRadio('bleaching')">Clear</span>
                                        </div>
                                        <div
                                            style="display: flex; padding: 0rem 1rem; align-items: center; border-radius: 0.25rem; border: 1px solid rgb(229 229 229);">
                                            <div style="display: flex; justify-content: space-between; width: 2/3; padding: 1rem 0rem;">
                                                <div style="display: flex; height: full; align-items: center;">
                                                    <input id="bleaching" type="radio" value="yes"
                                                        name="bleaching"
                                                        <?php echo isset($_POST['bleaching']) ? "checked" : ""; ?>
                                                        class="form-input">
                                                    <label for="bleaching-less"
                                                        style="margin-left: 0.5rem; font-size: 0.875 rem; line-height: 1.25rem; color: rgb(23 23 23);">Applicable</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 0.25rem; margin-top: 0.5rem;">
                                        <input type="checkbox" name="none" id="none">
                                        <label for="none">None of the above</label>
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
                                <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                                <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                            </div>
                        </div>
                        <button class="next-button" type="submit">Next</button>
                    </form>
                    <form action="./consultation-hair.php" method="POST">
                        <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
                        <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                        <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                        <?php if (isset($_POST['perming'])): ?> <input type="hidden" name="perming"
                                    value="<?php echo $_POST['perming']; ?>"> <?php endif; ?>
                            <?php if (isset($_POST['relax'])): ?> <input type="hidden" name="relax"
                                    value="<?php echo $_POST['relax']; ?>"> <?php endif; ?>
                            <?php if (isset($_POST['rebonding'])): ?> <input type="hidden" name="rebonding"
                                    value="<?php echo $_POST['rebonding']; ?>"> <?php endif; ?>
                            <?php if (isset($_POST['bleaching'])): ?> <input type="hidden" name="bleaching"
                                    value="<?php echo $_POST['bleaching']; ?>"> <?php endif; ?>
                        <button class="cancel-button" style="width: 100%;" type="submit">Back</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>