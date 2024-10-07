<script>
    function toggleDarkMode() {
        const theme = localStorage.getItem("theme");
        if (theme === "dark") {
            localStorage.setItem("theme", "light");
            $("body").removeClass("dark");
        } else {
            localStorage.setItem("theme", "dark");
            $("body").addClass("dark");
        }
    }
</script>

<div
    class="w-full bg-white dark:bg-neutral-900 border-b border-b-neutral-300 dark:border-b-neutral-600 h-20 flex items-center">
    <div class="mx-8 md:mx-24 flex w-full">
        <div class="flex w-full justify-between">
            <button class="flex gap-2 h-full items-center text-black dark:text-neutral-600"
                onclick="window.location.href = './'">
                <?php include __DIR__ . '/logo.php'; ?>
                <span class="text-[#A80011] font-extrabold text-2xl">LOGO</span>
            </button>
            <div class="flex gap-4">
                <div class="border rounded-md p-2 hover:cursor-pointer text-black dark:text-white"
                    onclick="toggleDarkMode()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3h.393a7.5 7.5 0 0 0 7.92 12.446A9 9 0 1 1 12 2.992V3Z"></path>
                    </svg>
                </div>
                <div class="border rounded-md p-2 text-black dark:text-white">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 5a2 2 0 1 1 4 0 7 7 0 0 1 4 6v3a4 4 0 0 0 2 3H4a4 4 0 0 0 2-3v-3a7 7 0 0 1 4-6">
                        </path>
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>