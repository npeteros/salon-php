<?php
if (!isset($_POST['texture']) || !isset($_POST['hair']) || !isset($_POST['scalp']))
    return header("Location: ./consultation-scalp.php");
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
                        <span class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 bg-red-500">
                            <svg width="20" height="20" fill="none" stroke="white" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="m5 12 5 5L20 7"></path>
                            </svg>
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Scalp</h3>
                        </span>
                    </li>
                    <li
                        class="flex items-center text-[#E53C37] dark:text-[#E53C37] space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-2 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 text-white bg-[#E53C37]">
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
                    <form method="post" action="./consultation-confirm.php" class="flex flex-col gap-4 w-full">
                        <div class="flex gap-4 w-full">
                            <div class="flex flex-col gap-2 w-full">
                                <div class="flex flex-col">
                                    <label for="name" class="font-bold dark:text-gray-200">Previous Hair Chemical
                                        Treatment</label>
                                    <span class="text-xs dark:text-white italic">How long have you been using the
                                        following:</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4 w-full">
                                    <div class="flex flex-col gap-1 w-full">
                                        <span
                                            class="w-full ms-2 text-sm font-medium text-neutral-900 dark:text-neutral-300">Straightening</span>
                                        <div
                                            class="flex items-center ps-4 border border-neutral-200 rounded dark:border-neutral-500">
                                            <div class="flex justify-between w-2/3 py-4">
                                                <div class="flex h-full items-center">
                                                    <input id="straightening" type="radio" value="less" required
                                                        name="straightening"
                                                        <?php echo isset($_POST['straightening']) ? $_POST['straightening'] == "less" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="straightening-less"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">Less
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="straightening" type="radio" value="more"
                                                        name="straightening"
                                                        <?php echo isset($_POST['straightening']) ? $_POST['straightening'] == "more" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="straightening-more"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">More
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="straightening" type="radio" value="none"
                                                        name="straightening"
                                                        <?php echo isset($_POST['straightening']) ? $_POST['straightening'] == "none" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="straightening-none"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1 w-full">
                                        <span
                                            class="w-full ms-2 text-sm font-medium text-neutral-900 dark:text-neutral-300">Perming</span>
                                        <div
                                            class="flex items-center ps-4 border border-neutral-200 rounded dark:border-neutral-500">
                                            <div class="flex justify-between w-2/3 py-4">
                                                <div class="flex h-full items-center">
                                                    <input id="perming" type="radio" value="less" required
                                                        name="perming"
                                                        <?php echo isset($_POST['perming']) ? $_POST['perming'] == "less" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="perming-less"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">Less
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="perming" type="radio" value="more" name="perming"
                                                        <?php echo isset($_POST['perming']) ? $_POST['perming'] == "more" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="perming-more"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">More
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="perming" type="radio" value="none" name="perming"
                                                        <?php echo isset($_POST['perming']) ? $_POST['perming'] == "none" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="perming-none"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1 w-full">
                                        <span
                                            class="w-full ms-2 text-sm font-medium text-neutral-900 dark:text-neutral-300">Relax</span>
                                        <div
                                            class="flex items-center ps-4 border border-neutral-200 rounded dark:border-neutral-500">
                                            <div class="flex justify-between w-2/3 py-4">
                                                <div class="flex h-full items-center">
                                                    <input id="relax" type="radio" value="less" required name="relax"
                                                        <?php echo isset($_POST['relax']) ? $_POST['relax'] == "less" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="relax-less"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">Less
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="relax" type="radio" value="more" name="relax"
                                                        <?php echo isset($_POST['relax']) ? $_POST['relax'] == "more" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="relax-more"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">More
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="relax" type="radio" value="none" name="relax"
                                                        <?php echo isset($_POST['relax']) ? $_POST['relax'] == "none" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="relax-none"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1 w-full">
                                        <span
                                            class="w-full ms-2 text-sm font-medium text-neutral-900 dark:text-neutral-300">Coloring</span>
                                        <div
                                            class="flex items-center ps-4 border border-neutral-200 rounded dark:border-neutral-500">
                                            <div class="flex justify-between w-2/3 py-4">
                                                <div class="flex h-full items-center">
                                                    <input id="coloring" type="radio" value="less" required
                                                        name="coloring"
                                                        <?php echo isset($_POST['coloring']) ? $_POST['coloring'] == "less" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="coloring-less"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">Less
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="coloring" type="radio" value="more" name="coloring"
                                                        <?php echo isset($_POST['coloring']) ? $_POST['coloring'] == "more" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="coloring-more"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">More
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="coloring" type="radio" value="none" name="coloring"
                                                        <?php echo isset($_POST['coloring']) ? $_POST['coloring'] == "none" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="coloring-none"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1 w-full">
                                        <span
                                            class="w-full ms-2 text-sm font-medium text-neutral-900 dark:text-neutral-300">Rebonding</span>
                                        <div
                                            class="flex items-center ps-4 border border-neutral-200 rounded dark:border-neutral-500">
                                            <div class="flex justify-between w-2/3 py-4">
                                                <div class="flex h-full items-center">
                                                    <input id="rebonding" type="radio" value="less" required
                                                        name="rebonding"
                                                        <?php echo isset($_POST['rebonding']) ? $_POST['rebonding'] == "less" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="rebonding-less"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">Less
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="rebonding" type="radio" value="more" name="rebonding"
                                                        <?php echo isset($_POST['rebonding']) ? $_POST['rebonding'] == "more" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="rebonding-more"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">More
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="rebonding" type="radio" value="none" name="rebonding"
                                                        <?php echo isset($_POST['rebonding']) ? $_POST['rebonding'] == "none" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="rebonding-none"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1 w-full">
                                        <span
                                            class="w-full ms-2 text-sm font-medium text-neutral-900 dark:text-neutral-300">Hair
                                            Bleaching</span>
                                        <div
                                            class="flex items-center ps-4 border border-neutral-200 rounded dark:border-neutral-500">
                                            <div class="flex justify-between w-2/3 py-4">
                                                <div class="flex h-full items-center">
                                                    <input id="bleaching" type="radio" value="less" required
                                                        name="bleaching"
                                                        <?php echo isset($_POST['bleaching']) ? $_POST['bleaching'] == "less" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="bleaching-less"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">Less
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="bleaching" type="radio" value="more" name="bleaching"
                                                        <?php echo isset($_POST['bleaching']) ? $_POST['bleaching'] == "more" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="bleaching-more"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">More
                                                        than 6 months</label>
                                                </div>
                                                <div class="flex h-full items-center">
                                                    <input id="bleaching" type="radio" value="none" name="bleaching"
                                                        <?php echo isset($_POST['bleaching']) ? $_POST['bleaching'] == "none" ? "checked" : "" : null; ?>
                                                        class="w-4 h-4 text-blue-600 bg-neutral-100 border-neutral-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-700 dark:border-neutral-600">
                                                    <label for="bleaching-none"
                                                        class="w-full ms-2 text-sm text-neutral-900 dark:text-neutral-300">None</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                                <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                                <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
                            </div>
                        </div>
                        <button class="bg-[#E53C37] hover:bg-[#AD1C1C] text-white rounded-lg px-4 py-2 w-full"
                            type="submit">Next</button>
                    </form>
                    <form action="./consultation-scalp.php" method="POST">
                        <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                        <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                        <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
                        <?php if(isset($_POST['straightening'])) { ?>
                                <input type="hidden" name="straightening" value="<?php echo $_POST['straightening']; ?>">
                                <input type="hidden" name="perming" value="<?php echo $_POST['perming']; ?>">
                                <input type="hidden" name="relax" value="<?php echo $_POST['relax']; ?>">
                                <input type="hidden" name="coloring" value="<?php echo $_POST['coloring']; ?>">
                                <input type="hidden" name="rebonding" value="<?php echo $_POST['rebonding']; ?>">
                                <input type="hidden" name="bleaching" value="<?php echo $_POST['bleaching']; ?>">
                        <?php } ?>
                        <button class="bg-[#D9D9D9] text-gray-500 rounded-lg px-4 py-2 w-full"
                            type="submit">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>