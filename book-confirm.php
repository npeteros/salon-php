<?php
if ($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST['date']) || !isset($_POST['time']) || !isset($_POST['service']) || !isset($_POST['stylist']))
    header("Location: ./book-service.php");
include './src/includes/header.php';
include './src/api/functions.php';
$formattedDate = date('l, F j, Y', strtotime($_POST['date']));
$formattedTime = date('g:i A', strtotime($_POST['time']));
$service = getServiceById($_POST['service']);
$stylist = getUser($_POST['stylist']);
?>

<div class="min-h-lvh bg-[#D9D9D9]">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="flex h-full gap-4">
        <?php include './src/includes/side_nav.php'; ?>

        <div class="w-full m-6">
            <div class="bg-white flex flex-col w-full gap-4 p-4 rounded-2xl">
                <ol class="items-center w-full justify-between space-y-4 sm:flex sm:space-y-0 rtl:space-x-reverse">
                    <li
                        class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-2 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span
                            class="flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-gray-400">
                            1
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Schedule</h3>
                        </span>
                    </li>
                    <li
                        class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span
                            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                            2
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Service</h3>
                        </span>
                    </li>
                    <li
                        class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span
                            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                            3
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Stylist</h3>
                        </span>
                    </li>
                    <li class="flex items-center text-[#E53C37] dark:text-[#E53C37] space-x-2.5 rtl:space-x-reverse">
                        <span
                            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-[#E53C37]">
                            4
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Confirm</h3>
                        </span>
                    </li>
                </ol>
                <div class="w-full flex flex-col gap-4 px-4 pt-4">
                    <div class="flex justify-center w-full px-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2">
                                <h1 class="text-xl font-bold">Date</h1>
                                <span><?php echo $formattedDate ?></span>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <h1 class="text-xl font-bold">Time</h1>
                                <span><?php echo $formattedTime ?></span>
                            </div>
                            <div class="flex flex-col gap-2">
                                <h1 class="text-xl font-bold">Service</h1>
                                <span><?php echo $service['name'] ?></span>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <h1 class="text-xl font-bold">Stylist</h1>
                                <span><?php echo $stylist['name'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <form method="post" action='book-confirm.php' class="flex flex-col gap-4 w-full">
                            <div class="flex flex-col gap-2 w-full">
                                <input type="hidden" name="date" id="date" value="<?php echo $_POST['date'] ?>" />
                                <input type="hidden" name="time" id="time" value="<?php echo $_POST['time'] ?>" />
                                <input type="hidden" name="service" id="service"
                                    value="<?php echo $_POST['service'] ?>" />
                                <input type="hidden" name="stylist" id="stylist"
                                    value="<?php echo $_POST['stylist']; ?>" />
                            </div>
                            <button class=" bg-[#E53C37] hover:bg-[#AD1C1C] text-white rounded-lg px-4 py-2 w-full"
                                type="submit">Submit</button>
                        </form>
                        <form method="post" action="./book-stylist.php">
                            <input type="hidden" name="date" id="date" value="<?php echo $_POST['date'] ?>" />
                            <input type="hidden" name="time" id="time" value="<?php echo $_POST['time'] ?>" />
                            <input type="hidden" name="service" id="service" value="<?php echo $_POST['service'] ?>">
                            <input type="hidden" name="stylist" id="stylist" value="<?php echo $_POST['stylist']; ?>">
                            <button class=" bg-[#D9D9D9] text-gray-500 rounded-lg px-4 py-2 w-full"
                                type="submit">Back</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>