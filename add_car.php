<?php
include 'conexiune.php';

$brand = $_POST['brand'];
$model = $_POST['model'];
$year = $_POST['year'];
$license_plate = $_POST['license_plate'];
$capacity = $_POST['capacity'];
$power = $_POST['power'];
$consumption = $_POST['consumption'];
$mileage = $_POST['mileage'];
$last_service_date = $_POST['last_service_date'];
$next_service_date = $_POST['next_service_date'];

$query = "INSERT INTO cars
(brand, model, year, license_plate, capacity, power, consumption, mileage,last_service_date,next_service_date)
VALUES
('$brand', '$model', '$year', '$license_plate',
'$capacity', '$power', '$consumption', '$mileage','$last_service_date','$next_service_date')";

mysqli_query($conn, $query);

header("Location: cars-m.php");
exit();
?>