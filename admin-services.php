<?php
define('FILE_CSS', 'src/styles/appointments.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="main-container">
        <?php include 'src/includes/admin_side_nav.php'; ?>

        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%; margin: 1.5rem;">
            <div style="display: flex; flex-direction: column;">
                <div>
                    <div style="position: relative;">
                        <div
                            style="position: absolute; display: flex; top: 0; bottom: 0; padding-left: 0.75rem; align-items: center; pointer-events: none;">
                            <svg class="w-4 h-4 text-gray-500 dark:text-neutral-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="services-search" class="search-button" placeholder="Search Services..."
                            required />
                    </div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.5rem">
                <div style="display: flex; justify-content: space-between;">
                    <span
                        style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Services</span>
                    <button
                        style="background-color: #A80011; border: 0px; color: white; padding: 0rem 2rem; border-radius: 0.5rem; cursor: pointer;"
                        onclick="window.location.href = './add-service.php'">Add a Service</button>
                </div>
                <div id="servicesList" data-userid="<?php echo $_SESSION['user']['id']; ?>">
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>