<?php
session_start();
include "../config.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit();
}

if(isset($_POST['selected'])) {
    foreach($_POST['selected'] as $book_id) {
        $book_id = intval($book_id);

$check = mysqli_query($conn, "SELECT * FROM cart 
                              WHERE user_id='".$_SESSION['user_id']."' 
                              AND book_id='$book_id'");

if(mysqli_num_rows($check) > 0) {
    mysqli_query($conn, "UPDATE cart 
                         SET quantity = quantity + 1 
                         WHERE user_id='".$_SESSION['user_id']."' 
                         AND book_id='$book_id'");
} else {
    mysqli_query($conn, "INSERT INTO cart (user_id, book_id, quantity)
                         VALUES ('".$_SESSION['user_id']."', '$book_id', 1)");
}

    }

}

header("Location: /cart/cart.php");
