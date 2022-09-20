<?php
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

/*$dateb = DateTime::createFromFormat('Ymd H:i:s', $docdate);
$dateb->modify("+1 second");
$dateb = $dateb->format('Ymd H:i:s');

$datee = DateTime::createFromFormat('Ymd H:i:s', $docdate);
$datee->modify("+1 day");  
$datee = $datee->format('Ymd H:i:s');*/

/*$docdate = DateTime::createFromFormat('Ymd H:i:s', $docdate);
$docdate->modify("+1 day");  
$docdate = $docdate->format('Ymd'). " 00:00:00";
$dateb = DateTime::createFromFormat('Ymd H:i:s', $docdate ); 
$d1    = $dateb;
$datee = DateTime::createFromFormat('Ymd H:i:s', $docdate ); 
$dateb->modify("-15 hour -1 second");
$d1->modify("-7 hour +1 second");
$d1 = $d1->format('d.m.y H:i:s');

$datee->add(new DateInterval('PT8H'));
$d2    = $datee;
$d2->modify("-6 hour");
$d2 = $d2->format('d.m.y H:i:s');
$datee->modify(" -1 second");
$dateb = $dateb->format('Ymd H:i:s');
//echo $dateb->format("Y.m.d H:i:s");
$datee = $datee->format('Ymd H:i:s');*/

include($file_func);

$NULL       = "--";


$connectionInfo = array( "Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD);
$conn = sqlsrv_connect( $ServerName, $connectionInfo);

if( $conn ) 
{  
  $tsql = "SELECT * FROM Report WHERE (date_ between '{#dateb}' and '{#datee}') ORDER BY date_;";

  $tsql=str_replace("{#dateb}", $dateb, $tsql);
  $tsql=str_replace("{#datee}", $datee, $tsql); 

  $stmt = sqlsrv_query($conn, $tsql);
  
  if( $stmt === false) 
  {
    die( print_r( sqlsrv_errors(), true) );
  }
  $dDate            = array();
  $dDateD           = array();
  $date_Report		= array();
  $Aver_press       = array();
  $Aver_temp     	= array();
  $Accum_V_work	  	= array(); 
  $Accum_V_std	  	= array();
  
  $n 		 = 0;

  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) 
  {      
       /*$dDate[0]         = $row["dDateBegin"]->format("d.m.Y");
       $dDate[1]         = $row["dDateEnd"]->format("H.i.s");
       $dDate[2]         = $row["dDateBegin"]->format("d.m.Y");
       $dDate[3]         = $row["dDateEnd"]->format("H.i.s");
	   $dDateD[$n]       = $row["dCreateDate"]->format("H:i");*/
       $date_Report[$n]    	 = $row["date_"];
       $Aver_press[$n]  	 = $row["Aver_press"];
       $Aver_temp[$n]    	 = $row["Aver_temp"];
       $Accum_V_work[$n]     = $row["Accum_V_work"];
       $Accum_V_std[$n]      = $row["Accum_V_std"];
       
       $n                = $n + 1; 
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

		echo $param_1[0];

	?>

<TABLE align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">

	<TR align="center" BGCOLOR="#CCCCCC">
		<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Время</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Среднее давление&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Средняя температура&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Средний расх. в р.у.&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Средний расх. в ст.у.&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Накоп. V в р.у.&nbsp;</TD>
		<TD colspan="1" style="border-bottom:none;border-right:none">Накоп. V в ст.у.&nbsp;</TD>
	</TR>

	<TR align="center" BGCOLOR="#CCCCCC">
		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> С &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> м3/ч &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> м3/ч &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> м3 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> м3 &nbsp;</TD>
	</TR>


	
		<?php 
		$Itog_Aver_press	= 0;
		$Itog_Aver_temp  	= 0;
		$Itog_Accum_V_work  = 0;
		$Itog_Accum_V_std  	= 0;
		$count 				= 0; 
		?>
        
		<?php

			for ($nn = 0; $nn < $n; $nn++){ 
				echo '<TR align="center">';

					$Aver_com_work = (FormatEx($Accum_V_work[$nn], 	3, $NULL))/2;
					$Aver_com_std  = (FormatEx($Accum_V_std[$nn], 	3, $NULL))/2;

					echo '<TD style="border-bottom:none;border-right:none">' . $date_Report [$nn]->format("H:i:s") . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Aver_press[$nn], 	2, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Aver_temp[$nn], 	2, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Aver_com_work, 	3, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Aver_com_std, 	3, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Accum_V_work[$nn], 	3, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Accum_V_std[$nn], 	3, $NULL) . '</TD>';

				echo '</TR>'  ;

				$Itog_Aver_press = $Itog_Aver_press + FormatEx($Aver_press[$nn], 	2, $NULL);
				$Itog_Aver_temp = $Itog_Aver_temp + FormatEx($Aver_temp[$nn], 	2, $NULL);
				$Itog_Accum_V_work = $Itog_Accum_V_work + FormatEx($Accum_V_work[$nn], 	3, $NULL);
				$Itog_Accum_V_std = $Itog_Accum_V_std + FormatEx($Accum_V_std[$nn], 	3, $NULL);
				$count = $count + 1;
			}

		?>


	<TR align="center" BGCOLOR="#CCCCCC">
		<TD style="border-bottom:none;border-right:none"> Итог за сутки &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_Aver_press/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_Aver_temp/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_Accum_V_work/($count*2)), 	3, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_Accum_V_std/($count*2)), 	3, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx($Itog_Accum_V_work, 	3, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx($Itog_Accum_V_std, 	3, $NULL); ?> &nbsp;</TD>
	</TR>
	


</TABLE>

</CENTER>



                                                                                                                              



<font style="font size=12">
<br><br>
Сдал: _______________________&nbsp;(Ф.И.О.)  подпись: ______________________<p><br>
Принял: _____________________&nbsp;(Ф.И.О.)  подпись: ______________________
</font>          
