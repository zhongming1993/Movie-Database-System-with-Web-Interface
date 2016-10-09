<html>
<body>
<head>
	<title>Adding Director/Movie Relatioship to Library</title>
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

		if (empty($_POST["director"])) {
			$directorErr = "Director is required";
		}else{
			$director = $_POST['director'];
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

<h2>Add a Director Relation</h2>	
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
  



  Movie:<SELECT NAME="movie">
  <?php
    $result = mysql_query("SELECT id, title FROM Movie ORDER BY title ASC",$db_connection);
    while($result_p = mysql_fetch_array($result)){
     	$mtitle=$result_p[title];
		$movieid=$result_p[id];     	
?> 
<OPTION value="<?=$movieid?>"> <?php echo "$mtitle"?> </OPTION>
<?php	
}
?> </SELECT>
<span class="error">* <?php echo "$movieErr";?></span><br/><br/>


  Director: <SELECT NAME="director">
  <?php
  	$result2 = mysql_query("SELECT id, concat(concat(first,' '),last) as name FROM Director ORDER BY first,last ASC",$db_connection);
	while($title2 = mysql_fetch_array($result2)){
		$directorname=$title2[name];
		$directorid=$title2[id];
	?>
	<OPTION value="<?=$directorid?>"> <?php echo "$directorname"?> </OPTION>
	<?php	
	}
	?> </SELECT>	
	<span class="error">* <?php echo "$directorErr";?></span><br/><br/>




  <INPUT TYPE="submit" VALUE="Submit">
  </FORM>

<?php

	if($movie && $director){
		$sql_addrole="INSERT INTO MovieDirector VALUES($movie,$director)";
		mysql_query($sql_addrole,$db_connection);
		mysql_close($db_connection); 
		echo "Succeed!";
	}
?>

</body>
<html>