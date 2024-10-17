<?php
define('FILE_CSS', 'src/styles/profile.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
include 'src/api/functions.php';
$_SESSION['user'] = getUser($_SESSION['user']['id']);
?>

<?php include './src/includes/dash_nav.php'; ?>
<div style="display: flex; height: 100%; gap: 1rem;">
    <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%; margin: 1.5rem;">
        <div
            style="padding: 2rem; background-color: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border-radius: 0.5rem;">
            <section style="max-width: 36rem;">
                <header>
                    <h2 style="font-size: 1.125rem; line-height: 1.75rem; font-weight: 500; color: #1f2937;">Profile
                        Information</h2>
                    <p style="margin-top: 0.25rem; font-size: 0.875rem; line-height: 1.25rem; color: #4b5563;">Update
                        your account's profile information and email address.</p>
                </header>

                <form style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;"
                    id="profile-information">
                    <div>
                        <label for="name"
                            style="display: block; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem; color: #1f2937;">Name</label>
                        <input type="text" name="name" id="name"
                            style="margin-top: 0.25rem; display: block; width: 100%; background-color: #e5e7eb; border-radius: 0.375rem; padding-left: 1rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; color: #111827; border-color: #374151;"
                            value="<?php echo $_SESSION['user']['name']; ?>">
                    </div>

                    <div>
                        <label for="email"
                            style="display: block; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem; color: #1f2937;">Email</label>

                        <input type="email" name="email" id="email"
                            style="margin-top: 0.25rem; display: block; width: 100%; background-color: #e5e7eb; border-radius: 0.375rem; padding-left: 1rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; color: #111827; border-color: #374151;"
                            value="<?php echo $_SESSION['user']['email']; ?>">
                    </div>

                    <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']; ?>">

                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <button
                            style="cursor: pointer; display: inline-flex; align-items: center; padding-left: 1rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; background-color: #1f2937; color: white; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 0.375rem; transition: background-color 150ms ease-in-out;">Save</button>
                        <span style="font-size: 0.875rem; color: #16a34a; display: none;"
                            id="profile-saved">Saved.</span>
                    </div>
                </form>
            </section>
        </div>
        <div
            style="padding: 2rem; background-color: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border-radius: 0.5rem;">
            <section style="max-width: 36rem;">
                <header>
                    <h2 style="font-size: 1.125rem; line-height: 1.75rem; font-weight: 500; color: #1f2937;">Update
                        Password</h2>

                    <p style="margin-top: 0.25rem; font-size: 0.875rem; line-height: 1.25rem; color: #4b5563;">
                        Ensure your account is using a long, random password to stay secure.
                    </p>
                </header>

                <form style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;"
                    id="update-password">
                    <div>
                        <label for="current-password"
                            style="display: block; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem; color: #1f2937;">Current
                            Password</label>
                        <input type="password" name="current-password" id="current-password"
                            style="margin-top: 0.25rem; display: block; width: 100%; background-color: #e5e7eb; border-radius: 0.375rem; padding-left: 1rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; color: #111827; border-color: #374151;">
                    </div>

                    <div>
                        <label for="new-password"
                            style="display: block; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem; color: #1f2937;">New
                            Password</label>

                        <input type="password" name="new-password" id="new-password"
                            style="margin-top: 0.25rem; display: block; width: 100%; background-color: #e5e7eb; border-radius: 0.375rem; padding-left: 1rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; color: #111827; border-color: #374151;">
                    </div>

                    <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']; ?>">

                    <div>
                        <label for="confirm-password"
                            style="display: block; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem; color: #1f2937;">Confirm
                            Password</label>

                        <input type="password" name="confirm-password" id="confirm-password"
                            style="margin-top: 0.25rem; display: block; width: 100%; background-color: #e5e7eb; border-radius: 0.375rem; padding-left: 1rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; color: #111827; border-color: #374151;">
                    </div>

                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <button
                            style="cursor: pointer; display: inline-flex; align-items: center; padding-left: 1rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; background-color: #1f2937; color: white; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 0.375rem; transition: background-color 150ms ease-in-out;">Save</button>
                        <span style="font-size: 0.875rem; color: #16a34a; display: none;"
                            id="password-saved">Saved.</span>
                    </div>
                </form>
            </section>
        </div>
        <div
            style="padding: 2rem; background-color: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border-radius: 0.5rem;">
            <section style="max-width: 36rem;">
                <header>
                    <h2 style="font-size: 1.125rem; line-height: 1.75rem; font-weight: 500; color: #1f2937;">Delete
                        Account</h2>

                    <p style="margin-top: 0.25rem; font-size: 0.875rem; line-height: 1.25rem; color: #4b5563;">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Before
                        deleting your account, please download any data or information that you wish to retain.
                    </p>
                </header>
                <form style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;"
                    id="delete-account">
                    <div>
                        <label for="delete-password"
                            style="display: block; font-weight: 500; font-size: 0.875rem; line-height: 1.25rem; color: #1f2937;">Enter
                            Password</label>

                        <input type="password" name="delete-password" id="delete-password"
                            style="margin-top: 0.25rem; display: block; width: 100%; background-color: #e5e7eb; border-radius: 0.375rem; padding-left: 1rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; color: #111827; border-color: #374151;">
                    </div>

                    <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']; ?>">

                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <button
                            style="cursor: pointer; display: inline-flex; padding-top: 0.5rem; padding-bottom: 0.5rem; padding-left: 1rem; padding-right: 1rem; align-items: center; border-radius: 0.375rem; border-width: 1px; border-color: transparent; font-size: 0.75rem; line-height: 1rem; font-weight: 600; letter-spacing: 0.1em; color: #ffffff; text-transform: uppercase; background-color: #DC2626; transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 300ms; transition-duration: 150ms; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); width: fit-content;">DELETE
                            ACCOUNT</button>
                        <span style="display: none; font-size: 0.875rem; line-height: 1.25rem; color: #059669;"
                            id="delete-confirm">Saved.</span>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>