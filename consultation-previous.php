<?php
if (!isset($_POST['treatment']) || !isset($_POST['type']) || !isset($_POST['texture']) || !isset($_POST['hair']))
    return header("Location: ./consultation-hair.php");
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';
include './src/api/functions.php';

$treatments = getAllTreatments();
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
                    <li class="next">
                        <span class="progress inactive">
                            2
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Treatment</h3>
                        </span>
                    </li>
                    <li class="next active">
                        <span class="progress active">
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
                    <form method="post" action="./consultation-confirm.php"
                        style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                <div style="display: flex; flex-direction: column;">
                                    <label for="name" style="font-weight: 700;">Previous Hair Treatment</label>
                                    <span style="font-size: 0.75rem; line-height: 1rem;">Have you been recently treated
                                        with the following:</span>
                                </div>
                                <div
                                    style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
                                    <?php foreach ($treatments as $treatment): ?>
                                        <div style="display: flex; gap: 0.25rem; margin-top: 0.5rem;">
                                            <input type="checkbox" name="previous[]"
                                                value="<?php echo $treatment['treatment_id']; ?>"
                                                id="<?php echo $treatment['name']; ?>">
                                            <label
                                                for="<?php echo $treatment['name']; ?>"><?php echo $treatment['name']; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div style="display: flex; gap: 0.25rem; margin-top: 0.5rem;">
                                    <input type="checkbox" name="none" id="none">
                                    <label for="none">None of the above</label>
                                </div>
                                <input type="hidden" name="treatment" value="<?php echo $_POST['treatment']; ?>">
                                <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
                                <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                                <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                            </div>
                        </div>
                        <button class="next-button" type="submit">Next</button>
                    </form>
                    <form action="./consultation-treatment.php" method="POST">
                        <button class="cancel-button" style="width: 100%;" type="submit">Back</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>