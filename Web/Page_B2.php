<html>
<head>
	<title>Movie Information</title>
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
	    	$movieErr = "A movie name is required";
	    }else{
	    	$movie = $_GET['keyword'];
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

	if($movie){
		$sql_movieInfo1 = "SELECT * FROM Movie WHERE id = $movie";
		$sql_movieInfo1=mysql_query($sql_movieInfo1,$db_connection);
    	$sql_movieInfo1_p=mysql_fetch_array($sql_movieInfo1); 

 		$sql_movieInfo2 = "SELECT * FROM MovieDirector WHERE mid = $movie";
 		$sql_movieInfo2=mysql_query($sql_movieInfo2,$db_connection);
    	$sql_movieInfo2_p=mysql_fetch_array($sql_movieInfo2);

 		$sql_movieInfo3 = "SELECT * FROM Director WHERE id = $sql_movieInfo2_p[did]";
 		$sql_movieInfo3=mysql_query($sql_movieInfo3,$db_connection); 		
    	$sql_movieInfo3_p=mysql_fetch_array($sql_movieInfo3);

 		$sql_movieInfo4 = "SELECT * FROM MovieGenre WHERE mid = $movie";
 		$sql_movieInfo4=mysql_query($sql_movieInfo4,$db_connection);
		
		$sql_movieInfo5 = "SELECT concat_ws(' ', first,last) AS fullname,role,id FROM (SELECT aid,role FROM MovieActor WHERE mid = $movie) as Role, Actor WHERE Actor.id = Role.aid";
		$sql_movieInfo5 = mysql_query($sql_movieInfo5,$db_connection);



		$sql_movieInfo6 = "SELECT avg(rating) FROM Review WHERE mid = $movie";
		$sql_movieInfo6 = mysql_query($sql_movieInfo6, $db_connection);
		$sql_movieInfo6_p =  mysql_fetch_array($sql_movieInfo6);

		$sql_movieInfo7 = "SELECT count(*) FROM Review WHERE mid = $movie";
		$sql_movieInfo7 = mysql_query($sql_movieInfo7, $db_connection);
		$sql_movieInfo7_p = mysql_fetch_array($sql_movieInfo7);


		$sql_movieInfo8 = "SELECT * FROM Review WHERE mid = $movie";
		$sql_movieInfo8 = mysql_query($sql_movieInfo8, $db_connection);


		mysql_close($db_connection); 



	}
?>


Search for Movie Information
<form method="GET" action="./Page_S1.php">
    Search: <input type="text" name="keyword"></input>
    <span class="error">* <?php echo "$movieErr";?></span><br/><br/>
    
    <input type="submit" value="Search"/>

</form>

<h2> Movie Information </h2>
Name: 
<?php echo $sql_movieInfo1_p[title]." ".$sql_movieInfo1_p[year];?><br/>
Company: 
<?php echo $sql_movieInfo1_p[company];?><br/>
MPAA Rating:
<?php echo $sql_movieInfo1_p[rating];?><br/>
Director:
<?php 
	if($sql_movieInfo3_p){
		echo $sql_movieInfo3_p[first]." ".$sql_movieInfo3_p[last];
	}
	if ($movie && !$sql_movieInfo3_p){
		echo 'NULL';
	}
?><br/>
Genre:
<?php 
while($sql_movieInfo4_p = mysql_fetch_array($sql_movieInfo4)){
  echo $sql_movieInfo4_p[genre].' ';}
?><br/>


<h3> Actor/Actress in this movie </h3>

<?php

	if($sql_movieInfo5){
		while($sql_movieInfo5_p = mysql_fetch_array($sql_movieInfo5)){
		echo '<a href="./Page_B1.php?keyword='.$sql_movieInfo5_p[id].'">'.$sql_movieInfo5_p[fullname].'</a> act as '.$sql_movieInfo5_p[role].'<br/>';
	}
}
	if ($movie && !$sql_movieInfo5){
		echo 'NULL';
	}
?>


<h3> User Feedback </h3>


Average Score: 
<?php
	if($sql_movieInfo8){
		echo $sql_movieInfo6_p[0] ." with ".$sql_movieInfo7_p[0]." reviews.";
	}
	if (!$sql_movieInfo8 && $movie){
		echo "No review for this movie";
	}
?>

<br/><br/>
Comments: <br/>
<?php
	if($sql_movieInfo8){
		echo 'All Comments in Details:<br/>';
	while($sql_movieInfo8_p = mysql_fetch_array($sql_movieInfo8)){
		echo 'On time: '.$sql_movieInfo8_p[time].'; <br/> User Name: '.$sql_movieInfo8_p[name].'; <br/> rated: '.$sql_movieInfo8_p[rating].'; <br/> With comment:'.$sql_movieInfo8_p[comment].'; <br/><br/>';

	}

}
?>
<br/><br/>

<?php

	echo '<a href="./Page_L3.php">  Add your review. </a><br/>';
?>

<hr/>		

</body>
</html>
