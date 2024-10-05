<?php
include 'src/includes/header.php';
if (isset($_SESSION['user']))
    header('Location: index.php');
?>

<div class="bg-[#DCDFE9] min-h-screen w-full flex justify-center">
    <div class="bg-[#FFFFFF] rounded-2xl min-h-full w-full lg:w-5/6 flex lg:grid lg:grid-cols-2">
        <div class="hidden lg:grid lg:bg-[#820000] rounded-tr-[14rem] rounded-br-[14rem] place-items-center">
            <div class="flex flex-col items-center gap-6">
                <h1 class="font-bold text-4xl text-white">
                    Sign In
                </h1>
                <a href="./login.php">
                    <button
                        class="bg-[#820000] rounded-md py-2  text-white px-14 font-sans uppercase outline outline-2 outline-offset-2 hover:bg-white hover:text-[#820000] hover:border-red-900">
                        LOGIN
                    </button>
                </a>
            </div>
        </div>
        <div class="flex flex-col gap-4 justify-center items-center px-4 md:px-0 w-full">
            <h1 class="font-bold text-4xl">Create Account</h1>
            <form class="flex flex-col gap-4" id="register-form">
                <div class="flex flex-col w-full">
                    <input type="text" placeholder="Name" class="bg-[#EEEEEE] rounded-xl p-2 w-96" id="name" name="name"
                        autoComplete="name" />
                </div>
                <div class="flex flex-col w-full">
                    <input type="email" placeholder="Email" class="bg-[#EEEEEE] rounded-xl p-2 w-96" id="email"
                        name="email" autoComplete="username" />
                </div>
                <div class="flex flex-col w-full">
                    <input type="password" placeholder="Password" class="bg-[#EEEEEE] rounded-xl p-2 w-96" id="password"
                        name="password" autoComplete="password" />
                </div>
                <div class="flex flex-col w-full">
                    <input type="password" placeholder="Confirm Password" class="bg-[#EEEEEE] rounded-xl p-2 w-96"
                        id="confirm-password" name="confirm-password" autoComplete="confirm-password" />
                </div>
                <div class="flex flex-col w-full">
                    <p class="text-sm text-red-600 dark:text-red-400" id="register-error"></p>
                </div>
                <button class="bg-[#D01C27] hover:bg-[#A80011] rounded-xl py-2  text-white px-14 font-sans uppercase">
                    Sign Up
                </button>
            </form>
        </div>
    </div>
</div>
<?php include 'src/includes/footer.php'; ?>