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
        <div class="modal" id="filterModal">
            <div class="modal-content">
                <span class="modal-close" id="closeModal">&times;</span>
                <div class="modal-header">Filter Options</div>
                <form id="filterUsers">
                    <label class="modal-label" for="name">Name</label>
                    <input type="text" id="name" class="modal-input" placeholder="Enter name">

                    <label class="modal-label" for="email">Email</label>
                    <input type="text" id="email" class="modal-input" placeholder="Enter email">

                    <label class="modal-label" for="role">Role</label>
                    <input type="text" id="role" class="modal-input" placeholder="Enter role">

                    <div class="modal-actions">
                        <button type="button" class="clear-filters">Clear Filters</button>
                        <button type="submit" class="apply-button">Apply</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include 'src/includes/admin_side_nav.php'; ?>

        <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%; margin: 1.5rem;">
            <div style="display: flex; flex-direction: column;">
                <div style="display: flex;">
                    <button
                        style="background-color: #A80011; border: 0px; color: white; padding: 0rem 2rem; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;"
                        class="filter-button">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5h13a1 1 0 0 1 .5 1.5L14 12v7l-4-3v-4L5 6.5A1 1 0 0 1 5.5 5Z"></path>
                        </svg>
                        Filter
                    </button>
                    <input type="text" id="users-search" class="search-button" placeholder="Search Users..." required />
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.5rem">
                <div style="display: flex; justify-content: space-between;">
                    <span style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Users</span>
                    <button
                        style="background-color: #A80011; border: 0px; color: white; padding: 0rem 2rem; border-radius: 0.5rem; cursor: pointer;"
                        onclick="window.location.href = './add-user.php'">Add a User</button>
                </div>
                <div class="stylists-container" id="usersList">
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>