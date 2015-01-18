<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}
/*
Student Declaration

I/we declare that the attached assignment is my/our own work in accordance with Seneca Academic Policy. 
No part of this assignment has been copied manually or electronically from any other source (including web sites) 
or distributed to other students.

Name: Karedia Noorsil

Student ID : 014 939 136

*/
    
include 'library.php';
$link = conmysql();

if(isset($_POST['search']) || isset($_SESSION['search'])){
	if(isset($_POST['search']))
		$search = mysqli_real_escape_string($link,htmlspecialchars($_POST['srch']));
	else if(isset($_SESSION['search']))
		$search = mysqli_real_escape_string($link,htmlspecialchars($_SESSION['search']));
	$qry = "SELECT * FROM inventory WHERE description LIKE '%".$search."%'";
	$result = sqlquery($link,$qry);
	$_SESSION['search'] = $search;
}
else {
	$result = sqlquery($link, "SELECT * FROM inventory");
}
?>

<html>
    <head>
        <title> Database View </title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <?php htmlheader(); ?>
        <div id="div">
            <table id="view">
                <tr>
                    <th id="tableheader" class="th">Id</th>
                    <th id="tableheader">Item Name</th>
                    <th id="tableheader">Description</th>
                    <th id="tableheader">Supplier</th>
                    <th id="tableheader">Cost</th>
                    <th id="tableheader">Price</th>
                    <th id="tableheader">Number<br>on<br>Hand</th>
                    <th id="tableheader">Reorder<br>Level</th>
                    <th id="tableheader">On<br>Back<br>Order</th>
                    <th id="tableheader" class="th1">Delete/Restore</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($result))
                {
                    ?>
                    <tr>
                        <td id="tdview"><?php echo $row['id']; ?></td>
                        <td id="tdview"><?php echo $row['itemName']; ?></td>
                        <td id="tdview"><?php echo $row['description']; ?></td>
                        <td id="tdview"><?php echo $row['supplierCode']; ?></td>
                        <td id="tdview"><?php echo $row['cost']; ?></td>
                        <td id="tdview"><?php echo $row['price']; ?></td>
                        <td id="tdview"><?php echo $row['onHand']; ?></td>
                        <td id="tdview"><?php echo $row['reorderPoint']; ?></td>
                        <td id="tdview"><?php echo $row['backOrder']; ?></td>
                        <td id="tdview">
                            <a id="del" href="delete.php?val=<?php echo $row['id']; ?>&del=<?php echo $row['deleted']; ?>">
                                <?php
                                if ($row['deleted'] == "n")
                                    echo "Delete";
                                else
                                    echo "Restore";
                                ?>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                delete($result,$link);
                ?>
            </table>
        </div><br>
        <?php footer(); ?>
    </body>
</html>