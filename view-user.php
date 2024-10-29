<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if (!isset($_GET['id']))
    header('Location: ./stylists.php');
if ($_SESSION['user']['role'] != 'owner' && $_SESSION['user']['role'] != 'manager')
    header('Location: ./index.php');
include 'src/api/functions.php';

$user = getUser($_GET['id']);
if (!$user)
    return header('Location: ./admin-dashboard.php');

$consultation = getConsultationByCustomer($_GET['id']) ? getConsultationByCustomer($_GET['id']) : null;

if (isset($consultation)) {
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

    switch ($consultation['type']) {
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

    switch ($consultation['texture']) {
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

    switch ($consultation['hair']) {
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

    if (isset($consultation['rebonding']) && $consultation['rebonding'] == 'less') {
        $index = array_search('Rebonding Treatment', $uniqueTreatments);
        if ($index !== false) {
            unset($uniqueTreatments[$index]);
            $uniqueTreatments = array_values($uniqueTreatments);
        }
    }
}
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include 'src/includes/admin_side_nav.php'; ?>

        <div class="parent-container">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Stylist
                    Details (#<?php echo $_GET['id']; ?>)</span>
                <div class="stylist-container">
                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div
                            style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem;">
                            <img src="./uploads/<?php echo $user['img_path']; ?>" alt="Image"
                                style="width: 100%; height: 100%; border-radius: 0.5rem;">
                        </div>
                        <div class="info-container">
                            <div
                                style="display: flex; flex-direction: column; gap: 1rem; width: 12rem; align-items: start;">
                                <div
                                    style="display: flex; flex-direction: column; gap: 0.25rem; width: 12rem; align-items: start;">
                                    <span
                                        style="font-weight: 700; font-size: 1.875rem;"><?php echo $user['name']; ?></span>
                                    <span style="opacity: 50%;"><?php echo $user['email'] ?></span>
                                </div>
                                <div
                                    style="display: flex; flex-direction: column; gap: 0.25rem; width: 12rem; align-items: start;">
                                    <span style="font-weight: 700;" id="role"
                                        data-id="<?php echo $user['id']; ?>"><?php echo ucfirst($user['role']); ?></span>
                                    <select style="display: none;" id="change-role-select">
                                        <?php if ($_SESSION['user']['role'] == "owner") { ?>
                                            <option value="owner" <?php echo $user['role'] == "owner" ? "selected" : null; ?>>
                                                Owner</option>
                                            <option value="manager" <?php echo $user['role'] == "manager" ? "selected" : null; ?>>Manager</option>
                                        <?php } ?>
                                        <option value="stylist" <?php echo $user['role'] == "stylist" ? "selected" : null; ?>>Stylist</option>
                                        <option value="user" <?php echo $user['role'] == "user" ? "selected" : null; ?>>
                                            Customer</option>
                                    </select>
                                    <span
                                        style="font-size: 0.875rem; text-decoration: underline; cursor: pointer; opacity: 50%;"
                                        id="change-role">Change role</span>
                                    <span
                                        style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                        id="change-role-error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.5rem">
                        <button
                            style="padding-top: 0.625rem; padding-bottom: 0.625rem; padding-left: 1.25rem; padding-right: 1.25rem; margin-bottom: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #ffffff; height: fit-content; background-color: #E53C37; border: none; cursor: pointer;"
                            onclick="window.location.href = './edit-user.php?id=<?php echo $user['id']; ?>'">Edit
                            User</button>
                        <button
                            style="padding-top: 0.625rem; padding-bottom: 0.625rem; padding-left: 1.25rem; padding-right: 1.25rem; margin-bottom: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; color: #E53C37; height: fit-content; background-color: white; border: 1px solid #E53C37; cursor: pointer;"
                            id="delete-user" data-id="<?php echo $user['id']; ?>">Delete
                            User</button>
                        <span style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                            id="user-error"></span>
                    </div>
                </div>
            </div>
            <?php if (isset($consultation)) { ?>
                <div
                    style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                    <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Hair Treatment
                        Recommendation</span>
                    <div
                        style="display: flex; flex-direction: column; gap: 2rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                        <div style="display: flex; flex-direction: column; justify-content: space-between; gap: 1rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span style="font-weight: 700; font-size: 1.25rem;">
                                    Hair Type (<?php echo ucwords($consultation['type']); ?>)
                                </span>
                                <span style="margin-left: 1rem;">
                                    <span>Needs
                                    </span><?php echo lcfirst($recommendedTreatments['hairType']['needs']); ?>
                                </span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span style="font-weight: 700; font-size: 1.25rem;">
                                    Hair Texture (<?php echo ucwords($consultation['texture']); ?>)
                                </span>
                                <span style="margin-left: 1rem;">
                                    <span>Needs
                                    </span><?php echo lcfirst($recommendedTreatments['hairTexture']['needs']); ?>
                                </span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span style="font-weight: 700; font-size: 1.25rem;">
                                    Hair Condition (<?php echo ucwords($consultation['hair']); ?>)
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
                        <?php echo isset($consultation['bleaching']) ? '<span
                        style="color: rgb(153 27 27); font-weight: 900; font-size: 1.15rem; text-decoration: underline; text-align: center;">Note:
                        Your hair
                        is bleached, best to visit the salon for a face-to-face hair assessment.</span>' : null; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>