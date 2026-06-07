<?php
session_start();
include'conexiune.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email=$_POST['email'];
    $password=MD5($_POST['password']);

    $query="SELECT*FROM users WHERE email='$email' AND password='$password'";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result) > 0)
    {
        $user=mysqli_fetch_assoc($result);
        $_SESSION['user_id']=$user['id'];
        $_SESSION['username']=$user['username'];
        $_SESSION['role']=$user['role'];
        if($user['role']=='manager')
        {
            header("Location: dashboard_manager.php");
        }
        else{
            header("Location: dashboard_user.php");
        }

        exit();

    }
    else{
        echo "Email sau parola incorecta!";
    }
}
?>


