<?php

/*
    opens the database to store the values 
    and returns the state of sql server
    that is in boolean flag
*/
function conmysql()
{
      $lines = file('topsecret.txt');
      $dbserver = trim($lines[0]);
      $uid = trim($lines[1]);
      $pw = trim($lines[2]);
      $dbname = trim($lines[3]); 


    $link = mysqli_connect($dbserver, $uid, $pw, $dbname) or die("Could not connect to " . mysqli_error($link));
    return $link;
}


/*
    Process mysql query from the parameter $query
    and returns the appropriate boolean flag
*/
function sqlquery($link, $query)
{
    $result = mysqli_query($link, $query) or die('query failed ' . mysqli_error($link));
    return $result;
}

/*
    clears all result and closes the mysql connection
*/
function delete($result,$link)
{
    mysqli_free_result($result);
    mysqli_close($link);
}


/*
    html headers function which have two links
    that redirects to thier respective pages
*/
function htmlheader()
{
	session_start();
    ?>
    <header>
        <img src='1.png' height="100"> 
        <ul id="header">
        	<form method="post" action="view.php">
        		<li id="listheader"><a href="add.php">Add</a></li>
        		<li id="listheader"><a href="view.php">View</a></li>
        		<li id="listheader"><input class="search-box" type="text" name="srch" placeholder="Search" value="<?php if(isset($_SESSION['search'])) echo htmlspecialchars_decode($_SESSION['search']); ?>"/></li>
        		<li id="listheader"><input type="submit" name="search" value="Search" /></li>
        		<li id="listheader"><label>User : <?php echo $_SESSION['username']; ?></label></li>
        		<li id="listheader"><a style="text-decoration: underline;" href="logout.php">Logout</a></li>
        	</form>
        </ul>
    </header>
    <?php
}

/*
    footer function includes the copyright information of the website
*/

function footer()
{
    ?>
    <footer>
        <h5> Copyright &copy; 2014 Design nkaredia </h5>
    </footer>
    <?php
}

?>
