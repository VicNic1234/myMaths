<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['litem'];
$sql_res=mysql_query("UPDATE users SET porApproval='1' WHERE uid = '$q'");

$result = mysql_query($query, $dbhandle);
}
//close the connection
mysql_close($dbhandle);


?>
