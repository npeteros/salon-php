<?php
define('FILE_CSS', 'src/styles/admin-dashboard.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');
include 'src/api/functions.php';

$popularServices = getPopularServices() ? array_slice(getPopularServices(), 0, 3) : null;
$appointments = getAllAppointments() ? array_slice(getAllAppointments(), 0, 8) : null;
$users = getAllUsers() ? array_slice(getAllUsers(), 0, 3) : null;
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="dashboard-container">
        <?php include 'src/includes/admin_side_nav.php'; ?>

        <div class="main-content-container">
            <div style="display: flex; flex-direction: column; gap: 1rem">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <span
                        style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Appointments</span>
                    <table style="width: 100%; background: #A80011;">
                        <thead style="color: white;">
                            <tr>
                                <th style="padding: 0.5rem 0rem; font-weight: 400;">Staff</th>
                                <th style="font-weight: 400;">Customer</th>
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
                                    <tr onclick="window.location.href = 'admin-view-appointment.php?id=<?php echo $appointment['appointment_id']; ?>';"
                                        class="appointment-row">
                                        <td style="display: flex; justify-content: center; padding: 0.5rem 0;">
                                            <?php echo $appointment['stylist']; ?>
                                        </td>
                                        <td><?php echo $appointment['customer']; ?></td>
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
                <div class="services-users-container">
                    <div class="popular-services-container" style="grid-column: span 2 / span 2;">
                        <span style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Popular
                            Services</span>
                        <?php if (isset($popularServices))
                            foreach ($popularServices as $service): ?>
                                <div
                                    style="display: flex; padding: 1rem; justify-content: space-between; border-radius: 1rem; background-color: #ffffff;">
                                    <div style="display: flex; justify-content: space-between; width: 100%; ">
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
                                        <span style="color: #49454F;"> <?php echo $service['price']; ?></span>
                                    </div>
                                </div>
                            <?php endforeach; else
                            null; ?>
                    </div>
                    <div class="popular-services-container" style="grid-column: span 3 / span 3;">
                        <span
                            style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Users</span>
                        <?php if (isset($users))
                            foreach ($users as $user): ?>
                                <div style="background-color: white; display: flex; flex-direction: column; padding: 1rem; border-radius: 0.875rem; cursor: pointer;"
                                    onclick="window.location.href = './view-user.php?id=<?php echo $user['id']; ?>';">
                                    <div style="display: flex; justify-content: space-between;">
                                        <div style="display: flex; gap: 1rem; width: 3rem; height: 3rem;">
                                            <img src="./uploads/<?php echo $user['img_path']; ?>" alt="user"
                                                style="width: 100%; border-radius: 9999px;">
                                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                                <span><?php echo $user['name']; ?></span>
                                                <span style="opacity: 50%;"><?php echo $user['email']; ?></span>
                                            </div>
                                        </div>
                                        <div style="display: flex; align-items: center;"><?php echo ucfirst($user['role']); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; else
                            null; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'src/includes/footer.php'; ?>