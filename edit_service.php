<?php
include 'conexiune.php';

if(isset($_POST['id'])){

    $id = $_POST['id'];
    $service_center = $_POST['service_center'];
    $estimated_cost = $_POST['estimated_cost'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    $query = "UPDATE service_orders
              SET service_center='$service_center',
                  estimated_cost='$estimated_cost',
                  status='$status',
                  description='$description'
              WHERE id=$id";

    mysqli_query($conn, $query);

    header("Location: services.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM service_orders WHERE id=$id";
$result = mysqli_query($conn, $query);

$service = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
</head>
<body>

<h2>Edit Service</h2>

<form method="POST">

    <input type="hidden" name="id"
           value="<?php echo $service['id']; ?>">

    <label>Service Center</label><br>
    <input type="text"
           name="service_center"
           value="<?php echo $service['service_center']; ?>">
    <br><br>

    <label>Estimated Cost</label><br>
    <input type="text"
           name="estimated_cost"
           value="<?php echo $service['estimated_cost']; ?>">
    <br><br>

    <label>Status</label><br>
    <select name="status">
        <option value="scheduled"
        <?php if($service['status']=='scheduled') echo 'selected'; ?>>
        Scheduled
        </option>

        <option value="in_progress"
        <?php if($service['status']=='in_progress') echo 'selected'; ?>>
        In Progress
        </option>

        <option value="completed"
        <?php if($service['status']=='completed') echo 'selected'; ?>>
        Completed
        </option>

        <option value="canceled"
        <?php if($service['status']=='canceled') echo 'selected'; ?>>
        Canceled
        </option>
    </select>

    <br><br>

    <label>Description</label><br>
    <textarea name="description"><?php echo $service['description']; ?></textarea>

    <br><br>

    <button type="submit">Save Changes</button>

</form>

</body>
</html>