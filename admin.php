<?php
define('FILE_CSS', 'src/styles/login.css');
include 'src/includes/header.php';
if (isset($_SESSION['user']))
    header('Location: index.php');
?>

<div class="parent-container">
    <div
        style="display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: white; width: 75%; border-radius: 1rem;">
        <h1 style="font-size: 2.25rem; line-height: 2.5rem; font-weight: 700; text-align: center;">Sign In</h1>
        <form
            style="display: flex; flex-direction: column; gap: 1rem; justify-content: center; align-items: center; width: 50%;"
            id="admin-login-form">
            <div style="display: flex; flex-direction: column; width: 100%">
                <input type="email" placeholder="Email" name="email" id="email" autoComplete="username" isFocused={true}
                    class="input-form-container" />
            </div>
            <div style="display: flex; flex-direction: column; width: 100%">
                <input type="password" placeholder="Password" id="password" name="password"
                    autoComplete="current-password" class="input-form-container" />
            </div>
            <p style="font-size: 0.875rem; line-height: 1.25rem; color: #DC2626; display: none;" id="admin-login-error"></p>
            <button class="sign-in-button">
                Sign In
            </button>
        </form>
    </div>
</div>
<?php include 'src/includes/footer.php'; ?>