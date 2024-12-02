<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "salon";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(`Connection failed: {$conn->connect_error}`);
}

function printJsonData($code, $data): void
{
    print_r(json_encode(["code" => $code, "data" => $data]));
}

function formatTime($minutes): string
{
    if ($minutes < 60) {
        return $minutes . " minute" . ($minutes == 1 ? "" : "s");
    } else {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        $hourString = $hours . " hour" . ($hours == 1 ? "" : "s");
        $minuteString = $remainingMinutes > 0 ? " and " . $remainingMinutes . " minute" . ($remainingMinutes == 1 ? "" : "s") : "";

        return $hourString . $minuteString;
    }
}

function printStars($rating)
{
    $fullStar =
        '<svg width="16" height="16" fill="yellow" stroke="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27Z"></path>
        </svg>';

    $halfStar =
        '<svg width="16" height="16" fill="yellow" stroke="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="m14.81 8.62 7.19.62-5.45 4.73L18.18 21 12 17.27 5.82 21l1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.62ZM12 6.1v9.3l3.77 2.28-1-4.28 3.32-2.88-4.38-.38L12 6.1Z" clip-rule="evenodd"></path>
        </svg>';    // Half star

    $emptyStar =
        '<svg width="16" height="16" fill="yellow" stroke="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="m22 9.74-7.19-.62L12 2.5 9.19 9.13 2 9.74l5.46 4.73-1.64 7.03L12 17.77l6.18 3.73-1.63-7.03L22 9.74ZM12 15.9l-3.76 2.27 1-4.28-3.32-2.88 4.38-.38L12 6.6l1.71 4.04 4.38.38-3.32 2.88 1 4.28L12 15.9Z"></path>
        </svg>';   // Empty star

    $fullStars = floor($rating);
    $halfStars = ($rating - $fullStars >= 0.5) ? 1 : 0;
    $emptyStars = 5 - ($fullStars + $halfStars);

    for ($i = 0; $i < $fullStars; $i++) {
        echo $fullStar;
    }

    if ($halfStars) {
        echo $halfStar;
    }

    for ($i = 0; $i < $emptyStars; $i++) {
        echo $emptyStar;
    }
}

/* CONSULTATION APIs */

function getConsultationByCustomer(int $customerId)
{
    global $conn;
    $consultation = null;
    $query = "SELECT 
                c.id,
                c.type,
                c.texture,
                c.hair,
                ct.treatment_id,
                ct.status
            FROM consultations c
            INNER JOIN client_treatments ct ON ct.consultation_id = c.id
            WHERE customer_id = {$customerId} AND c.removed = 0";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) > 0) {
            while ($row = mysqli_fetch_assoc($r)) {
                $consultation = $row;
            }
        }
        return $consultation;
    }
}

function createConsultation(int $customerId, string $type, string $texture, string $hair, string $perming, string $relax, string $rebonding, string $bleaching): int
{
    global $conn;

    $query = "SELECT customer_id from consultations WHERE customer_id = {$customerId} AND removed = 0";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) > 0) {
            return -2;
        }
    }

    $columns = 'customer_id, type, texture, hair';
    $values = $customerId . ', "' . $type . '", "' . $texture . '", "' . $hair . '"';

    if (strlen($perming) > 0) {
        $columns .= ', perming';
        $values .= ', "' . $perming . '"';
    }
    if (strlen($relax) > 0) {
        $columns .= ', relax';
        $values .= ', "' . $relax . '"';
    }
    if (strlen($rebonding) > 0) {
        $columns .= ', rebonding';
        $values .= ', "' . $rebonding . '"';
    }
    if (strlen($bleaching) > 0) {
        $columns .= ', bleaching';
        $values .= ', "' . $bleaching . '"';
    }

    $query = 'INSERT INTO consultations (' . $columns . ') VALUES (' . $values . ')';
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function deleteConsultation(int $id)
{
    global $conn;
    $query = "UPDATE consultations SET removed = 1 WHERE id = {$id}";
    // $query = "DELETE FROM consultations WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        return 1;
    }
    return -1;
}

/* APPOINTMENT APIs */
function getAllAppointments(): array|null
{
    global $conn;
    $appointments = null;
    $query =
        "SELECT 
            a.id as appointment_id,
            c.name as customer,
            u.name as stylist, 
            s.name as service, 
            a.status as status,
            a.scheduled_date as schedule
        FROM 
            appointments a 
        JOIN 
            services s ON s.id = a.service_id 
        JOIN 
            users u ON u.id = a.stylist_id
        JOIN
            users c ON c.id = a.customer_id
        ORDER BY
            a.scheduled_date DESC;";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $appointments[] = $row;
        }
    }
    return $appointments;
}

function getAppointmentById(int $id): array|null
{
    global $conn;
    $appointment = null;
    $query =
        "SELECT 
        u.id AS customer_id,
        u.img_path AS customer_image,
        u.name AS customer_name,
        u.email AS customer_email,
        st.id AS stylist_id,
        st.img_path AS stylist_image,
        st.name AS stylist_name,
        st.email AS stylist_email,
        s.name AS service_name,
        s.price AS service_price,
        s.duration AS service_duration,
        a.id AS appointment_id,
        a.status AS appointment_status,
        a.scheduled_date AS appointment_date
    FROM appointments a
    JOIN users u ON a.customer_id = u.id
    JOIN users st ON a.stylist_id = st.id
    JOIN services s ON a.service_id = s.id
    WHERE a.id = {$id};";
    if ($r = mysqli_query($conn, $query)) {
        $appointment = mysqli_fetch_assoc($r);
    }
    return $appointment;
}

function getAppointmentsByScheduledDate(string $scheduledDate): array|null
{
    global $conn;
    $appointments = null;
    $query = "SELECT * FROM appointments WHERE scheduled_date = '{$scheduledDate}'";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $appointments[] = $row;
        }
    }
    return $appointments;
}

function getAppointmentsBySearch(string $search): array|null
{
    global $conn;
    $appointments = null;
    $query =
        "SELECT 
            a.id as appointment_id,
            u.name as stylist, 
            c.name as customer,
            s.name as service, 
            a.status as status,
            a.scheduled_date as schedule
        FROM 
            appointments a 
        JOIN 
            services s ON s.id = a.service_id 
        JOIN 
            users u ON u.id = a.stylist_id
        JOIN
            users c ON c.id = a.customer_id
        WHERE (s.name LIKE '%{$search}%'
            OR a.status LIKE '%{$search}%'
            OR a.scheduled_date LIKE '%{$search}%'
            OR u.name LIKE '%{$search}%'
            OR c.name LIKE '%{$search}%');";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $appointments[] = $row;
        }
    }
    return $appointments;
}

function getAppointmentsByCustomerAndSearch(int $customerId, string $search): array|null
{
    global $conn;
    $appointments = null;
    $query =
        "SELECT 
            a.id as appointment_id,
            u.name as stylist, 
            u.img_path as stylist_img,
            s.name as service, 
            a.status as status,
            a.scheduled_date as schedule
        FROM 
            appointments a 
        JOIN 
            services s ON s.id = a.service_id 
        JOIN 
            users u ON u.id = a.stylist_id
        WHERE (customer_id = {$customerId})
            AND
            (s.name LIKE '%{$search}%'
            OR a.status LIKE '%{$search}%'
            OR a.scheduled_date LIKE '%{$search}%'
            OR u.name LIKE '%{$search}%'
            OR s.name LIKE '%{$search}%');";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $appointments[] = $row;
        }
    }
    return $appointments;
}

function getPendingAppointment(int $customerId): array|null
{
    global $conn;
    $appointments = null;
    $query =
        "SELECT *
        FROM appointments
        WHERE (customer_id = {$customerId})
            AND
            (status = 'pending' OR status = 'confirmed')";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $appointments[] = $row;
        }
    }
    return $appointments;
}

function getAppointmentsByCustomer(int $customerId): array|null
{
    global $conn;
    $appointments = null;
    $query =
        "SELECT 
            a.id as appointment_id,
            u.name as stylist, 
            u.img_path as stylist_img,
            s.name as service, 
            a.status as status,
            a.scheduled_date as schedule
        FROM 
            appointments a 
        JOIN 
            services s ON s.id = a.service_id 
        JOIN 
            users u ON u.id = a.stylist_id
        WHERE customer_id = {$customerId};";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $appointments[] = $row;
        }
    }
    return $appointments;
}

function getAppointmentsByStylist(int $stylistId): array|null
{
    global $conn;
    $appointments = null;
    $query = "SELECT * FROM appointments WHERE stylist_id = {$stylistId}";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $appointments[] = $row;
        }
    }
    return $appointments;
}

function getAppointmentsByStatus(string $status): array|null
{
    global $conn;
    $appointments = null;
    $query = "SELECT * FROM appointments WHERE status = '{$status}'";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $appointments[] = $row;
        }
    }
    return $appointments;
}

function createAppointment(int $customerId, int $stylistId, int $serviceId, string $status = 'pending', string $scheduledDate): int
{
    global $conn;
    $query = "INSERT INTO appointments (customer_id, stylist_id, service_id, status, scheduled_date) VALUES ({$customerId}, {$stylistId}, {$serviceId}, '{$status}', '{$scheduledDate}')";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function updateAppointment(int $id, int $customerId, int $stylistId, string $status, string $scheduledDate): int
{
    global $conn;
    $query = "UPDATE appointments SET customer_id = {$customerId}, stylist_id = {$stylistId}, status = '{$status}', scheduled_date = '{$scheduledDate}', updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function cancelAppointment(int $id): int
{
    global $conn;
    $query = "UPDATE appointments SET status = 'cancelled' WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        $rows = mysqli_affected_rows($conn);
        return $rows;
    }
    return -1;
}

function deleteAppointment(int $id): int
{
    global $conn;
    $query = "DELETE FROM appointments WHERE id = {$id}";
    mysqli_query($conn, $query);
    if (mysqli_affected_rows($conn) > 0) {
        return 1;
    }
    return -1;
}

/* APPOINTMENT SERVICES APIs */

function getAllAppointmentServices(): array|null
{
    global $conn;
    $services = null;
    $query = 'SELECT * FROM appointment_services';
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $services[] = $row;
        }
    }
    return $services;
}

function getAppointmentServiceById(int $id): array|null
{
    global $conn;
    $service = null;
    $query = "SELECT * FROM appointment_services WHERE id = {$id}";
    if ($r = mysqli_query($conn, $query)) {
        $service = mysqli_fetch_assoc($r);
    }
    return $service;
}

function getAppointmentServicesByAppointmentId(int $appointmentId): array|null
{
    global $conn;
    $services = null;
    $query = "SELECT * FROM appointment_services WHERE appointment_id = {$appointmentId}";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $services[] = $row;
        }
    }
    return $services;
}

function getAppointmentServicesByServiceId(int $serviceId): array|null
{
    global $conn;
    $services = null;
    $query = "SELECT * FROM appointment_services WHERE service_id = {$serviceId}";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $services[] = $row;
        }
    }
    return $services;
}

function createAppointmentService(int $appointmentId, int $serviceId): int
{
    global $conn;
    $query = "INSERT INTO appointment_services (appointment_id, service_id) VALUES ({$appointmentId}, {$serviceId})";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function updateAppointmentService(int $id, int $appointmentId, int $serviceId): int
{
    global $conn;
    $query = "UPDATE appointment_services SET appointment_id = {$appointmentId}, service_id = {$serviceId}, updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function deleteAppointmentService(int $id): int
{
    global $conn;
    $query = "DELETE FROM appointment_services WHERE id = {$id}";
    mysqli_query($conn, $query);
    if (mysqli_affected_rows($conn) > 0) {
        return 1;
    }
    return -1;
}

/* REVIEW APIs */

function getAllReviews(): array|null
{
    global $conn;
    $reviews = null;
    $query = 'SELECT * FROM reviews';
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $reviews[] = $row;
        }
    }
    return $reviews;
}

function getReviewsByStylistId(int $stylistId): array|null
{
    global $conn;
    $reviews = null;
    $query =
        "SELECT 
            u.name AS customer_name,
            u.email AS customer_email,
            u.img_path AS customer_image,
            r.rating,
            r.review,
            r.created_at,
            a.id AS appointment_id
        FROM reviews r
        JOIN appointments a ON r.appointment_id = a.id
        JOIN users u ON r.customer_id = u.id
        WHERE a.stylist_id = {$stylistId}";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $reviews[] = $row;
        }
    }
    return $reviews;
}

function getReviewById(int $id): array|null
{
    global $conn;
    $review = null;
    $query = "SELECT * FROM reviews WHERE id = {$id}";
    if ($r = mysqli_query($conn, $query)) {
        $review = mysqli_fetch_assoc($r);
    }
    return $review;
}

function getReviewsByCustomerId(int $customerId): array|null
{
    global $conn;
    $reviews = null;
    $query = "SELECT * FROM reviews WHERE customer_id = {$customerId}";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $reviews[] = $row;
        }
    }
    return $reviews;
}

function getReviewsByAppointmentId(int $appointmentId): array|null
{
    global $conn;
    $reviews = null;
    $query = "SELECT * FROM reviews WHERE appointment_id = {$appointmentId}";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $reviews[] = $row;
        }
    }
    return $reviews;
}

function getReviewsByReview(string $review): array|null
{
    global $conn;
    $reviews = null;
    $query = "SELECT * FROM reviews WHERE review = '{$review}'";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $reviews[] = $row;
        }
    }
    return $reviews;
}

function createReview(int $customerId, int $appointmentId, int $rating, string $review): int
{
    global $conn;
    $query = "INSERT INTO reviews (customer_id, appointment_id, rating, review) VALUES ({$customerId}, {$appointmentId}, {$rating}, '{$review}')";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function updateReview(int $id, int $customerId, int $appointmentId, string $rating, string $review): int
{
    global $conn;
    $query = "UPDATE reviews SET customer_id = {$customerId}, appointment_id = {$appointmentId}, rating = '{$rating}', review = '{$review}', updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function deleteReview(int $id): int
{
    global $conn;
    $query = "DELETE FROM reviews WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            return 1;
        }
    }
    return -1;
}

/* SERVICE APIs */

function getAllServices(): array|null
{
    global $conn;
    $services = null;
    $query = 'SELECT * FROM services';
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $services[] = $row;
        }
    }
    return $services;
}

function getServiceById(int $id): array|null
{
    global $conn;
    $services = null;
    $query = "SELECT * FROM services WHERE id = {$id}";
    if ($r = mysqli_query($conn, $query)) {
        $services = mysqli_fetch_assoc($r);
    }
    return $services;
}

function getServicesByName(string $name): array|null
{
    global $conn;
    $services = null;
    $query = "SELECT * FROM services WHERE name = '{$name}'";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $services[] = $row;
        }
    }
    return $services;
}

function getPopularServicesBySearch(string $search): array|null
{
    global $conn;
    $services = null;
    $query =
        "SELECT
            s.id as id,
            s.name as name,
            s.description as description,
            s.price as price,
            s.img_path as img_path,
            s.chemical as chemical,
            COUNT(a.id) as appointment_count
        FROM
            services s
        LEFT JOIN
            appointments a ON s.id = a.service_id
        WHERE
            s.name LIKE '%{$search}%'
            OR s.price LIKE '%{$search}%'
            OR s.description LIKE '%{$search}%'
        GROUP BY
            s.id, s.name, s.price
        ORDER BY
            appointment_count DESC";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $services[] = $row;
        }
    }
    return $services;
}

function getPopularServices(): array|null
{
    global $conn;
    $services = null;
    $query =
        "SELECT
            s.id as id,
            s.name as name,
            s.description as description,
            s.price as price,
            s.img_path as img_path,
            s.chemical as chemical,
            COUNT(a.id) as appointment_count
        FROM
            services s
        LEFT JOIN
            appointments a ON s.id = a.service_id
        GROUP BY
            s.id, s.name
        ORDER BY
            appointment_count DESC";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $services[] = $row;
        }
    }
    return $services;
}

function getPopularServiceById(int $id): array|null
{
    global $conn;
    $services = null;
    $query =
        "SELECT
            s.id as id,
            s.name as name,
            s.description as description,
            s.price as price,
            s.duration as duration,
            s.followup_duration as followup_duration,
            s.img_path as img_path,
            s.chemical as chemical,
            COUNT(a.id) as appointment_count
        FROM
            services s
        LEFT JOIN
            appointments a ON s.id = a.service_id
        WHERE
            s.id = {$id}
        GROUP BY
            s.id, s.name
        ORDER BY
            appointment_count DESC";

    if ($r = mysqli_query($conn, $query)) {
        $services = mysqli_fetch_assoc($r);
    }
    return $services;
}

function createServiceWithPicture(string $name, float $price, int $duration, int $followup_duration, string $description, array $image, int $chemical): int
{
    global $conn;
    $query = "INSERT INTO services (name, price, description, duration, followup_duration, chemical) VALUES ('{$name}', {$price}, '{$description}', {$duration}, {$followup_duration}, {$chemical})";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        if ($image['error'] === UPLOAD_ERR_OK) {

            $fileTmpPath = $image['tmp_name'];
            $fileName = $image['name'];
            $uploadDir = '../../uploads/services/';

            // Ensure the upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $destPath = $uploadDir . $fileName;

            // Move the file to the specified directory
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $query = "UPDATE services SET img_path = '{$fileName}', updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
                if (mysqli_query($conn, $query)) {
                    return $id;
                }
            } else
                return -1;
        }
    }
    return -1;
}

function createService(string $name, float $price, int $duration, int $followup_duration, string $description, int $chemical): int
{
    global $conn;
    $query = "INSERT INTO services (name, price, description, duration, followup_duration, chemical) VALUES ('{$name}', {$price}, '{$description}', {$duration}, {$followup_duration}, {$chemical})";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function updateService(int $id, string $name, float $price, int $duration, int $followup_duration, string $description): int
{
    global $conn;
    $query = "UPDATE services SET name = '{$name}', price = {$price}, description = '{$description}', duration = {$duration}, followup_duration = {$followup_duration}, updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function deleteService(int $id): int
{
    global $conn;
    $query = "DELETE FROM services WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            return 1;
        }
    }
    return -1;
}

/* STYLIST SPECIALTIES APIs */

function getAllStylistSpecialties(): array|null
{
    global $conn;
    $specialties = null;
    $query = 'SELECT * FROM stylist_specialties';
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $specialties[] = $row;
        }
    }
    return $specialties;
}

function getStylistSpecialtiesByStylistId(int $stylistId): array|null
{
    global $conn;
    $specialties = null;
    $query = "SELECT 
                    ss.id AS specailty_id,
                    ss.stylist_id AS stylist_id,
                    ss.service_id AS service_id,
                    s.name AS service_name
                FROM stylist_specialties ss
                JOIN services s ON ss.service_id = s.id
                WHERE ss.stylist_id = {$stylistId};";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $specialties[] = $row;
        }
    }
    return $specialties;
}

function getStylistSpecialtiesByServiceId(int $serviceId): array|null
{
    global $conn;
    $specialties = null;
    $query = "SELECT * FROM stylist_specialties WHERE service_id = {$serviceId}";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $specialties[] = $row;
        }
    }
    return $specialties;
}

function getStylistSpecialtiesById(int $id): array|null
{
    global $conn;
    $specialty = null;
    $query = "SELECT * FROM stylist_specialties WHERE id = {$id}";
    if ($r = mysqli_query($conn, $query)) {
        $specialty = mysqli_fetch_assoc($r);
    }
    return $specialty;
}

function createStylistSpecialty(int $stylistId, int $serviceId): int
{
    global $conn;
    $query = "INSERT INTO stylist_specialties (stylist_id, service_id) VALUES ({$stylistId}, {$serviceId})";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function updateStylistSpecialty(int $id, int $stylistId, int $serviceId): int
{
    global $conn;
    $query = "UPDATE stylist_specialties SET stylist_id = {$stylistId}, service_id = {$serviceId}, updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function deleteStylistSpecialty(int $id): int
{
    global $conn;
    $query = "DELETE FROM stylist_specialties WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            return 1;
        }
    }
    return -1;
}

/* STYLIST APIs */

function getAllStylists(): array|null
{
    global $conn;
    $reviewSummary = null;
    $query =
        "SELECT 
            u.id AS stylist_id,
            u.name AS stylist_name, 
            u.img_path AS stylist_img,
            u.email AS stylist_email,
            COUNT(r.id) AS total_appointments,  -- Number of appointments with reviews
            AVG(r.rating) AS average_rating
        FROM 
            users u
        LEFT JOIN 
            appointments a ON u.id = a.stylist_id
        LEFT JOIN 
            reviews r ON a.id = r.appointment_id
        WHERE 
            u.role = 'stylist'  -- Ensure you're only retrieving stylists
        GROUP BY 
            u.id, u.name, u.img_path, u.email
        ORDER BY 
            average_rating DESC;
        ";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $reviewSummary[] = $row;
        }
    }
    return $reviewSummary;
}

function getStylistById(int $stylistId): array|null
{
    global $conn;
    $reviewSummary = null;
    $query =
        "SELECT 
            u.id AS stylist_id,
            u.name AS stylist_name, 
            u.img_path AS stylist_img,
            u.email AS stylist_email,
            COUNT(r.id) AS total_appointments,  -- Number of appointments with reviews
            AVG(r.rating) AS average_rating
        FROM 
            users u
        LEFT JOIN 
            appointments a ON u.id = a.stylist_id
        LEFT JOIN 
            reviews r ON a.id = r.appointment_id
        WHERE 
            u.role = 'stylist'  -- Ensure you're only retrieving stylists
            AND u.id = {$stylistId}
        GROUP BY 
            u.id, u.name, u.img_path, u.email
        ORDER BY 
            average_rating DESC; 
        ";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $reviewSummary = $row;
        }
    }
    return $reviewSummary;
}

function getStylistsBySearch(string $search): array|null
{
    global $conn;
    $reviewSummary = null;
    $query =
        "SELECT 
            u.id AS stylist_id,
            u.name AS stylist_name, 
            u.img_path AS stylist_img,
            u.email AS stylist_email,
            COUNT(r.id) AS total_appointments,  -- Number of appointments with reviews
            AVG(r.rating) AS average_rating
        FROM 
            users u
        LEFT JOIN 
            appointments a ON u.id = a.stylist_id
        LEFT JOIN 
            reviews r ON a.id = r.appointment_id
        WHERE 
            u.role = 'stylist'  -- Ensure you're only retrieving stylists
            AND 
            (u.name LIKE '%{$search}%'
            OR u.email LIKE '%{$search}%')
        GROUP BY 
            u.id, u.name, u.img_path, u.email
        ORDER BY 
            average_rating DESC;  -- Optionally, order by average rating
        ";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $reviewSummary[] = $row;
        }
    }
    return $reviewSummary;
}

function getStylistsBySpecialties(int $specialtyId): array|null
{
    global $conn;
    $stylists = null;
    $query = "SELECT * FROM users WHERE role='stylist' AND id IN (SELECT stylist_id FROM stylist_specialties WHERE service_id = {$specialtyId})";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $stylists[] = $row;
        }
    }
    return $stylists;
}

function getStylistReviewSummary($stylistId): array|null
{
    global $conn;
    $reviewSummary = null;
    $query =
        "SELECT 
            u.name AS stylist_name, 
            COUNT(r.id) AS total_appointments,  -- Number of appointments with reviews
            AVG(r.rating) AS average_rating
        FROM 
            reviews r
        JOIN 
            appointments a ON r.appointment_id = a.id
        JOIN 
            users u ON a.stylist_id = u.id
        WHERE 
            u.role = 'stylist'  -- Ensure you're only retrieving stylists
            AND u.id = {$stylistId}
        GROUP BY 
            u.id, u.name
        ORDER BY 
            average_rating DESC;  -- Optionally, order by average rating
        ";
    if ($r = mysqli_query($conn, $query)) {
        $reviewSummary = mysqli_fetch_assoc($r);
    }
    return $reviewSummary;
}

/* USERS APIs */

function getAllUsers(): array|null
{
    global $conn;
    $users = null;
    $query = 'SELECT * FROM users';
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $users[] = $row;
        }
    }
    return $users;
}

function getUser(int $id): array|null
{
    global $conn;
    $users = null;
    $query = "SELECT * FROM users WHERE id = {$id}";
    if ($r = mysqli_query($conn, $query)) {
        $users = mysqli_fetch_assoc($r);
    }
    return $users;
}

function getUserBySearch(string $search): array|null
{
    global $conn;
    $users = null;
    $query = "SELECT * 
                FROM users 
                WHERE name LIKE '%{$search}%' 
                OR email LIKE '%{$search}%' 
                OR role LIKE '%{$search}%';";
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $users[] = $row;
        }
    }
    return $users;
}

function loginUser(string $email, string $password)
{
    global $conn;
    $hashedPassword = sha1(trim($password));
    $query = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$hashedPassword}' AND (role != 'manager' AND role != 'owner')";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) > 0) {
            $user = mysqli_fetch_assoc($r);
            $_SESSION['user'] = $user;
            return printJsonData(200, "Login successful");
        }
    }
    return printJsonData(401, "Invalid email or password");
}
function loginAdmin(string $email, string $password)
{
    global $conn;
    $hashedPassword = sha1(trim($password));
    $query = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$hashedPassword}' AND (role = 'manager' OR role = 'owner')";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) > 0) {
            $user = mysqli_fetch_assoc($r);
            $_SESSION['user'] = $user;
            return printJsonData(200, "Login successful");
        }
    }
    return printJsonData(401, "Invalid email or password");
}

function createUserByAdmin(string $name, string $email, string $rawPassword, string $role, array $image = null)
{
    global $conn;
    $password = sha1(trim($rawPassword));
    $query = "SELECT email FROM users WHERE email = '{$email}'";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) > 0)
            return printJsonData(500, "Email already exists");
    }
    $query = "INSERT INTO users (name, email, password, role) VALUES ('{$name}', '{$email}', '{$password}', '{$role}')";
    if (mysqli_query($conn, $query)) {
        if (isset($image)) {
            if ($image['error'] === UPLOAD_ERR_OK) {

                $fileTmpPath = $image['tmp_name'];
                $fileName = $image['name'];
                $uploadDir = '../../uploads/';

                // Ensure the upload directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $destPath = $uploadDir . $fileName;

                // Move the file to the specified directory
                if (move_uploaded_file($fileTmpPath, $destPath)) {

                    $last_id = mysqli_insert_id($conn);
                    $query = "UPDATE users SET img_path = '{$fileName}', updated_at = CURRENT_TIMESTAMP WHERE id = {$last_id}";
                    if (mysqli_query($conn, $query)) {
                        return printJsonData(200, "User created successfully");
                    }
                }
            }
        } else {
            return printJsonData(200, "User created successfully");
        }
    }
    return printJsonData(500, "Failed to create user");
}

function createUser(string $name, string $email, string $rawPassword)
{
    global $conn;
    $password = sha1(trim($rawPassword));
    $query = "SELECT email FROM users WHERE email = '{$email}'";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) > 0)
            return printJsonData(500, "Email already exists");
    }
    $query = "INSERT INTO users (name, email, password) VALUES ('{$name}', '{$email}', '{$password}')";
    if (mysqli_query($conn, $query)) {
        return printJsonData(200, "User created successfully");
    }
    return printJsonData(500, "Failed to create user");
}

function updateUserPicture(int $id, string $img_path)
{
    global $conn;
    $query = "UPDATE users SET img_path = '{$img_path}', updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    mysqli_query($conn, $query);
}

function updateUserByAdmin(int $id, string $newName, string $newEmail, string $rawNewPassword)
{
    global $conn;
    $password = sha1(trim($rawNewPassword));
    $query = "UPDATE users SET name = '{$newName}', email = '{$newEmail}', password = '{$password}', updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        return printJsonData(200, "User updated successfully");
    }
    return printJsonData(500, "Failed to update user");
}

function updateUserProfile(int $id, string $newName, string $newEmail)
{
    global $conn;
    $query = "SELECT email FROM users WHERE email = '{$newEmail}' AND id != {$id}";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) > 0)
            return printJsonData(500, "Email already exists");
    }

    $query = "UPDATE users SET name = '{$newName}', email = '{$newEmail}', updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        return printJsonData(200, "Profile updated successfully");
    }
    return printJsonData(500, "Failed to update profile");
}

function updateUserPassword(int $id, string $oldPassword, string $rawNewPassword)
{
    global $conn;
    $hashedOldPassword = sha1(trim($oldPassword));
    $query = "SELECT password FROM users WHERE id = {$id} AND password = '{$hashedOldPassword}'";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) == 0)
            return printJsonData(500, "Old password is incorrect");
    }

    $password = sha1(trim($rawNewPassword));
    $query = "UPDATE users SET password = '{$password}', updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        return printJsonData(200, "Password updated successfully");
    }
    return printJsonData(500, "Failed to update password");
}

function updateUserRole(int $id, string $role)
{
    global $conn;
    $query = "UPDATE users SET role = '{$role}', updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        return printJsonData(200, "Role updated successfully");
    }
    return printJsonData(500, "Failed to update role");
}

function updateUser(int $id, string $name, string $email, string $rawNewPassword)
{
    global $conn;
    $newUser = null;
    $password = sha1(trim($rawNewPassword));
    $query = "UPDATE users SET name = '{$name}', email = '{$email}', password = '{$password}', updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        return printJsonData(200, "User updated successfully");
    }
    return printJsonData(500, "Failed to update user");
}

function deleteUserByAdmin(int $id)
{
    global $conn;
    $query = "DELETE FROM users WHERE id = {$id}";
    mysqli_query($conn, $query);
    if (mysqli_affected_rows($conn) > 0)
        return printJsonData(200, "Account deleted successfully");
    return printJsonData(500, "Failed to delete account");
}

function deleteUser(int $id, string $password)
{
    global $conn;
    $hashedOldPassword = sha1(trim($password));
    $query = "SELECT password FROM users WHERE id = {$id} AND password = '{$hashedOldPassword}'";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) == 0)
            return printJsonData(500, "Password is incorrect");
    }

    $query = "DELETE FROM users WHERE id = {$id}";
    mysqli_query($conn, $query);
    if (mysqli_affected_rows($conn) > 0)
        return printJsonData(200, "Account deleted successfully");
    return printJsonData(500, "Failed to delete account");
}

function getAllTreatments(): array|null
{
    global $conn;
    $treatments = null;
    $query = "SELECT 
                t.id AS treatment_id,
                t.service_id,
                s.*
            FROM 
                treatments t
            INNER JOIN 
                services s ON t.service_id = s.id
            ORDER BY 
                s.name ASC;";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $treatments[] = $row;
        }
    }

    return $treatments;
}

function getAllTreatmentBySearch(string $search): array|null
{
    global $conn;
    $treatments = null;
    $query = "SELECT 
                t.id AS treatment_id,
                t.service_id,
                s.*
            FROM 
                treatments t
            INNER JOIN 
                services s ON t.service_id = s.id
            WHERE 
                s.name LIKE '%{$search}%'
            ORDER BY 
                s.name ASC;";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $treatments[] = $row;
        }
    }

    return $treatments;
}

function getTreatmentEditInfo(int $id): array|null
{
    global $conn;
    $treatment = null;

    $query = "SELECT *
            FROM 
                treatments
            WHERE 
                id = {$id}";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $treatment = $row;
        }
    }

    return $treatment;
}

function getPreviousTreatmentsById(int $id): array|null
{
    global $conn;
    $treatments = null;
    $query = "SELECT * FROM previous_treatments WHERE treatment_id = {$id}";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $treatments[] = $row;
        }
    }

    return $treatments;
}

function checkSuitability(int $treatmentId, int $prevTreatmentId, int $months): bool
{
    global $conn;
    $query = "
            SELECT 
                pt.treatment_id, 
                pt.prev_treatment_id, 
                pt.min_time_months, 
                CASE 
                    WHEN {$months} < pt.min_time_months THEN 0
                    ELSE 1
                END AS suitability
            FROM previous_treatments pt
            WHERE pt.treatment_id = {$treatmentId} AND pt.prev_treatment_id = {$prevTreatmentId};";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            if ($row['suitability'] == 1)
                return true;
        }
    }

    return false;
}

function getAlternativeTreatmentById(int $id): array|null
{
    global $conn;
    $treatment = null;
    $query = "SELECT 
                t.id AS treatment_id,
                a.id AS alternative_id,
                t.service_id AS treatment_service_id,
                a.alternative_service_id AS alternative_service_id,
                pt.min_time_months,
                a.reason,
                s.id AS service_id
            FROM 
                treatments t
            INNER JOIN 
                services s ON t.service_id = s.id
            INNER JOIN
            	alternative_treatments a ON t.service_id = a.treatment_service_id
            INNER JOIN
                previous_treatments pt ON t.id = pt.treatment_id
            WHERE 
                t.id = {$id}
            ORDER BY 
                s.name ASC;";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $treatment = $row;
        }
    }

    return $treatment;
}

function getAlternativeTreatments(int $serviceId): array
{
    global $conn;
    $alternativeTreatments = [];
    $query = "SELECT 
            s.* ,
            alt.reason
        FROM 
            alternative_treatments alt
        INNER JOIN 
            services s
        ON 
            alt.alternative_service_id = s.id
        WHERE 
            alt.treatment_service_id = {$serviceId};";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $alternativeTreatments[] = $row;
        }
    }

    return $alternativeTreatments;
}

function getTreatmentById(int $id): array|null
{
    global $conn;
    $treatment = null;
    $query = "SELECT 
                t.id AS treatment_id,
                t.service_id,
                s.*
            FROM 
                treatments t
            INNER JOIN 
                services s ON t.service_id = s.id
            WHERE 
                t.id = {$id}
            ORDER BY 
                s.name ASC;";

    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $treatment = $row;
        }
    }

    return $treatment;
}

function createTreatment(int $serviceId, array $minTime = [], int $alternativeId, string $reason): int|string
{
    global $conn;

    $treatmentQuery = "SELECT 
                service_id
            FROM 
                treatments
            WHERE service_id = {$serviceId}";

    if ($r = mysqli_query($conn, $treatmentQuery)) {
        if (mysqli_num_rows($r) <= 0) {
            $query = "INSERT INTO treatments (service_id) VALUES ($serviceId);";
            if (mysqli_query($conn, $query)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $treatmentId = mysqli_insert_id($conn);
                    $query = "INSERT INTO alternative_treatments (treatment_service_id, alternative_service_id, reason) VALUES ({$serviceId}, {$alternativeId}, '{$reason}');";
                    foreach ($minTime as $prevTreatmentId => $minTimeMonths) {
                        if ($minTimeMonths == "")
                            $minTimeMonths = 0;
                        $query .= "INSERT INTO previous_treatments (treatment_id, prev_treatment_id, min_time_months) VALUES ({$treatmentId}, {$prevTreatmentId}, {$minTimeMonths});";
                    }
                    if (mysqli_multi_query($conn, $query)) {
                        if (mysqli_affected_rows($conn) > 0) {
                            return $query;
                        }
                    }
                }
            }
        }
    }

    return -1;
}

function createChemicalTreatment(int $serviceId): int
{
    global $conn;

    $query = "SELECT * FROM previous_treatments WHERE service_id = {$serviceId}";

    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) <= 0) {
            $query = "INSERT INTO previous_treatments (service_id) VALUES ($serviceId)";
            if (mysqli_query($conn, $query)) {
                return mysqli_insert_id($conn);
            }
        }
    }

    return -1;
}

function deleteTreatment(int $id): int
{
    global $conn;
    $query = "DELETE FROM treatments WHERE id = {$id}";
    if (mysqli_query($conn, $query)) {
        $query = "DELETE FROM alternative_treatments WHERE treatment_service_id = {$id}";
        if (mysqli_query($conn, $query)) {
            return 1;
        }
    }
    return -1;
}