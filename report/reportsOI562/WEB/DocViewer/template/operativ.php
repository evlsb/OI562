<?php
error_reporting(0);
$dateb      = $_POST["dateb"];
$datee      = $_POST["datee"];
$ServerName = $_POST["ServerName"];
$Database   = $_POST["Database"];
$UID        = $_POST["UID"];
$PWD        = $_POST["PWD"];
$descr      = $_POST["descr"];
$descr1     = $_POST["descr1"];
$type       = $_POST["itype"];
$NumBIK     = $_POST["NumBIK"];
$file_func  = $_POST["file_func"];  
$Sikn  	    = $_POST["SIKN"];  
$Owner 	    = $_POST["OWNER"];   
$Substance  = $_POST["substance"];  

 $type = "2"; 


$docdate  = $_POST["docdate"];  


$dateb = DateTime::createFromFormat('Ymd H:i:s', $docdate);
$dateb->modify("-1 second");
$dateb = $dateb->format('Ymd H:i:s');

$d1 = DateTime::createFromFormat('Ymd H:i:s', $docdate ); 
$d2 = DateTime::createFromFormat('Ymd H:i:s', $docdate ); 
$d2->modify("+24 hour");
$d1 = $d1->format('d.m.y H:i:s');
$d2 = $d2->format('d.m.y H:i:s');

$datee = DateTime::createFromFormat('Ymd H:i:s', $docdate);
$datee->modify("+1 day");  
$datee = $datee->format('Ymd H:i:s');



include($file_func);

$NULL       = "--";


$connectionInfo = array( "Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD);
$conn = sqlsrv_connect( $ServerName, $connectionInfo);

if( $conn ) 
{  
  $tsql = "SELECT *, convert (datetime, convert(varchar(10), date_, 104), 104) as dDateBegin FROM KMH_1 WHERE (date_ between '{#dateb}' and '{#datee}') ORDER BY date_;";

  $tsql=str_replace("{#dateb}", $dateb, $tsql);
  $tsql=str_replace("{#datee}", $datee, $tsql); 

  $stmt = sqlsrv_query($conn, $tsql);
  
  if( $stmt === false) 
  {
    die( print_r( sqlsrv_errors(), true) );
  }
  $dDate            = array();
  $dDateD           = array();
  $param_1		 	= array();
  $param_2        	= array();
  $param_3     		= array();
  $param_4	  		= array(); 
  $flow	  			= array();
  $point_flow	  	= array();
  $KMH_num	  		= array();
  $date_KMH	  		= array();
  $Press	  		= array();
  $Temp	  			= array();
  
  $n 		 = 0;


  

$descr2 = '';
  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) 
  {      
 
	eval("\$descr2 = \"$descr\";");
	//echo $descr;

	if ($descr1 == $descr2) {
       /*$dDate[0]         = $row["dDateBegin"]->format("d.m.Y");
       $dDate[1]         = $row["dDateEnd"]->format("H.i.s");
       $dDate[2]         = $row["dDateBegin"]->format("d.m.Y");
       $dDate[3]         = $row["dDateEnd"]->format("H.i.s");
	   $dDateD[$n]       = $row["dCreateDate"]->format("H:i");*/
       $param_1[$n]    	 = $row["param_1"];
       $param_2[$n]  	 = $row["param_2"];
       $param_3[$n]    	 = $row["param_3"];
       $param_4[$n]      = $row["param_4"];
       $flow[$n]      	 = $row["flow"];
       $point_flow[$n]   = $row["point_flow"];
       $KMH_num[$n]   	 = $row["KMH_num"];
       $date_KMH[$n]   	 = $row["date_"];
       $Press[$n]   	 = $row["Press"];
       $Temp[$n]   		 = $row["Temp"];
       
       $n                = $n + 1; 
    }
  }
 
  sqlsrv_free_stmt($stmt);
}   	
 	 

?>


<font style="font size=14;line-height:1.2"><b>

<?php if ($type == "0"){ ?>
	<CENTER>Оперативный отчет  2-х часовок за сутки</CENTER>
	<?php $WeightText="2 часа"; } ?>

<?php if ($type == "1"){ ?>
	<CENTER>Оперативный отчет за смену</CENTER>
	<?php $WeightText="смену"; } ?>

<?php if ($type == "2"){ ?>
	<CENTER>Оперативный отчет за сутки</CENTER>
	<?php $WeightText="сутки	"; } ?>

<?php if ($type == "4"){ ?>
	<CENTER>Оперативный отчет за месяц</CENTER>	
	<?php $WeightText="месяц"; } ?>

</b></font>

<font style="font size=6;line-height:1.2"><b>
<br>
</b></font>

<font style="font size=12;line-height:1.2"><b>
<CENTER><?php echo $Sikn . ' ' . $Owner; ?></CENTER>
</b></font>

<font style="font size=12;line-height:1.2">
<P>Дата начала формирования:&nbsp;<u>&nbsp;<?php echo $d1; ?>&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;Дата окончания формирования:&nbsp;<u>&nbsp;<?php echo $d2; ?>&nbsp;</u>
<BR>

</font>

<CENTER>

	<?php 

		//echo $param_1[0];
		/*$num = '5';
		$str = 'Число $num';
		echo $str;
		eval("\$str2 = \"$str\";");
		echo $str2;*/

	?>

<TABLE align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">

	<TR align="center" BGCOLOR="#CCCCCC">
		<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Время</TD>
		<TD rowspan="2" style="border-bottom:none;border-right:none">№ КМХ&nbsp;</TD>
		<TD rowspan="2" style="border-bottom:none;border-right:none">№ точки расхода&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Объем газа при КМХ&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Относит погрешность&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">V ст.у. по поверяемому расходомеру&nbsp;</TD>
		<TD colspan="1" style="border-bottom:none;border-right:none">V ст.у. по контрольному расходомеру&nbsp;</TD>
		<TD colspan="1" style="border-bottom:none;border-right:none">Ср. расход ст.у. по повер. расходомеру&nbsp;</TD>
		<TD colspan="1" style="border-bottom:none;border-right:none">Давление&nbsp;</TD>
		<TD colspan="1" style="border-bottom:none;border-right:none">Температура&nbsp;</TD>
	</TR>

	<TR align="center" BGCOLOR="#CCCCCC">
		<TD style="border-bottom:none;border-right:none"> м3 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> % &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> м3 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> м3 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> м3/ч &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> С &nbsp;</TD>
	</TR>


	
		
        
		<?php

			for ($nn = 0; $nn < $n; $nn++){ 
				echo '<TR align="center">';

					echo '<TD style="border-bottom:none;border-right:none">' . $date_KMH [$nn]->format("H:i:s") . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($KMH_num[$nn], 	0, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($point_flow[$nn], 	0, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($flow[$nn], 	3, $NULL) . '</TD>';

					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($param_1[$nn], 	3, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($param_2[$nn], 	3, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($param_3[$nn], 	3, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($param_4[$nn], 	3, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Press[$nn], 	3, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Temp[$nn], 	1, $NULL) . '</TD>';

				echo '</TR>'  ;
			}

		?>
	


</TABLE>

</CENTER>



                                                                                                                              



<font style="font size=12">
<br><br>
Сдал: _______________________&nbsp;(Ф.И.О.)  подпись: ______________________<p><br>
Принял: _____________________&nbsp;(Ф.И.О.)  подпись: ______________________
</font>          
<br><br>

<?php

	/*$docdate  = $_POST["docdate"];  
	$docdate = DateTime::createFromFormat('Ymd H:i:s', $docdate); 
	$docdate = $docdate->format('Ymd'). " 00:00:00";

	$dateb = DateTime::createFromFormat('Ymd H:i:s', $docdate ); 
	$dateb->modify("+4 hour");
	
	$datee = DateTime::createFromFormat('Ymd H:i:s', $docdate );
	$datee->modify("+28 hour");

	$d1 = DateTime::createFromFormat('Ymd H:i:s', $docdate ); 
	$d1->modify("+4 hour");
	$d1 = $d1->format('d.m.y H:i:s');

	$d2 = DateTime::createFromFormat('Ymd H:i:s', $docdate ); 
	$d2->modify("+28 hour");
	$d2 = $d2->format('d.m.y H:i:s');*/

	//echo $d1->format("d.m.y H:i:s");
	/*$d1    = $dateb;
	$datee = DateTime::createFromFormat('Ymd H:i:s', $docdate ); 
	$dateb->modify("-15 hour -1 second");
	$d1->modify("-3 hour +1 second");
	$d1 = $d1->format('d.m.y H:i:s');

	$datee->add(new DateInterval('PT8H'));
	$d2    = $datee;
	$d2->modify("-2 hour");
	$d2 = $d2->format('d.m.y H:i:s');
	$datee->modify(" -1 second");
	$dateb = $dateb->format('Ymd H:i:s');
	//echo $dateb->format("Y.m.d H:i:s");
	$datee = $datee->format('Ymd H:i:s');*/

?>