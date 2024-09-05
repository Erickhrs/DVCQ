<?php
if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['id'])) {
    $connected = 'false';
    echo json_encode($connected);
} else {
    $connected = 'true';
    echo json_encode($connected);
}
?>