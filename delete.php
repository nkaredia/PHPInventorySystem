<?php
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}

include 'library.php';
$val1 = $_GET['val'];
$val2 = $_GET['del'];
if ($val2 == 'n')
    $qry = "y";
else
    $qry = "n";

$link = conmysql();
$sqlqry = 'UPDATE inventory'
        . ' SET deleted="' . $qry . '"'
        . ' WHERE id=' . $val1;
$result = sqlquery($link, $sqlqry);
	delete($result,$link);
header("Location: view.php");
?>