<?php
if (!isset($_POST['texture']) || !isset($_POST['hair']) || !isset($_POST['scalp']) || !isset($_POST['straightening']) || !isset($_POST['perming']) || !isset($_POST['relax']) || !isset($_POST['coloring']) || !isset($_POST['rebonding']) || !isset($_POST['bleaching']))
    return header("Location: ./consultation-scalp.php");
include './src/includes/header.php';
$hair_treatment = [
    'straightening' => $_POST['straightening'],
    'perming' => $_POST['perming'],
    'relax' => $_POST['relax'],
    'coloring' => $_POST['coloring'],
    'rebonding' => $_POST['rebonding'],
    'hair bleaching' => $_POST['bleaching']
];
?>

<div class="h-fit min-h-lvh bg-[#D9D9D9] dark:bg-neutral-800">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="flex h-fit md:h-lvh gap-4">
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
                        <span class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 bg-red-500">
                            <svg width="20" height="20" fill="none" stroke="white" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="m5 12 5 5L20 7"></path>
                            </svg>
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Treatment</h3>
                        </span>
                    </li>
                    <li class="flex items-center text-[#E53C37] dark:text-[#E53C37] space-x-2.5 rtl:space-x-reverse">
                        <span
                            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 text-white bg-[#E53C37]">
                            4
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Confirm</h3>
                        </span>
                    </li>
                </ol>
                <div class="w-full flex flex-col gap-4 px-4 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="w-full flex flex-col gap-4">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex justify-between items-center">
                                    <span class="text-xl font-bold dark:text-white">Personal Information</span>
                                    <a class="text-blue-500 font-medium text-sm">Edit</a>
                                </div>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-300" />
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <span class="font-bold dark:text-white"><?php echo $_SESSION['user']['name']; ?></span>
                                <span
                                    class="text-sm ms-4 dark:text-white"><?php echo $_SESSION['user']['email']; ?></span>
                            </div>
                        </div>
                        <div class="w-full flex flex-col gap-4">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex justify-between items-center">
                                    <span class="text-xl font-bold dark:text-white">Hair Information</span>
                                    <a class="text-blue-500 font-medium text-sm">Edit</a>
                                </div>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-300" />
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <span class="font-bold dark:text-white">Hair Texture</span>
                                <span class="text-sm ms-4 dark:text-white"><?php echo $_POST['texture']; ?></span>
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <span class="font-bold dark:text-white">Hair Condition</span>
                                <span class="text-sm ms-4 dark:text-white"><?php echo $_POST['hair']; ?></span>
                            </div>
                        </div>
                        <div class="w-full flex flex-col gap-4">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex justify-between items-center">
                                    <span class="text-xl font-bold dark:text-white">Scalp Information</span>
                                    <a class="text-blue-500 font-medium text-sm">Edit</a>
                                </div>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-300" />
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <span class="font-bold dark:text-white">Scalp Condition</span>
                                <span class="text-sm ms-4 dark:text-white"><?php echo $_POST['scalp']; ?></span>
                            </div>
                        </div>
                        <div class="w-full flex flex-col gap-4">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex justify-between items-center">
                                    <span class="text-xl font-bold dark:text-white">Previous Hair Treatment</span>
                                    <a class="text-blue-500 font-medium text-sm">Edit</a>
                                </div>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-300" />
                            </div>
                            <div class="w-full grid grid-cols-2 gap-1">
                                <?php foreach ($hair_treatment as $key => $value): ?>
                                    <div class="w-full flex flex-col gap-1">
                                        <span class="font-bold dark:text-white"><?php echo ucwords($key); ?></span>
                                        <span class="text-sm ms-4 dark:text-white"><?php echo ucwords($value); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <form id="confirm-consultation" class="flex flex-col gap-4 w-full">
                            <div class="flex flex-col gap-2 w-full">
                                <input type="hidden" name="customer" id="customer"
                                    value="<?php echo $_SESSION['user']['id']; ?>">
                                <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                                <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                                <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
                                <input type="hidden" name="straightening"
                                    value="<?php echo $_POST['straightening']; ?>">
                                <input type="hidden" name="perming" value="<?php echo $_POST['perming']; ?>">
                                <input type="hidden" name="relax" value="<?php echo $_POST['relax']; ?>">
                                <input type="hidden" name="coloring" value="<?php echo $_POST['coloring']; ?>">
                                <input type="hidden" name="rebonding" value="<?php echo $_POST['rebonding']; ?>">
                                <input type="hidden" name="bleaching" value="<?php echo $_POST['bleaching']; ?>">
                            </div>
                            <span class="text-center text-sm text-red-600" id="booking-error"></span>
                            <button class="bg-[#E53C37] hover:bg-[#AD1C1C] text-white rounded-lg px-4 py-2 w-full"
                                type="submit">Submit</button>
                        </form>
                        <form method="post" action="./consultation-treatment.php">
                            <input type="hidden" name="texture" value="<?php echo $_POST['texture']; ?>">
                            <input type="hidden" name="hair" value="<?php echo $_POST['hair']; ?>">
                            <input type="hidden" name="scalp" value="<?php echo $_POST['scalp']; ?>">
                            <input type="hidden" name="straightening" value="<?php echo $_POST['straightening']; ?>">
                            <input type="hidden" name="perming" value="<?php echo $_POST['perming']; ?>">
                            <input type="hidden" name="relax" value="<?php echo $_POST['relax']; ?>">
                            <input type="hidden" name="coloring" value="<?php echo $_POST['coloring']; ?>">
                            <input type="hidden" name="rebonding" value="<?php echo $_POST['rebonding']; ?>">
                            <input type="hidden" name="bleaching" value="<?php echo $_POST['bleaching']; ?>">
                            <button class=" bg-[#D9D9D9] text-gray-500 rounded-lg px-4 py-2 w-full"
                                type="submit">Back</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>