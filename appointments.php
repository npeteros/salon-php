<?php
include 'src/includes/header.php';
include 'src/api/functions.php';
$appointments = getAppointmentsByCustomer($_SESSION['user']['id']) ? array_slice(getAppointmentsByCustomer($_SESSION['user']['id']), 0, 3) : null;
?>

<div class="h-fit min-h-lvh bg-[#D9D9D9] dark:bg-neutral-800">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="flex h-fit md:h-lvh gap-4">
        <?php include 'src/includes/side_nav.php'; ?>
        <div class="w-full flex flex-col gap-4 m-6">
            <div class="w-full flex flex-col">
                <div>
                    <label for="appointments-search"
                        class="mb-2 text-sm font-medium text-neutral-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 end-5 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-neutral-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="appointments-search"
                            class="block w-full p-4 ps-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                            placeholder="Search Appointments..." required />
                    </div>
                </div>
            </div>
            <div class="w-full flex flex-col gap-2">
                <span class="text-[#A80011] dark:text-white text-2xl font-medium">Appointments</span>
                <table class="bg-[#A80011] dark:bg-neutral-700 w-full rounded-xl">
                    <thead class="text-white ">
                        <tr>
                            <th class="font-normal py-2">Staff</th>
                            <th class="font-normal">Service</th>
                            <th class="font-normal">Date</th>
                            <th class="font-normal">Time</th>
                            <th class="font-normal">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-neutral-400 text-center" id="appointmentsList" data-userid="<?php echo $_SESSION['user']['id']; ?>">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>