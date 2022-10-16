<?php

	$dateb      = $_POST["dateb"];
	$datee      = $_POST["datee"];
	$descr      = $_POST["descr"];
	$descr1     = $_POST["descr1"];
	$docdate    = $_POST["docdate"];
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

  		$tsql = "SELECT * FROM Zamer_01 WHERE (date_time between '{#dateb}' and '{#datee}') ORDER BY date_time;";


  		$tsql=str_replace("'{#dateb}'", $dateb, $tsql);
  		$tsql=str_replace("'{#datee}'", $datee, $tsql); 

  		//echo $tsql;

  		$stmt = sqlsrv_query($conn, $tsql);

  		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}

		$id 	 						= array();
		$date_	 						= array();
		$date_e							= array();
		$field	 						= array();
		$bush	 						= array();
		$well	 						= array();

		$time_measure					= array();
		$rejim							= array();
		$method							= array();

		$Dol_mech_prim_Read				= array();
		$Konc_hlor_sol_Read				= array();
		$Dol_ras_gaz_Read				= array();
		$vlaj_oil_Read					= array();
		$Dol_ras_gaz_mass				= array();
		$Dens_gaz_KGN					= array();

		$Mass_brutto_Accum				= array();
		$Mass_netto_Accum				= array();
		$Volume_Count_Forward_sc_Accum	= array();
		$Mg_GK							= array();
		$Vg_GK							= array();
		$Mass_Gaz_UVP_Accum				= array();
		$WC5_Accum						= array();
		$Mass_water_UIG_Accum			= array();
		$Mass_KG						= array();
		$V_KG							= array();

		$Debit_liq						= array();
		$Debit_gas_in_liq				= array();
		$Debit_V_gas_in_liq				= array();
		$Debit_cond						= array();
		$Debit_water					= array();
		$Debit_gaz						= array();
		$Debit_KG						= array();

		$Clean_Gaz						= array();
		$Clean_Cond						= array();
		$V_Gaz							= array();
		$V_Cond							= array();
		$V_Water						= array();

		$TT100							= array();
		$PT100							= array();
		$PT201							= array();
		$PDT200							= array();
		$PT202							= array();
		$PT300							= array();
		$LT300							= array();
		$TT300							= array();
		$TT500							= array();
		$PT500							= array();
		$TT700							= array();
		$PT700							= array();

		$FS_P							= array();
		$FS_T							= array();
		$FS_Qw							= array();
		$FS_Qs							= array();
		$RT_Dens						= array();
		$RT_Vlaj						= array();

		$Wm_After						= array();
		$Wv_After						= array();

		//Блок параметров по скважине, вводимых оператором
		$OW_M_GD						= array();
		$OW_Dens_GD						= array();
		$OW_V_PO						= array();
		$OW_m_ZO						= array();
		$OW_Dens_SK						= array();
		$OW_m_PROB						= array();

		//Расчет из данных "блока параметров по скважине, вводимых оператором"
		$OR_m_RG						= array();
		$OR_W_RG						= array();

		$n = 0;


				function Convert_string($str_r){

					$arr_num = array();
					$type = 0;
					$ret;

					for($i = 0; $i < strlen($str_r); $i++){

						$arr_num[$i] = $str_r[$i];

						if($arr_num[$i] == "E"){
							$type = 1;
							$E = explode("E-", $str_r);
							$ret = "0.";
							for($p = 1; $p < $E[1]; $p++){
								$ret = $ret."0";
							}
							$ret = $ret.$str_r[0].$str_r[2].$str_r[3];
							return $ret;
						}

					}


					if ($type <> 1) {
						//echo "df";
						for ($r=0; $r < strlen($str_r); $r++) { 
							if ($arr_num[$r] == ",") {
								$type = 2;
								$E = explode(",", $str_r);
								$len = 3 - strlen($E[1]);
								if($len <= 0){
									$ret = $E[0].".".$E[1][0].$E[1][1].$E[1][2];
								}elseif ($len == 1) {
									$ret = $E[0].".".$E[1][0].$E[1][1]."0";
								}elseif ($len == 2) {
									$ret = $E[0].".".$E[1][0]."0"."0";
								}
								
								return $ret;
							}
						}
					}


					if($type <> 1 AND $type <> 2){
						$ret = $str_r.".000";
						return $ret;
					}


			}


		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$date1 = $row["date_time"]->format("d.m.y");
			$id1 = $row["id"];
			$tdescr = "Замер от Date № id";
			$tdescr=str_replace("Date", $date1, $tdescr);
			$tdescr=str_replace("id", $id1, $tdescr);	

			if($tdescr == $descr1){

				$id[$n] 			= $row["id"];
				$date_[$n] 			= $row["date_time"];
				$date_e[$n] 		= $row["date_time2"];
				$field[$n] 			= iconv("windows-1251", "utf-8", $row["Field"]);	//Месторождение
				$bush[$n] 			= iconv("windows-1251", "utf-8", $row["Bush"]);
				$well[$n]			= iconv("windows-1251", "utf-8", $row["Well"]);

				$time_measure[$n] 	= $row["Time_m"];

				if($row["Rejim"] == 1){
					$rejim[$n] = "проточный";
				}elseif ($row["Rejim"] == 2) {
					$rejim[$n] = "с накоплением/сливом";
				}

				if($row["Method_obv"] == 1){
					$method[$n] = "по влагомеру";
				}elseif ($row["Method_obv"] == 2) {
					$method[$n] = "по данным ХАЛ";
				}elseif ($row["Method_obv"] == 3) {
					$method[$n] = "без расчета";
				}elseif ($row["Method_obv"] == 4) {
					$method[$n] = "по плотномеру";
				}  


				$Dol_mech_prim_Read[$n]	 			= $row["Dol_mech_prim_Read"];				//Доля механических примесей
				$Konc_hlor_sol_Read[$n]	 			= $row["Konc_hlor_sol_Read"];				//Концентрация хлористых солей
				$Dol_ras_gaz_Read[$n]	 			= $row["Dol_ras_gaz_Read"];					//Доля растворенного газа
				$vlaj_oil_Read[$n]		 			= $row["vlaj_oil_Read"];					//Влагосодержание
				$Dol_ras_gaz_mass[$n]	 			= $row["Dol_ras_gaz_mass"];					//Доля растворенного газа
				$Dens_gaz_KGN[$n]	 	 			= $row["Dens_gaz_KGN"];						//Плотность выделевшегося из КГН газа

				

				$Mass_brutto_Accum[$n]		 		= $row["Mass_brutto_Accum"];				//Накопленная масса брутто
				$Mass_netto_Accum[$n]		 		= $row["Mass_netto_Accum"];					//Накопленная масса нетто
				$Volume_Count_Forward_sc_Accum[$n]	= $row["Volume_Count_Forward_sc_Accum"];	//Накопленный объем газа в газовом трубопроводе
				$Mg_GK[$n]		 					= $row["Mg_GK"];							//Накопленная масса газа в линии ГЖС
				$Vg_GK[$n]		 					= $row["Vg_GK"];							//Накопленный объем газа в линии ГЖС
				$Mass_Gaz_UVP_Accum[$n]		 		= $row["Mass_Gaz_UVP_Accum"];				//Масса газа, прошедшая через УИГ
				$WC5_Accum[$n]		 				= $row["WC5_Accum"];						//Масса WC5+
				$Mass_water_UIG_Accum[$n]		 	= $row["Mass_water_UIG_Accum"];				//Масса воды, прошедшя через УИГ
				$Mass_KG[$n]		 				= $row["Mass_KG"];							//Масса КЖ, прошедшая через УИГ
				$V_KG[$n]		 					= $row["V_KG"];								//Объем КЖ, прошедший через УИГ

				$Debit_liq[$n]		 				= $row["Debit_liq"];						//Дебит жидкости 
				$Debit_gas_in_liq[$n]		 		= $row["Debit_gas_in_liq"];					//Дебит раств.газа в  жидкости
				$Debit_V_gas_in_liq[$n]		 		= $row["Debit_V_Gaz_GK"];					//Дебит раств.газа в  жидкости
				$Debit_cond[$n]		 				= $row["Debit_cond"];						//Дебит конденсата
				$Debit_water[$n]		 			= $row["V_KG"];								//Дебит воды
				$Debit_gaz[$n]		 				= $row["Debit_gaz"];						//Дебит газа 
				$Debit_KG[$n]		 				= $row["Debit_KG"];							//Дебит кап.жидкости в газе сепар.

				$Clean_Gaz[$n]		 				= $row["Clean_Gaz"];						//Дебит чистого газа 
				$Clean_Cond[$n]		 				= $row["Clean_Cond"];						//Дебит чистого конденсата
				$V_Water[$n]		 				= $row["V_Water"];							//Накопленная масса воды 
				$V_Cond[$n]		 					= $row["V_Cond"];							//Накопленная масса чистого конд
				$V_Gaz[$n]		 					= $row["V_Gaz"];							//Накопленный V чистого газа

				$TT100[$n]		 					= $row["TT100"];							
				$PT100[$n]		 					= $row["PT100"];							
				$PT201[$n]		 					= $row["PT201"];							
				$PDT200[$n]		 					= $row["PDT200"];							
				$PT202[$n]		 					= $row["PT202"];							
				$PT300[$n]		 					= $row["PT300"];							
				$LT300[$n]		 					= $row["LT300"];							
				$TT300[$n]		 					= $row["TT300"];							
				$TT500[$n]		 					= $row["TT500"];							
				$PT500[$n]		 					= $row["PT500"];	
				$TT700[$n]		 					= $row["TT700"];
				$PT700[$n]		 					= $row["PT700"];	

				$FS_P[$n]		 					= $row["FS_P"];					//Давление в линии газа		
				$FS_T[$n]		 					= $row["FS_T"];					//Температура в линии газа
				$FS_Qw[$n]		 					= $row["FS_Qw"];				//Дебит газа FLOWSIC 
				$FS_Qs[$n]		 					= $row["FS_Qs"];				//Дебит газа FLOWSIC
				$RT_Dens[$n]		 				= $row["RT_Dens"];				//Плотность жидкости ROTAMASS
				$RT_Vlaj[$n]		 				= $row["RT_Vlaj"];				//Обводнённость влагомер
				$Wm_After[$n]						= $row["Wm_After"];
				$Wv_After[$n]						= $row["Wv_After"];

				//Блок параметров по скважине, вводимых оператором
				$OW_M_GD[$n]		 					= $row["OW_M_GD"];	
				$OW_Dens_GD[$n]		 					= $row["OW_Dens_GD"];	
				$OW_V_PO[$n]		 					= $row["OW_V_PO"];	
				$OW_m_ZO[$n]		 					= $row["OW_m_ZO"];	
				$OW_Dens_SK[$n]		 					= $row["OW_Dens_SK"];	
				$OW_m_PROB[$n]		 					= $row["OW_m_PROB"];	

				//Расчет из данных "блока параметров по скважине, вводимых оператором"
				$OR_m_RG[$n]		 					= $row["OR_m_RG"];	
				$OR_W_RG[$n]		 					= $row["OR_W_RG"];	


				$n = $n + 1;
			}

			

		}

		sqlsrv_free_stmt($stmt);

  	}

//echo(FormatEx((real)$Vg_GK[0], 3, $NULL));
  	//echo FormatEx($WC5_Accum[0], 7, $NULL);
  	//echo $Debit_V_gas_in_liq[0];
  	//print_r($OW_Dens_GD);
?>


<CENTER>

	<TABLE class="table table-bordered table-hover" align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">
	<thead class="table-dark">
		<TR  align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="4" style="border-bottom:none;border-right:none">&nbsp;Идентификационных параметров скважины</TD>
			<TD rowspan="1" colspan="5" style="border-bottom:none;border-right:none">&nbsp;Идентификационные параметров замера</TD>
		</TR>
	</thead>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дата записи в журнал <b>(1)</b></TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Месторождение <b>(2)</b></TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Куст <b>(3)</b></TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Скважина <b>(4)</b></TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Время старта <b>(5)</b></TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Время оконч. <b>(6)</b></TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Время изм., мин <b>(7)</b></TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Режим (проточный/налив-слив) <b>(8)</b></TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Расчет (по влагомеру/по ХАЛ) <b>(9)</b></TD>

		</TR>

		<?php

				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . $date_e[$nn]->format("Y-m-d H:i:s") . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $field[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $bush[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $well[$nn] . '</TD>';

						echo '<TD style="border-bottom:none;border-right:none">' . $date_[$nn]->format("Y-m-d H:i:s") . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $date_e[$nn]->format("Y-m-d H:i:s") . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . round(($time_measure[$nn])/60) . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $rejim[$nn] . '</TD>';
						echo '<TD style="border-bottom:none;border-right:none">' . $method[$nn] . '</TD>';

					echo '</TR>'  ;
				}

			?>

	</TABLE>

	<br />

	<TABLE class="table table-bordered table-hover" align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">
		<thead class="table-dark">
			<TR align="center" BGCOLOR="#CCCCCC">
				<TD rowspan="1" colspan="8" style="border-bottom:none;border-right:none">&nbsp; YБлок параметров по скважине (ХАЛ), вводимых оператором</TD>
			</TR>
		</thead>

			<TR align="center" BGCOLOR="#CCCCCC">
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Масса газа деазации <b>(10)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность газа дегазации <b>(11)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Водное число пробоотборника <b>(12)</b></TD>
				<TD rowspan="1" id="Dol_ras_gaz_mass_js" style="border-bottom:none;border-right:none">&nbsp;Масса жидкого остатка дегазации <b>(13)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность стабильного конденсата <b>(14)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Масса пробы <b>(14)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Масса растворенного газа (расчет) <b>(14)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Массовая доля растворенного газа <b>(14)</b></TD>
			</TR>

			<TR align="center" BGCOLOR="#CCCCCC">
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг/м3</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;дм3</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;г/см3</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;% масс</TD>
			</TR>

			<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($OW_M_GD[$nn], 5, $NULL) . '</TD>';		//Масса газа деазации
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($OW_Dens_GD[$nn], 5, $NULL) . '</TD>';	//Плотность газа дегазации
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($OW_V_PO[$nn], 5, $NULL) . '</TD>';		//Водное число пробоотборника
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($OW_m_ZO[$nn], 5, $NULL) . '</TD>';		//Масса жидкого остатка дегазации
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($OW_Dens_SK[$nn], 5, $NULL) . '</TD>';	//Плотность стабильного конденсата
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($OW_m_PROB[$nn], 5, $NULL) . '</TD>';	//Масса пробы
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($OR_m_RG[$nn], 5, $NULL) . '</TD>';		//Плотность стабильного конденсата
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($OR_W_RG[$nn], 5, $NULL) . '</TD>';		//Масса пробы
					echo '</TR>'  ;
				}

			?>

	</TABLE>

	<br />

	<TABLE class="table table-bordered table-hover" align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">
		<thead class="table-dark">
			<TR align="center" BGCOLOR="#CCCCCC">
				<TD rowspan="1" colspan="12" style="border-bottom:none;border-right:none">&nbsp;Блок параметров по замеру</TD>
			</TR>
		</thead>

			<TR align="center" BGCOLOR="#CCCCCC">
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Накоп масса жидкости в линии ГСЖ (ГК брутто) <b>(15)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Накоп масса конденсата в линии ГСЖ (ГК нетто) <b>(16)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Накопленная масса воды (расчет) <b>(17)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Накоп масса конд (ГК брутто - газ в ГК + КЖ в УИГ-(ГК брутто-ГК нетто)) <b>(18)</b></TD>
				
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Накопленный объем газа в УИГ <b>(19)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Накоп объем газа (УИГ + газ в ГСЖ) <b>(20)</b></TD>

				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Накоп масса газа в ГЖС  <b>(21)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Накоп объем газа в ГЖС (мас газ в ГЖС / плот газ дегазац) <b>(22)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Масса газа, прошедшая через УИГ <b>(23)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Масса WC5+ <b>(24)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Масса воды, прошедшя через УИГ <b>(25)</b></TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Масса КЖ, прошедшая через УИГ <b>(26)</b></TD>
				
			</TR>

			<TR align="center" BGCOLOR="#CCCCCC">
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;(<b>15</b>-<b>21</b>+<b>26</b>-(<b>15</b>-<b>16</b>))</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;(<b>19</b>+<b>22</b>)</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;(<b>15</b> * (<b>13</b> / 100%) )</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;(<b>21</b> / <b>14</b>)</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;</TD>
				
			</TR>

			<TR align="center" BGCOLOR="#CCCCCC">
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;м³ ст.у.</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;м³ ст.у.</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;м³ ст.у.</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг</TD>
				<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг</TD>
				
			</TR>

			<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD id="Mass_brutto_Accum" style="border-bottom:none;border-right:none">' . FormatEx($Mass_brutto_Accum[$nn], 7, $NULL) . '</TD>';	//Накопленная масса брутто
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Mass_netto_Accum[$nn], 7, $NULL) . '</TD>';							//Накопленная масса нетто
						$Mass_water_Accum = $Mass_brutto_Accum[$nn] - $Mass_netto_Accum[$nn];																		//Накопленная масса воды
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Mass_brutto_Accum[$nn] - $Mass_netto_Accum[$nn], 7, $NULL) . '</TD>';	//Накопленная масса воды
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($V_Cond[$nn], 3, $NULL) . '</TD>';										//Накопленная масса чистого конд
						echo '<TD id="Volume_Count_Forward_sc_Accum" style="border-bottom:none;border-right:none">' . FormatEx($Volume_Count_Forward_sc_Accum[$nn], 3, $NULL) . '</TD>';//Накопл.объем газа в УИГ
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($V_Gaz[$nn], 3, $NULL) . '</TD>';										//Накопленный V чистого газа
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Mg_GK[$nn], 6, $NULL) . '</TD>';										//Накопленная масса газа в линии ГЖС
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Vg_GK[$nn], 6, $NULL) . '</TD>';										//Накопленный объем газа в линии ГЖС
						echo '<TD id="Mass_Gaz_UVP_Accum" style="border-bottom:none;border-right:none">' . FormatEx($Mass_Gaz_UVP_Accum[$nn], 3, $NULL) . '</TD>';	//Масса газа, прошедшая через УИГ
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($WC5_Accum[$nn], 3, $NULL) . '</TD>';									//Масса WC5+
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Mass_water_UIG_Accum[$nn], 3, $NULL) . '</TD>';						//Масса воды, прошедшя через УИГ
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Mass_KG[$nn], 3, $NULL) . '</TD>';										//Масса КЖ, прошедшая через УИГ
						//echo '<TD style="border-bottom:none;border-right:none">' . $V_KG[$nn] . '</TD>';//Объем КЖ, прошедший через УИГ

					echo '</TR>'  ;
				}

			?>

	</TABLE>



	<br />

	<TABLE class="table table-bordered table-hover" align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">
	<thead class="table-dark">
		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="11" style="border-bottom:none;border-right:none">&nbsp;Блок основных результатов по скважине</TD>
		</TR>
	</thead>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит жидкости</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит конденсата</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит воды (расчет)</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит общего конденсата (расчет)</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит кап.жидкости в газе сепар.</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит газа </TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит раств.газа в  жидкости</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит раств.газа в  жидкости</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит общего газа (расчет)</TD>
					
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ст.м³/сут</TD>

			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ст.м³/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ст.м³/сут</TD>

		</TR>

		<?php
				//$p1 = (float) $Mg_GK[0];   
				//echo $p1;

				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Debit_liq[$nn], 3, $NULL) . '</TD>';//Дебит жидкости
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Debit_cond[$nn], 3, $NULL) . '</TD>';//Дебит конденсата
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Debit_water[$nn], 3, $NULL) . '</TD>';//Дебит воды
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Clean_Cond[$nn], 3, $NULL) . '</TD>';//Дебит чистого конденсата

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Debit_KG[$nn], 3, $NULL) . '</TD>';//Дебит кап.жидкости в газе сепар.
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Debit_gaz[$nn], 3, $NULL) . '</TD>';//Дебит газа

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Debit_gas_in_liq[$nn], 3, $NULL) . '</TD>';//Дебит раств.газа в  жидкости
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Debit_V_gas_in_liq[$nn], 3, $NULL) . '</TD>';//Дебит раств.газа в  жидкости
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Clean_Gaz[$nn], 3, $NULL) . '</TD>';//Дебит чистого газа			

					echo '</TR>'  ;
				}

		?>

		<TR align="center" BGCOLOR="#CCCCCC">
			
			
			


	</TABLE>

	<br />

	<TABLE class="table table-bordered table-hover" align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">
	<thead class="table-dark">
		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="6" style="border-bottom:none;border-right:none">&nbsp;Общие технологические параметры установки при измерении</TD>
		</TR>
	</thead>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Температура во входном коллекторе</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давление во входном коллекторе</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давление на всасе Н-1</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Перепад давления на фильтре</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давление на выкиде Н-1</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давление в газосепараторе ГС-1</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[TT100] °С</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[PT100] МПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[PT201] кПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[PDT200] кПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[PT202] МПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[PT300] МПа</TD>
		</TR>

		<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TT100[$nn], 2, $NULL) . '</TD>';	//Температура во входном коллекторе
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PT100[$nn], 3, $NULL) . '</TD>';	//Давление во входном коллекторе
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PT201[$nn], 3, $NULL) . '</TD>';	//Давление на всасе Н-1
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PDT200[$nn], 3, $NULL) . '</TD>';	//Перепад давления на фильтре
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PT202[$nn], 3, $NULL) . '</TD>';	//Давление на выкиде Н-1
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PT300[$nn], 3, $NULL) . '</TD>';	//Давление в газосепараторе ГС-1

					echo '</TR>'  ;
				}

		?>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Уровень в емкости Е-1</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Темп в емкости Е-1</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Темп в вых. коллек жидк</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давл в вых. коллек жидк</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Темп в вых. коллек газа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давл в вых. коллек газа</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[LT300] см</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[TT300] °С</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[TT500] °С</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[PT500] МПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[TT700] °С</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;[PT700] МПа</TD>
		</TR>

		<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($LT300[$nn], 3, $NULL) . '</TD>';	//Уровень в емкости Е-1
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TT300[$nn], 2, $NULL) . '</TD>';	//Темп в емкости Е-1
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TT500[$nn], 2, $NULL) . '</TD>';	//Темп в вых. коллек жидк
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PT500[$nn], 3, $NULL) . '</TD>';	//Давл в вых. коллек жидк
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($TT700[$nn], 2, $NULL) . '</TD>';	//Темп в вых. коллек газа
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($PT700[$nn], 3, $NULL) . '</TD>';	//Давл в вых. коллек газа

					echo '</TR>'  ;
				}

		?>


	</TABLE>

	<br />

	<TABLE class="table table-bordered table-hover" align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">
	<thead class="table-dark">
		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="4" style="border-bottom:none;border-right:none">&nbsp;Блок параметров по газовой линии, связанных с работой и расчетом по ултразвуковому расходомеру - FLOWSIC</TD>
		</TR>
	</thead>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Давление в линии газа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Температура в линии газа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит газа FLOWSIC (р.у.)</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит газа FLOWSIC (ст.у.)</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;МПа</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;°С</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;м³/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;ст.м³/сут</TD>
		</TR>

		<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($FS_P[$nn], 3, $NULL) . '</TD>';	//Давление в линии газа
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($FS_T[$nn], 2, $NULL) . '</TD>';	//Температура в линии газа
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($FS_Qw[$nn], 3, $NULL) . '</TD>';	//Дебит газа FLOWSIC
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($FS_Qs[$nn], 3, $NULL) . '</TD>';	//Дебит газа FLOWSIC

					echo '</TR>'  ;
				}

		?>

	</TABLE>

	<br />

	<TABLE class="table table-bordered table-hover" align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">
	<thead class="table-dark">
		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="4" style="border-bottom:none;border-right:none">&nbsp;Результаты измерения кориолисовым расходомером жидкости ROTAMASS</TD>
		</TR>
	</thead>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Дебит жидкости ROTAMASS</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Масса жидкости ROTAMASS</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Плотность жидкости ROTAMASS</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Обводнённость влагомер</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т/сут</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;т</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;кг/м³</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;% объем.</TD>
		</TR>

		<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';

						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Debit_liq[$nn], 3, $NULL) . '</TD>';			//Дебит жидкости ROTAMASS
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Mass_brutto_Accum[$nn], 3, $NULL) . '</TD>';	//Масса жидкости ROTAMASS
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($RT_Dens[$nn], 3, $NULL) . '</TD>';				//Плотность жидкости ROTAMASS
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($RT_Vlaj[$nn], 3, $NULL) . '</TD>';				//Обводнённость влагомер

					echo '</TR>'  ;
				}

		?>

	</TABLE>

	<br /> 

	<TABLE class="table table-bordered table-hover" align="center" BORDER CELLSPACING=0 CELLPADDING=0 WIDTH="100%"  style='border-top:none;border-left:none' style="font size=14" bordercolor="#000000">
	<thead class="table-dark">
		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" colspan="2" style="border-bottom:none;border-right:none">&nbsp;Определение обводненности после замера</TD>
		</TR>
	</thead>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Объемная доля воды</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;Массовая доля воды</TD>
		</TR>

		<TR align="center" BGCOLOR="#CCCCCC">
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;%, об</TD>
			<TD rowspan="1" style="border-bottom:none;border-right:none">&nbsp;%, масс</TD>
		</TR>

		<?php
				for ($nn = 0; $nn < $n; $nn++){
					echo '<TR align="center">';



						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Wv_After[$nn], 2, $NULL) . '</TD>';	
						echo '<TD style="border-bottom:none;border-right:none">' . FormatEx($Wm_After[$nn], 2, $NULL) . '</TD>';	

					echo '</TR>'  ;
				}

		?>

	</TABLE>


</CENTER>


<br />    






<!-- Отправка POST запроса для формирования excel файла -->
<form action="/web/docviewer/excel_save_new.php" method="post">
	<input type="hidden" name="Date_"							value="<?=$date_e[0]->format("Y-m-d"); ?>">
	<input type="hidden" name="Date1_" 							value="<?=$date_e[0]->format("H:i:s"); ?>">
	<input type="hidden" name="Field" 							value="<?=$field[0]; ?>">							<!-- Месторождение -->
	<input type="hidden" name="Bush" 							value="<?=$bush[0]; ?>">							<!-- Куст -->
	<input type="hidden" name="Well" 							value="<?=$well[0]; ?>">							<!-- Скважина -->

	<input type="hidden" name="Date2_" 							value="<?=$date_[0]->format("Y-m-d H:i:s"); ?>">	<!-- Дата начала замера -->
	<input type="hidden" name="Date3_" 							value="<?=$date_e[0]->format("Y-m-d H:i:s"); ?>">	<!-- Дата конца замера -->
	<input type="hidden" name="Time_measure" 					value="<?=round(($time_measure[0])/60); ?>">		<!-- Время замера -->
	<input type="hidden" name="Rejim" 							value="<?=$rejim[0]; ?>">							<!-- Режим -->
	<input type="hidden" name="Method" 							value="<?=$method[0]; ?>">							<!-- Метод -->

	<input type="hidden" name="Dol_mech_prim_Read" 				value="<?=$Dol_mech_prim_Read[0]; ?>">				<!-- Доля механических примесей -->
	<input type="hidden" name="Konc_hlor_sol_Read" 				value="<?=$Konc_hlor_sol_Read[0]; ?>">				<!-- Концентрация хлористых солей -->
	<input type="hidden" name="Dol_ras_gaz_Read" 				value="<?=$Dol_ras_gaz_Read[0]; ?>">				<!-- Доля растворенного газа -->
	<input type="hidden" name="Vlaj_oil_Read" 					value="<?=$vlaj_oil_Read[0]; ?>">					<!-- Влагосодержание -->
	<input type="hidden" name="Dol_ras_gaz_mass" 				value="<?=$Dol_ras_gaz_mass[0]; ?>">				<!-- Доля растворенного газа -->
	<input type="hidden" name="Dens_gaz_KGN" 					value="<?=$Dens_gaz_KGN[0]; ?>">					<!-- Плотность выделевшегося из КГН газа -->

	<!-- Блок параметров по замеру --------------------------------------------------------------------------------------------------------------------------------------->
	<input type="hidden" name="Mass_brutto_Accum" 				value="<?=$Mass_brutto_Accum[0]; ?>">				<!-- Накоп масса жидкости в линии ГСЖ (ГК брутто) -->
	<input type="hidden" name="Mass_netto_Accum" 				value="<?=$Mass_netto_Accum[0]; ?>">				<!-- Накоп масса конденсата в линии ГСЖ (ГК нетто) -->
	<input type="hidden" name="Mass_water_Accum" 				value="<?=$Mass_water_Accum; ?>">					<!-- Накопленная масса воды (расчет) -->
	<input type="hidden" name="V_Cond" 							value="<?=$V_Cond[0]; ?>">							<!-- Накоп масса конд -->
	<input type="hidden" name="Volume_Count_Forward_sc_Accum" 	value="<?=$Volume_Count_Forward_sc_Accum[0]; ?>">	<!-- Накопленный объем газа в УИГ -->
	<input type="hidden" name="V_Gaz" 							value="<?=$V_Gaz[0]; ?>">							<!-- Накоп объем газа -->
	<input type="hidden" name="Mg_GK" 							value="<?=$Mg_GK[0]; ?>">							<!-- Накоп масса газа в ГЖС -->
	<input type="hidden" name="Vg_GK" 							value="<?=$Vg_GK[0]; ?>">							<!-- Накоп объем газа в ГЖС -->
	<input type="hidden" name="Mass_Gaz_UVP_Accum" 				value="<?=$Mass_Gaz_UVP_Accum[0]; ?>">				<!-- Масса газа, прошедшая через УИГ -->
	<input type="hidden" name="WC5_Accum" 						value="<?=$WC5_Accum[0]; ?>">						<!-- Масса WC5+ -->
	<input type="hidden" name="Mass_water_UIG_Accum" 			value="<?=$Mass_water_UIG_Accum[0]; ?>">			<!-- Масса воды, прошедшя через УИГ -->
	<input type="hidden" name="Mass_KG" 						value="<?=$Mass_KG[0]; ?>">							<!-- Масса КЖ, прошедшая через УИГ -->

	<!-- Блок основных результатов по скважине --------------------------------------------------------------------------------------------------------------------------------------->
	<input type="hidden" name="Debit_liq" 						value="<?=$Debit_liq[0]; ?>">						<!-- Дебит жидкости -->
	<input type="hidden" name="Debit_cond" 						value="<?=$Debit_cond[0]; ?>">						<!-- Дебит конденсата -->
	<input type="hidden" name="Debit_water" 					value="<?=$Debit_water[0]; ?>">						<!-- Дебит воды -->
	<input type="hidden" name="Clean_Cond" 						value="<?=$Clean_Cond[0]; ?>">						<!-- Дебит чистого конденсата -->
	<input type="hidden" name="Debit_KG" 						value="<?=$Debit_KG[0]; ?>">						<!-- Дебит кап.жидкости в газе сепар. -->
	<input type="hidden" name="Debit_gaz" 						value="<?=$Debit_gaz[0]; ?>">						<!-- Дебит газа -->
	<input type="hidden" name="Debit_gas_in_liq" 				value="<?=$Debit_gas_in_liq[0]; ?>">				<!-- Дебит раств.газа в  жидкости -->
	<input type="hidden" name="Debit_V_gas_in_liq" 				value="<?=$Debit_V_gas_in_liq[0]; ?>">				<!-- Дебит раств.газа в  жидкости -->
	<input type="hidden" name="Clean_Gaz" 						value="<?=$Clean_Gaz[0]; ?>">						<!-- Дебит чистого газа -->

	<!--  Общие технологические параметры установки при измерении --------------------------------------------------------------------------------------------------------------------------------------->
	<input type="hidden" name="TT100" 							value="<?=$TT100[0]; ?>">							<!-- Температура во входном коллекторе -->
	<input type="hidden" name="PT100" 							value="<?=$PT100[0]; ?>">							<!-- Давление во входном коллекторе -->
	<input type="hidden" name="PT201" 							value="<?=$PT201[0]; ?>">							<!-- Давление на всасе Н-1 -->
	<input type="hidden" name="PDT200" 							value="<?=$PDT200[0]; ?>">							<!-- Перепад давления на фильтре -->
	<input type="hidden" name="PT202" 							value="<?=$PT202[0]; ?>">							<!-- Давление на выкиде Н-1 -->
	<input type="hidden" name="PT300" 							value="<?=$PT300[0]; ?>">							<!-- Давление в газосепараторе ГС-1 -->
	<input type="hidden" name="LT300" 							value="<?=$LT300[0]; ?>">							<!-- Уровень в емкости Е-1 -->
	<input type="hidden" name="TT300" 							value="<?=$TT300[0]; ?>">							<!-- Темп в емкости Е-1 -->
	<input type="hidden" name="TT500" 							value="<?=$TT500[0]; ?>">							<!-- Темп в вых. коллек жидк -->
	<input type="hidden" name="PT500" 							value="<?=$PT500[0]; ?>">							<!-- Давл в вых. коллек жидк -->
	<input type="hidden" name="TT700" 							value="<?=$TT700[0]; ?>">							<!-- Темп в вых. коллек газа -->
	<input type="hidden" name="PT700" 							value="<?=$PT700[0]; ?>">							<!-- Давл в вых. коллек газа -->

	<!--  FLOWSIC --------------------------------------------------------------------------------------------------------------------------------------->
	<input type="hidden" name="FS_P" 							value="<?=$FS_P[0]; ?>">							<!-- Давление в линии газа -->
	<input type="hidden" name="FS_T" 							value="<?=$FS_T[0]; ?>">							<!-- Температура в линии газа -->
	<input type="hidden" name="FS_Qw" 							value="<?=$FS_Qw[0]; ?>">							<!-- Дебит газа FLOWSIC -->
	<input type="hidden" name="FS_Qs" 							value="<?=$FS_Qs[0]; ?>">							<!-- Дебит газа FLOWSIC -->

	<!-- ROTAMASS --------------------------------------------------------------------------------------------------------------------------------------->
	<!--<input type="hidden" name="Debit_liq" 						value="<?=$Debit_liq[0]; ?>">	-->				<!-- Дебит жидкости ROTAMASS -->
	<input type="hidden" name="Mass_brutto_Accum" 				value="<?=$Mass_brutto_Accum[0]; ?>">				<!-- Масса жидкости ROTAMASS -->
	<input type="hidden" name="RT_Dens" 						value="<?=$RT_Dens[0]; ?>">							<!-- Плотность жидкости ROTAMASS -->

	<!-- ВСН-2 --------------------------------------------------------------------------------------------------------------------------------------->
	<input type="hidden" name="RT_Vlaj" 						value="<?=$RT_Vlaj[0]; ?>">							<!-- Обводнённость влагомер -->
	




	<input type="hidden" name="RT_Dens" 						value="<?=$RT_Dens[0]; ?>">							<!-- Плотность жидкости ROTAMASS -->
	<input type="hidden" name="RT_Vlaj" 						value="<?=$RT_Vlaj[0]; ?>">							<!-- Обводнённость влагомер -->

	<input type="hidden" name="OW_M_GD" 						value="<?=$OW_M_GD[0]; ?>">							<!-- Масса газа деазации -->
	<input type="hidden" name="OW_Dens_GD" 						value="<?=$OW_Dens_GD[0]; ?>">						<!-- Плотность газа дегазации -->
	<input type="hidden" name="OW_V_PO" 						value="<?=$OW_V_PO[0]; ?>">							<!-- Водное число пробоотборника -->
	<input type="hidden" name="OW_m_ZO" 						value="<?=$OW_m_ZO[0]; ?>">							<!-- Масса жидкого остатка дегазации -->
	<input type="hidden" name="OW_Dens_SK" 						value="<?=$OW_Dens_SK[0]; ?>">						<!-- Плотность стабильного конденсата -->
	<input type="hidden" name="OW_m_PROB" 						value="<?=$OW_m_PROB[0]; ?>">						<!-- Масса пробы -->

	<input type="hidden" name="OR_m_RG" 						value="<?=$OR_m_RG[0]; ?>">							<!-- Плотность стабильного конденсата -->
	<input type="hidden" name="OR_W_RG" 						value="<?=$OR_W_RG[0]; ?>">							<!-- Масса пробы -->

	<input class="button_print but_weight" type="submit" name="Сформировать Excel файл по замеру" value="Сформировать Excel файл по замеру">
</form>

<br /> 

<!-- Отправка POST запроса для удаления строки из БД -->


	<input type="hidden" name="ServerName" value="<?=$ServerName; ?>">
	<input type="hidden" name="Database" value="<?=$Database; ?>">
	<input type="hidden" name="UID" value="<?=$UID; ?>">
	<input type="hidden" name="PWD" value="<?=$PWD; ?>">
	<input type="hidden" name="file_func" value="<?=$file_func; ?>">
	<input type="hidden" name="id" value="<?=$id[0]; ?>">		

	



<!-- Отправка POST запроса для пересчета доли воды в ГК -->
<!--<form action="/web/docviewer/calc_water.php" method="post">-->

	<input type="hidden" name="ServerName" value="<?=$ServerName; ?>">
	<input type="hidden" name="Database" value="<?=$Database; ?>">
	<input type="hidden" name="UID" value="<?=$UID; ?>">
	<input type="hidden" name="PWD" value="<?=$PWD; ?>">
	<input type="hidden" name="file_func" value="<?=$file_func; ?>">
	
	<input type="hidden" name="Mass_brutto_Accum" value="<?=$Mass_brutto_Accum[0]; ?>">


	<div class="input_print_div">
		<div style="border: 1px solid #bbb; margin: 10px 0px; border-radius: 5px; padding: 10px;">
			<p style="font-style: italic;">Вычисляем массовую долю воды:</p>
			<hr style="margin-bottom: 10px;">
			<p>Объемная доля воды, % об</p>
			<input class="input_print but_weight" id="Water_After" type="number" name="Wp" value="40"> 
			<p>Плотность ГК, кг/м3</p>
			<input class="input_print" id="Dens_After" type="number" name="Dens_GK" value="700">
			<p>Плотность воды, кг/м3</p>
			<input class="input_print" id="DensW_After" type="number" name="Dens_GK" value="1000">	
		</div>

		

		<!-- Скрытые поля для JS -->
		<input id="Number_zamer" type="hidden" name="id" value="<?=$id[0]; ?>">  
		<input id="Time_measure_js" type="hidden" name="Time_measure_js" value="<?=$time_measure[0]; ?>">   
		<input id="Mass_brutto_Accum_js" type="hidden" name="Mass_brutto_Accum_js" value="<?=$Mass_brutto_Accum[0]; ?>">
		<input id="Mass_brutto_Accum_js" type="hidden" name="Mass_brutto_Accum_js" value="<?=$Mass_brutto_Accum[0]; ?>">
		<input id="Debit_liq_js" type="hidden" name="Mass_brutto_Accum_js" value="<?=$Debit_liq[0]; ?>">

		<div style="border: 1px solid #bbb; margin: 10px 0px; border-radius: 5px; padding: 10px;">
			<p style="font-style: italic;">Вычисляем массовую долю растворенного газа:</p>
			<hr style="margin-bottom: 10px;">
			<!-- Отправка POST запроса для пересчета данных по резельтатам ХАЛ -->
			<p>Масса газа дегазации, кг</p>
			<input class="input_print but_weight" id="M_GD" type="number" name="M_GD" value="0.00386">
			<p>Плотность газа дегазации, кг/м3</p>
			<input class="input_print but_weight" id="Dens_GD" type="number" name="Dens_GD" value="1.044">
			<p>Водное число пробоотборника, дм3</p>
			<input class="input_print but_weight" id="V_PO" type="number" name="V_PO" value="0.09722">
			<p>Масса жидкого остатка дегазации, кг</p>
			<input class="input_print but_weight" id="m_ZO" type="number" name="m_ZO" value="0.06288">
			<p>Плотность стабильного конденсата, г/см3</p>
			<input class="input_print but_weight" id="Dens_SK" type="number" name="Dens_SK" value="0.7116">
			<p>Масса пробы, кг</p>
			<input class="input_print but_weight" id="m_PROB" type="number" name="m_PROB" value="0.06674">
		</div>
		

		<!-- <p>Массовая доля мех. примесей (ХАЛ), % масс</p>
		<input class="input_print but_weight" id="W_MP" type="number" name="W_MP" value="">
		<p>Массовая доля хлористых солей (ХАЛ), % масс</p>
		<input class="input_print but_weight" id="W_HL" type="number" name="W_HL" value=""> -->

		<div style="border: 1px solid #bbb; margin: 10px 0px; border-radius: 5px; padding: 10px;">
			<p style="font-style: italic;">Вычисляем массу капельной жидкости:</p>
			<hr style="margin-bottom: 10px;">
			<p>Компонентный состав газа</p>
			<p>CH4, % мол</p>
			<input class="input_print but_weight" id="HAL_CH4" type="number" name="HAL_CH4" value="88.49">
			<p>C2H6, % мол</p>
			<input class="input_print but_weight" id="HAL_C2H6" type="number" name="HAL_C2H6" value="3.23">
			<p>C3H8, % мол</p>
			<input class="input_print but_weight" id="HAL_C3H8" type="number" name="HAL_C3H8" value="2.27">
			<p>iC4H10, % мол</p>
			<input class="input_print but_weight" id="HAL_iC4H10" type="number" name="HAL_iC4H10" value="0.68">
			<p>nC4H10, % мол</p>
			<input class="input_print but_weight" id="HAL_nC4H10" type="number" name="HAL_nC4H10" value="0.9">
			<p>iC5H12, % мол</p>
			<input class="input_print but_weight" id="HAL_iC5H12" type="number" name="HAL_iC5H12" value="0.47">
			<p>nC5H12, % мол</p>
			<input class="input_print but_weight" id="HAL_nC5H12" type="number" name="HAL_nC5H12" value="0.47">
			<p>C6H14, % мол</p>
			<input class="input_print but_weight" id="HAL_C6H14" type="number" name="HAL_C6H14" value="0.43">
			<p>C7H16, % мол</p>
			<input class="input_print but_weight" id="HAL_C7H16" type="number" name="HAL_C7H16" value="0.13">
			<p>N2, % мол</p>
			<input class="input_print but_weight" id="HAL_N2" type="number" name="HAL_N2" value="2.92">
			<p>O2, % мол</p>
			<input class="input_print but_weight" id="HAL_O2" type="number" name="HAL_O2" value="0.01">
			<p>CO2, % мол</p>
			<input class="input_print but_weight" id="HAL_CO2" type="number" name="HAL_CO2" value="0">
			<p>H2S, % мол</p>
			<input class="input_print but_weight" id="HAL_H2S" type="number" name="HAL_H2S" value="0">
			<p>H2O, % мол</p>
			<input class="input_print but_weight" id="HAL_H2O" type="number" name="HAL_H2O" value="0">
		</div>

		<p>Масса растворенного газа в пробе, кг</p>
		<span>55</span>

		<br><br>

		<input class="button_print but_weight" type="submit" name="Вывести пересчитанные данные" value="Вывести пересчитанные данные" onclick="Calc_Params()">


		<input class="button_print but_weight" type="submit" name="Пересчитать долю воды" value="Пересчитать долю воды" onclick="Calc_Line()">
	</div>	

	<input class="button_print button_print1" type="submit" name="Удалить замер из БД" value="Удалить замер из БД" onclick="Del_Line()">

	<br />
	<br />





<?php

	//$row["V_Water"]

	//$ss = Convert_string($V_Cond[0]);
	//echo $ss;

	/*$ss = Convert_string($V_Water[0]);
	echo $ss."<br />";

	$ss = Convert_string($Dol_mech_prim_Read[0]);
	echo $ss;*/

?>