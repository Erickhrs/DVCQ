<?php
include_once('./includes/loading.php');
if(!isset($_SESSION)) {
    session_start();
}

session_destroy();

header("Location: questions.php");