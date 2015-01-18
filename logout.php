<?php

session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}
unset($_SESSION['username']);
unset($_SESSION['role']);
unset($_SESSION['search']);
session_destroy();
header("Location: login.php");