<?php
if ($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST['date']) || !isset($_POST['time']) || !isset($_POST['service']) || !isset($_POST['stylist']))
    header("Location: ./book-service.php");
include './src/includes/header.php';
include './src/api/functions.php';
$service = getServiceById($_POST['service']);
$stylist = getUser($_POST['stylist']);
$formattedDate = date('l, F j, Y', strtotime($_POST['date']));
$formattedTime = date('g:i A', strtotime($_POST['time']));
$formattedDuration = formatTime($service['duration']);
$stylistReviewSummary = getStylistReviewSummary($_POST['stylist']);
// print_r($stylistReviewSummary);
?>

<div class="min-h-lvh bg-[#D9D9D9]">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="flex h-full gap-4">
        <?php include './src/includes/side_nav.php'; ?>

        <div class="w-full m-6">
            <div class="bg-white flex flex-col w-full gap-4 p-4 rounded-2xl">
                <ol class="items-center w-full justify-between space-y-4 sm:flex sm:space-y-0 rtl:space-x-reverse">
                    <li
                        class="flex items-center text-[#E53C37] dark:text-[#E53C37] space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-2 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 dark:bg-[#E53C37]">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="m5 12 5 5L20 7"></path>
                            </svg>
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Schedule</h3>
                        </span>
                    </li>
                    <li
                        class="flex items-center text-[#E53C37] dark:text-[#E53C37] space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-2 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 dark:bg-[#E53C37]">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="m5 12 5 5L20 7"></path>
                            </svg>
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Service</h3>
                        </span>
                    </li>
                    <li
                        class="flex items-center text-[#E53C37] dark:text-[#E53C37] space-x-2.5 rtl:space-x-reverse sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-2 xl:after:mx-10 dark:after:border-gray-200 w-full">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 dark:bg-[#E53C37]">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="m5 12 5 5L20 7"></path>
                            </svg>
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Stylist</h3>
                        </span>
                    </li>
                    <li class="flex items-center text-[#E53C37] dark:text-[#E53C37] space-x-2.5 rtl:space-x-reverse">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full shrink-0 text-white dark:bg-[#E53C37]">
                            4
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">Confirm</h3>
                        </span>
                    </li>
                </ol>
                <div class="w-full flex flex-col gap-4 px-4 pt-4">
                    <div class="grid grid-cols-2 gap-8">
                        <div class="w-full flex flex-col gap-4">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex justify-between items-center">
                                    <span class="text-xl font-bold">Personal Information</span>
                                    <a class="text-blue-500 font-medium text-sm">Edit</a>
                                </div>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-300" />
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <span class="font-bold"><?php echo $_SESSION['user']['name']; ?></span>
                                <span class="text-sm"><?php echo $_SESSION['user']['email']; ?></span>
                            </div>
                        </div>
                        <div class="w-full flex flex-col gap-4">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex justify-between items-center">
                                    <span class="text-xl font-bold">Stylist Information</span>
                                    <a class="text-blue-500 font-medium text-sm">Edit</a>
                                </div>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-300" />
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <span class="w-full flex justify-between items-center">
                                    <span class="font-bold"><?php echo $stylist['name']; ?></span>
                                    <p class="flex items-center text-xs gap-2">
                                        <span class="flex items-center"><?php echo printStars($stylistReviewSummary['average_rating']) ?></span>
                                        <a class="text-blue-500 underline">(<?php echo $stylistReviewSummary['total_appointments']; ?>)</a>
                                    </p>
                                </span>
                                <span class="text-sm"><?php echo $stylist['email']; ?></span>
                            </div>
                        </div>
                        <div class="w-full flex flex-col gap-4">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex justify-between items-center">
                                    <span class="text-xl font-bold">Appointment Schedule</span>
                                    <a class="text-blue-500 font-medium text-sm">Edit</a>
                                </div>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-300" />
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <span class="font-bold"><?php echo $formattedDate; ?></span>
                                <span class="text-sm"><?php echo $formattedTime; ?></span>
                            </div>
                        </div>
                        <div class="w-full flex flex-col gap-4">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex justify-between items-center">
                                    <span class="text-xl font-bold">Service Details</span>
                                    <a class="text-blue-500 font-medium text-sm">Edit</a>
                                </div>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-300" />
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <div class="w-full flex justify-between items-center">
                                    <span class=""><?php echo $service['name']; ?></span>
                                    <span class="text-sm font-bold">&#x20B1; <?php echo $service['price']; ?></span>
                                </div>
                                <span class="text-sm"><span class="font-bold">Length:</span>
                                    <?php echo $formattedDuration ?></span>
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