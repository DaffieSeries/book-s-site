<?php
session_start();
include "../config.php";

$user_id = $_SESSION['user_id'];
$book_id = $_POST['book_id'];

$delete = "DELETE FROM cart 
           WHERE user_id='$user_id' AND book_id='$book_id'";

mysqli_query($conn, $delete);

header("Location: cart.php");
exit();
?>
