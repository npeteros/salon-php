<?php
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';
include 'src/api/functions.php';

$consultation = getConsultationByCustomer($_SESSION['user']['id']);
if (!$consultation)
    header('Location: ./consultation-hair.php');


$selectedTreatment = getTreatmentById($consultation['treatment_id']);
$suitable = $consultation['status'] == 'Suitable' ? true : false;
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Hair Treatment
                    Recommendation</span>
                <div
                    style="display: flex; flex-direction: column; align-items: center; gap: 2rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <div style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: rgb(229 229 229); width: 50%; cursor: pointer;"
                        onclick="window.open('./view-service.php?id=<?php echo $selectedTreatment['service_id']; ?>', '_blank');"
                        target="_blank">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <img src="./uploads/services/<?php echo $selectedTreatment['img_path']; ?>" alt="Image"
                                style="width: 3rem; height: 3rem; border-radius: 9999px;">
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span
                                    style="font-size: 1.125rem; line-height: 1.75rem;"><?php echo $selectedTreatment['name']; ?></span>
                                <span
                                    style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo strlen($selectedTreatment['description']) > 35 ? substr($selectedTreatment['description'], 0, 35) . '...' : $selectedTreatment['description']; ?></span>
                            </div>
                        </div>
                        <span style="color: #49454F;">&#x20B1; <?php echo $selectedTreatment['price']; ?></span>
                    </div>
                    <span
                        style="font-size: 1rem; font-weight: bold; line-height: 1.25rem; text-align: center; color: <?php echo $suitable ? 'green' : 'red'; ?>;"><?php echo $suitable ? "Note: This treatment is suitable for your hair." : "Note: This treatment is NOT suitable for your hair."; ?></span>

                    <?php if (!$suitable): ?>
                        <div class="divider"></div>
                        <div style="display: flex; flex-direction: column; align-items: start; gap: 1rem; width: 100%;">
                            <span style="font-weight: 700; font-size: 1.25rem; text-align: center;">Alternative Recommended
                                Treatments:</span>
                            <div
                                style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; width: 100%;">
                                <?php
                                if (empty($alternativeTreatments)) {
                                    echo "<span style='font-size: 0.875rem; line-height: 1.25rem; text-align: center;'>No alternative treatments found. Please wait until a few months have passed.</span>";
                                }

                                foreach ($alternativeTreatments as $alternativeTreatment): ?>
                                    <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                        <div style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: rgb(229 229 229); cursor: pointer;"
                                            onclick="window.open('./view-service.php?id=<?php echo $alternativeTreatment['id']; ?>', '_blank');"
                                            target="_blank">
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <img src="./uploads/services/<?php echo $alternativeTreatment['img_path']; ?>"
                                                    alt="Image" style="width: 3rem; height: 3rem; border-radius: 9999px;">
                                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                                    <span
                                                        style="font-size: 1.125rem; line-height: 1.75rem;"><?php echo $alternativeTreatment['name']; ?></span>
                                                    <span
                                                        style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo strlen($alternativeTreatment['description']) > 35 ? substr($alternativeTreatment['description'], 0, 35) . '...' : $alternativeTreatment['description']; ?></span>
                                                </div>
                                            </div>
                                            <span style="color: #49454F;">&#x20B1;
                                                <?php echo $alternativeTreatment['price']; ?></span>
                                        </div>
                                        <span
                                            style="font-size: 1rem; font-weight: bold; line-height: 1.25rem; opacity: 80%;">Note:
                                            <?php echo $alternativeTreatment['reason']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="divider"></div>
                    <span style="font-weight: 700; font-size: 1.25rem">Hair Profile Information (For Stylist&apos;s
                        reference)</span>
                    <div style="display: flex; flex-direction: column; align-items: start; gap: 1rem; width: 100%;">
                        <div style="display: flex; gap: 0.5rem;">
                            <span style="font-weight: 700;">
                                Hair Type:
                            </span>
                            <span><?php echo ucwords($consultation['type']); ?></span>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <span style="font-weight: 700;">
                                Hair Texture:
                            </span>
                            <span><?php echo ucwords($consultation['texture']); ?></span>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <span style="font-weight: 700;">
                                Hair Condition:
                            </span>
                            <span><?php echo ucwords($consultation['hair']); ?></span>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; margin-top: -1rem; gap: 0.5rem;">
                        <span style="font-size: 0.875rem; line-height: 1.25rem; text-align: center; color: #DC2626;"
                            id="consultation-error"></span>
                        <form id="delete-consultation" style="width: 100%; display: flex; justify-content: center;">
                            <input type="hidden" name="id" value="<?php echo $consultation['id']; ?>">
                            <button class="next-button" style="padding-left: 2rem; padding-right: 2rem;" type="submit"
                                id="delete-consultation-button">Resubmit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>