<?php

	$ServerName      	= $_POST["ServerName"];
	$Database      		= $_POST["Database"];
	$UID      			= $_POST["UID"];
	$PWD      			= $_POST["PWD"];

	$id      			= $_POST["Number_zamer"];		//номер замера
	$Mass_netto_Accum   = $_POST["Mass_netto_Accum"];	//Масса нетто за замер, т
	// $Water_After      	= $_POST["Water_After"];	
	// $Dens_After      	= $_POST["Dens_After"];
	// $DensW_After      	= $_POST["DensW_After"];

	// $ServerName      	= "DESKTOP-DQQKSJF\WINCC";
	// $Database      		= "OI562";
	// $UID      			= "ozna";
	// $PWD      			= "ozna";


	//$W = ($Water_After * $DensW_After)/$Dens_After; //Массовая доля воды, % масс



	$connectionInfo = array( "Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD);
	$conn = sqlsrv_connect( $ServerName, $connectionInfo);

	if( $conn ){

			$tsql = "UPDATE Zamer SET Field = 'rt', Mass_netto_Accum = $Mass_netto_Accum WHERE id = $id;";
			$stmt = sqlsrv_query($conn, $tsql);
			//$tsql2 = "UPDATE Zamer SET Wm_After = $W WHERE id = $id;";
			//$stmt = sqlsrv_query($conn, $tsql2);
	}


?>

<p>Замер пересчитан</p>

<form action="/web/docviewer/index.php" method="post">

	<input type="submit" name="ok" value="вернуться к отчетам">

</form>
<p>Замер</p>