<?php
if ($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST['type']) || !isset($_POST['texture']) || !isset($_POST['hair']))
    return header("Location: ./consultation-treatment.php");
define("FILE_CSS", "src/styles/consultation-hair.css");
include './src/includes/header.php';

$recommendedTreatments = [];

$treatmentDetails = [
    "Deep Conditioning Hair Treatment" => "Restores moisture and enhances softness.",
    "Keratin Treatment" => "Smooths hair and reduces frizz, providing a polished look.",
    "Botox Treatment" => "Deeply conditions and smooths curls while preserving texture.",
    "Rebonding Treatment" => "Provides a straighter finish and smoother texture than a relaxer.",
    "Relax Treatment" => "Chemically relaxes hair for easier styling.",
    "Protein Treatment" => "Strengthens fine hair and reduces breakage.",
    "Hot Oil Treatment" => "Nourishes without heaviness, adding shine.",
    "Clarifying Treatment" => "Removes excess oil and product buildup.",
    "Scalp Treatment" => "Targets oiliness on the scalp for a refreshed feel."
];

switch ($_POST['type']) {
    case "Straight":
        $recommendedTreatments['hairType'] = [
            'needs' => "Moisture and smoothness to prevent dryness and frizz.",
            'treatments' => [
                "Deep Conditioning Hair Treatment",
                "Keratin Treatment"
            ]
        ];
        break;
    case "Wavy":
        $recommendedTreatments['hairType'] = [
            'needs' => "Definition and frizz control while maintaining natural texture.",
            'treatments' => [
                "Keratin Treatment",
                "Botox Treatment",
                "Rebonding Treatment"
            ]
        ];
        break;
    case "Curly":
        $recommendedTreatments['hairType'] = [
            'needs' => "Hydration and definition for curls without frizz.",
            'treatments' => [
                "Botox Treatment",
                "Deep Conditioning Hair Treatment",
                "Keratin Treatment",
                "Rebonding Treatment"
            ]
        ];
        break;
    case "Kinky":
        $recommendedTreatments['hairType'] = [
            'needs' => "Manageability and moisture to avoid dryness and breakage.",
            'treatments' => [
                "Relax Treatment",
                "Rebonding Treatment",
                "Keratin Treatment"
            ]
        ];
        break;
}

switch ($_POST['texture']) {
    case "Fine":
        $recommendedTreatments['hairTexture'] = [
            'needs' => "Strength to prevent breakage without weighing it down.",
            'treatments' => [
                "Protein Treatment",
                "Hot Oil Treatment",
                "Keratin Treatment"
            ]
        ];
        break;
    case "Medium":
        $recommendedTreatments['hairTexture'] = [
            'needs' => "Hydration and overall health maintenance.",
            'treatments' => [
                "Hot Oil Treatment",
                "Deep Conditioning Hair Treatment",
                "Keratin Treatment"
            ]
        ];
        break;
    case "Thick":
        $recommendedTreatments['hairTexture'] = [
            'needs' => "Moisture and strength to manage volume and prevent frizz.",
            'treatments' => [
                "Deep Conditioning Hair Treatment",
                "Protein Treatment",
                "Keratin Treatment"
            ]
        ];
        break;
}

switch ($_POST['hair']) {
    case "Damaged":
        $recommendedTreatments['hairCondition'] = [
            'needs' => "Restoration of strength and moisture.",
            'treatments' => [
                "Protein Treatment",
                "Botox Treatment",
                "Deep Conditioning Hair Treatment",
                "Keratin Treatment"
            ]
        ];
        break;
    case "Dry":
        $recommendedTreatments['hairCondition'] = [
            'needs' => "Intense hydration to restore moisture balance.",
            'treatments' => [
                "Hot Oil Treatment",
                "Deep Conditioning Hair Treatment",
                "Keratin Treatment"
            ]
        ];
        break;
    case "Oily":
        $recommendedTreatments['hairCondition'] = [
            'needs' => "Cleanliness and balance to manage oil levels.",
            'treatments' => [
                "Clarifying Treatment",
                "Scalp Treatment"
            ]
        ];
        break;
    case "Normal":
        $recommendedTreatments['hairCondition'] = [
            'needs' => "Maintenance of moisture and health.",
            'treatments' => [
                "Deep Conditioning Hair Treatment",
                "Protein Treatment",
                "Keratin Treatment"
            ]
        ];
        break;
    case "Chemically Treated":
        $recommendedTreatments['hairCondition'] = [
            'needs' => "Repair and hydration to maintain health and texture.",
            'treatments' => [
                "Botox Treatment",
                "Deep Conditioning Hair Treatment",
                "Keratin Treatment"
            ]
        ];
        break;
}

$uniqueTreatments = [];

foreach ($recommendedTreatments as $category => &$data) {
    if (isset($data['treatments'])) {
        $data['treatments'] = array_unique($data['treatments']);

        foreach ($data['treatments'] as $treatment) {
            if (!in_array($treatment, $uniqueTreatments)) {
                $uniqueTreatments[] = $treatment;
            }
        }
    }
}

if (isset($_POST['rebonding']) && $_POST['rebonding'] == 'less') {
    $index = array_search('Rebonding Treatment', $uniqueTreatments);
    if ($index !== false) {
        unset($uniqueTreatments[$index]);
        $uniqueTreatments = array_values($uniqueTreatments);
    }
}

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
                    style="display: flex; flex-direction: column; gap: 2rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <div style="display: flex; flex-direction: column; justify-content: space-between; gap: 1rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <span style="font-weight: 700; font-size: 1.25rem;">
                                Hair Type (<?php echo ucwords($_POST['type']); ?>)
                            </span>
                            <span style="margin-left: 1rem;">
                                <span>Needs
                                </span><?php echo lcfirst($recommendedTreatments['hairType']['needs']); ?>
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <span style="font-weight: 700; font-size: 1.25rem;">
                                Hair Texture (<?php echo ucwords($_POST['texture']); ?>)
                            </span>
                            <span style="margin-left: 1rem;">
                                <span>Needs
                                </span><?php echo lcfirst($recommendedTreatments['hairTexture']['needs']); ?>
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <span style="font-weight: 700; font-size: 1.25rem;">
                                Hair Condition (<?php echo ucwords($_POST['hair']); ?>)
                            </span>
                            <span style="margin-left: 1rem;">
                                <span>Needs
                                </span><?php echo lcfirst($recommendedTreatments['hairCondition']['needs']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <span style="font-weight: 700; font-size: 1.25rem;">Recommended Treatments:</span>
                        <div
                            style="display: grid; grid-template-rows: repeat(3, minmax(0, 1fr)); grid-auto-flow: column; gap: 0.5rem;">
                            <?php
                            foreach ($uniqueTreatments as $treatment) {
                                echo "<div style='display: flex; flex-direction: column; gap: 0.25rem;'><span style='font-weight: 700;'>" . $treatment . "</span><span style='margin-left: 1rem; color: rgb(75 85 99);'>" . $treatmentDetails[$treatment] . "</span></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <span style="font-size: 0.875rem; line-height: 1.25rem; text-align: center; color: #DC2626;"
                        id="consultation-error"></span>
                    <?php echo isset($_POST['bleaching']) ? '<span
                        style="color: rgb(153 27 27); font-weight: 900; font-size: 1.15rem; text-decoration: underline; text-align: center;">Note:
                        Your hair
                        is bleached, best to visit the salon for a face-to-face hair assessment.</span>' : null; ?>
                    <div style="display: flex; flex-direction: column; margin-top: -1rem;">
                        <form id="submit-consultation" method="post"
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
                                id="reservation-error"></span>
                            <button class="next-button" type="button" id="redirect-appointment" style="display: none;" onclick="window.location.href='./reserve-schedule.php'">Reserve an
                                Appointment</button>
                            <button class="cancel-button" type="button" id="back-dashboard" style="display: none;" onclick="window.location.href='./dashboard.php'">Back to Dashboard</button>
                            <button class="next-button" type="submit" id="submit-consultation-btn">Submit</button>
                        </form>
                        <form action="./consultation-confirm.php" method="POST">
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
                            <button class="cancel-button" style="width: 100%;" type="submit" id="back-consultation-btn">Back</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>