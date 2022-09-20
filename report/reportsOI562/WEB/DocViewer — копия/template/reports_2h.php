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
  $tsql = "SELECT * FROM NGS_GS_TO WHERE (date_ between '{#dateb}' and '{#datee}') ORDER BY date_;";

  $tsql=str_replace("{#dateb}", $dateb, $tsql);
  $tsql=str_replace("{#datee}", $datee, $tsql); 

  $stmt = sqlsrv_query($conn, $tsql);
  
  if( $stmt === false) 
  {
    die( print_r( sqlsrv_errors(), true) );
  }
  $dDate            		= array();
  $dDateD           		= array();
  $date_Report				= array();
  $Press_inMUPN				= array();
  $NGS1_Press      			= array();
  $NGS1_Temp     			= array();
  $NGS1_Level	  			= array(); 
  $GS1_Press	  			= array();
  $GS1_Temp					= array();
  $GS1_Level        		= array();
  $TO11_T_Oil_in     		= array();
  $TO11_T_Oil_out	  		= array(); 
  $TO11_T_Liq_in			= array();
  $TO11_P_Liq_in			= array();
  $TO11_T_Liq_out     		= array();
  $TO11_P_Liq_out     		= array();
  
  $n 		 = 0;

  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) 
  {      
       /*$dDate[0]         = $row["dDateBegin"]->format("d.m.Y");
       $dDate[1]         = $row["dDateEnd"]->format("H.i.s");
       $dDate[2]         = $row["dDateBegin"]->format("d.m.Y");
       $dDate[3]         = $row["dDateEnd"]->format("H.i.s");
	   $dDateD[$n]       = $row["dCreateDate"]->format("H:i");*/
       $date_Report[$n]    		 	= $row["date_"];
       $Press_inMUPN[$n]  	 		= $row["Press_inMUPN"];
       $NGS1_Press[$n]    		    = $row["NGS1_Press"];
       $NGS1_Temp[$n]     			= $row["NGS1_Temp"];
       $NGS1_Level[$n]     		    = $row["NGS1_Level"];
       $GS1_Press[$n]  	 			= $row["GS1_Press"];
       $GS1_Level[$n]     			= $row["GS1_Level"];
       $GS1_Temp[$n]    			= $row["GS1_Temp"];
       $TO11_T_Oil_in[$n]      		= $row["TO11_T_Oil_in"];
       $TO11_T_Oil_out[$n]  		= $row["TO11_T_Oil_out"];
       $TO11_T_Liq_in[$n]   		= $row["TO11_T_Liq_in"];
       $TO11_P_Liq_in[$n]    		= $row["TO11_P_Liq_in"];
       $TO11_T_Liq_out[$n]     		= $row["TO11_T_Liq_out"];
       $TO11_P_Liq_out[$n]  		= $row["TO11_P_Liq_out"];
       $TO12_T_Oil_in[$n]      		= $row["TO12_T_Oil_in"];
       $TO12_T_Oil_out[$n]  		= $row["TO12_T_Oil_out"];
       $TO12_T_Liq_in[$n]   		= $row["TO12_T_Liq_in"];
       $TO12_P_Liq_in[$n]    		= $row["TO12_P_Liq_in"];
       $TO12_T_Liq_out[$n]     		= $row["TO12_T_Liq_out"];
       $TO12_P_Liq_out[$n]  		= $row["TO12_P_Liq_out"];

       
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
<BR>

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
		<TD rowspan="2" colspan="1" style="border-bottom:none;border-right:none">&nbsp;Время</TD>
		<TD rowspan="1" colspan="1" style="border-bottom:none;border-right:none">&nbsp;Вход МУПН</TD>
		<TD rowspan="1" colspan="3" style="border-bottom:none;border-right:none">НГС-1&nbsp;</TD>
		<TD rowspan="1" colspan="3" style="border-bottom:none;border-right:none">ГС-1&nbsp;</TD>
		<TD rowspan="1" colspan="6" colspan="4" style="border-bottom:none;border-right:none">ТО-1/1&nbsp;</TD>
		<TD rowspan="1" colspan="6" colspan="4" style="border-bottom:none;border-right:none">ТО-1/2&nbsp;</TD>
	</TR>

	<TR align="center" BGCOLOR="#CCCCCC">
		<TD rowspan="1" style="border-bottom:none;border-right:none">P, МПа&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">P, МПа&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">T, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">L, мм &nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">P, МПа&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">T, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">L, мм &nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Tн вх, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Tн вых, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Tж вх, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Pж вх, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Tж вых, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Pж вых, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Tн вх, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Tн вых, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Tж вх, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Pж вх, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Tж вых, C&nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none">Pж вых, C&nbsp;</TD>
	</TR>

	<!--<TR align="center" BGCOLOR="#CCCCCC">
		<TD rowspan="1" style="border-bottom:none;border-right:none"> м3 &nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none"> м3 &nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none"> м3/ч &nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none"> м3/ч &nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none"> м3 &nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none"> м3 &nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none"> м3/ч &nbsp;</TD>
		<TD rowspan="1" style="border-bottom:none;border-right:none"> м3/ч &nbsp;</TD>
	</TR>-->

	
		<?php 
		$Itog_Press_inMUPN				= 0;
		$Itog_NGS1_Press  				= 0;
		$Itog_NGS1_Temp  				= 0;
		$Itog_NGS1_Level  				= 0;
		$Itog_GS1_Press 				= 0; 
		$Itog_GS1_Level 				= 0;
		$Itog_GS1_Temp  				= 0;
		$Itog_TO11_T_Oil_in  			= 0;
		$Itog_TO11_T_Oil_out 			= 0; 
		$Itog_TO11_T_Liq_in 			= 0;
		$Itog_TO11_TO11_P_Liq_in  		= 0;
		$Itog_TO11_T_Liq_out 			= 0; 
		$Itog_TO11_P_Liq_out 			= 0;
		$Itog_TO12_T_Oil_in  			= 0;
		$Itog_TO12_T_Oil_out 			= 0; 
		$Itog_TO12_T_Liq_in 			= 0;
		$Itog_TO12_TO11_P_Liq_in  		= 0;
		$Itog_TO12_T_Liq_out 			= 0; 
		$Itog_TO12_P_Liq_out 			= 0;
		?>
        
		<?php

			for ($nn = 0; $nn < $n; $nn++){ 
				echo '<TR align="center">';

					/*$Aver_com_work = (FormatEx($Accum_V_work[$nn], 	3, $NULL))/2;
					$Aver_com_std  = (FormatEx($Accum_V_std[$nn], 	3, $NULL))/2;*/




					echo '<TD style="border-bottom:none;border-right:none">' . $date_Report [$nn]->format("H:i:s") . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Press_inMUPN[$nn], 	2, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($NGS1_Press[$nn], 	2, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($NGS1_Temp[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($NGS1_Level[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($GS1_Press[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($GS1_Level[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($GS1_Temp[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO11_T_Oil_in[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO11_T_Oil_out[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO11_T_Liq_in[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO11_P_Liq_in[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO11_T_Liq_out[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO11_P_Liq_out[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO12_T_Oil_in[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO12_T_Oil_out[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO12_T_Liq_in[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO12_P_Liq_in[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO12_T_Liq_out[$nn], 	1, $NULL) . '</TD>';
					echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TO12_P_Liq_out[$nn], 	1, $NULL) . '</TD>';

				echo '</TR>'  ;

				$Itog_Press_inMUPN = $Itog_Press_inMUPN + FormatEx($Press_inMUPN[$nn], 	2, $NULL);
				$Itog_NGS1_Press = $Itog_NGS1_Press + FormatEx($NGS1_Press[$nn], 	2, $NULL);
				$Itog_NGS1_Temp = $Itog_NGS1_Temp + FormatEx($NGS1_Temp[$nn], 	1, $NULL);
				$Itog_NGS1_Level = $Itog_NGS1_Level + FormatEx($NGS1_Level[$nn], 	1, $NULL);
				$Itog_GS1_Press = $Itog_GS1_Press + FormatEx($GS1_Press[$nn], 	1, $NULL);
				$Itog_GS1_Level = $Itog_GS1_Level + FormatEx($GS1_Level[$nn], 	1, $NULL);
				$Itog_GS1_Temp = $Itog_GS1_Temp + FormatEx($GS1_Temp[$nn], 	1, $NULL);
				$Itog_TO11_T_Oil_in = $Itog_TO11_T_Oil_in + FormatEx($TO11_T_Oil_in[$nn], 	1, $NULL);
				$Itog_TO11_T_Oil_out = $Itog_TO11_T_Oil_out + FormatEx($TO11_T_Oil_out[$nn], 	1, $NULL);
				$Itog_TO11_T_Liq_in = $Itog_TO11_T_Liq_in + FormatEx($TO11_T_Liq_in[$nn], 	1, $NULL);
				$Itog_TO11_P_Liq_in = $Itog_TO11_P_Liq_in + FormatEx($TO11_P_Liq_in[$nn], 	1, $NULL);
				$Itog_TO11_T_Liq_out = $Itog_TO11_T_Liq_out + FormatEx($TO11_T_Liq_out[$nn], 	1, $NULL);
				$Itog_TO11_P_Liq_out = $Itog_TO11_P_Liq_out + FormatEx($TO11_P_Liq_out[$nn], 	1, $NULL);
				$Itog_TO12_T_Oil_in = $Itog_TO12_T_Oil_in + FormatEx($TO12_T_Oil_in[$nn], 	1, $NULL);
				$Itog_TO12_T_Oil_out = $Itog_TO12_T_Oil_out + FormatEx($TO12_T_Oil_out[$nn], 	1, $NULL);
				$Itog_TO12_T_Liq_in = $Itog_TO12_T_Liq_in + FormatEx($TO12_T_Liq_in[$nn], 	1, $NULL);
				$Itog_TO12_P_Liq_in = $Itog_TO12_P_Liq_in + FormatEx($TO12_P_Liq_in[$nn], 	1, $NULL);
				$Itog_TO12_T_Liq_out = $Itog_TO12_T_Liq_out + FormatEx($TO12_T_Liq_out[$nn], 	1, $NULL);
				$Itog_TO12_P_Liq_out = $Itog_TO12_P_Liq_out + FormatEx($TO12_P_Liq_out[$nn], 	1, $NULL);
				$count = $count + 1;
			}

		?>


	<TR align="center" BGCOLOR="#CCCCCC">
		<TD style="border-bottom:none;border-right:none"> Итог за сутки &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_Press_inMUPN/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_NGS1_Press/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_NGS1_Temp/$count), 	1, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_NGS1_Level/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_GS1_Press/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_GS1_Level/$count), 	1, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_GS1_Temp/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO11_T_Oil_in/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO11_T_Oil_out/$count), 	1, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO11_T_Liq_in/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO11_P_Liq_in/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO11_T_Liq_out/$count), 	1, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO11_P_Liq_out/$count), 	1, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO12_T_Oil_in/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO12_T_Oil_out/$count), 	1, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO12_T_Liq_in/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO12_P_Liq_in/$count), 	2, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO12_T_Liq_out/$count), 	1, $NULL); ?> &nbsp;</TD>
		<TD style="border-bottom:none;border-right:none"> <?php echo FormatEx(($Itog_TO12_P_Liq_out/$count), 	1, $NULL); ?> &nbsp;</TD>
		
		
	</TR>


</TABLE>

</CENTER>



                                                                                                                              



<font style="font size=12">
<br><br>
Сдал: _______________________&nbsp;(Ф.И.О.)  подпись: ______________________<p><br>
Принял: _____________________&nbsp;(Ф.И.О.)  подпись: ______________________
</font>          
