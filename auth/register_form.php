<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $query = "INSERT INTO users (username, email, password) 
              VALUES ('$username', '$email', '$password')";

    if (mysqli_query($conn, $query)) {

        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['username'] = $username;

        header('Location: ../index.php');
        exit();

    } else {
        echo "Ошибка: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
