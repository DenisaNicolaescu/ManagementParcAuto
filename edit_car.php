<?php
    include 'conexiune.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = $_POST['id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_plate = $_POST['license_plate'];

    $query = "UPDATE cars SET
              brand='$brand',
              model='$model',
              year='$year',
              license_plate='$license_plate'
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

    <button type="submit">
        Save
    </button>

</form>

</body>
</html>