<?php
include 'conexiune.php';

$id = $_GET['id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $brand = $_POST['brand'];
    $size = $_POST['size'];
    $wear_level = $_POST['wear_level'];
    $tire_type = $_POST['tire_type'];
    $condition_status = $_POST['condition_status'];

    $query = "
    UPDATE tires
    SET
        brand='$brand',
        size='$size',
        tire_type='$tire_type',
        wear_level='$wear_level',
        condition_status='$condition_status'
    WHERE id=$id
    ";

    mysqli_query($conn, $query);

    header("Location: cars-m.php");
    exit();
}

$query = "SELECT * FROM tires WHERE id=$id";
$result = mysqli_query($conn, $query);
$tire = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tire</title>
</head>
<body>

<h2>Edit Tire</h2>

<form method="POST">

    <label>Brand</label><br>
    <input type="text" name="brand"
           value="<?php echo $tire['brand']; ?>"><br><br>

    <label>Size</label><br>
    <input type="text" name="size"
           value="<?php echo $tire['size']; ?>"><br><br>

    <label>Tire Type</label><br>
    <select name="tire_type">
        <option value="winter" <?php if($tire['tire_type']=="winter") echo "selected"; ?>>Winter</option>
        <option value="summer" <?php if($tire['tire_type']=="summer") echo "selected"; ?>>Summer</option>
        <option value="all-season" <?php if($tire['tire_type']=="all-season") echo "selected"; ?>>All Season</option>
    </select><br><br>

    <label>Wear Level (%)</label><br>
    <input type="number" name="wear_level"
           value="<?php echo $tire['wear_level']; ?>"><br><br>

    <label>Condition Status</label><br>
    <select name="condition_status">
        <option value="new" <?php if($tire['condition_status']=="new") echo "selected"; ?>>Good Condition</option>
        <option value="used" <?php if($tire['condition_status']=="used") echo "selected"; ?>>Normal Wear</option>
        <option value="worn" <?php if($tire['condition_status']=="worn") echo "selected"; ?>>Needs Replacement</option>
    </select><br><br>

    <button type="submit">Save Changes</button>

</form>

</body>
</html>