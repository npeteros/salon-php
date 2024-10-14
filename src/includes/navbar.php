<div class="flex h-20 w-full bg-white items-center">
    <div class="mx-8 md:mx-24 flex w-full">
        <div class="flex w-full items-center justify-between">
            <button class="flex gap-2 h-full items-center" onclick="window.location.href = './'">
                <?php include 'src/includes/logo.php'; ?>
                <span class="text-[#A80011] font-extrabold text-2xl">LOGO</span>
            </button>
            <div class="hidden items-center gap-16 lg:flex">
                <a href="./#home"
                    class="text-black hover:font-medium hover:text-[#E53C37] uppercase group transition duration-300 border-b md:border-none">
                    Home
                    <span
                        class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-[#E53C37]"></span>
                </a>
                <a href="./#services"
                    class="text-black hover:font-medium hover:text-[#E53C37] uppercase group transition duration-300 border-b md:border-none">
                    Our Services
                    <span
                        class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-[#E53C37]"></span>
                </a>
                <a href="/team"
                    class="text-black hover:font-medium hover:text-[#E53C37] uppercase group transition duration-300 border-b md:border-none">
                    Our Team
                    <span
                        class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-[#E53C37]"></span>
                </a>
                <a href="/about"
                    class="text-black hover:font-medium hover:text-[#E53C37] uppercase group transition duration-300 border-b md:border-none">
                    About Us
                    <span
                        class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-[#E53C37]"></span>
                </a>
                <?php if (!isset($_SESSION['user'])) { ?>
                    <a href="./register.php"
                        class="text-black hover:font-medium hover:text-[#E53C37] uppercase group transition duration-300 border-b md:border-none">
                        Register
                        <span
                            class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-[#E53C37]"></span>
                    </a>
                <?php } else { ?>
                    <a href="./logout.php"
                        class="text-black hover:font-medium hover:text-[#E53C37] uppercase group transition duration-300 border-b md:border-none">
                        Logout
                        <span
                            class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-[#E53C37]"></span>
                    </a>
                <?php } ?>
            </div>
            <button class="block items-center text-black lg:hidden" id="menu-button">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fillRule="evenodd" d="M3 8V6h18v2H3Zm0 5h18v-2H3v2Zm0 5h18v-2H3v2Z" clipRule="evenodd">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</div>