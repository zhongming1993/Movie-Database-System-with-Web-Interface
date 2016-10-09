<html>
<body>
<head>
	<title>Adding Comment to Library</title>
	</style>
</head>

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

# more required area can be added later

	if ($_SERVER["REQUEST_METHOD"] == "POST") {	
   
	    if (empty($_POST["movie"])) {
	    	$movieErr = "Movie is required";
	    }else{
	    	$movie = $_POST['movie'];
	    }

		if (empty($_POST["name"])) {
			$name = "NULL";
		}else{
			$name = $_POST['name'];
		}

		if (empty($_POST["rating"])) {
			$ratingErr = "Rating is required";
		}else{
			$rating= $_POST['rating'];
		}

		if (empty($_POST["comments"])) {
			$comments = "NULL";
		}else{
			$comments= $_POST['comments'];
		}
	}
	
?>

<h2> Add new comment:</h2>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
	Movie:<SELECT name="movie" style="width:500px">
	<OPTION SELECTED>
	<?php
	$db_connection=mysql_connect("localhost","cs143","");
	if(!$db_connection){
	    $errmsg=mysql_error($db_connection);
	    echo "Connection failed: $errmsg<br />";
	    exit(1);    
	}else{
		$sqlmovie="SELECT id,title,year FROM Movie;";		
	  	mysql_select_db("CS143",$db_connection);
		$query_selectmovie=mysql_query($sqlmovie);
	}
	while($resultmovie=mysql_fetch_array($query_selectmovie)){
	$mtitle=$resultmovie[title];
	$myear=$resultmovie[year];
	$movieid=$resultmovie[id];	
	?>	
	<OPTION value="<?=$movieid?>"><?php echo"$mtitle ($myear)"?></OPTION>	
	<?php
	}
	?></SELECT>
	<span class="error">* <?php echo "$movieErr";?></span><br/><br/>

	Your Name:<input type="text" name="name"><br/><br/>
	Rating: <br/>
	<input type="radio" name="rating" value="5">Excellent</input><br/>
	<input type="radio" name="rating" value="4">Good</input><br/>
	<input type="radio" name="rating" value="3">Ok</input><br/>
	<input type="radio" name="rating" value="2">Not Worth</input><br/>
	<input type="radio" name="rating" value="1">Bad</input>
	<span class="error">* <?php echo "$ratingErr";?></span><br/><br/>

	Comments:<br/><br/>
	<textarea type="textarea"cols="60" rows="10" name="comments"></textarea><br/><br/>

	<input type="submit" value="Submit"><br/><br/>
</form>

<?php
	if($movie){
		$sql_time="SELECT now()";
		$time=mysql_query($sql_time,$db_connection);
		$curtimestamp=mysql_fetch_array($time);
		$query_insertreview="INSERT INTO Review VALUES('$name','$curtimestamp[0]',$movie, $rating,'$comments');";
		mysql_query($query_insertreview,$db_connection);
		mysql_close($db_connection); 
		echo "Succeed!";
	}
?>
</body>
</html>