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
//$NumBIK     = $_POST["NumBIK"];
$file_func  = $_POST["file_func"];  
//$Sikn  	    = $_POST["SIKN"];  
$Owner 	    = $_POST["OWNER"];   
$Substance  = $_POST["substance"];  

 $type = "2"; 


$docdate  = $_POST["docdate"]; 

//echo $docdate;
//echo $descr;

include($file_func);

$NULL       = "--";


$connectionInfo = array( "Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD);
$conn = sqlsrv_connect( $ServerName, $connectionInfo);

if( $conn ) 
{  

  $tsql = "SELECT * FROM requisites WHERE (date_ between '{#dateb}' and '{#datee}') ORDER BY date_;";

  $tsql=str_replace("'{#dateb}'", $dateb, $tsql);
  $tsql=str_replace("'{#datee}'", $datee, $tsql); 
  //$tdescr=str_replace("'{#datee}'", $datee, $tsql);

  //echo $tsql;

  	$stmt = sqlsrv_query($conn, $tsql);

	if( $stmt === false) {
		die( print_r( sqlsrv_errors(), true) );
	}

	$id 	 		= array();
	$date_	 		= array();
	$date_e			= array();
	$time_measure	= array();
	$method			= array();
	$field	 		= array();
	$bush	 		= array();
	$well	 		= array();

	$dencity_gaz_std	 	= array();
	$dencity_w_std	 		= array();
	$dencity_o_std	 		= array();
	$water_cut_XAL	 		= array();
	$XAL_gaz_in_liq	 		= array();
	$XAL_liq_in_gaz	 		= array();

	$dencity_gaz_w	 	= array();
	$dencity_water_w	= array();
	$dencity_oil_w	 	= array(); 

	$debit_liq	 		= array(); 
	$debit_gaz_in_liq	= array(); 
	$debit_oil	 		= array(); 
	$debit_water	 	= array(); 
	$debit_gaz	 		= array(); 
	$debit_liq_in_gaz	= array();

	$dencity_gaz_std	= array();
	$dencity_w_std	 	= array();
	$dencity_o_std	 	= array();
	$water_cut_XAL	 	= array();
	$XAL_gaz_in_liq	 	= array();
	$XAL_liq_in_gaz	 	= array();

	$PT100_aver			= array();
	$PT500_aver			= array();
	$PT300_aver			= array();
	$TT700_aver			= array();
	$PDT200_aver		= array();
	$TT300_aver			= array();

	$P_Flowsic_aver							= array();
	$T_Flowsic_aver							= array();
	$Vol_flow_rate_at_standart_aver			= array();
	$Vol_flow_rate_at_actual_aver			= array();

	$diff_liq							= array();
	$Dencity_w	 		= array();
	$Liq_vol	 		= array();
	$dryness	 		= array();
	$diff_gaz	 		= array();


	$n = 0;

	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

		$date1 = $row["date_"]->format("d.m.y");
		$id1 = $row["id"];
		//echo $date1;
		$tdescr = "Замер от Date № id";
		$tdescr=str_replace("Date", $date1, $tdescr);
		$tdescr=str_replace("id", $id1, $tdescr);
		//echo $descr1;
		//echo $tdescr;


		if($tdescr == $descr1){

			$id[$n] 	= $row["id"];
			$date_[$n] = $row["date_"];
			$date_e[$n] = $row["date_e"];
			$time_measure[$n] = $row["time_measure"];
			$method[$n] = $row["method"];
			$field[$n] = iconv("windows-1251", "utf-8", $row["field"]);
			$bush[$n] = iconv("windows-1251", "utf-8", $row["bush"]);
			$well[$n] = iconv("windows-1251", "utf-8", $row["well"]);

			$dencity_gaz_std[$n] = $row["dencity_gaz_std"];
			$dencity_w_std[$n] = $row["dencity_w_std"];
			$dencity_o_std[$n] = $row["dencity_o_std"];
			$water_cut_XAL[$n] = $row["water_cut_XAL"];
			$XAL_gaz_in_liq[$n] = $row["XAL_gaz_in_liq"];
			$XAL_liq_in_gaz[$n] = $row["XAL_liq_in_gaz"];

			$dencity_gaz_w[$n] = $row["dencity_gaz_w"];
			$dencity_water_w[$n] = $row["dencity_water_w"];
			$dencity_oil_w[$n] = $row["dencity_oil_w"];

			$debit_liq[$n] = $row["debit_liq"];
			$debit_gaz_in_liq[$n] = $row["debit_gaz_in_liq"];
			$debit_oil[$n] = $row["debit_oil"];
			$debit_water[$n] = $row["debit_water"];
			$debit_gaz[$n] = $row["debit_gaz"];
			$debit_liq_in_gaz[$n] = $row["debit_liq_in_gaz"];

			$dencity_gaz_std[$n] = $row["dencity_gaz_std"];
			$dencity_w_std[$n] = $row["dencity_w_std"];
			$dencity_o_std[$n] = $row["dencity_o_std"];
			$water_cut_XAL[$n] = $row["water_cut_XAL"];
			$XAL_gaz_in_liq[$n] = $row["XAL_gaz_in_liq"];
			$XAL_liq_in_gaz[$n] = $row["XAL_liq_in_gaz"];

			$PT100_aver[$n] = $row["PT100_aver"];
			$PT500_aver[$n] = $row["PT500_aver"];
			$PT300_aver[$n] = $row["PT300_aver"];
			$TT700_aver[$n] = $row["TT700_aver"];
			$PDT200_aver[$n] = $row["PDT200_aver"];
			$TT300_aver[$n] = $row["TT300_aver"];

			$P_Flowsic_aver[$n] 				= $row["P_Flowsic_aver"];
			$T_Flowsic_aver[$n] 				= $row["T_Flowsic_aver"];
			$Vol_flow_rate_at_standart_aver[$n] = $row["Vol_flow_rate_at_standart_aver"];
			$Vol_flow_rate_at_actual_aver[$n] 	= $row["Vol_flow_rate_at_actual_aver"];

			$diff_liq[$n] 				= $row["diff_liq"];
			$Dencity_w[$n] 				= $row["Dencity_w"];
			$Liq_vol[$n] 				= $row["Liq_vol"];
			$dryness[$n] 				= $row["dryness"];
			$diff_gaz[$n] 				= $row["diff_gaz"];

			$n                = $n + 1;

		}

	}

	//echo $n;


	sqlsrv_free_stmt($stmt);
}   	
 	 

//echo $loading_time[0];

?>



<CENTER>

	<TABLE align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="4" style="border-bottom:none;border-right:none">&nbsp;Блок идентификационных параметров скважины</TD>
			<TD rowspan="1" colspan="5" style="border-bottom:none;border-right:none">&nbsp;Блок идентификационных данных измерения</TD>
			<TD rowspan="1" colspan="6" style="border-bottom:none;border-right:none">&nbsp;Блок параметров по скважине, вводимых оператором</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Дата замера</TD>
			<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Месторождение</TD>
			<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Куст</TD>
			<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Скважина</TD>

			<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;id</TD>
			<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Время старта</TD>
			<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Время окончания</TD>
			<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Время измерения, с</TD>
			<TD rowspan="2" style="border-bottom:none;border-right:none">&nbsp;Расчет</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность газа СУ</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность воды СУ</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность конденсата СУ</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;W_ХАЛ</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ХАЛ. Содержание газа в жидкости</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ХАЛ. Содержание жидкости в газе</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг/м³</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг/м³</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг/м³</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;%об.</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;-</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;-</TD>
		</TR>

		<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . $date_[$nn]->format("Y-m-d H:i:s") . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $field[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $bush[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $well[$nn] . '</TD>';

						echo '<TD style="border-bottom:none;border-right:none">' . $id[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $date_[$nn]->format("Y-m-d H:i:s") . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $date_e[$nn]->format("Y-m-d H:i:s") . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $time_measure[$nn] . '</TD>';
						if($method[$nn] == 1){
							$method[$nn] = "По влагомеру";
						}elseif($method[$nn] == 2){
							$method[$nn] = "По ХАЛ";
						}else{
							$method[$nn] = "---";
						}
						echo '<TD style="border-bottom:none;border-right:none">' . $method[$nn] . '</TD>';

						echo '<TD style="border-bottom:none;border-right:none">' . $dencity_gaz_std[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $dencity_w_std[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $dencity_o_std[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $water_cut_XAL[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $XAL_gaz_in_liq[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $XAL_liq_in_gaz[$nn] . '</TD>';

					echo '</TR>'  ;
				}

			?>

	</TABLE>

</br>

	<TABLE align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="3" style="border-bottom:none;border-right:none">&nbsp;Приведенные плотности</TD>
			<TD rowspan="1" colspan="6" style="border-bottom:none;border-right:none">&nbsp;Общие технологические параметры установки при измерении</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность газа РУ</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность воды РУ</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность конденсата РУ</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давление входа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давление выхода</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давление сепаратора</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Температура газа в сепараторе</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Перепад давлений на фильтре</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Температура жидкости в сепараторе</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг/м³</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг/м³</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг/м³</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;МПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;МПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;МПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;°С</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp; °С</TD>

		</TR>

	     
			<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($dencity_gaz_w[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($dencity_water_w[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($dencity_oil_w[$nn], 	2, $NULL) . '</TD>';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PT100_aver[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PT500_aver[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PT300_aver[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TT700_aver[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PDT200_aver[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TT300_aver[$nn], 	2, $NULL) . '</TD>';

					echo '</TR>'  ;
				}

			?>

	</TABLE>

</br>

	<TABLE align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="5" style="border-bottom:none;border-right:none">&nbsp;Блок параметров по газовой линии, связанных с работой и расчетом по ултразвуковому расходомеру - FLOWSIC</TD>
			<TD rowspan="1" colspan="5" style="border-bottom:none;border-right:none">&nbsp;Результаты измерения кориолисовым расходомером жидкости ROTAMASS</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давление в линии газа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Температура в линии газа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит газа FLOWSIC</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит газа FLOWSIC</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Коэффииент сжимаемости</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит жидкости ROTAMASS</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Масса жидкости ROTAMASS</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность жидкости ROTAMASS</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;МПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp; °С</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;м³/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ст.м³/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp; кг/м³</TD>
		</TR>

		<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($P_Flowsic_aver[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($T_Flowsic_aver[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Vol_flow_rate_at_standart_aver[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Vol_flow_rate_at_actual_aver[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">-</TD>';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($debit_liq[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($diff_liq[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Dencity_w[$nn], 	2, $NULL) . '</TD>';

					echo '</TR>'  ;
				}

			?>

	</TABLE>

</br>

	<TABLE align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="2" style="border-bottom:none;border-right:none">&nbsp;Влагомер</TD>
			<TD rowspan="1" colspan="6" style="border-bottom:none;border-right:none">&nbsp;Блок ОСНОВНЫХ результатов по скважине</TD>
			<TD rowspan="1" colspan="1" style="border-bottom:none;border-right:none">&nbsp;Дополнительные результаты по измерению газа</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Обводненность об</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Обводненность масс</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит жидкости</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит газа в жидкости</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит конденсата</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит воды</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит газа СУ</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит жидкости в газе</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Объём газа СУ</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;%</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;%</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ст.м³/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ст.м³/сут</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ст.м³</TD>
		</TR>

		<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Liq_vol[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($dryness[$nn], 	2, $NULL) . '</TD>';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($debit_liq[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($debit_gaz_in_liq[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($debit_oil[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($debit_water[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($debit_gaz[$nn], 	2, $NULL) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($debit_liq_in_gaz[$nn], 	2, $NULL) . '</TD>';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($diff_gaz[$nn], 	2, $NULL) . '</TD>';

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

