<form action="/web/docviewer/excel_save_group.php">
    <button>hg</button>
  </form>
  

<?php

	//header('Content-Type: text/html; charset= windows-1251');
	

	$field      	= $_POST["field"];
	$bush      		= $_POST["bush"];
	$well      		= $_POST["well"];

	$day_start      = $_POST["day_start"];
	$month_start    = $_POST["month_start"];
	$year_start     = $_POST["year_start"];

	$day_end      	= $_POST["day_end"];
	$month_end      = $_POST["month_end"];
	$year_end      	= $_POST["year_end"];

	$ServerName     = $_POST["ServerName"];
	$Database      	= $_POST["Database"];
	$UID      		= $_POST["UID"];
	$PWD      		= $_POST["PWD"];

	$dateb = $year_start . "-". $month_start. "-" . $day_start . " 00:00:00";
	$datee = $year_end . "-". $month_end. "-" . $day_end . " 00:00:00";

	$date_b = DateTime::createFromFormat('Y-m-d H:i:s', $dateb);
	$date_b->modify("-1 second");
	$date_b = $date_b->format('Ymd H:i:s');

	$date_e = DateTime::createFromFormat('Y-m-d H:i:s', $datee);
	$date_e->modify("+1 second");
	$date_e = $date_e->format('Ymd H:i:s');


	$connectionInfo = array( "Database"=>"$Database", "UID"=>$UID, "PWD"=>$PWD);
	$conn = sqlsrv_connect( $ServerName, $connectionInfo);

	if($field <> "Все"){
		$field_s = "and Field='".$field."'";
	}else{  
		$field_s = "";
	}

	if($bush <> "Все"){
		$bush_s = "and Bush='".$bush."'";
	}else{
		$bush_s = "";
	}

	if($well <> "Все"){
		$well_s = "and Well='".$well."'";
	}else{
		$well_s = "";
	}



	$tsql = "SELECT * FROM Zamer WHERE ((date_time between date_b and date_e) field bush well) ORDER BY date_time;";

	$tsql=str_replace("date_b", "'".$date_b."'", $tsql);
	$tsql=str_replace("date_e", "'".$date_e."'", $tsql); 

	$tsql=str_replace("field", $field_s, $tsql);
	$tsql=str_replace("bush", $bush_s, $tsql);
	$tsql=str_replace("well", $well_s, $tsql);

	$tsql = iconv("utf-8","windows-1251",$tsql);

	echo $tsql;

	//echo $tsql;
	$id 	 						= array();
	$Field	 						= array();
	$date_time 	 					= array();
	$date_time2	 					= array();
	$Bush	 						= array();
	$Well	 						= array();
	$Time_m	 						= array();
	$Rejim	 						= array();
	$Method_obv	 					= array();

	$Dol_mech_prim_Read	 			= array();
	$Konc_hlor_sol_Read	 			= array();
	$Dol_ras_gaz_Read	 			= array();
	$vlaj_oil_Read	 				= array();
	$Dol_ras_gaz_mass	 			= array();
	$Dens_gaz_KGN	 				= array();

	$Mass_brutto_Accum	 			= array();
	$Mass_netto_Accum	 			= array();
	$Volume_Count_Forward_sc_Accum	= array();
	$Mg_GK	 						= array();
	$Vg_GK	 						= array();
	$Mass_Gaz_UVP_Accum	 			= array();
	$WC5_Accum	 					= array();
	$Mass_water_UIG_Accum	 		= array();
	$Mass_KG	 					= array();
	$V_KG	 						= array();

	$Debit_liq	 					= array();
	$Debit_gas_in_liq	 			= array();
	$Debit_cond	 					= array();
	$Debit_gaz	 					= array();
	$Debit_KG	 					= array();
	$Debit_water	 				= array();
	$Clean_Gaz	 					= array();
	$Clean_Cond	 					= array();
	$V_Gaz	 						= array();
	$V_Cond	 						= array();
	$V_Water	 					= array();
	$av	 							= array();

	$TT100	 						= array();
	$PT100	 						= array();
	$PT201	 						= array();
	$PDT200	 						= array();
	$PT202	 						= array();
	$PT300	 						= array();
	$LT300	 						= array();
	$TT300	 						= array();
	$TT500	 						= array();
	$PT500	 						= array();
	$TT700	 						= array();
	$PT700	 						= array();

	$FS_P	 						= array();
	$FS_T	 						= array();
	$FS_Qw	 						= array();
	$FS_Qs	 						= array();
	$RT_Dens	 					= array();
	$RT_Vlaj	 					= array();


	$n = 0;

	if( $conn ) {
    	$stmt = sqlsrv_query( $conn, $tsql);  //выполняем запрос

		if( $stmt === false){  // если не удачно выводим ошибки
			die( print_r(sqlsrv_errors(), true) );
		}

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){


			$id[$n] 							= $row["id"];
			$Field[$n] 							= $row["Field"];
			$date_time[$n] 						= $row["date_time"];
			$date_time2[$n] 					= $row["date_time2"];
			$Bush[$n] 							= $row["Bush"];
			$Well[$n] 							= $row["Well"];
			$Time_m[$n] 						= $row["Time_m"];
			$Rejim[$n] 							= $row["Rejim"];
			$Method_obv[$n] 					= $row["Method_obv"];

			$Dol_mech_prim_Read[$n] 			= $row["Dol_mech_prim_Read"];
			$Konc_hlor_sol_Read[$n] 			= $row["Konc_hlor_sol_Read"];
			$Dol_ras_gaz_Read[$n] 				= $row["Dol_ras_gaz_Read"];
			$vlaj_oil_Read[$n] 					= $row["vlaj_oil_Read"];
			$Dol_ras_gaz_mass[$n] 				= $row["Dol_ras_gaz_mass"];
			$Dens_gaz_KGN[$n] 					= $row["Dens_gaz_KGN"];

			$Mass_brutto_Accum[$n] 				= $row["Mass_brutto_Accum"];
			$Mass_netto_Accum[$n] 				= $row["Mass_netto_Accum"];
			$Volume_Count_Forward_sc_Accum[$n] 	= $row["Volume_Count_Forward_sc_Accum"];
			$Mg_GK[$n] 							= $row["Mg_GK"];
			$Vg_GK[$n] 							= $row["Vg_GK"];
			$Mass_Gaz_UVP_Accum[$n] 			= $row["Mass_Gaz_UVP_Accum"];
			$WC5_Accum[$n] 						= $row["WC5_Accum"];
			$Mass_water_UIG_Accum[$n] 			= $row["Mass_water_UIG_Accum"];
			$Mass_KG[$n] 						= $row["Mass_KG"];
			$V_KG[$n] 							= $row["V_KG"];

			$Debit_liq[$n] 						= $row["Debit_liq"];
			$Debit_gas_in_liq[$n] 				= $row["Debit_gas_in_liq"];
			$Debit_cond[$n] 					= $row["Debit_cond"];
			$Debit_gaz[$n] 						= $row["Debit_gaz"];
			$Debit_KG[$n] 						= $row["Debit_KG"];
			$Debit_water[$n] 					= $row["Debit_water"];
			$Clean_Gaz[$n] 						= $row["Clean_Gaz"];
			$Clean_Cond[$n] 					= $row["Clean_Cond"];
			$V_Gaz[$n] 							= $row["V_Gaz"];
			$V_Cond[$n] 						= $row["V_Cond"];
			$V_Water[$n] 						= $row["V_Water"];
			$av[$n] 							= $row["av"];

			$TT100[$n] 							= $row["TT100"];
			$PT100[$n] 							= $row["PT100"];
			$PT201[$n] 							= $row["PT201"];
			$PDT200[$n] 						= $row["PDT200"];
			$PT202[$n] 							= $row["PT202"];
			$PT300[$n] 							= $row["PT300"];
			$LT300[$n] 							= $row["LT300"];
			$TT300[$n] 							= $row["TT300"];
			$TT500[$n] 							= $row["TT500"];
			$PT500[$n] 							= $row["PT500"];
			$TT700[$n] 							= $row["TT700"];
			$PT700[$n] 							= $row["PT700"];

			$FS_P[$n] 							= $row["FS_P"];
			$FS_T[$n] 							= $row["FS_T"];
			$FS_Qw[$n] 							= $row["FS_Qw"];
			$FS_Qs[$n] 							= $row["FS_Qs"];
			$RT_Dens[$n] 						= $row["RT_Dens"];
			$RT_Vlaj[$n] 						= $row["RT_Vlaj"];


			$n = $n + 1;
		}   

    }else{
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
    }



?>

<div class="container-fluid">
	<div class="table">
		<table class="table table-striped table-bordered text-nowrap">
		  <tbody class="align-middle text-center">
		    <tr class="stick_1 table-dark">
		      <td scope="col">#</td>
		      <td colspan="3" scope="col">Идентификационные параметры скважины</td>
		      <td colspan="5" scope="col">Идентификационные параметров замера</td>
		      <td colspan="6" scope="col">Блок параметров по скважине (ХАЛ), вводимых оператором</td>
		      <td colspan="10" scope="col">Блок параметров по скважине</td>
		      <td colspan="12" scope="col">Блок основных результатов по скважине</td>
		      <td colspan="12" scope="col">Общие технологические параметры установки при измерении</td>
		      <td colspan="4" scope="col">Блок параметров по газовой линии, связанных с работой и расчетом по ултразвуковому расходомеру - FLOWSIC</td>
		      <td colspan="4" scope="col">Результаты измерения кориолисовым расходомером жидкости ROTAMASS</td>
		    </tr>
		    <tr class="stick_2 table-light">
		      <td scope="col">Дата записи в журнал</td>
		      <td scope="col">Месторождение	</td>
		      <td scope="col">Куст</td>
		      <td scope="col">Скважина</td>

		      <td scope="col">Время старта</td>
		      <td scope="col">Время оконч.</td>
		      <td scope="col">Время изм., с</td>
		      <td scope="col">Режим (проточный/налив-слив)</td>
		      <td scope="col">Расчет (по влагомеру/по ХАЛ)</td>

		      <td scope="col">Доля механических примесей</td>
		      <td scope="col">Концентрация хлористых солей</td>
		      <td scope="col">Доля растворенного газа</td>
		      <td scope="col">Влагосодержание</td>
		      <td scope="col">Доля растворенного газа</td>
		      <td scope="col">Плотность выделевшегося из КГН газа</td>

		      <td scope="col">Накопленная масса брутто</td>
		      <td scope="col">Накопленная масса нетто</td>
		      <td scope="col">Накопленный объем газа в УИГ</td>
		      <td scope="col">Накопленная масса газа в линии ГЖС</td>
		      <td scope="col">Накопленный объем газа в линии ГЖС</td>
		      <td scope="col">Масса газа, прошедшая через УИГ</td>
		      <td scope="col">Масса WC5+</td>
		      <td scope="col">Масса воды, прошедшя через УИГ</td>
		      <td scope="col">Масса КЖ, прошедшая через УИГ</td>
		      <td scope="col">Объем КЖ, прошедший через УИГ</td>

		      <td scope="col">Дебит жидкости</td>
		      <td scope="col">Дебит раств.газа в жидкости</td>
		      <td scope="col">Дебит конденсата</td>
		      <td scope="col">Дебит воды</td>
		      <td scope="col">Дебит газа</td>
		      <td scope="col">Дебит кап.жидкости в газе сепар.</td>
		      <td scope="col">Объём газа</td>
		      <td scope="col">Дебит чистого газа</td>
		      <td scope="col">Дебит чистого конденсата</td>
		      <td scope="col">Накопленная масса воды</td>
		      <td scope="col">Накопленная масса чистого конд</td>
		      <td scope="col">Накопленный V чистого газа</td>

		      <td scope="col">Температура во входном коллекторе</td>
		      <td scope="col">Давление во входном коллекторе</td>
		      <td scope="col">Давление на всасе Н-1</td>
		      <td scope="col">Перепад давления на фильтре</td>
		      <td scope="col">Давление на выкиде Н-1</td>
		      <td scope="col">Давление в газосепараторе ГС-1</td>
		      <td scope="col">Уровень в емкости Е-1</td>
		      <td scope="col">Темп в емкости Е-1</td>
		      <td scope="col">Темп в вых. коллек жидк</td>
		      <td scope="col">Давл в вых. коллек жидк</td>
		      <td scope="col">Темп в вых. коллек газа</td>
		      <td scope="col">Давл в вых. коллек газа</td>

		      <td scope="col">Давление в линии газа	</td>
		      <td scope="col">Температура в линии газа</td>
		      <td scope="col">Дебит газа FLOWSIC</td>
		      <td scope="col">Дебит газа FLOWSIC</td>

		      <td scope="col">Дебит жидкости ROTAMASS</td>
		      <td scope="col">Масса жидкости ROTAMASS</td>
		      <td scope="col">Плотность жидкости ROTAMASS</td>
		      <td scope="col">Обводнённость влагомер</td>
		    </tr>

		    <tr class="table-dark stick_3">
		      <td scope="col">-</td>
		      <td scope="col">-</td>
		      <td scope="col">-</td>
		      <td scope="col">-</td>

		      <td scope="col">-</td>
		      <td scope="col">-</td>
		      <td scope="col">-</td>
		      <td scope="col">-</td>
		      <td scope="col">-</td>

		      <td scope="col">W м.п., %масс</td>
		      <td scope="col">W х.с., г/м3</td>
		      <td scope="col">W р.г., %об</td>
		      <td scope="col">W в, %об.</td>
		      <td scope="col">W р.г., %масс</td>
		      <td scope="col">p г. кгн, кг/м3</td>

		      <td scope="col">т</td>
		      <td scope="col">т</td>
		      <td scope="col">м³ ст.у.</td>
		      <td scope="col">т</td>
		      <td scope="col">м³ ст.у.</td>
		      <td scope="col">кг</td>
		      <td scope="col">кг</td>
		      <td scope="col">кг</td>
		      <td scope="col">кг</td>
		      <td scope="col">м³ ст.у.</td>

		      <td scope="col">т/сут</td>
		      <td scope="col">т/сут</td>
		      <td scope="col">т/сут</td>
		      <td scope="col">т/сут</td>
		      <td scope="col">ст.м³/сут</td>
		      <td scope="col">ст.м³/сут</td>
		      <td scope="col">ст.м³</td>
		      <td scope="col">ст.м³/сут</td>
		      <td scope="col">т/сут</td>
		      <td scope="col">т</td>
		      <td scope="col">т</td>
		      <td scope="col">м3</td>

		      <td scope="col">[TT100] С</td>
		      <td scope="col">[PT100] кг/см2</td>
		      <td scope="col">[PT201] кг/см2</td>
		      <td scope="col">[PDT200] кг/см2</td>
		      <td scope="col">[PT202] кг/см2</td>
		      <td scope="col">[PT300] кг/см2</td>
		      <td scope="col">[LT300] см</td>
		      <td scope="col">[TT300] С</td>
		      <td scope="col">[TT500] С</td>
		      <td scope="col">[PT500] кг/см2</td>
		      <td scope="col">[TT700] С</td>
		      <td scope="col">[PT700] кг/см2</td>

		      <td scope="col">кг/см2</td>
		      <td scope="col">°С</td>
		      <td scope="col">м³/сут</td>
		      <td scope="col">ст.м³/сут</td>

		      <td scope="col">т/сут</td>
		      <td scope="col">т</td>
		      <td scope="col">кг/м³</td>
		      <td scope="col">%об</td>
		    </tr>

		    <?php
		    	//echo $Bush[10]; 


				for ($nn = 0; $nn < $n; $nn++){
					//echo $nn;
					echo '<tr>';

						

						echo '<td scope="col">' . $date_time2[$nn]->format("Y-m-d H:i:s") . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Field[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Bush[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Well[$nn])) . '</td>';

						echo '<td scope="col">' . $date_time[$nn]->format("Y-m-d H:i:s") . '</td>';
						echo '<td scope="col">' . $date_time2[$nn]->format("Y-m-d H:i:s") . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Time_m[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Rejim[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Method_obv[$nn])) . '</td>';

						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Dol_mech_prim_Read[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Konc_hlor_sol_Read[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Dol_ras_gaz_Read[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$vlaj_oil_Read[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Dol_ras_gaz_mass[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Dens_gaz_KGN[$nn])) . '</td>';

						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Mass_brutto_Accum[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Mass_netto_Accum[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Volume_Count_Forward_sc_Accum[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Mg_GK[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Vg_GK[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Mass_Gaz_UVP_Accum[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$WC5_Accum[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Mass_water_UIG_Accum[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Mass_KG[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$V_KG[$nn])) . '</td>';

						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Debit_liq[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Debit_gas_in_liq[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Debit_cond[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Debit_gaz[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Debit_KG[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Debit_water[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Clean_Gaz[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$Clean_Cond[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$V_Gaz[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$V_Cond[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$V_Water[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$av[$nn])) . '</td>';

						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$TT100[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$PT100[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$PT201[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$PDT200[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$PT202[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$PT300[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$LT300[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$TT300[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$TT500[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$PT500[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$TT700[$nn])) . '</td>';
						echo '<td scope="col">' . (iconv("windows-1251","utf-8",$PT700[$nn])) . '</td>';

						/*$TT100	 						= array();
	$PT100	 						= array();
	$PT201	 						= array();
	$PDT200	 						= array();
	$PT202	 						= array();
	$PT300	 						= array();
	$LT300	 						= array();
	$TT300	 						= array();
	$TT500	 						= array();
	$PT500	 						= array();
	$TT700	 						= array();
	$PT700	 						= array();*/

					echo '</tr>'  ;
				}

			?>

		  </tbody>
		</table>
	</div>
</div>