<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: welcome.html");
    exit();
}
//$_SESSION['username'] = 'Alex';
echo"<h1>Dashboard Manager</h1>";
echo"<p>Welcome back, ".$_SESSION['username']."!</p>";
?>
<?php
echo "Dashboard Manager Functioneaza!";
?>