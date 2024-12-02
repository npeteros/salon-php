<?php
define('FILE_CSS', 'src/styles/view-appointment.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');
include 'src/api/functions.php';
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="confirmation-container">
        <?php include './src/includes/admin_side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem; display: flex; flex-direction: column; gap: 2rem;">
            <div
                style="display: flex; flex-direction: column; padding-top: 1rem; gap: 1rem; border-radius: 1rem; background-color: #E53C37;">
                <span style="font-weight: 700; font-size: 1.25rem; text-align: center; color: white;">Add Service</span>
                <div
                    style="display: flex; flex-direction: column; gap: 0.875rem; background-color: white; padding: 1rem; border-bottom-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                    <form id="add-service" style="display: flex; gap: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div
                                style="padding: 0.875rem; border: 1px solid rgb(212 212 212); border-radius: 1rem; width: 8rem; height: 8rem; display: flex; align-items: center;">
                                <img src="./uploads/services/default.svg" alt="Image"
                                    style="width: 100%; height: 100%;">
                            </div>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%;">
                            <div class="add-service-container">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="name">Service Name</label>
                                    <input type="text" name="name"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        placeholder="Rebond Treatment">
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="price">Service Price</label>
                                    <div style="position: relative;">
                                        <div
                                            style="display: flex; position: absolute; top: 0; left: 0.5rem; bottom: 0; align-items: center; pointer-events: none;">
                                            <span style="color: #6B7280;">&#x20B1;</span>
                                        </div>
                                        <input type="number" name="price" step="0.01"
                                            style="display: block; padding: 0.625rem; padding-left: 2.5rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                            placeholder="4915.55">
                                    </div>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="duration">Service Duration (by minutes)</label>
                                    <input type="number" name="duration"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        placeholder="120">
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                                    <label for="followup_duration">Follow Up Duration (by minutes)</label>
                                    <input type="number" name="followup_duration"
                                        style="display: block; padding: 0.625rem; border-radius: 0.5rem; border-width: 1px; border-color: #D1D5DB; width: 100%; font-size: 0.875rem; line-height: 1.25rem; color: #111827; background-color: #F9FAFB;"
                                        placeholder="109">
                                </div>
                                <div
                                    style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%; grid-column: span 2 / span 2;">
                                    <label for="description">Service Description</label>
                                    <textarea name="description"
                                        placeholder="Get smooth, straight, and shiny hair with our long-lasting Rebond Treatment! Ideal for frizzy or wavy hair, it restructures bonds to give you sleek, frizz-free locks that last up to 6 months with minimal maintenance."
                                        required></textarea>
                                </div>
                                <div style="display: flex; gap: 0.25rem; width: 100%; grid-column: span 2 / span 2;">
                                    <input type="checkbox" name="chemical">
                                    <label for="chemical">This is a chemical treatment</label>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span
                                    style="text-align: center; color: #DC2626; font-size: 0.875rem; line-height: 1.25rem;"
                                    id="service-error"></span>
                                <button class="next-button" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>