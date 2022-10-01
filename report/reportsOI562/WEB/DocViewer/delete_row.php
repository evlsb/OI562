<?php

	/*$id      = $_POST["id"];
	$ServerName = $_POST["ServerName"];
	$Database   = $_POST["Database"];
	$UID        = $_POST["UID"];
	$PWD        = $_POST["PWD"];
	$file_func  = $_POST["file_func"];

	include($file_func);

	$NULL       = "--";

	$connectionInfo = array( "Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD);
	$conn = sqlsrv_connect( $ServerName, $connectionInfo);

	if( $conn ){  

		$tsql = "DELETE FROM Zamer WHERE id = $id;";
		$stmt = sqlsrv_query($conn, $tsql);
		//echo $tsql;

	}
*/
?>

<!--<p>Строка удалена</p>

<form action="/web/docviewer/index.php" method="post">

	<input type="submit" name="ok" value="вернуться к отчетам">

</form>-->
<?php

	$ServerName      	= $_POST["ServerName"];
	$Database      		= $_POST["Database"];
	$UID      			= $_POST["UID"];
	$PWD      			= $_POST["PWD"];

	$id      	= $_POST["Number_zamer"];

	$connectionInfo = array( "Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD);
	$conn = sqlsrv_connect( $ServerName, $connectionInfo);

	if( $conn ){

		$tsql = "DELETE FROM Zamer_01 WHERE id = $id;";
		$stmt = sqlsrv_query($conn, $tsql);

	}


?>

<p>Замер удален</p>

<form action="/web/docviewer/index.php" method="post">

	<input type="submit" name="ok" value="вернуться к отчетам">

</form>

?>