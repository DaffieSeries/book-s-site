<?php
session_start();
include "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        if ($row['password'] === $password) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];

            header('Location: ../index.php');
            exit();

        } else {
            echo "Неверный пароль.";
        }

    } else {
        echo "Пользователь не найден.";
    }

    mysqli_close($conn);
}
?>
