<?php

function login ($username, $password, $conn) {

    $md5 = md5($password);

    $stmt = $conn->prepare("SELECT `id`, `username` FROM `users` WHERE `username` = ? AND `password` = ?");
    $stmt->bind_param("ss", $username, $md5);
    $stmt->execute();

    $result = $stmt->get_result();

    $num_row = $result->num_rows;

    if ($num_row > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
    } else {
        $_SESSION['user_id'] = 0;
        $_SESSION['username'] = "";
    }

    session_write_close();

}