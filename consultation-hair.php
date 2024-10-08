<?php include './src/includes/header.php';
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
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 text-white bg-[#E53C37]">
                            1
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Hair</h3>
                        </span>
                    </li>
                    <li
                        class="flex items-center text-gray-500 dark:text-gray-200 space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span
                            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
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
                    <form method="post" action="./consultation-scalp.php" class="flex flex-col gap-4 w-full">
                        <div class="flex gap-4 w-full">
                            <div class="flex flex-col gap-2 w-1/2">
                                <label for="name" class="font-bold dark:text-gray-200">Hair Texture</label>
                                <div class="flex gap-2 w-full items-center">
                                    <input type="radio" name="texture" id="t-fine" value="Fine" 
                                        <?php echo isset($_POST['texture']) ? $_POST['texture'] == "Fine" ? "checked" : "" : null; ?>
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required />
                                    <label for="fine" class="dark:text-gray-200">Fine</label>
                                </div>
                                <div class="flex gap-2 w-full items-center">
                                    <input type="radio" name="texture" id="t-medium" value="Medium"
                                        <?php echo isset($_POST['texture']) ? $_POST['texture'] == "Medium" ? "checked" : "" : null; ?>
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                    <label for="medium" class="dark:text-gray-200">Medium</label>
                                </div>
                                <div class="flex gap-2 w-full items-center">
                                    <input type="radio" name="texture" id="t-thick" value="Thick"
                                        <?php echo isset($_POST['texture']) ? $_POST['texture'] == "Thick" ? "checked" : "" : null; ?>
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                    <label for="thick" class="dark:text-gray-200">Thick</label>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 w-1/2">
                                <label for="name" class="font-bold dark:text-gray-200">Hair Condition</label>
                                <div class="w-full grid grid-cols-2">
                                    <div class="flex gap-2 w-full items-center">
                                        <input type="radio" name="hair" id="h-damaged" value="Damaged"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Damaged" ? "checked" : "" : null; ?>
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required />
                                        <label for="damaged" class="dark:text-gray-200">Damaged</label>
                                    </div>
                                    <div class="flex gap-2 w-full items-center">
                                        <input type="radio" name="hair" id="h-dry" value="Dry"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Dry" ? "checked" : "" : null; ?>
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                        <label for="dry" class="dark:text-gray-200">Dry</label>
                                    </div>
                                    <div class="flex gap-2 w-full items-center">
                                        <input type="radio" name="hair" id="h-oily" value="Oily"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Oily" ? "checked" : "" : null; ?>
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                        <label for="oily" class="dark:text-gray-200">Oily</label>
                                    </div>
                                    <div class="flex gap-2 w-full items-center">
                                        <input type="radio" name="hair" id="h-normal" value="Normal"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Normal" ? "checked" : "" : null; ?>
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                        <label for="normal" class="dark:text-gray-200">Normal</label>
                                    </div>
                                    <div class="flex gap-2 w-full items-center">
                                        <input type="radio" name="hair" id="h-chemical" value="Chemically Treated"
                                        <?php echo isset($_POST['hair']) ? $_POST['hair'] == "Chemically Treated" ? "checked" : "" : null; ?>
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                        <label for="chemical" class="dark:text-gray-200">Chemically Treated</label>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <button class="bg-[#E53C37] hover:bg-[#AD1C1C] text-white rounded-lg px-4 py-2 w-full"
                            type="submit">Next</button>
                    </form>
                    <button class="bg-[#D9D9D9] text-gray-500 rounded-lg px-4 py-2 w-full" type="button"
                        onclick="window.location.href = './dashboard.php'">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>