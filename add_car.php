<?php
include 'conexiune.php';

$brand = trim($_POST['brand'] ?? '');
$model = trim($_POST['model'] ?? '');
$year = trim($_POST['year'] ?? '');
$license_plate = trim($_POST['license_plate'] ?? '');
$vin = trim($_POST['vin'] ?? '');
$capacity = trim($_POST['capacity'] ?? '');
$power = trim($_POST['power'] ?? '');
$consumption = trim($_POST['consumption'] ?? '');
$mileage = trim($_POST['mileage'] ?? '');
$last_service_date = trim($_POST['last_service_date'] ?? '');
$next_service_date = trim($_POST['next_service_date'] ?? '');
$assigned_user_id = $_POST['assigned_user_id'] ?? NULL;
$fuel_type = trim($_POST['fuel_type'] ?? '');


if (
    empty($brand) ||
    empty($model) ||
    empty($year) ||
    empty($license_plate) ||
    empty($vin) ||
    empty($fuel_type) ||
    empty($capacity) ||
    empty($power) ||
    empty($consumption) ||
    empty($mileage) ||
    empty($last_service_date) ||
    empty($next_service_date)
) {
    die("All fields are required.");
}
if(strlen($vin) != 17){
    die("VIN must contain exactly 17 characters.");
}
$query = "INSERT INTO cars
(
    brand,
    model,
    year,
    license_plate,
    vin,
    fuel_type,
    capacity,
    power,
    consumption,
    mileage,
    last_service_date,
    next_service_date,
    assigned_user_id
)
VALUES
(
    '$brand',
    '$model',
    '$year',
    '$license_plate',
    '$vin',
    '$fuel_type',
    '$capacity',
    '$power',
    '$consumption',
    '$mileage',
    '$last_service_date',
    '$next_service_date',
    '$assigned_user_id'
)";

mysqli_query($conn, $query);

header("Location: cars-m.php");
exit();
?>