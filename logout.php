<?php

session_start();

if (isset($_POST['logout']) && $_POST['logout'] == 1) {
    session_destroy();
    header('Location: index.php');
}