<?php
include 'src/includes/header.php';
if (isset($_SESSION['user']))
    header('Location: index.php');
?>

<div class="bg-[#DCDFE9] min-h-screen w-full flex justify-center">
    <div class="bg-[#FFFFFF] rounded-2xl min-h-full w-full lg:w-5/6 flex lg:grid lg:grid-cols-2">
        <div class="h-full flex flex-col w-full">
            <button class="w-fit h-16 mx-4 flex items-center" onclick="window.location.href = './'">
                <svg width="20" height="20" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m15 6-6 6 6 6"></path>
                </svg>
            </button>
            <div class="flex flex-col gap-4 justify-center items-center px-4 md:px-24 h-full w-full">
                <h1 class="font-bold text-4xl">Sign In</h1>
                <form class="flex flex-col gap-4 justify-center items-center w-full" id="login-form">
                    <div class="flex flex-col w-full">
                        <input type="email" placeholder="Email" name="email" id="email" autoComplete="username"
                            isFocused={true} class="bg-[#EEEEEE] rounded-xl p-2 w-full" />
                    </div>
                    <div class="flex flex-col w-full">
                        <input type="password" placeholder="Password" id="password" name="password"
                            autoComplete="current-password" class="bg-[#EEEEEE] rounded-xl p-2" />
                    </div>
                    <div class="flex flex-col w-full">
                        <p class="text-sm text-red-600 dark:text-red-400" id="login-error"></p>
                    </div>
                    <button
                        class="bg-[#D01C27] hover:bg-[#A80011] rounded-xl py-2 text-white px-14 font-sans uppercase">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
        <div class="hidden lg:grid lg:bg-[#820000] rounded-tl-[14rem] rounded-bl-[14rem] place-items-center">
            <div class="flex flex-col items-center gap-6">
                <h1 class="font-bold text-4xl text-white">
                    Sign Up
                </h1>
                <a href='./register.php'>
                    <button
                        class="bg-[#820000] rounded-md py-2  text-white px-14 font-sans uppercase outline outline-2 outline-offset-2 hover:bg-white hover:text-[#820000] hover:border-red-900">
                        REGISTER
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
<?php include 'src/includes/footer.php'; ?>