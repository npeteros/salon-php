<?php
define('FILE_CSS', 'src/styles/dashboard.css');
include 'src/includes/header.php';
if(!isset($_SESSION['user'])) header('Location: ./login.php');
include 'src/api/functions.php';

$popularServices = getPopularServices() ? array_slice(getPopularServices(), 0, 3) : [];
$appointments = getAppointmentsByCustomer($_SESSION['user']['id']) ? array_slice(getAppointmentsByCustomer($_SESSION['user']['id']), 0, 3) : null;
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="dashboard-container">
        <?php include 'src/includes/side_nav.php'; ?>

        <div class="main-content-container">
            <div class="submit-consultation-container">
                <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" class="h-full"
                    viewBox="0 0 866.33071 605.73993" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path
                        d="M898.30315,567.7887a9.14581,9.14581,0,0,1,1.93088-13.89051l-7.25159-31.682,15.8187,5.91773,4.46105,29.1785a9.19542,9.19542,0,0,1-14.959,10.47626Z"
                        transform="translate(-166.83465 -147.13004)" fill="#ffb8b8" />
                    <path
                        d="M897.20867,542.64389l-13.906-26.88477,1.88062-67.69726.89355,1.88281c1.041,2.19336,25.44019,53.84619,23.7,71.13819l2.78882,15.80224Z"
                        transform="translate(-166.83465 -147.13004)" fill="#3f3d56" />
                    <polygon points="721.307 594.201 732.458 594.201 737.762 551.192 721.305 551.193 721.307 594.201"
                        fill="#ffb8b8" />
                    <path
                        d="M885.29761,737.691l21.95908-.00089h.00155a13.99379,13.99379,0,0,1,13.99352,13.99352v.45476l-35.95371.00177Z"
                        transform="translate(-166.83465 -147.13004)" fill="#2f2e41" />
                    <polygon points="611.134 585.727 621.877 588.714 638.511 548.699 622.655 544.29 611.134 585.727"
                        fill="#ffb8b8" />
                    <path
                        d="M776.20352,728.58778,797.36,734.47044l.00149.00042a13.99378,13.99378,0,0,1,9.7326,17.23118l-.12184.43813-34.63966-9.63139Z"
                        transform="translate(-166.83465 -147.13004)" fill="#2f2e41" />
                    <path
                        d="M877.02434,724.5643l-22.50366-161.126L805.91619,723.65317l-38.21692-13.04981,54.77454-214.53271.36035-.02539,57.38061-3.99121,41.45679,219.48779Z"
                        transform="translate(-166.83465 -147.13004)" fill="#2f2e41" />
                    <path
                        d="M871.07293,420.14509s-20.91878-10.91415-49.11366-6.36659c0,0-15.007,36.205,0,50.61758l4.0928,36.24085s38.19952,22.7378,50.93269-3.63805l-1.819-30.01391s9.09512-14.39464,1.819-24.93281A34.82081,34.82081,0,0,1,871.07293,420.14509Z"
                        transform="translate(-166.83465 -147.13004)" fill="#a80011" />
                    <path
                        d="M873.72307,584.98666l3.67163-76.188-10.39135-90.63379.47705-.07227c13.63086-2.05517,18.00268,21.42774,18.18213,22.42822l23.72583,134.14209Z"
                        transform="translate(-166.83465 -147.13004)" fill="#3f3d56" />
                    <path
                        d="M827.46624,585.78061l-41.94336-4.66016.011-.45849c.14869-6.20948,3.75879-152.2041,13.87452-162.54395,10.17553-10.40137,29.37719-5.90088,30.18969-5.70312l.40479.09765-3.45142,61.77637Z"
                        transform="translate(-166.83465 -147.13004)" fill="#3f3d56" />
                    <path
                        d="M835.19144,498.52321a9.14584,9.14584,0,0,1-11.90719-7.409l-31.89489-6.24893,11.83539-12.04883,28.47343,7.7813a9.19542,9.19542,0,0,1,3.49326,17.92547Z"
                        transform="translate(-166.83465 -147.13004)" fill="#ffb8b8" />
                    <path
                        d="M818.17132,491.20932,807.77874,488.975c-15.34229,4.61425-42.12219-11.62989-52.94593-18.84522-2.03662-1.35742-2.69726-4.04736-1.9635-7.99365a23.30978,23.30978,0,0,1,8.567-13.915l38.11975-30.2251,9.62158-1.60889,2.85791,16.19483L787.74822,458.6683l35.75244,19.46Z"
                        transform="translate(-166.83465 -147.13004)" fill="#3f3d56" />
                    <path
                        d="M814.06094,400.06826v-21a33.5,33.5,0,1,1,67,0v21a4.50508,4.50508,0,0,1-4.5,4.5h-58A4.50507,4.50507,0,0,1,814.06094,400.06826Z"
                        transform="translate(-166.83465 -147.13004)" fill="#2f2e41" />
                    <circle cx="679.37983" cy="232.67051" r="24.56103" fill="#ffb8b8" />
                    <path
                        d="M820.97939,379.706a2.50023,2.50023,0,0,1-.5852-1.99317l2.90942-20.25976a2.50362,2.50362,0,0,1,1.41455-1.91895c14.85034-6.95019,29.90967-6.959,44.76-.02637a2.51921,2.51921,0,0,1,1.42871,2.03614L872.849,377.83a2.49954,2.49954,0,0,1-2.48877,2.73828h-4.92553a2.50966,2.50966,0,0,1-2.26539-1.44238l-2.12573-4.55469a1.49989,1.49989,0,0,0-2.84765.44824l-.41993,3.3584a2.50359,2.50359,0,0,1-2.48071,2.19043H822.8688A2.50013,2.50013,0,0,1,820.97939,379.706Z"
                        transform="translate(-166.83465 -147.13004)" fill="#2f2e41" />
                    <rect y="40.3663" width="551" height="343.11356" fill="#e6e6e6" />
                    <rect x="36.94894" y="106.46612" width="100.91574" height="65.59524" fill="#fff" />
                    <rect x="162.34439" y="106.46612" width="100.91574" height="65.59524" fill="#fff" />
                    <rect x="287.73987" y="106.46612" width="100.91577" height="65.59524" fill="#fff" />
                    <rect x="413.13531" y="106.46612" width="100.91577" height="65.59524" fill="#fff" />
                    <rect x="36.94894" y="199.30861" width="100.91574" height="65.59523" fill="#fff" />
                    <rect x="162.34439" y="199.30861" width="100.91574" height="65.59523" fill="#fff" />
                    <rect x="287.73987" y="199.30861" width="100.91577" height="65.59523" fill="#fff" />
                    <rect x="413.13531" y="199.30861" width="100.91577" height="65.59523" fill="#fff" />
                    <rect x="36.94894" y="292.15109" width="100.91574" height="65.59525" fill="#fff" />
                    <rect x="162.34439" y="292.15109" width="100.91574" height="65.59525" fill="#fff" />
                    <rect x="287.73987" y="292.15109" width="100.91577" height="65.59525" fill="#fff" />
                    <rect x="413.13531" y="292.15109" width="100.91577" height="65.59525" fill="#fff" />
                    <circle cx="144.30951" cy="65.59524" r="15.13736" fill="#fff" />
                    <circle cx="394.58057" cy="65.59524" r="15.13734" fill="#fff" />
                    <rect x="138.25458" width="12.10989" height="69.63187" fill="#e6e6e6" />
                    <rect x="388.52563" width="12.10986" height="69.63187" fill="#e6e6e6" />
                    <path
                        d="M653.24859,286.39377a22.75657,22.75657,0,1,1-3.52686-12.19043A22.7566,22.7566,0,0,1,653.24859,286.39377Z"
                        transform="translate(-166.83465 -147.13004)" fill="#a80011" />
                    <path
                        d="M649.72173,274.20337l-22.46387,22.45975c-1.41186-2.18579-9.27765-12.34394-9.27765-12.34394A31.82748,31.82748,0,0,1,621.2,281.477l6.52259,8.69678,19.36853-19.36856A22.72652,22.72652,0,0,1,649.72173,274.20337Z"
                        transform="translate(-166.83465 -147.13004)" fill="#fff" />
                    <path
                        d="M402.45763,379.23627a22.75655,22.75655,0,1,1-3.52685-12.19043A22.7566,22.7566,0,0,1,402.45763,379.23627Z"
                        transform="translate(-166.83465 -147.13004)" fill="#a80011" />
                    <path
                        d="M398.93078,367.04584l-22.46387,22.45974c-1.41187-2.18579-9.27765-12.34393-9.27765-12.34393a31.82748,31.82748,0,0,1,3.21979-2.84222l6.52258,8.69677,19.36859-19.36856A22.72613,22.72613,0,0,1,398.93078,367.04584Z"
                        transform="translate(-166.83465 -147.13004)" fill="#fff" />
                    <path
                        d="M277.06218,379.23627a22.75667,22.75667,0,1,1-3.52685-12.19043A22.75667,22.75667,0,0,1,277.06218,379.23627Z"
                        transform="translate(-166.83465 -147.13004)" fill="#a80011" />
                    <path
                        d="M273.53533,367.04584l-22.46387,22.45974c-1.41186-2.18579-9.27765-12.34393-9.27765-12.34393a31.82748,31.82748,0,0,1,3.21979-2.84222l6.52258,8.69677,19.3686-19.36856A22.72673,22.72673,0,0,1,273.53533,367.04584Z"
                        transform="translate(-166.83465 -147.13004)" fill="#fff" />
                    <path d="M1032.16535,752.87h-381a1,1,0,0,1,0-2h381a1,1,0,0,1,0,2Z"
                        transform="translate(-166.83465 -147.13004)" fill="#3f3d56" />
                </svg>
                <div
                    style="display: flex; padding-top: 1.5rem; padding-bottom: 1.5rem; flex-direction: column; gap: 1rem;">
                    <span
                        style="width: 75%; font-size: 3.75rem; line-height: 1; font-weight: 700; color: #A80011;">Pamper
                        yourself today!</span>
                    <button class="submit-consultation-button"
                        onclick="window.location.href = './consultation-hair.php'">Submit a Consultation Now!</button>
                </div>
            </div>

            <div class="popular-content-container">
                <div class="popular-services-container">
                    <span style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Popular
                        Services</span>
                    <?php if (isset($popularServices))
                        foreach ($popularServices as $service): ?>
                            <div
                                style="display: flex; padding: 1rem; justify-content: space-between; border-radius: 1rem; background-color: #ffffff;">
                                <div style="display: flex; justify-content: space-between; width: 100%; cursor: pointer;" onclick="window.location.href = './view-service.php?id=<?php echo $service['id']; ?>';">
                                    <div style="display: flex; gap: 1rem; align-items: center; color: #000000;">
                                        <svg width="48" height="48" viewBox="0 0 32 32" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M31.6718 3.20422C22.3451 -0.11135 12.2076 -0.3852 2.71558 2.42202C2.33828 2.5123 1.98304 2.67769 1.67108 2.90831C1.35911 3.13893 1.09682 3.43004 0.89985 3.76427C0.702884 4.09851 0.575287 4.469 0.524677 4.85363C0.474067 5.23827 0.501482 5.62916 0.605285 6.00297C1.1248 8.08787 1.88259 10.4833 2.79272 12.6551C2.80835 12.7059 2.83276 12.6815 2.83276 12.6307C2.70093 11.6122 3.48411 10.3261 5.0202 9.85832C12.4023 7.50895 20.3468 7.61413 27.6641 10.1581C27.934 10.2504 28.2196 10.2878 28.5042 10.2679C28.7887 10.2481 29.0664 10.1715 29.3209 10.0426C29.5754 9.91372 29.8015 9.7352 29.9859 9.51755C30.1702 9.29991 30.3092 9.04754 30.3945 8.77535C31.3046 5.84575 31.6718 3.85654 31.7626 3.35851C31.7782 3.26574 31.6962 3.23059 31.6718 3.2052V3.20422ZM9.16949 9.64935C8.05136 9.88274 6.5055 10.2499 5.34538 10.6347C3.02611 11.4344 3.13353 14.2566 4.36885 15.157C4.45967 14.6336 5.0202 13.9217 5.64518 13.6815C7.96054 12.7713 10.4468 12.2274 12.9604 12.0028C11.6831 11.4843 10.437 10.7411 9.18609 9.64837L9.16949 9.64935ZM27.6328 15.2996C24.3008 13.734 20.6887 12.8523 17.0101 12.7065C13.3315 12.5608 9.66094 13.1539 6.21547 14.451C5.11101 14.8679 4.41963 16.2117 5.11101 17.487C6.31883 19.6707 7.68954 21.7602 9.21148 23.7378C8.99274 22.98 9.37945 21.5767 10.8638 21.1178C14.9691 19.8561 19.2766 20.3912 22.1398 21.5504C22.9484 21.8756 24.0929 21.6783 24.7345 20.7174C25.8286 19.0319 26.8237 17.2842 27.7148 15.4832C27.7549 15.4021 27.7149 15.3416 27.6328 15.2996ZM20.9807 25.4165C19.7797 24.81 18.6814 24.0189 17.7259 23.0718C17.2835 22.6294 16.6322 21.9937 15.9457 21.2359C14.3783 21.2359 12.8569 21.3931 11.23 21.9127C9.71928 22.3853 9.57768 24.1304 10.2388 25.0405C11.3569 26.434 12.1411 27.1859 13.392 28.4789C14.055 29.1291 14.9452 29.4954 15.8738 29.5C16.8024 29.5045 17.6962 29.147 18.3655 28.5033C19.342 27.5268 19.9426 26.8754 21.0461 25.6245C21.1115 25.5581 21.0861 25.4419 20.9797 25.4165H20.9807Z"
                                                fill="currentColor" />
                                        </svg>
                                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                            <span style="font-weight: 500;"><?php echo $service['name']; ?></span>
                                            <span
                                                style="font-size: 0.875rem; line-height: 1.25rem;"><?php echo strlen($service['description'] > 70) ? substr($service['description'], 0, 70) . "..." : $service['description']; ?></span>
                                        </div>
                                    </div>
                                    <span style="color: #49454F;">  <?php echo $service['price']; ?></span>
                                </div>
                            </div>
                        <?php endforeach; else
                        null; ?>
                </div>
                <div class="appointments-content-container">
                    <div style="display: flex; flex-direction:column; gap: 1rem; width: 100%;">
                        <div style="height: 100%; width: 100%; display: flex; flex-direction: column; gap: 1rem;">
                            <span
                                style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Appointments</span>
                            <table style="width: 100%; background: #A80011;">
                                <thead style="color: white;">
                                    <tr>
                                        <th style="padding: 0.5rem 0rem; font-weight: 400;">Staff</th>
                                        <th style="font-weight: 400;">Service</th>
                                        <th style="font-weight: 400;">Date</th>
                                        <th style="font-weight: 400;">Time</th>
                                        <th style="font-weight: 400;">Status</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: white; text-align: center;">
                                    <?php
                                    if (isset($appointments)) {
                                        foreach ($appointments as $appointment):
                                            $dateTime = new DateTime($appointment['schedule']);
                                            $date = $dateTime->format('Y-m-d');
                                            $time = $dateTime->format('H:i A');

                                            $color = 'background-color: rgb(115 115 115);';

                                            switch ($appointment['status']) {
                                                case 'pending':
                                                    $color = 'background-color: rgb(115 115 115);';
                                                    break;
                                                case 'confirmed':
                                                    $color = 'background-color: rgb(14 165 233);';
                                                    break;
                                                case 'completed':
                                                    $color = 'background-color: rgb(34 197 94);';
                                                    break;
                                                case 'rescheduled':
                                                    $color = 'background-color: rgb(234 179 8);';
                                                    break;
                                                case 'cancelled':
                                                case 'noshow':
                                                    $color = 'background-color: rgb(239 68 68);';
                                                    break;
                                                default:
                                                    $color = 'background-color: rgb(115 115 115);';
                                                    break;
                                            }

                                            ?>
                                            <tr onclick="window.location.href = 'view-appointment.php?id=<?php echo $appointment['appointment_id']; ?>';" class="appointment-row">
                                                <td
                                                    style="display: flex; justify-content: center; padding: 0.5rem 0;">
                                                    <!-- <?php echo $appointment['stylist']; ?> -->
                                                    <img src="./uploads/<?php echo $appointment['stylist_img']; ?>" alt="staff"
                                                        style="width: 2rem; height: 2rem; border-radius: 9999px;">
                                                </td>
                                                <td><?php echo $appointment['service']; ?></td>
                                                <td><?php echo $date; ?></td>
                                                <td><?php echo $time; ?></td>
                                                <td style="padding-left: 1rem; padding-right: 1rem; width: 9rem; ">
                                                    <div
                                                        style="<?php echo $color; ?> border-radius: 9999px; color: white; padding-top: 0.25rem; padding-bottom: 0.25rem;">
                                                        <?php echo $appointment['status'] == "noshow" ? "No show" : ucfirst($appointment['status']); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    } else
                                        null; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="h-1/2 w-full">
                            <span class="text-[#A80011] dark:text-white text-2xl font-medium">Consultations</span>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>