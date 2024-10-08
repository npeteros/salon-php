<?php 
if(!isset($_POST['texture']) || !isset($_POST['hair'])) return header("Location: ./consultation-hair.php");
include './src/includes/header.php';
?>

<div class="min-h-lvh bg-[#D9D9D9] dark:bg-neutral-800">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="flex h-full gap-4">
        <?php include './src/includes/side_nav.php'; ?>

        <div class="w-full m-6">
            <div class="bg-white dark:bg-neutral-700 flex flex-col w-full gap-4 p-4 rounded-2xl">
                <ol class="items-center w-full justify-between space-y-4 sm:flex sm:space-y-0 rtl:space-x-reverse">
                    <li
                        class="flex items-center text-[#E53C37] dark:text-[#E53C37] space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-2 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 bg-red-500">
                            <svg width="20" height="20" fill="none" stroke="white" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="m5 12 5 5L20 7"></path>
                            </svg>
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Hair</h3>
                        </span>
                    </li>
                    <li
                        class="flex items-center text-[#E53C37] dark:text-[#E53C37] space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-2 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 text-white bg-[#E53C37]">
                            2
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Scalp</h3>
                        </span>
                    </li>
                    <li
                        class="flex items-center text-gray-500 dark:text-gray-200 space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span
                            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                            3
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Treatment</h3>
                        </span>
                    </li>
                    <li class="flex items-center text-gray-500 dark:text-gray-200 space-x-2.5 rtl:space-x-reverse">
                        <span
                            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                            4
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Confirm</h3>
                        </span>
                    </li>
                </ol>
                <div class="flex flex-col w-full px-4 pt-4 rounded-2xl">
                    <form method="post" action="./consultation-treatment.php" class="flex flex-col gap-4 w-full">
                        <div class="flex gap-4 w-full">
                            <div class="flex flex-col gap-2 w-full">
                                <label for="name" class="font-bold dark:text-gray-200">Scalp Condition</label>
                                <div class="w-1/3 flex justify-between">
                                    <div class="flex gap-2 items-center">
                                        <input type="radio" name="scalp" id="s-normal" value="Normal"
                                            <?php echo isset($_POST['scalp']) ? $_POST['scalp'] == "Normal" ? "checked" : "" : null; ?>
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required />
                                        <label for="normal" class="dark:text-gray-200">Normal</label>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <input type="radio" name="scalp" id="s-oily" value="Oily"
                                            <?php echo isset($_POST['scalp']) ? $_POST['scalp'] == "Oily" ? "checked" : "" : null; ?>
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                        <label for="oily" class="dark:text-gray-200">Oily</label>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <input type="radio" name="scalp" id="s-dry" value="Dry"
                                            <?php echo isset($_POST['scalp']) ? $_POST['scalp'] == "Dry" ? "checked" : "" : null; ?>
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                        <label for="dry" class="dark:text-gray-200">Dry</label>
                                    </div>
                                </div>
                                <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                                <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                                <?php if(isset($_POST['straightening'])) { ?>
                                        <input type="hidden" name="straightening" value="<?php echo $_POST['straightening']; ?>">
                                        <input type="hidden" name="perming" value="<?php echo $_POST['perming']; ?>">
                                        <input type="hidden" name="relax" value="<?php echo $_POST['relax']; ?>">
                                        <input type="hidden" name="coloring" value="<?php echo $_POST['coloring']; ?>">
                                        <input type="hidden" name="rebonding" value="<?php echo $_POST['rebonding']; ?>">
                                        <input type="hidden" name="bleaching" value="<?php echo $_POST['bleaching']; ?>">
                                <?php } ?>
                            </div>
                        </div>
                        <button class="bg-[#E53C37] hover:bg-[#AD1C1C] text-white rounded-lg px-4 py-2 w-full"
                            type="submit">Next</button>
                    </form>
                    <form action="./consultation-hair.php" method="POST">
                        <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                        <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                        <?php if(isset($_POST['scalp'])) { ?>
                            <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
                        <?php } ?>
                        <?php if(isset($_POST['straightening'])) { ?>
                                <input type="hidden" name="straightening" value="<?php echo $_POST['straightening']; ?>">
                                <input type="hidden" name="perming" value="<?php echo $_POST['perming']; ?>">
                                <input type="hidden" name="relax" value="<?php echo $_POST['relax']; ?>">
                                <input type="hidden" name="coloring" value="<?php echo $_POST['coloring']; ?>">
                                <input type="hidden" name="rebonding" value="<?php echo $_POST['rebonding']; ?>">
                                <input type="hidden" name="bleaching" value="<?php echo $_POST['bleaching']; ?>">
                        <?php } ?>
                        <button class="bg-[#D9D9D9] text-gray-500 rounded-lg px-4 py-2 w-full" type="submit">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>