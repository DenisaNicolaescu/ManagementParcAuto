<?php
    include 'conexiune.php';
    $brand=$_POST['brand'];
    $model=$_POST['model'];
    $year=$_POST['year'];
    $license_plate=$_POST['license_plate'];
    $next_service_date = $_POST['next_service_date'];
    $documents=$_POST['documents'];

    $query="INSERT INTO cars
    (brand,model,year,license_plate,next_service_date,documents)
    VALUES
    ('$brand','$model','$year','$license_plate','$next_service_date','$documents')";
    mysqli_query($conn,$query);

    header("Location:cars-m.php");
    exit();
?>