<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['CHKID'];
$PDFITmes= '';
$sql_res=mysql_query("select * from cheuqes WHERE chid = '$q'");
$NoRow = mysql_num_rows($sql_res);
//$ItemInfo[] = "";
	if ($NoRow > 0) 
	{
		while($row=mysql_fetch_array($sql_res))
		{
		    $ItemInfo[] = $row;
			//$PDFITmes .= '<option value="'.$row['reqid'].'">'.$row['ItemDes'].'</option>';
		}

		echo json_encode($ItemInfo);
	}
	else
	{

	}



}
?>
