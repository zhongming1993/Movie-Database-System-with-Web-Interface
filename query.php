<html>
<head>
    <title>Query for Movie Database</title>
</head>
 
<body>
 
    <h1>Query for Movie Database</h1>
<p>
This query enables obtaining a list of moives with desired information (etc. title), whose producing year is eariler than a given value. 
</p>
<p>
The year value is in the format of 4digital, for example, 1944.
</p>
 
<p>
Example: <tt>SELECT * FROM Movie WHERE year < 1944;</tt><br />
</p>
 
<div>    
    <p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <input TYPE="text" NAME="query" VALUE="" SIZE=100 MAXLENGTH=200>
        <input type="submit" value="Enter" /> 
    </form>   
    </p>
</div>
 
<?php
 
$dbConnection = mysql_connect("localhost", "cs143", "");
 
    mysql_select_db("CS143", $dbConnection);
    $userQuery = $_GET['query'];
     
    if(!empty($userQuery)){
        $rs = mysql_query($userQuery, $dbConnection);
    if (!$rs){
        die('Invalid query: '.mysql_error());
    }
    else{
        print "<h1>Results:</h1>";
        print "<table border=1 cellspacing=1 cellpadding=2>";
        $row = mysql_fetch_assoc($rs);
        print "<tr align=center>";
        print $row;
        
        foreach($row as $name=>$value){
            print "<td>$name</td>";
        }
        print "</tr>";
 
        while($row){
            print "<tr align=center>";
            $countRow = count($row);
            foreach($row as $value){
                if ($value){
                    print "<td>$value</td>";
                }else{
                    print "<td>N/A</td>";               
                }
            }
        print "</tr>";
        $row = mysql_fetch_row($rs);
        }}

    print "</table>";}
    mysql_close($db_connection);
?>
 
</body>
</html>