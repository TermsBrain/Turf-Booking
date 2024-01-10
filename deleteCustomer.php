<?php
session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: index.php');
    exit;
}
include 'connection.php';
$id = $_REQUEST['id']; //receive userid from query parameter
$str = "DELETE FROM users where id=$id";
if (mysqli_query($conn, $str)) {
    header('Location: customers.php');
}