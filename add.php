
<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}

	
include 'library.php';
$valid = true;
$itemName = "";
$description = "";
$supplierCode = "";
$cost = "";
$price = "";
$onHand = "";
$reorderPoint = "";
$itemNameErr = "";
$descriptionErr = "";
$supplierCodeErr = "";
$costErr = "";
$priceErr = "";
$onHandErr = "";
$reorderPointErr = "";
$onbackOrder = "";


/*
This fuction checks if the field is correct or not
and sets the error message and valid flag accordingly
through pointer variable $fieldErr and $fvalid .
*/
function fieldcheck($field, &$fieldErr, $regex, &$fvalid)
{
	if ($field == "")
	{
		$fieldErr = "*Required";
		$fvalid = false;
	} else if (!(preg_match($regex, $field)))
	{
		$fieldErr = "*Please enter correct input";
		$fvalid = false;
	}
}

if (isset($_POST['submit']))
{
	$itemName = trim($_POST['itemName']);
	$description = trim($_POST['description']);
	$supplierCode = trim($_POST['supplierCode']);
	$cost = trim($_POST['cost']);
	$price = trim($_POST['price']);
	$onHand = trim($_POST['onHand']);
	$reorderPoint = trim($_POST['reorderPoint']);

	if (isset($_POST['onbackOrder']))
	{
		$onbackOrder = "y";
	}
	else
	{
		$onbackOrder = "n";
	}

	$pattern = "/^[A-Za-z0-9 :;\-,\']+$/";
	fieldcheck($itemName, $itemNameErr, $pattern, $valid);
	$pattern = "/^[A-Za-z0-9 .,\'\-\n^M\s]+$/";
	fieldcheck($description, $descriptionErr, $pattern, $valid);
	$pattern = "/^[A-Za-z0-9 \-]+$/";
	fieldcheck($supplierCode, $supplierCodeErr, $pattern, $valid);
	$pattern = "/^[0-9]+\.[0-9]{2}$/";
	fieldcheck($cost, $costErr, $pattern, $valid);
	$pattern = "/^[0-9]+\.[0-9]{2}$/";
	fieldcheck($price, $priceErr, $pattern, $valid);
	$pattern = "/^[0-9]+$/";
	fieldcheck($onHand, $onHandErr, $pattern, $valid);
	$pattern = "/^[0-9]+$/";
	fieldcheck($reorderPoint, $reorderPointErr, $pattern, $valid);

	if ($valid && isset($_POST['submit']))
	{
        $link = conmysql();   // library.php

        $sql_query = 'INSERT INTO inventory set itemName="' . $itemName . '", description="' . $description . '", '
        . 'supplierCode="' . $supplierCode . '", cost= ' . $cost . ', price= ' . $price . ', onHand=' . $onHand . ', '
        . 'reorderPoint=' . $reorderPoint . ', backOrder="' . $onbackOrder . '", deleted="n"';

        $result = sqlquery($link, $sql_query);  // library.php

        delete($result,$link); // library.php

        header("Location: view.php");
    }
}
?>
<html>
<head>
	<title>
		Store Electro's Order Form
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php htmlheader(); ?>
	<form action="" method="post">
		<div>
			<table>
				<tr>
					<td id="col1"> Item Name: </td>
					<td> <input id="form" name="itemName" type="text" value="<?php
					if (isset($_POST['itemName']))
						echo $_POST['itemName'];
					?>"> </td>
					<td id="error"> <?php if ($_POST) echo $itemNameErr; ?> </td>
				</tr>
				<tr>
					<td id="col1"> Description: </td>
					<td> <textarea id="textarea" name="description" row="10" cols="20" ><?php
					if (isset($_POST['description']))
						echo $_POST['description'];
					?></textarea> </td> 
					<td id="error"><?php if ($_POST) echo $descriptionErr; ?></td>
				</tr>
				<tr>
					<td id="col1"> Supplier Code: </td>
					<td> <input id="form" name="supplierCode" type="text" value="<?php
					if (isset($_POST['supplierCode']))
						echo $_POST['supplierCode'];
					?>" ></td>
					<td id="error"> <?php if ($_POST) echo $supplierCodeErr; ?> </td>
				</tr>
				<tr>
					<td id="col1"> Cost: </td>
					<td> <input id="form" name="cost" type="text" value="<?php
					if (isset($_POST['cost']))
						echo $_POST['cost'];
					?>" > </td>
					<td id="error"> <?php if ($_POST) echo $costErr; ?> </td>
				</tr>
				<tr>
					<td id="col1"> Selling Price: </td>
					<td> <input id="form" name="price" type="text" value="<?php
					if (isset($_POST['price']))
						echo $_POST['price'];
					?>" > </td>
					<td id="error"> <?php if ($_POST) echo $priceErr; ?> </td>
				</tr>
				<tr>
					<td id="col1"> Number on Hand: </td>
					<td> <input id="form" name="onHand" type="text" value="<?php
					if (isset($_POST['onHand']))
						echo $_POST['onHand'];
					?>" > </td>
					<td id="error"> <?php if ($_POST) echo $onHandErr; ?> </td>
				</tr>
				<tr>
					<td id="col1"> Reorder Point: </td>
					<td> <input id="form" name="reorderPoint" type="text" value="<?php
					if (isset($_POST['reorderPoint']))
						echo $_POST['reorderPoint'];
					?>" > </td>
					<td id="error"> <?php if ($_POST) echo $reorderPointErr; ?> </td>
				</tr>
				<tr>
					<td id="col1"> On Back Order: </td>
					<td><input name="onbackOrder" type="checkbox" <?php
					if (isset($_POST['onbackOrder']))
						echo "checked";
					?> ></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="submit" id="submit"></td>
				</tr>
			</table>
		</div><br>
		<?php
		footer();
		?>
	</form>
</body>
</html>
