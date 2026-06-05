<?php
    include 'conexiune.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = $_POST['id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_plate = $_POST['license_plate'];
    $fuel_type = $_POST['fuel_type'];
    $capacity = $_POST['capacity'];
    $power = $_POST['power'];
    $consumption = $_POST['consumption'];
    $mileage = $_POST['mileage'];
    $status = $_POST['status'];
    $last_service_date = $_POST['last_service_date'];
    $next_service_date = $_POST['next_service_date'];

    $query = "UPDATE cars SET
                brand='$brand',
                model='$model',
                year='$year',
                license_plate='$license_plate',
                fuel_type='$fuel_type',
                capacity='$capacity',
                power='$power',
                consumption='$consumption',
                mileage='$mileage',
                status='$status',
                last_service_date='$last_service_date',
                next_service_date='$next_service_date'
                WHERE id=$id";

    mysqli_query($conn,$query);

    header("Location: cars-m.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM cars WHERE id=$id";
$result = mysqli_query($conn,$query);

$car = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Car</title>
</head>
<body>

<h2>Edit Car</h2>

<form method="POST">
<input type="hidden"
           name="id"
           value="<?php echo $car['id']; ?>">

    <input type="text"
           name="brand"
           value="<?php echo $car['brand']; ?>">

    <input type="text"
           name="model"
           value="<?php echo $car['model']; ?>">

    <input type="number"
           name="year"
           value="<?php echo $car['year']; ?>">

    <input type="text"
           name="license_plate"
           value="<?php echo $car['license_plate']; ?>">
    <input type="text"
       name="fuel_type"
       value="<?php echo $car['fuel_type']; ?>">

    <input type="number"
        step="0.1"
        name="capacity"
        value="<?php echo $car['capacity']; ?>">

    <input type="number"
        name="power"
        value="<?php echo $car['power']; ?>">

    <input type="number"
        step="0.1"
        name="consumption"
        value="<?php echo $car['consumption']; ?>">

    <input type="number"
        name="mileage"
        value="<?php echo $car['mileage']; ?>">

    <select name="status">
        <option value="active" <?php if($car['status']=='active') echo 'selected'; ?>>
            Active
        </option>

        <option value="in_service" <?php if($car['status']=='in_service') echo 'selected'; ?>>
            In Service
        </option>

        <option value="reserve" <?php if($car['status']=='reserve') echo 'selected'; ?>>
            Reserve
        </option>

        <option value="decommissioned" <?php if($car['status']=='decommissioned') echo 'selected'; ?>>
            Decommissioned
        </option>
    </select>

    <input type="date"
        name="last_service_date"
        value="<?php echo $car['last_service_date']; ?>">

    <input type="date"
        name="next_service_date"
        value="<?php echo $car['next_service_date']; ?>">
    <button type="submit">
        Save
    </button>

</form>

</body>
</html>