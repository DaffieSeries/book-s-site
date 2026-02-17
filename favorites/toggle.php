<?php
session_start();
include "../config.php";

if(!isset($_SESSION['user_id'])) {
    echo "not_logged";
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_POST['book_id']);

// проверяем, есть ли уже запись
$check = mysqli_query($conn, "SELECT * FROM favorites 
                              WHERE user_id='$user_id' 
                              AND book_id='$book_id'");

if(mysqli_num_rows($check) > 0) {
    // удалить
    mysqli_query($conn, "DELETE FROM favorites 
                         WHERE user_id='$user_id' 
                         AND book_id='$book_id'");
    echo "removed";
} else {
    // добавить
    mysqli_query($conn, "INSERT INTO favorites (user_id, book_id) 
                         VALUES ('$user_id', '$book_id')");
    echo "added";
}
