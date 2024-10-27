<?php
if(isset($_POST["login"])){
require "database.php";
$conn = getDB();

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT name, surname FROM gym_members WHERE username='$username' and password='$password'";
$results = mysqli_query($conn, $sql);
if ($results === false) {
echo mysqli_error($conn);
} else {
$user = mysqli_fetch_assoc($results);
}

if ($user === null)echo "Wrong username or password";
else echo "Welcome ".$user["name"]. " ". $user["surname"];
}
?>
