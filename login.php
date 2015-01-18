<?php
session_start();
if(isset($_SESSION['username'])){
	header("Location: view.php");
}
include 'library.php';

$err = "";
    if(isset($_POST['login'])){
    	$username = $_POST['username'];
		$password = $_POST['password'];
		$link = conmysql();
		$qry = 'SELECT * FROM users WHERE username="'.$username.'"';
		$res = sqlquery($link, $qry);
		$row = mysqli_fetch_array($res);
		if(!empty($row)){
			if(crypt($password,$row['password']) == $row['password']){
				$_SESSION['username'] = $row['username'];
				$_SESSION['role'] = $row['role'];
				header("Location: view.php");
			}
			else{
				$err = "Username or Password is Incorrect";
			}
		}
		else{
			$err = "Username or Password is Incorrect";
		}
    }
?>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<img src='1.png' height="100"> 
		<h1 style="margin-top: 150px;font-family: sans-serif;">Inventory Management System</h1>
		<div class="login">
			<h2 style="font-family: sans-serif;">Login</h2>
			<form method="post" action="">
				<table>
					<tr>
						<td>Username  </td>
						<td><input type="text" name="username" required/></td>
					</tr>
					<tr>
						<td>Password  </td>
						<td><input type="password" name="password" required /></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="login" value="Login" /></td>
					</tr>
					<tr>
						<td></td>
						<td style="color:red;"><?php if(isset($_POST['login']))echo $err; ?></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>