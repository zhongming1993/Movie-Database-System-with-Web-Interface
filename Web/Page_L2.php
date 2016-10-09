<!DOCTYPE html>
<html>
<body>
	<head>
		<title>Movie Library Add</title>
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
	if ($_SERVER["REQUEST_METHOD"] == "POST") {	
   
	    if (empty($_POST["title"])) {
	    	$titleErr = "Title is required";
	    }else{
	    	$title = $_POST['title'];
	    }

		if (empty($_POST["company"])) {
			$company = "NULL";
		}else{
			$company = $_POST['company'];
		}

		if (empty($_POST["year"])) {
			$year = "NULL";
		}else{
			$year = $_POST['year'];
		}

		if (empty($_POST["rating"])) {
			$rating = "NULL";
		}else{
			$rating = $_POST['rating'];
		}

		if (empty($_POST["genre"])) {
			$genreErr = "Genre is required";
		}else{
			$genre = $_POST['genre'];
		}
/*  added functions   */

		if (empty($_POST["ticketsold"])) {
			$ticketsold = "NULL";
		}else{
			$ticketsold = $_POST['ticketsold'];
		}


		if (empty($_POST["totalincome"])) {
			$totalincome = "NULL";
		}else{
			$totalincome = $_POST['totalincome'];
		}


		if (empty($_POST["imdb"])) {
			$imdb = "NULL";
		}else{
			$imdb = $_POST['imdb'];
		}


		if (empty($_POST["rot"])) {
			$rot = "NULL";
		}else{
			$rot = $_POST['rot'];
		}

	}	
?>

<h2> Adding Movie To Library: </h2>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">

Title : <input type="text" name="title" maxlength="20">
<span class="error">* <?php echo "$titleErr";?></span><br/><br/>
Compnay: <input type="text" name="company" maxlength="50"><br/>
Year : <input type="text" name="year" maxlength="4"><br/>
MPAA Rating : <select name="mpaarating">
	<option value="G" SELECTED>G</option>
	<option value="NC-17">NC-17</option>
	<option value="PG">PG</option>
	<option value="PG-13">PG-13</option>
	<option value="R">R</option>
	<option value="surrendere">surrendere</option>
	</select><br/>

Genre: <br/>
<input type="checkbox" name="genre[]" value="Action">Action</input><br/>
<input type="checkbox" name="genre[]" value="Adult">Adult</input><br/>
<input type="checkbox" name="genre[]" value="Adventure">Adventure</input><br/>
<input type="checkbox" name="genre[]" value="Animation">Animation</input><br/>
<input type="checkbox" name="genre[]" value="Comedy">Comedy</input><br/>
<input type="checkbox" name="genre[]" value="Crime">Crime</input><br/>
<input type="checkbox" name="genre[]" value="Documentary">Documentary</input><br/>
<input type="checkbox" name="genre[]" value="Drama">Drama</input><br/>
<input type="checkbox" name="genre[]" value="Family">Family</input><br/>
<input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input><br/>
<input type="checkbox" name="genre[]" value="Horror">Horror</input><br/>
<input type="checkbox" name="genre[]" value="Musical">Musical</input><br/>
<input type="checkbox" name="genre[]" value="Mystery">Mystery</input><br/>
<input type="checkbox" name="genre[]" value="Romance">Romance</input><br/>
<input type="checkbox" name="genre[]-Fi" value="Sci-Fi">Sci-Fi</input><br/>
<input type="checkbox" name="genre[]" value="Short">Short</input><br/>
<input type="checkbox" name="genre[]" value="Thriller">Thriller</input><br/>
<input type="checkbox" name="genre[]" value="War">War</input><br/>
<input type="checkbox" name="genre[]" value="Western">Western</input>
<span class="error">* <?php echo "$genreErr";?></span><br/><br/>

Tickets Sold: <input type="text" name="ticketsold" maxlength="50"><br/>
Total Income: <input type="text" name="totalincome" maxlength="50"><br/>


IMDB Rating: <input type="text" name="imdb" maxlength="50"><br/>
Rot Rating: <input type="text" name="rot" maxlength="50"><br/><br/>


<input type="submit" value="Submit"/>
</form><hr/>


<?php
	if($title && $genre){
		$db_connection=mysql_connect("localhost","cs143","");
		if(!$db_connection){
	      $errmsg=mysql_error($db_connection);
	      echo "Connection failed: $errmsg<br />";
	      exit(1);    
	  	}else{
	  		$query="SELECT id FROM MaxMovieID";
	  		mysql_select_db("CS143",$db_connection);
	 		$maxpid=mysql_query($query,$db_connection); 	
	 		$row = mysql_fetch_row($maxpid);
	 		$id=current($row);

		  	if($maxpid){
		  		$newid=$id+1;
		  		$query_addmovie="INSERT INTO Movie VALUES($newid,'$title',$year,'$rating','$company');";
				mysql_query($query_addmovie,$db_connection);
				$query_maxmovieid="UPDATE MaxMovieID Set id=$newid";
				mysql_query($query_maxmovieid,$db_connection);

				if(in_array('Action',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Action');";	
					mysql_query($query_insert,$db_connection);
				}	  		
				if(in_array('Adult',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Adult');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Adventure',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Adventure');";	
					mysql_query($query_insert,$db_connection);
				}

				if(in_array('Animation',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Animation');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Comedy',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Comedy');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Crime',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Crime');";	
					mysql_query($query_insert,$db_connection);
				}

				if(in_array('Documentary',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Documentary');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Drama',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Drama');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Family',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Family');";	
					mysql_query($query_insert,$db_connection);
				}

				if(in_array('Fantasy',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Fantasy');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Horror',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Horror');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Musical',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Musical');";	
					mysql_query($query_insert,$db_connection);
				}

				if(in_array('Mystery',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Mystery');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Romance',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Romance');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Sci-Fi',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Sci-Fi');";	
					mysql_query($query_insert,$db_connection);
				}

				if(in_array('Short',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Short');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Thriller',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Thriller');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('War',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'War');";	
					mysql_query($query_insert,$db_connection);
				}
				if(in_array('Western',$genre)){
					$query_insert="INSERT INTO MovieGenre VALUES($newid,'Western');";	
					mysql_query($query_insert,$db_connection);
				}


				$query_addsales="INSERT INTO Sales VALUES($newid, $ticketsold, $totalincome);";
				mysql_query($query_addsales,$db_connection);

				$query_addrating="INSERT INTO MovieRating VALUES($newid, $imdb, $rot);";
				mysql_query($query_addrating,$db_connection);

				mysql_close($db_connection);	 
				echo "Succeed!"; 
										
	 		}	 		

	  	}
  	}
?>
</body>
</html>