<?php
if (!isset($_POST['type']) || !isset($_POST['texture']) || !isset($_POST['hair']))
    return header("Location: ./consultation-treatment.php");
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';
$hair_treatment = [
    'perming' => isset($_POST['perming']) ? $_POST['perming'] : "none",
    'relax' => isset($_POST['relax']) ? $_POST['relax'] : "none",
    'rebonding' => isset($_POST['rebonding']) ? $_POST['rebonding'] : "none",
    'hair bleaching' => isset($_POST['bleaching']) ? $_POST['bleaching'] : "none",
];
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
                    <li class="next active">
                        <span class="progress active">
                            3
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Confirm</h3>
                        </span>
                    </li>
                    <li class="">
                        <span class="progress inactive">
                            4
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Recommendation</h3>
                        </span>
                    </li>
                </ol>
                <div
                    style="display: flex; padding-left: 1rem; padding-right: 1rem; flex-direction: column; border-radius: 1rem;">
                    <form class="confirmation-info-grid">
                        <div style="display: flex; flex-direction: column;">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Personal
                                    Information</span>
                                <hr
                                    style="margin-top: 0.5rem; margin-bottom: 0.5rem; border-width: 0; height: 1px; background-color: #E5E7EB;" />
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span style="font-weight: 700;"><?php echo $_SESSION['user']['name']; ?></span>
                                <span
                                    style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo $_SESSION['user']['email']; ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Hair
                                    Information</span>
                                <hr
                                    style="margin-top: 0.5rem; margin-bottom: 0.5rem; border-width: 0; height: 1px; background-color: #E5E7EB;" />
                            </div>
                            <div
                                style="display: grid; grid-template-rows: repeat(1, minmax(0, 1fr)); grid-auto-flow: column; gap: 0.25rem;">
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    <span style="font-weight: 700;">Hair Type</span>
                                    <span
                                        style="font-size: 0.875rem; line-height: 1.25rem; margin-left: 1rem;"><?php echo $_POST['type']; ?></span>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    <span style="font-weight: 700;">Hair Texture</span>
                                    <span
                                        style="font-size: 0.875rem; line-height: 1.25rem; margin-left: 1rem;"><?php echo $_POST['texture']; ?></span>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    <span style="font-weight: 700;">Hair Condition</span>
                                    <span
                                        style="font-size: 0.875rem; line-height: 1.25rem; margin-left: 1rem;"><?php echo $_POST['hair']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column;">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Previous
                                    Hair Treatment</span>
                                <hr
                                    style="margin-top: 0.5rem; margin-bottom: 0.5rem; border-width: 0; height: 1px; background-color: #E5E7EB;" />
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));">
                                <?php foreach ($hair_treatment as $key => $value):
                                    $formattedValue = 'None';
                                    switch ($value) {
                                        case 'less':
                                            $formattedValue = "Less than 6 months";
                                            break;

                                        case 'more':
                                            $formattedValue = "More than 6 months";
                                            break;

                                        default:
                                            break;
                                    }
                                    ?>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-weight: 700;"><?php echo ucwords($key); ?></span>
                                        <span
                                            style="font-size: 0.875rem; line-height: 1.25rem; margin-left: 1rem;"><?php echo $formattedValue; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </form>
                    <div style="display: flex; flex-direction: column;">
                        <form action="./recommendation.php" method="post"
                            style="display: flex; flex-direction: column; gap: 1rem;">
                            <input type="hidden" name="customer" id="customer"
                                value="<?php echo $_SESSION['user']['id']; ?>">
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
                            <span style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                id="booking-error"></span>
                            <button class="next-button" type="submit">Submit</button>
                        </form>
                        <form action="./consultation-treatment.php" method="POST">
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
</div>

<?php include 'src/includes/footer.php'; ?>