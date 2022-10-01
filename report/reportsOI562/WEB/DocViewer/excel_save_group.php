<?php


	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
 	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/IOFactory.php';

 	   include "function.php";

 	$field     	    = $_POST["field"];
	$bush      		= $_POST["bush"];
	$well      		= $_POST["well"];

	//$day_start      = $_POST["day_start"];
	//$month_start    = $_POST["month_start"];
	//$year_start     = $_POST["year_start"];

	//$day_end      	= $_POST["day_end"];
	//$month_end      = $_POST["month_end"];
	//$year_end      	= $_POST["year_end"];
	$day_start      = $_POST["day3"];
	$month_start    = $_POST["month3"];
	$year_start     = $_POST["year3"];

	$day_end      	= $_POST["day4"];
	$month_end      = $_POST["month4"];
	$year_end      	= $_POST["year4"];

	//$ServerName     = $_POST["ServerName"];
	//$Database      	= $_POST["Database"];
	//$UID      		= $_POST["UID"];
	//$PWD      		= $_POST["PWD"];
	$ServerName     = "DESKTOP-DQQKSJF\WINCC";
	$Database      	= "OI562";
	$UID      		= "ozna";
	$PWD      		= "ozna";


	$month_start1 = mounth_num($month_start);
	$month_end1 = mounth_num($month_end);

	$dateb = $year_start . "-". $month_start1. "-" . $day_start . " 00:00:00";
	$datee = $year_end . "-". $month_end1. "-" . $day_end . " 00:00:00";


	$date_b = DateTime::createFromFormat('Y-m-d H:i:s', $dateb);
	
	$date_b->modify("-1 second");
	$date_b = $date_b->format('Ymd H:i:s');
	//echo $date_b;

	$date_e = DateTime::createFromFormat('Y-m-d H:i:s', $datee);
	$date_e->modify("+1 day");
	//$date_e->modify("+1 second");
	$date_e = $date_e->format('Ymd H:i:s');
	//echo $date_e;

	//---------------------приводит числа к нормальному виду---------------------------------------------------------------------------------------

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

		//------------------------------------------------------------------------------------------------------------



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



	$tsql = "SELECT * FROM Zamer_01 WHERE ((date_time between date_b and date_e) field bush well) ORDER BY date_time asc;";


	$tsql=str_replace("date_b", "'".$date_b."'", $tsql);
	$tsql=str_replace("date_e", "'".$date_e."'", $tsql); 

	$tsql=str_replace("field", $field_s, $tsql);
	$tsql=str_replace("bush", $bush_s, $tsql);
	$tsql=str_replace("well", $well_s, $tsql);

	$tsql = iconv("utf-8","windows-1251",$tsql);

	//echo $tsql;


	//echo $field;
	//echo $bush;
	//echo $well;
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
			//echo iconv("windows-1251","utf-8",$Field[$n]);
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
			$Debit_water[$n] 					= $row["V_KG"];
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



 	//Создаем объект класса PHPExcel
	$xls = new PHPExcel();
	//Устанавливаем индекс активного листа
	$xls->setActiveSheetIndex();
	//Получаем активный лист
	$sheet = $xls->getActiveSheet();

	//Настройка ширины столбцов
	$sheet->getColumnDimension("A")->setWidth(20);
	$sheet->getColumnDimension("B")->setWidth(18);
	$sheet->getColumnDimension("C")->setWidth(8);
	$sheet->getColumnDimension("D")->setWidth(10);
	
	$sheet->getColumnDimension("E")->setWidth(20);
	$sheet->getColumnDimension("F")->setWidth(20);
	$sheet->getColumnDimension("G")->setWidth(15);
	$sheet->getColumnDimension("H")->setWidth(17);
	$sheet->getColumnDimension("I")->setWidth(15);
	
	$sheet->getColumnDimension("J")->setWidth(11);
	$sheet->getColumnDimension("K")->setWidth(12);
	$sheet->getColumnDimension("L")->setWidth(17);
	$sheet->getColumnDimension("M")->setWidth(14);
	$sheet->getColumnDimension("N")->setWidth(15);
	
	$sheet->getColumnDimension("O")->setWidth(13);
	$sheet->getColumnDimension("P")->setWidth(13);
	$sheet->getColumnDimension("Q")->setWidth(13);
	$sheet->getColumnDimension("R")->setWidth(13);
	$sheet->getColumnDimension("S")->setWidth(14);
	$sheet->getColumnDimension("T")->setWidth(14);
	$sheet->getColumnDimension("U")->setWidth(13);
	$sheet->getColumnDimension("V")->setWidth(13);
	$sheet->getColumnDimension("W")->setWidth(12);
	$sheet->getColumnDimension("X")->setWidth(12);
	$sheet->getColumnDimension("Y")->setWidth(12);
	$sheet->getColumnDimension("Z")->setWidth(12);
	
	$sheet->getColumnDimension("AA")->setWidth(11);
	$sheet->getColumnDimension("AB")->setWidth(11);
	$sheet->getColumnDimension("AC")->setWidth(12);
	$sheet->getColumnDimension("AD")->setWidth(12);
	$sheet->getColumnDimension("AE")->setWidth(14);
	$sheet->getColumnDimension("AF")->setWidth(11);
	$sheet->getColumnDimension("AG")->setWidth(12);
	$sheet->getColumnDimension("AH")->setWidth(11);

	$sheet->getColumnDimension("AI")->setWidth(13);
	$sheet->getColumnDimension("AJ")->setWidth(12);
	$sheet->getColumnDimension("AK")->setWidth(12);
	$sheet->getColumnDimension("AL")->setWidth(11);
	$sheet->getColumnDimension("AM")->setWidth(10);
	$sheet->getColumnDimension("AN")->setWidth(15);
	$sheet->getColumnDimension("AO")->setWidth(12);
	$sheet->getColumnDimension("AP")->setWidth(12);
	$sheet->getColumnDimension("AQ")->setWidth(15);
	$sheet->getColumnDimension("AR")->setWidth(14);
	$sheet->getColumnDimension("AS")->setWidth(12);
	$sheet->getColumnDimension("AT")->setWidth(12);

	$sheet->getColumnDimension("AU")->setWidth(11);
	$sheet->getColumnDimension("AV")->setWidth(13);
	$sheet->getColumnDimension("AW")->setWidth(15);
	$sheet->getColumnDimension("AX")->setWidth(15);

	$sheet->getColumnDimension("AY")->setWidth(11);
	$sheet->getColumnDimension("AZ")->setWidth(11);
	$sheet->getColumnDimension("BA")->setWidth(11);
	$sheet->getColumnDimension("BB")->setWidth(15);

	

	//Объединяем нужные ячейки в шапке
	$sheet->mergeCells("A1:D1");
	$sheet->mergeCells("E1:I1");
	$sheet->mergeCells("J1:N1");
	$sheet->mergeCells("O1:Z1");
	$sheet->mergeCells("AA1:AH1");
	$sheet->mergeCells("AI1:AT1");
	$sheet->mergeCells("AU1:AX1");
	$sheet->mergeCells("AY1:BB1");


	//Ровняем их по середине
	$sheet->getStyle("A1:BB1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//Создаем стиль для фона шапки
	$bd = array(
			'fill'=>array(
				'type'=>PHPExcel_Style_Fill::FILL_SOLID,
				'color'=>array('rgb'=>'CFCFCF')
				)
	);
	$sheet->getStyle("A1:BB3")->applyFromArray($bd); //применяем

	//Создаем стиль для рамки шапки
	$border = array(
			'borders'=>array(
				'outline'=>array(
					'style'=>PHPExcel_Style_Border::BORDER_THICK,
					'color'=>array('rgb'=>'000000')
				),
				'allborders'=>array(
					'style'=>PHPExcel_Style_Border::BORDER_THIN,
					'color'=>array('rgb'=>'000000')
				)));
	$sheet->getStyle("A1:BB3")->applyFromArray($border); //применяем

	// Другие свойства шапки
	$sheet->getStyle("A2:BB3")->getAlignment()->setWrapText(true);
	$sheet->getStyle("A1:BB3")->getFont()->getColor()->setRGB('701d18'); 
	$sheet->getStyle("A1:BB3")->getFont()->setBold(true);

	// Фиксируем шапку
	$sheet->freezePane('A4');


	//Подписываем лист
	$sheet->setTitle('Отчет по замерам');
	
	//************ Формируем шапку ********************
	// первая строка шапки
	$sheet->setCellValue("A1", "Блок идентификационных параметров скважины");
	$sheet->setCellValue("E1", "Блок идентификационных данных о режиме измерения");
	$sheet->setCellValue("J1", "Блок параметров по скважине, вводимых оператором");
	$sheet->setCellValue("O1", "Блок параметров по замеру");
	$sheet->setCellValue("AA1", "Блок основных результатов по скважине");
	$sheet->setCellValue("AI1", "Общие технологические параметры установки при измерении");
	$sheet->setCellValue("AU1", "Ультразвуковой расходомер FLOWSIC");
	$sheet->setCellValue("AY1", "Кориолисовый расходомер ROTAMASS");

	// вторая строка шапки
	$sheet->setCellValue("A2", "Дата/Время\nзаписи в журнал");
	$sheet->setCellValue("B2", "Месторождение");
	$sheet->setCellValue("C2", "Куст");
	$sheet->setCellValue("D2", "Скважина");

	$sheet->setCellValue("E2", "Дата/Время старта");
	$sheet->setCellValue("F2", "Дата/Время окончания");
	$sheet->setCellValue("G2", "Время замера");
	$sheet->setCellValue("H2", "Режим");
	$sheet->setCellValue("I2", "Расчёт\nобводненности");

	$sheet->setCellValue("J2", "Доля мех.\nпримесей");
	$sheet->setCellValue("K2", "Доля\nхлор. солей");
	$sheet->setCellValue("L2", "Влагосодержание");
	$sheet->setCellValue("M2", "Доля\nрастворенного\nгаза");
	$sheet->setCellValue("N2", "Плотность\nвыделевшегося\nиз КГН газа");

	$sheet->setCellValue("O2", "Накопленная\nмасса жидкости");
	$sheet->setCellValue("P2", "Накопленная\nмасса конденсата");
	$sheet->setCellValue("Q2", "Накопленная\nмасса воды (расчет)");
	$sheet->setCellValue("R2", "Накопленная\nмасса общего\nконденсата (расчет)");
	$sheet->setCellValue("S2", "Накопленный\nобъем газа\nв газовом трубопроводе");
	$sheet->setCellValue("T2", "Накопленный\nобъем\nобщего газа (расчет)");
	$sheet->setCellValue("U2", "Накопленная\nмасса газа\nв линии ГЖС");
	$sheet->setCellValue("V2", "Накопленный\nобъем газа\nв линии ГЖС");
	$sheet->setCellValue("W2", "Масса газа,\nпрошедшая через УИГ");
	$sheet->setCellValue("X2", "Масса WC5+");
	$sheet->setCellValue("Y2", "Масса воды,\nпрошедшая через УИГ");
	$sheet->setCellValue("Z2", "Масса КЖ,\nпрошедшая через УИГ");
	
	$sheet->setCellValue("AA2", "Дебит\nжидкости");
	$sheet->setCellValue("AB2", "Дебит\nконденсата");
	$sheet->setCellValue("AC2", "Дебит воды\n (расчет)");
	$sheet->setCellValue("AD2", "Суммарный\nдебит\nконденсата");
	$sheet->setCellValue("AE2", "Дебит\nкап.жидкости\nв газе сепар.");
	$sheet->setCellValue("AF2", "Дебит газа ");
	$sheet->setCellValue("AG2", "Дебит\nраств.газа\nв  жидкости");
	$sheet->setCellValue("AH2", "Суммарный\nдебит\nгаза");
	
	$sheet->setCellValue("AI2", "[TT100]\nТемпература\nво входном\nколлекторе");
	$sheet->setCellValue("AJ2", "[PT100]\nДавление\nво входном\nколлекторе");
	$sheet->setCellValue("AK2", "[PT201]\nДавление\nна всасе Н-1");
	$sheet->setCellValue("AL2", "[PDT200]\nПерепад\nдавления\nна фильтре");
	$sheet->setCellValue("AM2", "[PT202]\nДавление\nна выкиде\nН-1");
	$sheet->setCellValue("AN2", "[PT300]\nДавление в\nгазосепараторе\nГС-1");
	$sheet->setCellValue("AO2", "[LT300]\nУровень в\nемкости Е-1");
	$sheet->setCellValue("AP2", "[TT300]\nТемп-ра в\nемкости Е-1");
	$sheet->setCellValue("AQ2", "[TT500]\n Темп-ра в вых.\nколлек. жидк.");
	$sheet->setCellValue("AR2", "[PT500]\n Давл в вых.\nколлек. жидк.");
	$sheet->setCellValue("AS2", "[TT700]\n Темп в вых.\nколлек. газа");
	$sheet->setCellValue("AT2", "[PT700]\n Давл в вых.\nколлек. газа");

	$sheet->setCellValue("AU2", "Давление в\nлинии газа");
	$sheet->setCellValue("AV2", "Температура\nв линии газа");
	$sheet->setCellValue("AW2", "Дебит газа\nFLOWSIC (р.у.)");
	$sheet->setCellValue("AX2", "Дебит газа\nFLOWSIC (ст.у.)");

	$sheet->setCellValue("AY2", "Дебит\nжидкости\nROTAMASS");
	$sheet->setCellValue("AZ2", "Масса\nжидкости\nROTAMASS");
	$sheet->setCellValue("BA2", "Плотность\nжидкости\nROTAMASS");
	$sheet->setCellValue("BB2", "Обводнённость\nвлагомер");


	// третья строка шапки			
	$sheet->setCellValue("A3", "-");
	$sheet->setCellValue("B3", "-");
	$sheet->setCellValue("C3", "-");
	$sheet->setCellValue("D3", "-");
	
	$sheet->setCellValue("E3", "-");
	$sheet->setCellValue("F3", "-");
	$sheet->setCellValue("G3", "сек.");
	$sheet->setCellValue("H3", "-");
	$sheet->setCellValue("I3", "-");
	
	$sheet->setCellValue("J3", "% масс.");
	$sheet->setCellValue("K3", "% масс.");
	$sheet->setCellValue("L3", "% масс.");
	$sheet->setCellValue("M3", "% масс.");
	$sheet->setCellValue("N3", "кг/м³");
	
	$sheet->setCellValue("O3", "т");
	$sheet->setCellValue("P3", "т");
	$sheet->setCellValue("Q3", "т");
	$sheet->setCellValue("R3", "т");
	$sheet->setCellValue("S3", "м³ ст.у.");
	$sheet->setCellValue("T3", "м³ ст.у.");
	$sheet->setCellValue("U3", "т");
	$sheet->setCellValue("V3", "м³ ст.у.");
	$sheet->setCellValue("W3", "т");
	$sheet->setCellValue("X3", "т");
	$sheet->setCellValue("Y3", "т");
	$sheet->setCellValue("Z3", "т");
	
	$sheet->setCellValue("AA3", "т/сут");
	$sheet->setCellValue("AB3", "т/сут");
	$sheet->setCellValue("AC3", "т/сут");
	$sheet->setCellValue("AD3", "т/сут");
	$sheet->setCellValue("AE3", "т/сут");
	$sheet->setCellValue("AF3", "ст.м³/сут");
	$sheet->setCellValue("AG3", "т/сут");
	$sheet->setCellValue("AH3", "ст.м³/сут");
	
	$sheet->setCellValue("AI3", "°С");
	$sheet->setCellValue("AJ3", "МПа");
	$sheet->setCellValue("AK3", "кПа");
	$sheet->setCellValue("AL3", "кПа");
	$sheet->setCellValue("AM3", "МПа");
	$sheet->setCellValue("AN3", "МПа");
	$sheet->setCellValue("AO3", "%");
	$sheet->setCellValue("AP3", "°С");
	$sheet->setCellValue("AQ3", "°С");
	$sheet->setCellValue("AR3", "МПа");
	$sheet->setCellValue("AS3", "°С");
	$sheet->setCellValue("AT3", "МПа");
	
	$sheet->setCellValue("AU3", "МПа");
	$sheet->setCellValue("AV3", "°С");
	$sheet->setCellValue("AW3", "м³/сут");
	$sheet->setCellValue("AX3", "ст.м³/сут");
	
	$sheet->setCellValue("AY3", "т/сут");
	$sheet->setCellValue("AZ3", "т");
	$sheet->setCellValue("BA3", "кг/м³");
	$sheet->setCellValue("BB3", "% объем.");
	





	$num_str = 4;

	$nn = 0;

	
				for ($nn = 0; $nn < $n; $nn++){
					
					$sheet->setCellValue("A".$num_str, $date_time2[$nn]);								//Дата записи в журнал
					$sheet->setCellValue("B".$num_str, iconv("windows-1251","utf-8",$Field[$nn]));		//Месторождение
					$sheet->setCellValue("C".$num_str, iconv("windows-1251","utf-8",$Bush[$nn]));		//Куст
					$sheet->setCellValue("D".$num_str, iconv("windows-1251","utf-8",$Well[$nn]));		//Скважина

					$sheet->setCellValue("E".$num_str, $date_time[$nn]);								//Дата начала замера
					$sheet->setCellValue("F".$num_str, $date_time2[$nn]);								//Дата конца замера
					$sheet->setCellValue("G".$num_str, $Time_m[$nn]);									//Время замера
					//$sheet->setCellValue("H".$num_str, $Rejim[$nn]);									//Режим
					//$sheet->setCellValue("I".$num_str, $Method[$nn]);									//Метод

					$sheet->setCellValue("J".$num_str, FormatEx($Dol_mech_prim_Read[$nn], 3, $NULL));						//Доля механических примесей
					$sheet->setCellValue("K".$num_str, FormatEx($Konc_hlor_sol_Read[$nn], 3, $NULL));						//Концентрация хлористых солей
					$sheet->setCellValue("L".$num_str, FormatEx($vlaj_oil_Read[$nn], 2, $NULL));							//Влагосодержание
					$sheet->setCellValue("M".$num_str, FormatEx($Dol_ras_gaz_mass[$nn], 3, $NULL));							//Доля растворенного газа
					$sheet->setCellValue("N".$num_str, FormatEx($Dens_gaz_KGN[$nn], 3, $NULL));								//Плотность выделевшегося из КГН газа

					$sheet->setCellValue("O".$num_str, FormatEx($Mass_brutto_Accum[$nn], 7, $NULL));	//Накопленная масса брутто
					$sheet->setCellValue("P".$num_str, FormatEx($Mass_netto_Accum[$nn], 7, $NULL));		//Накопленная масса нетто
					$sheet->setCellValue("Q".$num_str, FormatEx($V_Water[$nn], 7, $NULL));				//Накопленная масса воды
					$sheet->setCellValue("R".$num_str, FormatEx($V_Cond[$nn], 3, $NULL));	//Накопленная масса чистого конд
					$sheet->setCellValue("S".$num_str, FormatEx($Volume_Count_Forward_sc_Accum[$nn], 3, $NULL));//Накопленный объем газа в УИГ
					$sheet->setCellValue("T".$num_str, FormatEx($V_Gaz[$nn], 3, $NULL));	//Накопленный V чистого газа
					$sheet->setCellValue("U".$num_str, FormatEx($Mg_GK[$nn], 6, $NULL));		//Накопленная масса газа в линии ГЖС
					$sheet->setCellValue("V".$num_str, FormatEx($Vg_GK[$nn], 6, $NULL));		//Накопленный объем газа в линии ГЖС
					$sheet->setCellValue("W".$num_str, FormatEx((($Mass_Gaz_UVP_Accum[$nn])/1000), 3, $NULL));	//Масса газа, прошедшая через УИГ
					$sheet->setCellValue("X".$num_str, FormatEx((($WC5_Accum[$nn])/1000), 3, $NULL));			//Масса WC5+
					$sheet->setCellValue("Y".$num_str, FormatEx((($Mass_water_UIG_Accum[$nn])/100), 3, $NULL));	//Масса воды, прошедшя через УИГ
					$sheet->setCellValue("Z".$num_str, FormatEx((($Mass_KG[$nn])/1000), 3, $NULL));			//Масса КЖ, прошедшая через УИГ
					

					$sheet->setCellValue("AA".$num_str, FormatEx($Debit_liq[$nn], 3, $NULL));	//Дебит жидкости
					$sheet->setCellValue("AB".$num_str, FormatEx($Debit_cond[$nn], 3, $NULL));	//Дебит конденсата
					$sheet->setCellValue("AC".$num_str, FormatEx($Debit_water[$nn], 3, $NULL));	//Дебит воды
					$sheet->setCellValue("AD".$num_str, FormatEx($Clean_Cond[$nn], 3, $NULL));	//Суммарный дебит конденсата
					$sheet->setCellValue("AE".$num_str, FormatEx($Debit_KG[$nn], 3, $NULL));	//Дебит кап.жидкости в газе сепар.
					$sheet->setCellValue("AF".$num_str, FormatEx($Debit_gaz[$nn], 3, $NULL));	//Дебит газа
					$sheet->setCellValue("AG".$num_str, FormatEx($Debit_gas_in_liq[$nn], 3, $NULL));	//Дебит раств.газа в  жидкости
					$sheet->setCellValue("AH".$num_str, FormatEx($Clean_Gaz[$nn], 3, $NULL));	//Суммарный дебит газа (расчет)
					
					$sheet->setCellValue("AI".$num_str, FormatEx($TT100[$nn], 2, $NULL));									//Температура во входном коллекторе
					$sheet->setCellValue("AJ".$num_str, FormatEx($PT100[$nn], 3, $NULL));									//Давление во входном коллекторе
					$sheet->setCellValue("AK".$num_str, FormatEx($PT201[$nn], 3, $NULL));									//Давление на всасе Н-1
					$sheet->setCellValue("AL".$num_str, FormatEx($PDT200[$nn], 3, $NULL));									//Перепад давления на фильтре
					$sheet->setCellValue("AM".$num_str, FormatEx($PT202[$nn], 3, $NULL));									//Давление на выкиде Н-1
					$sheet->setCellValue("AN".$num_str, FormatEx($PT300[$nn], 3, $NULL));									//Давление в газосепараторе ГС-1
					$sheet->setCellValue("AO".$num_str, FormatEx($LT300[$nn], 2, $NULL));									//Уровень в емкости Е-1
					$sheet->setCellValue("AP".$num_str, FormatEx($TT300[$nn], 2, $NULL));									//Темп в емкости Е-1
					$sheet->setCellValue("AQ".$num_str, FormatEx($TT500[$nn], 2, $NULL));									//Темп в вых. коллек жидк
					$sheet->setCellValue("AR".$num_str, FormatEx($PT500[$nn], 3, $NULL));									//Давл в вых. коллек жидк
					$sheet->setCellValue("AS".$num_str, FormatEx($TT700[$nn], 2, $NULL));									//Темп в вых. коллек газа
					$sheet->setCellValue("AT".$num_str, FormatEx($PT700[$nn], 3, $NULL));									//Давл в вых. коллек газа

					$sheet->setCellValue("AU".$num_str, FormatEx($FS_P[$nn], 3, $NULL));									//Давление в линии газа
					$sheet->setCellValue("AV".$num_str, FormatEx($FS_T[$nn], 2, $NULL));									//Температура в линии газа
					$sheet->setCellValue("AW".$num_str, FormatEx($FS_Qw[$nn], 3, $NULL));									//Дебит газа FLOWSIC
					$sheet->setCellValue("AX".$num_str, FormatEx($FS_Qs[$nn], 3, $NULL));									//Дебит газа FLOWSIC
					//
					$sheet->setCellValue("AY".$num_str, FormatEx($Debit_liq[$nn], 3, $NULL));	        //Дебит жидкости
					$sheet->setCellValue("AZ".$num_str, FormatEx($Mass_brutto_Accum[$nn], 3, $NULL));	//Накопленная масса брутто
					$sheet->setCellValue("BA".$num_str, FormatEx($RT_Dens[$nn], 3, $NULL));				//Плотность жидкости ROTAMASS
					$sheet->setCellValue("BB".$num_str, FormatEx($RT_Vlaj[$nn], 3, $NULL));				//Обводнённость влагомер



					if(iconv("windows-1251","utf-8",$Rejim[$nn]) == 1){
						$sheet->setCellValue("H".$num_str, "проточный");
					}else{
						$sheet->setCellValue("H".$num_str, "налив/слив");
					}
					if(iconv("windows-1251","utf-8",$Method_obv[$nn]) == 1){
						$sheet->setCellValue("I".$num_str, "по влагомеру");
					}else{
						$sheet->setCellValue("I".$num_str, "по данным ХАЛ");
					}

					$num_str = $num_str +1;

				}



	//$sheet->setCellValue("I4", $date_time[0]);
	
	//Выводим содержимое файла
	$objWriter = new PHPExcel_Writer_Excel2007($xls);
	//$objWriter->save('../PKIOS.xlsx');
	$objWriter->save('C:\Users\admin\Desktop\Reports\PKIOS.xlsx');

	


?>

<div>Excel документ сформирован</div>

<form action="/web/docviewer/index.php" method="post">

		<input type="submit" name="ok" value="вернуться к отчетам">

	</form>

		<br />
		<br />