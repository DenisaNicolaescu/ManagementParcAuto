<?php

include 'conexiune.php';

$id = $_POST['id'];
$type = $_POST['intervention_type'];
$center = $_POST['service_center'];
$cost = $_POST['estimated_cost'];
$status = $_POST['status'];

mysqli_query($conn,"
UPDATE service_orders
SET
    intervention_type='$type',
    service_center='$center',
    estimated_cost='$cost',
    status='$status'
WHERE id=$id
");

$getCar = mysqli_query(
    $conn,
    "SELECT car_id FROM service_orders WHERE id=$id"
);

$car = mysqli_fetch_assoc($getCar);

if($status == 'in_progress'){
    $carStatus = 'in_service';
}
else{
    $carStatus = 'active';
}

mysqli_query(
    $conn,
    "UPDATE cars
     SET status='$carStatus'
     WHERE id=".$car['car_id']
);

header("Location: services.php");
exit();