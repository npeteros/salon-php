<?php 
if (!isset($_POST['texture']) || !isset($_POST['hair']) || !isset($_POST['scalp']) || !isset($_POST['straightening']) || !isset($_POST['perming']) || !isset($_POST['relax']) || !isset($_POST['coloring']) || !isset($_POST['rebonding']) || !isset($_POST['bleaching']))
    return header("Location: ./consultation-scalp.php");
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';
$hair_treatment = [
    'straightening' => $_POST['straightening'],
    'perming' => $_POST['perming'],
    'relax' => $_POST['relax'],
    'coloring' => $_POST['coloring'],
    'rebonding' => $_POST['rebonding'],
    'hair bleaching' => $_POST['bleaching']
];
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
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
                    <li class="next">
                        <span
                            class="progress inactive">
                            3
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Treatment</h3>
                        </span>
                    </li>
                    <li class="active">
                        <span
                            class="progress active">
                            4
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Confirm</h3>
                        </span>
                    </li>
                </ol>
                <div style="display: flex; padding-left: 1rem; padding-right: 1rem; flex-direction: column; border-radius: 1rem;">
                    <div class="confirmation-info-grid">
                        <div style="display: flex; flex-direction:column;">
                            <div style="display: flex; flex-direction:column;">
                                <div style="display: flex; justify-content: space-between; align-items: center">
                                    <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Personal Information</span>
                                    <a style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #3B82F6;">Edit</a>
                                </div>
                                <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem; border-width: 0; height: 1px; background-color: #E5E7EB;" />
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span style="font-weight: 700;"><?php echo $_SESSION['user']['name']; ?></span>
                                <span
                                    style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo $_SESSION['user']['email']; ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction:column;">
                            <div style="display: flex; flex-direction:column;">
                                <div style="display: flex; justify-content: space-between; align-items: center">
                                    <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Hair Information</span>
                                    <a style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #3B82F6;">Edit</a>
                                </div>
                                <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem; border-width: 0; height: 1px; background-color: #E5E7EB;" />
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span style="font-weight: 700;">Hair Texture</span>
                                <span style="font-size: 0.875rem; line-height: 1.25rem; margin-left: 1rem;"><?php echo $_POST['texture']; ?></span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span style="font-weight: 700;">Hair Condition</span>
                                <span style="font-size: 0.875rem; line-height: 1.25rem; margin-left: 1rem;"><?php echo $_POST['hair']; ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction:column;">
                            <div style="display: flex; flex-direction:column;">
                                <div style="display: flex; justify-content: space-between; align-items: center">
                                    <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Scalp Information</span>
                                    <a style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #3B82F6;">Edit</a>
                                </div>
                                <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem; border-width: 0; height: 1px; background-color: #E5E7EB;" />
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span style="font-weight: 700;">Scalp Condition</span>
                                <span style="font-size: 0.875rem; line-height: 1.25rem; margin-left: 1rem;"><?php echo $_POST['scalp']; ?></span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction:column;">
                            <div style="display: flex; flex-direction:column;">
                                <div style="display: flex; justify-content: space-between; align-items: center">
                                    <span style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700;">Previous Hair Treatment</span>
                                    <a style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #3B82F6;">Edit</a>
                                </div>
                                <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem; border-width: 0; height: 1px; background-color: #E5E7EB;" />
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));">
                                <?php foreach ($hair_treatment as $key => $value): ?>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-weight: 700;"><?php echo ucwords($key); ?></span>
                                        <span style="font-size: 0.875rem; line-height: 1.25rem; margin-left: 1rem;"><?php echo ucwords($value); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column;">
                        <form id="confirm-consultation" style="display: flex; flex-direction: column; gap: 1rem;">
                            <input type="hidden" name="customer" id="customer"
                                    value="<?php echo $_SESSION['user']['id']; ?>">
                            <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                            <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                            <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
                            <input type="hidden" name="straightening"
                                value="<?php echo $_POST['straightening']; ?>">
                            <input type="hidden" name="perming" value="<?php echo $_POST['perming']; ?>">
                            <input type="hidden" name="relax" value="<?php echo $_POST['relax']; ?>">
                            <input type="hidden" name="coloring" value="<?php echo $_POST['coloring']; ?>">
                            <input type="hidden" name="rebonding" value="<?php echo $_POST['rebonding']; ?>">
                            <input type="hidden" name="bleaching" value="<?php echo $_POST['bleaching']; ?>">
                            <span style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;" id="booking-error"></span>
                            <button class="next-button" type="submit">Submit</button>
                        </form>
                        <form action="./consultation-treatment.php" method="POST">
                            <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                            <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                            <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
                            <input type="hidden" name="straightening" value="<?php echo $_POST['straightening']; ?>">
                            <input type="hidden" name="perming" value="<?php echo $_POST['perming']; ?>">
                            <input type="hidden" name="relax" value="<?php echo $_POST['relax']; ?>">
                            <input type="hidden" name="coloring" value="<?php echo $_POST['coloring']; ?>">
                            <input type="hidden" name="rebonding" value="<?php echo $_POST['rebonding']; ?>">
                            <input type="hidden" name="bleaching" value="<?php echo $_POST['bleaching']; ?>">
                            <button class="cancel-button" style="width: 100%;" type="submit">Back</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>