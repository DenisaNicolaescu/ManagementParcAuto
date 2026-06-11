<?php
include 'conexiune.php';

$email = $_POST['email'];
$newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

$query = "UPDATE users
          SET password='$newPassword'
          WHERE email='$email'";

mysqli_query($conn, $query);

echo "Password updated successfully!";
?>