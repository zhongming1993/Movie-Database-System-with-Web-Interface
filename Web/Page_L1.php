
<html>
	<head>
		<title>Actor/Deirectory Library Add</title>
		</style>
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

		$identity = $_POST['identity'];
   
	    if (empty($_POST["first"])) {
	    	$fnameErr = "First name is required";
	    }else{
	    	$fname = $_POST['first'];
	    }

		if (empty($_POST["last"])) {
			$lnameErr = "Last name is required";
		}else{
			$lname = $_POST['last'];
		}

		$sex = $_POST['sex'];

		if (empty($_POST["dob"])) {
			$dobErr = "Date of Birth is required";
		}else{
			$dob = $_POST['dob'];
		}

		if (empty($_POST["dod"])) {
			$dod = "NULL";
		}else{
			$dod = $_POST['dod'];
		}
	}
?>


		<h2>Adding Actor/Director To Library</h2>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
			Identity:	
				<input type="radio" name="identity" value="Actor" checked>Actor
				<input type="radio" name="identity" value="Director">Director<br/>
			First Name:	
				<input type="text" name="first" maxlength="20">
				<span class="error">* <?php echo "$fnameErr";?></span><br/><br/>
			Last Name:	
				<input type="text" name="last" maxlength="20">
				<span class="error">* <?php echo "$lnameErr";?></span><br/><br/>
			Sex:		
				<input type="radio" name="sex" value="Male" checked>Male
				<input type="radio" name="sex" value="Female">Female<br/>		
			Date of Birth:	
				<input type="text" name="dob">
				<span class="error">* <?php echo "$dobErr";?></span><br/><br/>	
			Date of Die:	
				<input type="text" name="dod"> (leave blank if alive now)<br/>
			Press to Submit:
			<input type="submit" value="Submit"/>
		</form>
		<hr/>

<?php
	if($identity && $fname && $lname && $dob){

		$db_connection=mysql_connect("localhost","cs143","");
		if(!$db_connection){
	      $errmsg=mysql_error($db_connection);
	      echo "Connection failed: $errmsg<br />";
	      exit(1);    
	  	}else{
	  		mysql_select_db("CS143",$db_connection);
			$query="SELECT id FROM MaxPersonID;";
	 		$maxpid=mysql_query($query,$db_connection);
	 		$row = mysql_fetch_row($maxpid);
	 		$id=current($row);
		  	if($maxpid){
		  		$newid=$id+1;
		  		$query_maxpersonid="UPDATE MaxPersonID Set id=$newid;";
				if($identity == 'Director'){
					$query_insert="INSERT INTO Director VALUES($newid,'$lname','$fname',$dob,$dod);";
					mysql_query($query_insert,$db_connection);
				}	  		
		  			 
				if($identity == 'Actor'){
					$query_insert="INSERT INTO Actor VALUES($newid,'$lname','$fname','$sex',$dob,$dod);";			
					mysql_query($query_insert,$db_connection);
				}
				mysql_query($query_maxpersonid,$db_connection);
        		mysql_close($db_connection); 
				echo "Add succeed!";  				
	 		}
	  	}
  	}
?>


</body>
</html>
