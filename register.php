<?php
define('FILE_CSS', 'src/styles/register.css');
include 'src/includes/header.php';
if (isset($_SESSION['user']))
    header('Location: index.php');
?>

<div class="parent-container">
    <div class="register-container">
        <div class="sign-in-container">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 1.5rem;">
                <h1 style="font-size: 2.25rem; line-height: 2.5rem; font-weight: 700; color: #ffffff;">
                    Sign In
                </h1>
                <a href="./login.php">
                    <button class="login-form-button">
                        LOGIN
                    </button>
                </a>
            </div>
        </div>
        <div class="div-form-container">
            <h1 style="font-size: 2.25rem; line-height: 2.5rem; font-weight: 700; text-align: center;">Create Account
            </h1>
            <form
                style="display: flex; flex-direction: column; gap: 1rem; justify-content: center; align-items: center; width: 100%;"
                id="register-form">
                <div style="display: flex; flex-direction: column; width: 100%">
                    <input type="text" placeholder="Name" class="input-form-container" id="name" name="name"
                        autoComplete="name" />
                </div>
                <div style="display: flex; flex-direction: column; width: 100%">
                    <input type="email" placeholder="Email" class="input-form-container" id="email"
                        name="email" autoComplete="username" />
                </div>
                <div style="display: flex; flex-direction: column; width: 100%">
                    <input type="password" placeholder="Password" class="input-form-container" id="password"
                        name="password" autoComplete="password" />
                </div>
                <div style="display: flex; flex-direction: column; width: 100%">
                    <input type="password" placeholder="Confirm Password" class="input-form-container"
                        id="confirm-password" name="confirm-password" autoComplete="confirm-password" />
                </div>
                <div style="display: flex; flex-direction: column; width: 100%">
                    <p style="font-size: 0.875rem; line-height: 1.25rem; color: #DC2626;" id="register-error"></p>
                </div>
                <button class="sign-up-button">
                    Sign Up
                </button>
                <a href="./login.php" class="login-link">Already have an account?</a>
            </form>
        </div>
    </div>
</div>
<?php include 'src/includes/footer.php'; ?>