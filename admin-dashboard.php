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
                                            <img src="./uploads/services/<?php echo $service['img_path']; ?>" alt="Image"
                                                style="width: 3rem; height: 3rem; border-radius: 9999px;">
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