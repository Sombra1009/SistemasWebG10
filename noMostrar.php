<?php
require_once 'config.php';

$_SESSION['noMostrar'] = true;

header("Location: ./");
exit();