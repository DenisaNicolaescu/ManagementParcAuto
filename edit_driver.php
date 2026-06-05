<?php

include 'conexiune.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $license_category = $_POST['license_category'];

    $query = "UPDATE drivers SET
              first_name='$first_name',
              last_name='$last_name',
              phone='$phone',
              email='$email',
              license_category='$license_category'
              WHERE id=$id";

    mysqli_query($conn,$query);

    header("Location: drivers.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM drivers WHERE id=$id";
$result = mysqli_query($conn,$query);

$driver = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Driver</title>
</head>
<body>

<h2>Edit Driver</h2>

<form method="POST">

    <input type="hidden"
           name="id"
           value="<?php echo $driver['id']; ?>">

    First Name:
    <input type="text"
           name="first_name"
           value="<?php echo $driver['first_name']; ?>">

    <br><br>

    Last Name:
    <input type="text"
           name="last_name"
           value="<?php echo $driver['last_name']; ?>">

    <br><br>

    Phone:
    <input type="text"
           name="phone"
           value="<?php echo $driver['phone']; ?>">

    <br><br>

    Email:
    <input type="email"
           name="email"
           value="<?php echo $driver['email']; ?>">

    <br><br>

    License Category:
    <input type="text"
           name="license_category"
           value="<?php echo $driver['license_category']; ?>">

    <br><br>

    <button type="submit">
        Save Changes
    </button>

</form>

</body>
</html>