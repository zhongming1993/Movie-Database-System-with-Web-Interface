<html>
<body>
<head>
	<title>Adding Actor/Movie Relatioship to Library</title>
</head>
<body>

<div class = "navigation">
	<a href = "Page_L1.php">Add an Actor or Director</a></br> 
	<a href = "Page_L2.php">Add a Movie</a></br> 
	<a href = "Page_L3.php">Add a Comment</a></br>
	<a href = "Page_L4.php">Add an Actor/Movie Relation</a></br> 
	<a href = "Page_L5.php">Add a Director/Movie Relation</a></br> 
	<a href = "Page_B1.php">Actor Information</a></br> 	
	<a href = "Page_B2.php">Movie Information</a></br> 	
	<a href = "Page_S1.php">Keyword Search</a></br>
</div>


<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {	
   
	    if (empty($_POST["movie"])) {
	    	$movieErr = "Movie is required";
	    }else{
	    	$movie = $_POST['movie'];
	    }

		if (empty($_POST["actor"])) {
			$actorErr = "Actor is required";
		}else{
			$actor = $_POST['actor'];
		}

		if (empty($_POST["role"])) {
			$roleErr = "Role is required";
		}else{
			$role = $_POST['role'];
		}
	}
	
?>

 <?php 
 	$db_connection=mysql_connect("localhost","cs143","");
	if(!$db_connection){
	    $errmsg=mysql_error($db_connection);
	    echo "Connection failed: $errmsg<br />";
	    exit(1);    
	} else {
    mysql_select_db("CS143",$db_connection);
	}	
 ?>

<h2>Add an Actor/Movie Relation</h2>	
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">




  Movie: <SELECT NAME="movie">
  <?php
    $result = mysql_query("SELECT id, title FROM Movie ORDER BY title ASC",$db_connection);
    while($result_p = mysql_fetch_array($result)){
    	$mtitle=$result_p[title];
		$movieid=$result_p[id];    	
  ?> 
  <OPTION value="<?=$movieid?>"> <?php echo "$mtitle"?></OPTION>	
  <?php	
  }
  ?> </SELECT>
  <span class="error">* <?php echo "$movieErr";?></span><br/><br/>



  Actor: <SELECT NAME="actor">
  <?php
  	$result2 = mysql_query("SELECT id, concat(concat(first,' '),last) as name FROM Actor ORDER BY first,last ASC",$db_connection);
	while($title2 = mysql_fetch_array($result2)){
		$actorname=$title2[name];
		$actorid=$title2[id];
	?>		
	<OPTION value="<?=$actorid?>"> <?php echo"$actorname"?></OPTION>	
	<?php	
	}
	?> </SELECT>
	<span class="error">* <?php echo "$actorErr";?></span><br/><br/>




  Role:
  <INPUT TYPE="text" NAME="role" VALUE="" SIZE=20 MAXLENGTH=50>
	<span class="error">* <?php echo "$roleErr";?></span><br/><br/>

  <INPUT TYPE="submit" VALUE="Submit">
  </FORM>

<?php

	if($movie && $actor && $role){
		$sql_addrole="INSERT INTO MovieActor VALUES($movie,$actor,'$role')";
		mysql_query($sql_addrole,$db_connection);
		mysql_close($db_connection); 
		echo "Succeed!";
	}
?>

</body>
<html>