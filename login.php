<?php
define('FILE_CSS', 'src/styles/login.css');
include 'src/includes/header.php';
if (isset($_SESSION['user']))
    header('Location: index.php');
?>

<div class="parent-container">
    <div class="login-container">
        <div style="height: 100%; width: 100%; display: flex; flex-direction: column;">
            <button class="back-button" onclick="window.location.href = './'">
                <svg width="20" height="20" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m15 6-6 6 6 6"></path>
                </svg>
            </button>
            <div class="div-form-container">
                <h1 style="font-size: 2.25rem; line-height: 2.5rem; font-weight: 700; text-align: center;">Sign In</h1>
                <form
                    style="display: flex; flex-direction: column; gap: 1rem; justify-content: center; align-items: center; width: 100%;"
                    id="login-form">
                    <div style="display: flex; flex-direction: column; width: 100%">
                        <input type="email" placeholder="Email" name="email" id="email" autoComplete="username"
                            isFocused={true} class="input-form-container" />
                    </div>
                    <div style="display: flex; flex-direction: column; width: 100%">
                        <input type="password" placeholder="Password" id="password" name="password"
                            autoComplete="current-password" class="input-form-container" />
                    </div>
                    <div style="display: flex; flex-direction: column; width: 100%">
                        <p style="font-size: 0.875rem; line-height: 1.25rem; color: #DC2626;" id="login-error"></p>
                    </div>
                    <button class="sign-in-button">
                        Sign In
                    </button>
                    <a href="./register.php" class="register-link">Don't have an account yet?</a>
                </form>
            </div>
        </div>
        <div class="sign-up-container">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 1.5rem;">
                <h1 style="font-size: 2.25rem; line-height: 2.5rem; font-weight: 700; color: #ffffff; ">
                    Sign Up
                </h1>
                <a href='./register.php'>
                    <button class="register-form-button">
                        REGISTER
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
<?php include 'src/includes/footer.php'; ?>