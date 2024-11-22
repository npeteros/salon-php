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
                    <input type="email" placeholder="Email" class="input-form-container" id="email" name="email"
                        autoComplete="username" />
                </div>
                <div style="display: flex; flex-direction: column; width: 100%">
                    <div style="position: relative;">
                        <div
                            style="display: flex; position: absolute; top: 0; bottom: 0; right: 1rem; align-items: center;">
                            <svg style="width: 1rem; height: 1rem; color: #6B7280; cursor: pointer;"
                                class="show-password" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 6.5a9.77 9.77 0 0 1 8.82 5.5A9.76 9.76 0 0 1 12 17.5 9.76 9.76 0 0 1 3.18 12 9.77 9.77 0 0 1 12 6.5Zm0-2C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5Zm0 5a2.5 2.5 0 0 1 0 5 2.5 2.5 0 0 1 0-5Zm0-2c-2.48 0-4.5 2.02-4.5 4.5s2.02 4.5 4.5 4.5 4.5-2.02 4.5-4.5-2.02-4.5-4.5-4.5Z">
                                </path>
                            </svg>
                        </div>
                        <input type="password" placeholder="Password"
                            class="input-form-container password-input" style="width: 100%;" id="password"
                            name="password" autoComplete="password" />
                    </div>
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