<?php
if (!isset($_POST['treatment']) || !isset($_POST['type']) || !isset($_POST['texture']) || !isset($_POST['hair']))
    // return header("Location: ./consultation-hair.php");
    print_r($_POST);
if (!isset($_POST['previous']) && !isset($_POST['none'])) {
    $data = [
        'treatment' => $_POST['treatment'],
        'type' => $_POST['type'],
        'texture' => $_POST['texture'],
        'hair' => $_POST['hair'],
    ];

    echo '<form id="redirectForm" action="./recommendation.php" method="post">';
    foreach ($data as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.getElementById("redirectForm").submit();</script>';
}
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';
if (isset($_POST['none'])) {
    $data = [
        'treatment' => $_POST['treatment'],
        'type' => $_POST['type'],
        'texture' => $_POST['texture'],
        'hair' => $_POST['hair'],
    ];

    echo '<form id="redirectForm" action="./recommendation.php" method="post">';
    foreach ($data as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.getElementById("redirectForm").submit();</script>';
    exit;
}

include './src/api/functions.php';
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
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
                    <li class="next">
                        <span class="progress inactive">
                            3
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">History</h3>
                        </span>
                    </li>
                    <li class="next active">
                        <span class="progress active">
                            4
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Timeline</h3>
                        </span>
                    </li>
                </ol>
                <div
                    style="display: flex; padding-left: 1rem; padding-right: 1rem; flex-direction: column; border-radius: 1rem;">
                    <form method="post" action="./recommendation.php"
                        style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                <div style="display: flex; flex-direction: column;">
                                    <label for="name" style="font-weight: 700;">How long ago have you had the
                                        treatment?</label>
                                    <span style="font-size: 0.75rem; line-height: 1rem;">Input time frame for each
                                        treatment:</span>
                                </div>
                                <div
                                    style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
                                    <?php foreach ($_POST['previous'] as $previous):

                                        $service = getServiceById($previous);
                                        ?>
                                        <div
                                            style="display: flex; flex-direction: column; gap: 0.25rem; margin-top: 0.5rem;">
                                            <label
                                                for="<?php echo $service['name']; ?>"><?php echo $service['name']; ?></label>
                                            <input type="number" name="month_time[<?php echo $previous; ?>]"
                                                style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                                id="<?php echo $previous; ?>" required>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" name="treatment" value="<?php echo $_POST['treatment']; ?>">
                                <?php foreach ($_POST['previous'] as $index => $value): ?>
                                    <input type="hidden" name="previous[<?php echo $index; ?>]"
                                        value="<?php echo $value; ?>">
                                <?php endforeach; ?>
                                <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
                                <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                                <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                            </div>
                        </div>
                        <button class="next-button" type="submit">Submit</button>
                    </form>
                    <button class="cancel-button" type="button"
                        onclick="window.location.href = './consultation-treatment.php'">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>