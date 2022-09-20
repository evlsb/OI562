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
  $tsql = "SELECT * FROM operativ_2h WHERE (date_ between '{#dateb}' and '{#datee}') ORDER BY date_;";

  $tsql=str_replace("{#dateb}", $dateb, $tsql);
  $tsql=str_replace("{#datee}", $datee, $tsql); 

  $stmt = sqlsrv_query($conn, $tsql);
  
  if( $stmt === false) 
  {
    die( print_r( sqlsrv_errors(), true) );
  }
  $dDate            = array();
  $TT100            = array();
  $PT100            = array();
  $PT201            = array();
  $PDT200           = array();
  $PT202            = array();
  $PT300            = array();
  $LT300            = array();
  $TT300            = array();
  $TT500            = array();
  $PT500            = array();
  $TT700            = array();
  $PT700            = array();
  $P_Flowsic            = array();
  $T_Flowsic            = array();
  $FT_Flowsic           = array();
  $Accum_Flowsic        = array();
  $P_Rotmass        	= array();
  $T_Rotmass        	= array();
  $FT_Rotmass       	= array();
  $Accum_Rotmass        = array();
  $AT_Rotmass        	= array();
  $Den_Rotmass        	= array();
  
  $n 		 = 0;


  

$descr2 = '';
  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) 
  {      
 
	//eval("\$descr2 = \"$descr\";");
	//echo $descr;

	//if ($descr1 == $descr2) {
       /*$dDate[0]         = $row["dDateBegin"]->format("d.m.Y");
       $dDate[1]         = $row["dDateEnd"]->format("H.i.s");
       $dDate[2]         = $row["dDateBegin"]->format("d.m.Y");
       $dDate[3]         = $row["dDateEnd"]->format("H.i.s");
	   $dDateD[$n]       = $row["dCreateDate"]->format("H:i");*/
	   $date_[$n] 		= $row["date_"];
       $TT100[$n]    	= $row["TT100"];
       $PT100[$n]  	 	= $row["PT100"];
       $PT201[$n]  	 	= $row["PT201"];
       $PDT200[$n]  	= $row["PDT200"];
       $PT202[$n]  	 	= $row["PT202"];
       $PT300[$n]  	 	= $row["PT300"];
       $LT300[$n]  	 	= $row["LT300"];
       $TT300[$n]  	 	= $row["TT300"];
       $TT500[$n]  	 	= $row["TT500"];
       $PT500[$n]  	 	= $row["PT500"];
       $TT700[$n]  	 	= $row["TT700"];
       $PT700[$n]  	 	= $row["PT700"];
       $P_Flowsic[$n]  	 	= $row["P_Flowsic"];
       $T_Flowsic[$n]  	 	= $row["T_Flowsic"];
       $FT_Flowsic[$n]  	= $row["FT_Flowsic"];
       $Accum_Flowsic[$n]  	= $row["Accum_Flowsic"];

       $P_Rotmass[$n]  		= $row["P_Rotmass"];
       $T_Rotmass[$n]  		= $row["T_Rotmass"];
       $FT_Rotmass[$n]  	= $row["FT_Rotmass"];
       $Accum_Rotmass[$n]  	= $row["Accum_Rotmass"];
       $AT_Rotmass[$n]  	= $row["AT_Rotmass"];
       $Den_Rotmass[$n]  	= $row["Den_Rotmass"];

       
       $n                = $n + 1; 
    //}
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
		<TD rowspan="3" style="border-bottom:none;border-right:none"> Время &nbsp;</TD>
		<TD rowspan="1" colspan="2" style="border-bottom:none;border-right:none">&nbsp;Входной коллектор</TD>
		<TD rowspan="1" colspan="3" style="border-bottom:none;border-right:none">&nbsp;Насос Н-1</TD>
		<TD rowspan="1" colspan="1" style="border-bottom:none;border-right:none">&nbsp;ГС-1</TD>
		<TD rowspan="1" colspan="2" style="border-bottom:none;border-right:none">&nbsp;E-1</TD>
		<TD rowspan="1" colspan="2" style="border-bottom:none;border-right:none">&nbsp;Выходной коллектор жидкости</TD>
		<TD rowspan="1" colspan="2" style="border-bottom:none;border-right:none">&nbsp;Выходной коллектор газа</TD>
		<TD rowspan="1" colspan="4" style="border-bottom:none;border-right:none">&nbsp;Flowsic</TD>
		<TD rowspan="1" colspan="6" style="border-bottom:none;border-right:none">&nbsp;ROTAMASS</TD>
	</TR>

	<TR align="center" BGCOLOR="#CCCCCC">
		<TD style="border-bottom:none;border-right:none"> TT100 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> PT100 &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> PT201 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> PDT200 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> PT202 &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> PT300 &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> LT300 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> TT300 &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> TT500 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> PT500 &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> TT700 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> PT700 &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> PT &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> TT &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> FT &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> Q &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> PT &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> TT &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> FT &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> Q &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> AT &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> ρ &nbsp;</TD>
	</TR>

	<TR align="center" BGCOLOR="#CCCCCC">
		<TD style="border-bottom:none;border-right:none"> °С &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> кг/см2 &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> см &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> °С &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> °С &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> °С &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> °С &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> ст.м³/сут &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> ст.м³ &nbsp;</TD>

		<TD style="border-bottom:none;border-right:none"> МПа &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> °С &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> т/сут &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> т &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> % &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> кг/м³ &nbsp;</TD>
	</TR>
	
		
		<?php 
			$Itog_TT100					= 0;
			$Itog_PT100					= 0;
			$Itog_PT201  				= 0;
			$Itog_PDT200  				= 0;
			$Itog_PT202  				= 0;
			$Itog_PT300 				= 0; 
			$Itog_LT300 				= 0;
			$Itog_TT300  				= 0;
			$Itog_TT500 				= 0;
			$Itog_PT500 				= 0; 
			$Itog_TT700 				= 0;
			$Itog_PT700					= 0;
			$Itog_P_Flowsic 			= 0; 
			$Itog_T_Flowsic 			= 0;
			$Itog_FT_Flowsic 			= 0;
			$Itog_Accum_Flowsic 		= 0;
			$Itog_P_Rotmass 			= 0;
			$Itog_T_Rotmass 			= 0;
			$Itog_FT_Rotmass 			= 0;
			$Itog_Accum_Rotmass 		= 0;
			$Itog_AT_Rotmass 			= 0;
			$Itog_Den_Rotmass 			= 0;
		?>
        
        
		<?php

			for ($nn = 0; $nn < $n; $nn++){ 
				echo '<TR align="center">';

					//echo '<TD style="border-bottom:none;border-right:none">' . $date_KMH [$nn]->format("H:i:s") . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $date_[$nn]->format("H:i:s") . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $TT100[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $PT100[$nn] . '</TD>';

					echo '<TD style="border-bottom:none;border-right:none">' . $PT201[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $PDT200[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $PT202[$nn] . '</TD>';

					echo '<TD style="border-bottom:none;border-right:none">' . $PT300[$nn] . '</TD>';

					echo '<TD style="border-bottom:none;border-right:none">' . $LT300[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $TT300[$nn] . '</TD>';

					echo '<TD style="border-bottom:none;border-right:none">' . $TT500[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $PT500[$nn] . '</TD>';

					echo '<TD style="border-bottom:none;border-right:none">' . $TT700[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $PT700[$nn] . '</TD>';

					echo '<TD style="border-bottom:none;border-right:none">' . $P_Flowsic[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $T_Flowsic[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $FT_Flowsic[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $Accum_Flowsic[$nn] . '</TD>';

					echo '<TD style="border-bottom:none;border-right:none">' . $P_Rotmass[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $T_Rotmass[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $FT_Rotmass[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $Accum_Rotmass[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $AT_Rotmass[$nn] . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . $Den_Rotmass[$nn] . '</TD>';
		

				echo '</TR>'  ;


				$Itog_TT100 = $Itog_TT100 + FormatEx($TT100[$nn], 	2, $NULL);
				$Itog_PT100 = $Itog_PT100 + FormatEx($PT100[$nn], 	2, $NULL);
				$Itog_PT201 = $Itog_PT201 + FormatEx($PT201[$nn], 	1, $NULL);
				$Itog_PDT200 = $Itog_PDT200 + FormatEx($PDT200[$nn], 	1, $NULL);
				$Itog_PT202 = $Itog_PT202 + FormatEx($PT202[$nn], 	1, $NULL);
				$Itog_PT300 = $Itog_PT300 + FormatEx($PT300[$nn], 	1, $NULL);
				$Itog_LT300 = $Itog_LT300 + FormatEx($LT300[$nn], 	1, $NULL);
				$Itog_TT300 = $Itog_TT300 + FormatEx($TT300[$nn], 	1, $NULL);
				$Itog_TT500 = $Itog_TT500 + FormatEx($TT500[$nn], 	1, $NULL);
				$Itog_PT500 = $Itog_PT500 + FormatEx($PT500[$nn], 	1, $NULL);
				$Itog_TT700 = $Itog_TT700 + FormatEx($TT700[$nn], 	1, $NULL);
				$Itog_PT700 = $Itog_PT700 + FormatEx($PT700[$nn], 	1, $NULL);
				$Itog_P_Flowsic = $Itog_P_Flowsic + FormatEx($P_Flowsic[$nn], 	1, $NULL);
				$Itog_T_Flowsic = $Itog_T_Flowsic + FormatEx($T_Flowsic[$nn], 	1, $NULL);
				$Itog_FT_Flowsic = $Itog_FT_Flowsic + FormatEx($FT_Flowsic[$nn], 	1, $NULL);
				$Itog_Accum_Flowsic = $Itog_Accum_Flowsic + FormatEx($Accum_Flowsic[$nn], 	1, $NULL);
				$Itog_P_Rotmass = $Itog_P_Rotmass + FormatEx($P_Rotmass[$nn], 	1, $NULL);
				$Itog_T_Rotmass = $Itog_T_Rotmass + FormatEx($T_Rotmass[$nn], 	1, $NULL);
				$Itog_FT_Rotmass = $Itog_FT_Rotmass + FormatEx($FT_Rotmass[$nn], 	1, $NULL);
				$Itog_Accum_Rotmass = $Itog_Accum_Rotmass + FormatEx($Accum_Rotmass[$nn], 	1, $NULL);
				$Itog_AT_Rotmass = $Itog_AT_Rotmass + FormatEx($AT_Rotmass[$nn], 	1, $NULL);
				$Itog_Den_Rotmass = $Itog_Den_Rotmass + FormatEx($Den_Rotmass[$nn], 	1, $NULL);

				$count = $count + 1;
			}

		?>
	
	<TR align="center" BGCOLOR="#CCCCCC">
		<TD style="border-bottom:none;border-right:none"> Итог за сутки &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TT100/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_PT100/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_PT201/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_PDT200/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_PT202/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_PT300/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_LT300/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TT300/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TT500/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_PT500/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TT700/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_PT700/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_P_Flowsic/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_T_Flowsic/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_FT_Flowsic/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_Accum_Flowsic), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_P_Rotmass/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_T_Rotmass/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_FT_Rotmass/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_Accum_Rotmass), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_AT_Rotmass/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_Den_Rotmass/$count), 	2, $NULL); ?> &nbsp;</TD>
		

		
	</TR>


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