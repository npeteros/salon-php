<?php
include './src/api/functions.php';

$appointments = getCompletedAppointments();

$daily = getSalesByPeriod($appointments, 'daily');

echo 'DAILY:<pre>';
print_r($daily);
echo '</pre>';

$weekly = getSalesByPeriod($appointments, 'weekly');

echo 'WEEKLY:<pre>';
print_r($weekly);
echo '</pre>';

$monthly = getSalesByPeriod($appointments, 'monthly');

echo 'MONTHLY:<pre>';
print_r($monthly);
echo '</pre>';

$yearly = getSalesByPeriod($appointments, 'yearly');

echo 'YEARLY:<pre>';
print_r($yearly);
echo '</pre>';