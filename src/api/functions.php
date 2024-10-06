<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "salon_db";
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
        '<svg width="16" height="16" fill="yellow" stroke="black" stroke-linecap="round"
            stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
        >
                <path
                    d="m12 17.748-6.172 3.245 1.179-6.873-5-4.867 6.9-1L11.993 2l3.086 6.253 6.9 1-5 4.867 1.179 6.873L12 17.748Z"
                >
                </path>
        </svg>';

    $halfStar =
        '<svg width="16" height="16" fill="yellow" stroke="black" stroke-linecap="round"
            stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
                <path d="m12 17.748-6.172 3.245 1.179-6.873-5-4.867 6.9-1L11.993 2 12 17.748Z">
                </path>
        </svg>';    // Half star

    $emptyStar =
        '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-linecap="round"
            stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
                <path
                    d="m12 17.748-6.172 3.245 1.179-6.873-5-4.867 6.9-1L11.993 2l3.086 6.253 6.9 1-5 4.867 1.179 6.873L12 17.748Z">
                </path>
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

/* APPOINTMENT APIs */
function getAllAppointments(): array|null
{
    global $conn;
    $appointments = null;
    $query = 'SELECT * FROM appointments';
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
    $query = "SELECT * FROM appointments WHERE id = {$id}";
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

function getAppointmentsByCustomer(int $customerId): array|null
{
    global $conn;
    $appointments = null;
    $query = "SELECT * FROM appointments WHERE customer_id = {$customerId}";
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

function createAppointment(int $customerId, int $stylistId, string $status, string $scheduledDate): int
{
    global $conn;
    $query = "INSERT INTO appointments (customer_id, stylist_id, status, scheduled_date) VALUES ({$customerId}, {$stylistId}, '{$status}', '{$scheduledDate}')";
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

function createReview(int $customerId, int $appointmentId, string $rating, string $review): int
{
    global $conn;
    $query = "INSERT INTO reviews (customer_id, appointment_id, rating, review) VALUES ({$customerId}, {$appointmentId}, '{$rating}', '{$review}')";
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

function createService(string $name, float $price, int $duration, int $followup_duration): int
{
    global $conn;
    $query = "INSERT INTO services (name, price, duration, followup_duration) VALUES ('{$name}', {$price}, {$duration}, {$followup_duration})";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn);
        return $id;
    }
    return -1;
}

function updateService(int $id, string $name, float $price, int $duration, int $followup_duration): int
{
    global $conn;
    $query = "UPDATE services SET name = '{$name}', price = {$price}, duration = {$duration}, followup_duration = {$followup_duration}, updated_at = CURRENT_TIMESTAMP WHERE id = {$id}";
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
    $query = "SELECT * FROM stylist_specialties WHERE stylist_id = {$stylistId}";
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
    $stylists = null;
    $query = 'SELECT * FROM users WHERE role="stylist"';
    if ($r = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($r)) {
            $stylists[] = $row;
        }
    }
    return $stylists;
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

function loginUser(string $email, string $password)
{
    global $conn;
    $hashedPassword = sha1(trim($password));
    $query = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$hashedPassword}'";
    if ($r = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($r) > 0) {
            $user = mysqli_fetch_assoc($r);
            $_SESSION['user'] = $user;
            return printJsonData(200, "Login successful");
        }
    }
    return printJsonData(401, "Invalid email or password");
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

function deleteUser(int $id)
{
    global $conn;
    $query = "DELETE FROM users WHERE id = {$id}";
    mysqli_query($conn, $query);
    if (mysqli_affected_rows($conn) > 0)
        return printJsonData(200, "User deleted successfully");
    return printJsonData(500, "Failed to delete user");
}