<html>
<head>
	<title>Keyword Search</title>
	<style></style>
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
	$db_connection = mysql_connect('localhost','cs143', "");
	mysql_select_db("CS143",$db_connection);
	if(!$db_connection){
		die('Could not connect:'.mysql_error());
	}

	if(isset($_GET['keyword']) && $_GET['keyword']){
		$inputKeywordArray = explode(" ", $_GET['keyword']);
		if(sizeof($inputKeywordArray) > 0){
					
		mysql_query('CREATE VIEW viewWithFullName AS SELECT id,dob,concat_ws(" ",first,last) AS fullname FROM Actor;',$db_connection);
		mysql_query('CREATE VIEW tempView0 AS SELECT * from viewWithFullName WHERE fullname LIKE "%'.$inputKeywordArray[0].'%";',$db_connection);
		for($i = 1;$i < sizeof($inputKeywordArray);$i++){
			mysql_query('CREATE VIEW tempView'.$i.' AS SELECT * FROM tempView'.($i - 1).' WHERE fullname LIKE "%'.$inputKeywordArray[$i].'%";',$db_connection);
		}
		$actorInfoInTuple = mysql_query('SELECT * FROM tempView'.(sizeof($inputKeywordArray)-1).';',$db_connection);
		for($i = sizeof($inputKeywordArray) - 1;$i >= 0;$i--){
			mysql_query('DROP VIEW tempView'.$i.';',$db_connection);
		}
		mysql_query('DROP VIEW viewWithFullName;',$db_connection);

		mysql_query('CREATE VIEW tempView0 AS SELECT * FROM Movie WHERE title LIKE "%'.$inputKeywordArray[0].'%";',$db_connection);
		for($i = 1;$i < sizeof($inputKeywordArray);$i++){
			mysql_query('CREATE VIEW tempView'.$i.' AS SELECT * FROM tempView'.($i - 1).' WHERE title LIKE "%'.$inputKeywordArray[$i].'%";',$db_connection);
		}
		$movieInfoInTuple = mysql_query('SELECT * FROM tempView'.(sizeof($inputKeywordArray)-1).';',$db_connection);
			for($i = sizeof($inputKeywordArray) - 1;$i >= 0;$i--){
				mysql_query('DROP VIEW tempView'.$i.';',$db_connection);
			}
		}
	}
		mysql_close($db_connection);
?>


<h2>Search for actors/movies</h2>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
	Search: <input type="text" name="keyword" style="width:300px">
	<input type="submit" value="Search">
</form>

<hr/>
Search Result:<br/><br/>
Match Results in Actor: <br/>
<?php
	while($eachActorInfoAssoc = mysql_fetch_assoc($actorInfoInTuple)){
		echo '<a href = "./Page_B1.php?keyword='.$eachActorInfoAssoc[id].'">'.$eachActorInfoAssoc[fullname].'('.$eachActorInfoAssoc[dob].')</a><br/>';
	}
?><br/>
Match Results in Movie: <br/>
<?php
	while($eachMovieInfoAssoc = mysql_fetch_assoc($movieInfoInTuple)){
		echo '<a href = "./Page_B2.php?keyword='.$eachMovieInfoAssoc[id].'">'.$eachMovieInfoAssoc[title].'('.$eachMovieInfoAssoc[year].')</a><br/>';
	}
?>
<br/>
<hr/>
</body>
</html>




