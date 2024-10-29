<?php
if (($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST['date']) || !isset($_POST['time']) || !isset($_POST['service'])))
    header("Location: ./reserve-service.php");
define('FILE_CSS', 'src/styles/reserve-appointment.css');
include './src/includes/header.php';
include './src/api/functions.php';
$stylists = getAllStylists();
// $stylists = getStylistsBySpecialties($_POST['service']);
?>

<div style="min-height: 100lvh; background: #D9D9D9">
    <?php include './src/includes/dash_nav.php'; ?>
    <div style="display: flex; height: 100%; gap: 1rem;">
        <?php include './src/includes/side_nav.php'; ?>

        <div style="width: 100%; margin: 1.5rem;">
            <div
                style="display: flex; padding: 1rem; flex-direction: column; gap: 1rem; border-radius: 1rem; width: 100%; background-color: #ffffff;">
                <ol>
                    <li class="next">
                        <span class="progress inactive">
                            1
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Schedule</h3>
                        </span>
                    </li>
                    <li class="next">
                        <span class="progress inactive">
                            2
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Service</h3>
                        </span>
                    </li>
                    <li class="next active">
                        <span class="progress active">
                            3
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Stylist</h3>
                        </span>
                    </li>
                    <li class="">
                        <span class="progress inactive">
                            4
                        </span>
                        <span>
                            <h3 style="font-weight: 500; line-height: 1.25;">Confirm</h3>
                        </span>
                    </li>
                </ol>

                <div
                    style="display: flex; padding-left: 1rem; padding-right: 1rem; flex-direction: column; border-radius: 1rem;">
                    <form method="post" action='reserve-confirm.php'
                        style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label for="name" style="font-weight: 700;">Confirm Stylist</label>
                            <select name="stylist" id="stylist"
                                style="padding: 0.5rem 1rem; border-radius: 0.5rem; border-width: 1px;" required>
                                <?php
                                foreach ($stylists as $stylist) {
                                    echo '<option value="' . $stylist['stylist_id'] . '" ' . ($stylist['stylist_id'] == $_POST['stylist'] ? 'selected' : '') . '>' . $stylist['stylist_name'] . '</option>';
                                }
                                ?>
                            </select>
                            <input type="hidden" name="date" id="date" value="<?php echo $_POST['date'] ?>" />
                            <input type="hidden" name="time" id="time" value="<?php echo $_POST['time'] ?>" />
                            <input type="hidden" name="service" id="service" value="<?php echo $_POST['service'] ?>"">
                        </div>
                        <button class=" next-button" type="submit">Next</button>
                    </form>
                    <form method="post" action="./reserve-service.php">
                        <input type="hidden" name="date" id="date" value="<?php echo $_POST['date'] ?>" />
                        <input type="hidden" name="time" id="time" value="<?php echo $_POST['time'] ?>" />
                        <input type="hidden" name="service" id="service" value="<?php echo $_POST['service'] ?>"">
                        <button class=" cancel-button" style="width: 100%;" type="submit">Back</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './src/includes/footer.php'; ?>