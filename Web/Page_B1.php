<html>
<head>
	<title>Actor Information</title>
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


</br>
</br>


<?php

	if ($_SERVER["REQUEST_METHOD"] == "GET") {	
   
	    if (empty($_GET["keyword"])) {
	    	$actorErr = "An actor name is required";
	    }else{
	    	$actor = $_GET['keyword'];
	    }
	}	
?>


<?php

	$db_connection = mysql_connect('localhost','cs143', "");
	if(!$db_connection){
	    $errmsg=mysql_error($db_connection);
	    echo "Connection failed: $errmsg<br />";
	    exit(1);  
	} else {
	mysql_select_db("CS143",$db_connection);
	}

	if($actor){
		$sql_actorInfo = "SELECT * FROM Actor WHERE id = $actor";
		$sql_movieInfo = "SELECT title,role,id FROM (SELECT mid,role FROM MovieActor WHERE aid = $actor) AS Role,Movie WHERE Movie.id = Role.mid;";
		$actorInfoInTuple = mysql_query($sql_actorInfo,$db_connection);
		$actorActMovieInTuple = mysql_query($sql_movieInfo,$db_connection);
		$result_ActorInfo = mysql_fetch_array($actorInfoInTuple);
		mysql_close($db_connection); 
	}
?>


Search for Actor Information
<form method="GET" action="./Page_S1.php">
    Search: <input type="text" name="keyword"></input>
    <span class="error">* <?php echo "$actorErr";?></span><br/><br/>
    
    <input type="submit" value="Search"/>

</form>

<h2> Actor/Actress Information </h2>
Name: 
<?php echo $result_ActorInfo[first].' '.$result_ActorInfo[last];?><br/>
Gender: 
<?php echo $result_ActorInfo[sex];?><br/>
Date Of Birth: 
<?php echo $result_ActorInfo[dob];?><br/>
Date Of Death: 
<?php
	if($result_ActorInfo[dod]){
		echo $result_ActorInfo[dod];
	}
	if ($actor && !$result_ActorInfo[dod]){
		echo '---------';
	}
?>

<h2> Movies Act In </h2>
<?php

	while($result_ActorMovie = mysql_fetch_array($actorActMovieInTuple)){
		echo 'Act '.$result_ActorMovie[role].' in <a href = "./Page_B2.php?keyword='.$result_ActorMovie[id].'">'.$result_ActorMovie[title].'</a><br/>';
}

?>
<hr/>		

</body>
</html>
