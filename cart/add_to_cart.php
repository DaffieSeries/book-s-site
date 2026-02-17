<?php
session_start();
include "../config.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit();
}

if(!isset($_POST['book_id'])) {
    header("Location: /index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_POST['book_id']);

$check = "SELECT * FROM cart WHERE user_id='$user_id' AND book_id='$book_id'";
$result = mysqli_query($conn, $check);

if(mysqli_num_rows($result) > 0) {
    $update = "UPDATE cart 
               SET quantity = quantity + 1 
               WHERE user_id='$user_id' AND book_id='$book_id'";
    mysqli_query($conn, $update);
} else {
    $insert = "INSERT INTO cart (user_id, book_id, quantity) 
               VALUES ('$user_id', '$book_id', 1)";
    mysqli_query($conn, $insert);
}

header("Location: /index.php");
exit();
?>
