<?php
include 'src/includes/header.php';
include 'src/api/functions.php';
$_SESSION['user'] = getUser($_SESSION['user']['id']);
?>

<?php include './src/includes/dash_nav.php'; ?>
<div class="flex h-full gap-4">
    <div class="flex flex-col gap-4 w-full m-6">
        <div class="p-8 bg-white dark:bg-neutral-700 shadow rounded-lg">
            <section class="max-w-xl">
                <header>
                    <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Profile Information</h2>

                    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                        Update your account's profile information and email address.
                    </p>
                </header>

                <form class="mt-6 space-y-6" id="profile-information">
                    <div>
                        <label for="name"
                            class="block font-medium text-sm text-neutral-700 dark:text-neutral-300">Name</label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full bg-neutral-200 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm px-4 py-2"
                            value="<?php echo $_SESSION['user']['name']; ?>">
                    </div>

                    <div>
                        <label for="email"
                            class="block font-medium text-sm text-neutral-700 dark:text-neutral-300">Email</label>

                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full bg-neutral-200 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm px-4 py-2"
                            value="<?php echo $_SESSION['user']['email']; ?>">
                    </div>

                    <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']; ?>">

                    <div class="flex items-center gap-4">
                        <button
                            class="inline-flex items-center px-4 py-2 bg-neutral-800 dark:bg-neutral-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-neutral-800 uppercase tracking-widest hover:bg-neutral-700 dark:hover:bg-white focus:bg-neutral-700 dark:focus:bg-white active:bg-neutral-900 dark:active:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800 transition ease-in-out duration-150">Save</button>
                        <span class="text-sm text-green-600 dark:text-green-400 hidden" id="profile-saved">Saved.</span>
                    </div>
                </form>
            </section>
        </div>
        <div class="p-8 bg-white dark:bg-neutral-700 shadow rounded-lg">
            <section class="max-w-xl">
                <header>
                    <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Update Password</h2>

                    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                        Ensure your account is using a long, random password to stay secure.
                    </p>
                </header>

                <form class="mt-6 space-y-6" id="update-password">
                    <div>
                        <label for="current-password"
                            class="block font-medium text-sm text-neutral-700 dark:text-neutral-300">Current
                            Password</label>
                        <input type="password" name="current-password" id="current-password"
                            class="mt-1 block w-full bg-neutral-200 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm px-4 py-2">
                    </div>

                    <div>
                        <label for="new-password"
                            class="block font-medium text-sm text-neutral-700 dark:text-neutral-300">New
                            Password</label>

                        <input type="password" name="new-password" id="new-password"
                            class="mt-1 block w-full bg-neutral-200 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm px-4 py-2">
                    </div>

                    <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']; ?>">

                    <div>
                        <label for="confirm-password"
                            class="block font-medium text-sm text-neutral-700 dark:text-neutral-300">Confirm
                            Password</label>

                        <input type="password" name="confirm-password" id="confirm-password"
                            class="mt-1 block w-full bg-neutral-200 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm px-4 py-2">
                    </div>

                    <div class="flex items-center gap-4">
                        <button
                            class="inline-flex items-center px-4 py-2 bg-neutral-800 dark:bg-neutral-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-neutral-800 uppercase tracking-widest hover:bg-neutral-700 dark:hover:bg-white focus:bg-neutral-700 dark:focus:bg-white active:bg-neutral-900 dark:active:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800 transition ease-in-out duration-150">Save</button>
                        <span class="text-sm text-green-600 dark:text-green-400 hidden"
                            id="password-saved">Saved.</span>
                    </div>
                </form>
            </section>
        </div>
        <div class="p-8 bg-white dark:bg-neutral-700 shadow rounded-lg">
            <section class="max-w-xl">
                <header class="">
                    <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Delete Account</h2>

                    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Before
                        deleting your account, please download any data or information that you wish to retain.
                    </p>
                </header>
                <form class="mt-6 space-y-6" id="delete-account">
                    <div>
                        <label for="delete-password"
                            class="block font-medium text-sm text-neutral-700 dark:text-neutral-300">Enter
                            Password</label>

                        <input type="password" name="delete-password" id="delete-password"
                            class="mt-1 block w-full bg-neutral-200 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm px-4 py-2">
                    </div>

                    <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']; ?>">

                    <button
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">DELETE
                        ACCOUNT</button>
                        <span class="text-sm text-green-600 dark:text-green-400 hidden"
                            id="delete-confirm">Saved.</span>
                </form>
            </section>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>