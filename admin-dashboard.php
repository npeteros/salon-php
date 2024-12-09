<?php
define('FILE_CSS', 'src/styles/admin-dashboard.css');
include 'src/includes/header.php';
if (!isset($_SESSION['user']))
    header('Location: ./login.php');
if ($_SESSION['user']['role'] !== 'owner' && $_SESSION['user']['role'] !== 'manager')
    header('Location: ./index.php');
include 'src/api/functions.php';

$popularServices = getPopularServices() ? array_slice(getPopularServices(), 0, 3) : null;
$appointments = getCompletedAppointments() ?? [];

$recordedDays = 7;
$recordedWeeks = 4;
$recordedMonths = 12;
$recordedYears = 3;

$dailySales = getDailySalesFromDates(getLastXDays($recordedDays), $appointments);
$weeklySales = getWeeklySalesFromDates(getLastXWeeks($recordedWeeks), $appointments);
$monthlySales = getMonthlySalesFromDates(getLastXMonths($recordedMonths), $appointments);
$yearlySales = getYearlySalesFromDates(getLastXYears($recordedYears), $appointments);
$serviceSales = getServiceSales($appointments);

$dailyServiceSales = array_slice(getSalesByPeriod($appointments, 'daily'), 0, 7);
$weeklyServiceSales = array_slice(getSalesByPeriod($appointments, 'weekly'), 0, 7);
$monthlyServiceSales = array_slice(getSalesByPeriod($appointments, 'monthly'), 0, 7);
$yearlyServiceSales = array_slice(getSalesByPeriod($appointments, 'yearly'), 0, 7);
?>

<div style="height: fit-content; min-height: 100lvh; background: #D9D9D9;">
    <?php include './src/includes/dash_nav.php'; ?>
    <div class="dashboard-container">
        <?php include 'src/includes/admin_side_nav.php'; ?>

        <div class="main-content-container">
            <div style="display: flex; flex-direction: column; gap: 1rem">
                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem;">
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span
                                style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">General
                                Sales
                                Report</span>
                            <div class="filter-container">
                                <label for="filter">Filter by:</label>
                                <select id="filter" onchange="filterTable()">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                    <option value="service">Service</option>
                                </select>
                            </div>
                        </div>

                        <table class="sales-table">
                            <thead>
                                <tr>
                                    <th>Date Range</th>
                                    <th>Sales (PHP)</th>
                                    <th>Appointments</th>
                                </tr>
                            </thead>
                            <tbody id="salesTable">
                                <?php
                                foreach ($dailySales as $sale) {
                                    echo '<tr class="daily">
                                    <td>' . $sale['date'] . '</td>
                                    <td>&#x20B1; ' . number_format($sale['total_sales']) . '</td>
                                    <td>' . $sale['total_appointments'] . '</td>
                                </tr>';
                                }
                                foreach ($weeklySales as $sale) {
                                    echo '<tr class="weekly">
                                    <td>' . $sale['week'] . '</td>
                                    <td>&#x20B1; ' . $sale['total_sales'] . '</td>
                                    <td>' . $sale['total_appointments'] . '</td>
                                </tr>';
                                }
                                foreach ($monthlySales as $sale) {
                                    echo '<tr class="monthly">
                                    <td>' . $sale['month'] . '</td>
                                    <td>&#x20B1; ' . $sale['total_sales'] . '</td>
                                    <td>' . $sale['total_appointments'] . '</td>
                                </tr>';
                                }
                                foreach ($yearlySales as $sale) {
                                    echo '<tr class="yearly">
                                    <td>' . $sale['year'] . '</td>
                                    <td>&#x20B1; ' . $sale['total_sales'] . '</td>
                                    <td>' . $sale['total_appointments'] . '</td>
                                </tr>';
                                }
                                foreach ($serviceSales as $service => $sales) {
                                    echo '<tr class="service">
                                    <td>' . $sales['service'] . '</td>
                                    <td>&#x20B1; ' . $sales['total_sales'] . '</td>
                                    <td>' . $sales['total_appointments'] . '</td>
                                </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span
                                style="font-size: 1.5rem; line-height: 2rem; font-weight: 500; color: #A80011;">Service
                                Sales Report</span>
                            <div class="filter-container">
                                <label for="filter">Filter by:</label>
                                <select id="serviceFilter" onchange="filterServiceSalesTable()">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>

                        <table class="sales-table">
                            <thead>
                                <tr>
                                    <th>Date Range</th>
                                    <th>Service</th>
                                    <th>Sales (PHP)</th>
                                    <th>Appointments</th>
                                </tr>
                            </thead>
                            <tbody id="serviceSalesTable">
                                <?php
                                foreach ($dailyServiceSales as $date => $services) {
                                    foreach ($services as $service) {
                                        echo '<tr class="daily">
                                            <td>' . $service['date_range'] . '</td>
                                            <td>' . $service['service'] . '</td>
                                            <td>&#x20B1; ' . number_format($service['total_sales']) . '</td>
                                            <td>' . $service['total_appointments'] . '</td>
                                        </tr>';
                                    }
                                }
                                foreach ($weeklyServiceSales as $date => $services) {
                                    foreach ($services as $service) {
                                        echo '<tr class="weekly">
                                            <td>' . $service['date_range'] . '</td>
                                            <td>' . $service['service'] . '</td>
                                            <td>&#x20B1; ' . number_format($service['total_sales']) . '</td>
                                            <td>' . $service['total_appointments'] . '</td>
                                        </tr>';
                                    }
                                }
                                foreach ($monthlyServiceSales as $date => $services) {
                                    foreach ($services as $service) {
                                        echo '<tr class="monthly">
                                            <td>' . $service['date_range'] . '</td>
                                            <td>' . $service['service'] . '</td>
                                            <td>&#x20B1; ' . number_format($service['total_sales']) . '</td>
                                            <td>' . $service['total_appointments'] . '</td>
                                        </tr>';
                                    }
                                }
                                foreach ($yearlyServiceSales as $date => $services) {
                                    foreach ($services as $service) {
                                        echo '<tr class="yearly">
                                            <td>' . $service['date_range'] . '</td>
                                            <td>' . $service['service'] . '</td>
                                            <td>&#x20B1; ' . number_format($service['total_sales']) . '</td>
                                            <td>' . $service['total_appointments'] . '</td>
                                        </tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="services-users-container">
                    <div class="popular-services-container" style="grid-column: span 5 / span 5;">
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
                                        <div style="display: flex; flex-direction: column; align-items: flex-end;">
                                            <span style="color: #49454F;"> <?php echo $service['price']; ?></span>
                                            <span style="opacity: 50%;">Used in <?php echo $service['appointment_count'] ?>
                                                appointment<?php echo $service['appointment_count'] <= 1 ? '' : 's' ?></span>
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

<script>
    function filterTable() {
        const filter = document.getElementById('filter').value;
        const rows = document.querySelectorAll('#salesTable tr');

        rows.forEach(row => {
            if (row.classList.contains(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function filterServiceSalesTable() {
        const filter = document.getElementById('serviceFilter').value;
        const rows = document.querySelectorAll('#serviceSalesTable tr');

        rows.forEach(row => {
            if (row.classList.contains(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById("filter").value = "daily";
    document.getElementById("serviceFilter").value = "daily";

    filterTable();
    filterServiceSalesTable();
</script>

<?php include 'src/includes/footer.php'; ?>