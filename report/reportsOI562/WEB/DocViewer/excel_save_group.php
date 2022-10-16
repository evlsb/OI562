<?php


	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
 	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/IOFactory.php';

 	include "function.php";

 	$field     	    = $_POST["field"];
	$bush      		= $_POST["bush"];
	$well      		= $_POST["well"];

 	$day_start      = $_POST["day3"];
	$month_start    = $_POST["month3"];
	$year_start     = $_POST["year3"];

	$day_end      	= $_POST["day4"];
	$month_end      = $_POST["month4"];
	$year_end      	= $_POST["year4"];

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

	//Блок идентификационных параметров скважины
	$id 							= array();		//id
	$Field 							= array();		//Месторождение
	$Bush 							= array();		//Куст
	$Well 							= array();		//Скважина

	//Блок идентификационных данных измерения и информация о режиме измерения
	$date_time 	 					= array();		//Дата начала замера
	$date_time2 	 				= array();		//Дата конца замера
	$Time_m 						= array();		//Время замера
	$Rejim 							= array();		//Режим
	$Method_obv 					= array();		//Метод

	//Блок параметров по скважине, вводимых оператором
	$OW_M_GD 	 					= array();		//Масса газа деазации
	$OW_Dens_GD 	 				= array();		//Плотность газа дегазации
	$OW_V_PO 	 					= array();		//Водное число пробоотборника
	$OW_m_ZO 	 					= array();		//Масса жидкого остатка дегазации
	$OW_Dens_SK 	 				= array();		//Плотность стабильного конденсата
	$OW_m_PROB 	 					= array();		//Масса пробы

	//Расчет из данных "блока параметров по скважине, вводимых оператором"
	$OR_m_RG 	 					= array();		//Плотность стабильного конденсата
	$OR_W_RG 	 					= array();		//Масса пробы

	//Блок параметров по замеру
	$Mass_brutto_Accum   			= array();		//Накопленная масса брутто
	$Mass_netto_Accum   			= array();		//Накопленная масса нетто
	$Mass_water_Accum   			= array();		//Накопленная масса воды
	$V_Cond  						= array();		//Накопленная масса чистого конд
	$Volume_Count_Forward_sc_Accum  = array();		//Накопл.объем газа в УИГ
	$V_Gaz   						= array();		//Накопленный V чистого газа
	$Mg_GK   						= array();		//Накопленная масса газа в линии ГЖС
	$Vg_GK   						= array();		//Накопленный объем газа в линии ГЖС
	$Mass_Gaz_UVP_Accum   			= array();		//Масса газа, прошедшая через УИГ
	$WC5_Accum   					= array();		//Масса WC5+
	$Mass_water_UIG_Accum   		= array();		//Масса воды, прошедшя через УИГ
	$Mass_KG   						= array();		//Масса КЖ, прошедшая через УИГ

	//Блок основных результатов по скважине
	$Debit_liq   					= array();		//Дебит жидкости
	$Debit_cond   					= array();		//Дебит конденсата
	$Debit_water   					= array();		//Дебит воды
	$Clean_Cond   					= array();		//Дебит чистого конденсата
	$Debit_KG   					= array();		//Дебит кап.жидкости в газе сепар.
	$Debit_gaz   					= array();		//Дебит газа
	$Debit_gas_in_liq   			= array();		//Дебит раств.газа в жидкости
	$Debit_V_gas_in_liq   			= array();		//Дебит раств.газа в жидкости
	$Clean_Gaz   					= array();		//Дебит чистого газа

	//Общие технологические параметры установки при измерении
	$TT100   						= array();		//Температура во входном коллекторе
	$PT100   						= array();		//Давление во входном коллекторе
	$PT201   						= array();		//Давление на всасе Н-1
	$PDT200   						= array();		//Перепад давления на фильтре
	$PT202   						= array();		//Давление на выкиде Н-1
	$PT300   						= array();		//Давление в газосепараторе ГС-1
	$LT300   						= array();		//Уровень в емкости Е-1
	$TT300   						= array();		//Темп в емкости Е-1
	$TT500   						= array();		//Темп в вых. коллек жидк
	$PT500   						= array();		//Давл в вых. коллек жидк
	$TT700   						= array();		//Темп в вых. коллек газа
	$PT700   						= array();		//Давл в вых. коллек газа

	//FLOWSIC
	$FS_P   						= array();		//Давление в линии газа
	$FS_T   						= array();		//Температура в линии газа
	$FS_Qw   						= array();		//Дебит газа FLOWSIC
	$FS_Qs   						= array();		//Дебит газа FLOWSIC

	//ROTAMASS
	$Debit_liq   					= array();		//Дебит жидкости ROTAMASS
	$Mass_brutto_Accum   			= array();		//Масса жидкости ROTAMASS
	$RT_Dens   						= array();		//Плотность жидкости ROTAMASS

	//ВСН-2
	$RT_Vlaj   						= array();		//Обводнённость влагомер




	$n = 0;

	if( $conn ) {
    	$stmt = sqlsrv_query( $conn, $tsql);  //выполняем запрос

		if( $stmt === false){  // если не удачно выводим ошибки
			die( print_r(sqlsrv_errors(), true) );
		}

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){

			//Блок идентификационных параметров скважины
			$id[$n] 							= $row["id"];											//id
			$date_time[$n] 						= $row["date_time"];
			$date_time2[$n] 					= $row["date_time2"];											
			$Field[$n] 							= $row["Field"];										//Месторождение
			$Bush[$n] 							= $row["Bush"];											//Куст
			$Well[$n] 							= $row["Well"];											//Скважина

			//Блок идентификационных данных измерения и информация о режиме измерения
			$Time_m[$n] 						= $row["Time_m"];										//Время замера
			$Rejim[$n] 							= $row["Rejim"];										//Режим
			$Method_obv[$n] 					= $row["Method_obv"];									//Метод

			//Блок параметров по скважине, вводимых оператором
			$OW_M_GD[$n] 	 					= $row["OW_M_GD"];										//Масса газа деазации
			$OW_Dens_GD[$n] 	 				= $row["OW_Dens_GD"];									//Плотность газа дегазации
			$OW_V_PO[$n] 	 					= $row["OW_V_PO"];										//Водное число пробоотборника
			$OW_m_ZO[$n] 	 					= $row["OW_m_ZO"];										//Масса жидкого остатка дегазации
			$OW_Dens_SK[$n] 	 				= $row["OW_Dens_SK"];									//Плотность стабильного конденсата
			$OW_m_PROB[$n] 	 					= $row["OW_m_PROB"];									//Масса пробы

			//Расчет из данных "блока параметров по скважине, вводимых оператором"
			$OR_m_RG[$n] 	 					= $row["OR_m_RG"];										//Плотность стабильного конденсата
			$OR_W_RG[$n] 	 					= $row["OR_W_RG"];										//Масса пробы

			//Блок параметров по замеру
			$Mass_brutto_Accum[$n]   			= $row["Mass_brutto_Accum"];							//Накопленная масса брутто
			$Mass_netto_Accum[$n]   			= $row["Mass_netto_Accum"];								//Накопленная масса нетто
			$Mass_water_Accum[$n]   			= $row["Mass_brutto_Accum"] - $row["Mass_netto_Accum"];	//Накопленная масса воды
			$V_Cond[$n]  						= $row["V_Cond"];										//Накопленная масса чистого конд
			$Volume_Count_Forward_sc_Accum[$n]  = $row["Volume_Count_Forward_sc_Accum"];				//Накопл.объем газа в УИГ
			$V_Gaz[$n]   						= $row["V_Gaz"];										//Накопленный V чистого газа
			$Mg_GK[$n]   						= $row["Mg_GK"];										//Накопленная масса газа в линии ГЖС
			$Vg_GK[$n]   						= $row["Vg_GK"];										//Накопленный объем газа в линии ГЖС
			$Mass_Gaz_UVP_Accum[$n]   			= $row["Mass_Gaz_UVP_Accum"];							//Масса газа, прошедшая через УИГ
			$WC5_Accum[$n]   					= $row["WC5_Accum"];									//Масса WC5+
			$Mass_water_UIG_Accum[$n]   		= $row["Mass_water_UIG_Accum"];							//Масса воды, прошедшя через УИГ
			$Mass_KG[$n]   						= $row["Mass_KG"];										//Масса КЖ, прошедшая через УИГ

			//Блок основных результатов по скважине
			$Debit_liq[$n]   					= $row["Debit_liq"];									//Дебит жидкости
			$Debit_cond[$n]   					= $row["Debit_cond"];									//Дебит конденсата
			$Debit_water[$n]   					= $row["Debit_water"];									//Дебит воды
			$Clean_Cond[$n]   					= $row["Clean_Cond"];									//Дебит чистого конденсата
			$Debit_KG[$n]   					= $row["Debit_KG"];										//Дебит кап.жидкости в газе сепар.
			$Debit_gaz[$n]   					= $row["Debit_gaz"];									//Дебит газа
			$Debit_gas_in_liq[$n]   			= $row["Debit_gas_in_liq"];								//Дебит раств.газа в жидкости
			$Debit_V_gas_in_liq[$n]   			= $row["Debit_V_Gaz_GK"];								//Дебит раств.газа в жидкости
			$Clean_Gaz[$n]   					= $row["Clean_Gaz"];									//Дебит чистого газа

			//Общие технологические параметры установки при измерении
			$TT100[$n]   						= $row["TT100"];										//Температура во входном коллекторе
			$PT100[$n]   						= $row["PT100"];										//Давление во входном коллекторе
			$PT201[$n]   						= $row["PT201"];										//Давление на всасе Н-1
			$PDT200[$n]   						= $row["PDT200"];										//Перепад давления на фильтре
			$PT202[$n]   						= $row["PT202"];										//Давление на выкиде Н-1
			$PT300[$n]   						= $row["PT300"];										//Давление в газосепараторе ГС-1
			$LT300[$n]   						= $row["LT300"];										//Уровень в емкости Е-1
			$TT300[$n]   						= $row["TT300"];										//Темп в емкости Е-1
			$TT500[$n]   						= $row["TT500"];										//Темп в вых. коллек жидк
			$PT500[$n]   						= $row["PT500"];										//Давл в вых. коллек жидк
			$TT700[$n]   						= $row["TT700"];										//Темп в вых. коллек газа
			$PT700[$n]   						= $row["PT700"];										//Давл в вых. коллек газа

			//FLOWSIC
			$FS_P[$n]   						= $row["FS_P"];											//Давление в линии газа
			$FS_T[$n]   						= $row["FS_T"];											//Температура в линии газа
			$FS_Qw[$n]   						= $row["FS_Qw"];										//Дебит газа FLOWSIC
			$FS_Qs[$n]   						= $row["FS_Qs"];										//Дебит газа FLOWSIC

			//ROTAMASS
			$Debit_liq[$n]   					= $row["Debit_liq"];									//Дебит жидкости ROTAMASS
			$Mass_brutto_Accum[$n]   			= $row["Mass_brutto_Accum"];							//Масса жидкости ROTAMASS
			$RT_Dens[$n]   						= $row["RT_Dens"];										//Плотность жидкости ROTAMASS

			//ВСН-2
			$RT_Vlaj[$n]   						= $row["RT_Vlaj"];										//Обводнённость влагомер



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

	//----------------------------Настройка ширины столбцов------------------------------
	//Блок идентификационных параметров скважины
	$sheet->getColumnDimension("A")->setWidth(20);
	$sheet->getColumnDimension("B")->setWidth(18);
	$sheet->getColumnDimension("C")->setWidth(8);
	$sheet->getColumnDimension("D")->setWidth(10);
	
	//Блок идентификационных данных измерения и информация о режиме измерения
	$sheet->getColumnDimension("E")->setWidth(20);
	$sheet->getColumnDimension("F")->setWidth(20);
	$sheet->getColumnDimension("G")->setWidth(15);
	$sheet->getColumnDimension("H")->setWidth(17);
	$sheet->getColumnDimension("I")->setWidth(15);
	
	//Блок параметров по скважине, вводимых оператором
	$sheet->getColumnDimension("J")->setWidth(11);
	$sheet->getColumnDimension("K")->setWidth(12);
	$sheet->getColumnDimension("L")->setWidth(17);
	$sheet->getColumnDimension("M")->setWidth(14);
	$sheet->getColumnDimension("N")->setWidth(15);
	$sheet->getColumnDimension("O")->setWidth(15);

	//Расчет из данных "блока параметров по скважине, вводимых оператором"
	$sheet->getColumnDimension("P")->setWidth(30);
	$sheet->getColumnDimension("Q")->setWidth(30);

	//Блок параметров по замеру
	$sheet->getColumnDimension("R")->setWidth(15);
	$sheet->getColumnDimension("S")->setWidth(15);
	$sheet->getColumnDimension("T")->setWidth(15);
	$sheet->getColumnDimension("U")->setWidth(15);
	$sheet->getColumnDimension("V")->setWidth(15);
	$sheet->getColumnDimension("W")->setWidth(15);
	$sheet->getColumnDimension("X")->setWidth(15);
	$sheet->getColumnDimension("Y")->setWidth(15);
	$sheet->getColumnDimension("Z")->setWidth(15);
	$sheet->getColumnDimension("AA")->setWidth(15);
	$sheet->getColumnDimension("AB")->setWidth(15);
	$sheet->getColumnDimension("AC")->setWidth(15);

	//Блок основных результатов по скважине
	$sheet->getColumnDimension("AD")->setWidth(15);
	$sheet->getColumnDimension("AE")->setWidth(15);
	$sheet->getColumnDimension("AF")->setWidth(15);
	$sheet->getColumnDimension("AG")->setWidth(15);
	$sheet->getColumnDimension("AH")->setWidth(15);
	$sheet->getColumnDimension("AI")->setWidth(15);
	$sheet->getColumnDimension("AJ")->setWidth(15);
	$sheet->getColumnDimension("AK")->setWidth(15);
	$sheet->getColumnDimension("AL")->setWidth(15);

	//Общие технологические параметры установки при измерении
	$sheet->getColumnDimension("AM")->setWidth(15);
	$sheet->getColumnDimension("AN")->setWidth(15);
	$sheet->getColumnDimension("AO")->setWidth(15);
	$sheet->getColumnDimension("AP")->setWidth(15);
	$sheet->getColumnDimension("AQ")->setWidth(15);
	$sheet->getColumnDimension("AR")->setWidth(15);
	$sheet->getColumnDimension("AS")->setWidth(15);
	$sheet->getColumnDimension("AT")->setWidth(15);
	$sheet->getColumnDimension("AU")->setWidth(15);
	$sheet->getColumnDimension("AV")->setWidth(15);
	$sheet->getColumnDimension("AW")->setWidth(15);
	$sheet->getColumnDimension("AX")->setWidth(15);

	//FLOWSIC
	$sheet->getColumnDimension("AY")->setWidth(15);
	$sheet->getColumnDimension("AZ")->setWidth(15);
	$sheet->getColumnDimension("BA")->setWidth(15);
	$sheet->getColumnDimension("BB")->setWidth(15);

	//ROTAMASS
	$sheet->getColumnDimension("BC")->setWidth(15);
	$sheet->getColumnDimension("BD")->setWidth(15);
	$sheet->getColumnDimension("BE")->setWidth(15);

	//ВСН-2
	$sheet->getColumnDimension("BF")->setWidth(15);





	




	//Объединяем нужные ячейки в шапке
	$sheet->mergeCells("A1:D1");
	$sheet->mergeCells("E1:I1");
	$sheet->mergeCells("J1:O1");
	$sheet->mergeCells("P1:Q1");
	$sheet->mergeCells("R1:AC1");
	$sheet->mergeCells("AD1:AL1");
	$sheet->mergeCells("AM1:AX1");
	$sheet->mergeCells("AY1:BB1");
	$sheet->mergeCells("BC1:BE1");
	$sheet->mergeCells("BF1:BF1");
	

	//Ровняем их по середине
	$sheet->getStyle("A1:BF1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//Создаем стиль для фона шапки
	$bd = array(
			'fill'=>array(
				'type'=>PHPExcel_Style_Fill::FILL_SOLID,
				'color'=>array('rgb'=>'CFCFCF')
				)
	);
	$sheet->getStyle("A1:BF3")->applyFromArray($bd); //применяем

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
	$sheet->getStyle("A1:BF3")->applyFromArray($border); //применяем

	// Другие свойства шапки
	$sheet->getStyle("A2:BF3")->getAlignment()->setWrapText(true);
	$sheet->getStyle("A1:BF3")->getFont()->getColor()->setRGB('701d18'); 
	$sheet->getStyle("A1:BF3")->getFont()->setBold(true);

	// Фиксируем шапку
	$sheet->freezePane('A4');


	//Подписываем лист
	$sheet->setTitle('Отчет по замерам');
	
	//************ Формируем шапку ********************


	// -----------первая строка шапки--------------------------------
	$sheet->setCellValue("A1", "Блок идентификационных параметров скважины");
	$sheet->setCellValue("E1", "Блок идентификационных данных о режиме измерения");
	$sheet->setCellValue("J1", "Блок параметров по скважине, вводимых оператором");
	$sheet->setCellValue("P1", "Расчет из данных блока, вводимых оператором");
	$sheet->setCellValue("R1", "Блок параметров по замеру");
	$sheet->setCellValue("AD1", "Блок основных результатов по скважине");
	$sheet->setCellValue("AM1", "Общие технологические параметры установки при измерении");
	$sheet->setCellValue("AY1", "FLOWSIC");
	$sheet->setCellValue("BC1", "ROTAMASS");
	$sheet->setCellValue("BF1", "ВСН-2");

	// -----------вторая строка шапки--------------------------------
	//Блок идентификационных параметров скважины
	$sheet->setCellValue("A2", "Дата/Время\nзаписи в журнал");
	$sheet->setCellValue("B2", "Месторождение");
	$sheet->setCellValue("C2", "Куст");
	$sheet->setCellValue("D2", "Скважина");

	//Блок идентификационных данных измерения и информация о режиме измерения
	$sheet->setCellValue("E2", "Дата/Время старта");
	$sheet->setCellValue("F2", "Дата/Время окончания");
	$sheet->setCellValue("G2", "Время замера");
	$sheet->setCellValue("H2", "Режим");
	$sheet->setCellValue("I2", "Расчёт\nобводненности");

	//Блок параметров по скважине, вводимых оператором
	$sheet->setCellValue("J2", "Масса газа деазации");
	$sheet->setCellValue("K2", "Плотность газа дегазации");
	$sheet->setCellValue("L2", "Водное число пробоотборника");
	$sheet->setCellValue("M2", "Масса жидкого остатка дегазации");
	$sheet->setCellValue("N2", "Плотность стабильного конденсата");
	$sheet->setCellValue("O2", "Масса пробы");

	//Расчет из данных "блока параметров по скважине, вводимых оператором"
	$sheet->setCellValue("P2", "Масса растворенного газа");
	$sheet->setCellValue("Q2", "Массовая доля растворенного газа");

	//Блок параметров по замеру
	$sheet->setCellValue("R2", "(ГК брутто)");
	$sheet->setCellValue("S2", "(ГК нетто)");
	$sheet->setCellValue("T2", "Накопленная масса воды");
	$sheet->setCellValue("U2", "Накопленная масса чистого конд");
	$sheet->setCellValue("V2", "Накопл.объем газа в УИГ");
	$sheet->setCellValue("W2", "Накопленный V чистого газа");
	$sheet->setCellValue("X2", "Накопленная масса газа в линии ГЖС (газ дегазации)");
	$sheet->setCellValue("Y2", "Накопленный объем газа в линии ГЖС (газ дегазации)");
	$sheet->setCellValue("Z2", "Масса газа, прошедшая через УИГ");
	$sheet->setCellValue("AA2", "Масса WC5+");
	$sheet->setCellValue("AB2", "Масса воды, прошедшя через УИГ");
	$sheet->setCellValue("AC2", "Масса КЖ, прошедшая через УИГ");

	//Блок основных результатов по скважине
	$sheet->setCellValue("AD2", "Дебит жидкости");
	$sheet->setCellValue("AE2", "Дебит конденсата");
	$sheet->setCellValue("AF2", "Дебит воды");
	$sheet->setCellValue("AG2", "Дебит чистого конденсата");
	$sheet->setCellValue("AH2", "Дебит кап.жидкости в газе сепар.");
	$sheet->setCellValue("AI2", "Дебит газа сепарации");
	$sheet->setCellValue("AJ2", "Дебит раств.газа в жидкости");
	$sheet->setCellValue("AK2", "Дебит раств.газа в жидкости");
	$sheet->setCellValue("AL2", "Дебит чистого газа");

	//Общие технологические параметры установки при измерении
	$sheet->setCellValue("AM2", "Температура во входном коллекторе");
	$sheet->setCellValue("AN2", "Давление во входном коллекторе");
	$sheet->setCellValue("AO2", "Давление на всасе Н-1");
	$sheet->setCellValue("AP2", "Перепад давления на фильтре");
	$sheet->setCellValue("AQ2", "Давление на выкиде Н-1");
	$sheet->setCellValue("AR2", "Давление в газосепараторе ГС-1");
	$sheet->setCellValue("AS2", "Уровень в емкости Е-1");
	$sheet->setCellValue("AT2", "Темп в емкости Е-1");
	$sheet->setCellValue("AU2", "Темп в вых. коллек жидк");
	$sheet->setCellValue("AV2", "Давл в вых. коллек жидк");
	$sheet->setCellValue("AW2", "Темп в вых. коллек газа");
	$sheet->setCellValue("AX2", "Давл в вых. коллек газа");

	//FLOWSIC
	$sheet->setCellValue("AY2", "Давление в линии газа");
	$sheet->setCellValue("AZ2", "Температура в линии газа");
	$sheet->setCellValue("BA2", "Дебит газа FLOWSIC");
	$sheet->setCellValue("BB2", "Дебит газа FLOWSIC");

	//ROTAMASS
	$sheet->setCellValue("BC2", "Дебит жидкости");
	$sheet->setCellValue("BD2", "Масса жидкости");
	$sheet->setCellValue("BE2", "Плотность жидкости");

	//ВСН-2
	$sheet->setCellValue("BF2", "Обводнённость");





	// -----------третья строка шапки--------------------------------
	//Блок идентификационных параметров скважины			
	$sheet->setCellValue("A3", "-");
	$sheet->setCellValue("B3", "-");
	$sheet->setCellValue("C3", "-");
	$sheet->setCellValue("D3", "-");
	
	//Блок идентификационных данных измерения и информация о режиме измерения
	$sheet->setCellValue("E3", "-");
	$sheet->setCellValue("F3", "-");
	$sheet->setCellValue("G3", "сек.");
	$sheet->setCellValue("H3", "-");
	$sheet->setCellValue("I3", "-");
	
	//Блок параметров по скважине, вводимых оператором
	$sheet->setCellValue("J3", "кг");
	$sheet->setCellValue("K3", "кг/м³");
	$sheet->setCellValue("L3", "дм³");
	$sheet->setCellValue("M3", "кг");
	$sheet->setCellValue("N3", "г/см³");
	$sheet->setCellValue("O3", "кг");

	//Расчет из данных "блока параметров по скважине, вводимых оператором"
	$sheet->setCellValue("P3", "кг");
	$sheet->setCellValue("Q3", "% масс");

	//Блок параметров по замеру
	$sheet->setCellValue("R3", "т");
	$sheet->setCellValue("S3", "т");
	$sheet->setCellValue("T3", "т");
	$sheet->setCellValue("U3", "т");
	$sheet->setCellValue("V3", "м³ ст.у.");
	$sheet->setCellValue("W3", "м³ ст.у.");
	$sheet->setCellValue("X3", "т");
	$sheet->setCellValue("Y3", "м³ ст.у.");
	$sheet->setCellValue("Z3", "т");
	$sheet->setCellValue("AA3", "т");
	$sheet->setCellValue("AB3", "т");
	$sheet->setCellValue("AC3", "т");

	//Блок основных результатов по скважине
	$sheet->setCellValue("AD3", "т/сут");
	$sheet->setCellValue("AE3", "т/сут");
	$sheet->setCellValue("AF3", "т/сут");
	$sheet->setCellValue("AG3", "т/сут");
	$sheet->setCellValue("AH3", "т/сут");
	$sheet->setCellValue("AI3", "ст.м³/сут");
	$sheet->setCellValue("AJ3", "т/сут");
	$sheet->setCellValue("AK3", "ст.м³/сут");
	$sheet->setCellValue("AL3", "ст.м³/сут");

	//Общие технологические параметры установки при измерении
	$sheet->setCellValue("AM3", "°С");
	$sheet->setCellValue("AN3", "МПа");
	$sheet->setCellValue("AO3", "кПа");
	$sheet->setCellValue("AP3", "кПа");
	$sheet->setCellValue("AQ3", "МПа");
	$sheet->setCellValue("AR3", "МПа");
	$sheet->setCellValue("AS3", "%");
	$sheet->setCellValue("AT3", "°С");
	$sheet->setCellValue("AU3", "°С");
	$sheet->setCellValue("AV3", "МПа");
	$sheet->setCellValue("AW3", "°С");
	$sheet->setCellValue("AX3", "МПа");

	//FLOWSIC
	$sheet->setCellValue("AY3", "МПа");
	$sheet->setCellValue("AZ3", "°С");
	$sheet->setCellValue("BA3", "м³/сут");
	$sheet->setCellValue("BB3", "ст.м³/сут");

	//ROTAMASS
	$sheet->setCellValue("BC3", "т/сут");
	$sheet->setCellValue("BD3", "т");
	$sheet->setCellValue("BE3", "кг/м³");

	//ВСН-2
	$sheet->setCellValue("BF3", "% объем.");



	
	

	$num_str = 4;

	$nn = 0;


	for ($nn = 0; $nn < $n; $nn++){

		//Блок идентификационных параметров скважины
		$sheet->setCellValue("A".$num_str, $date_time2[$nn]);								//Дата записи в журнал
		$sheet->setCellValue("B".$num_str, iconv("windows-1251","utf-8",$Field[$nn]));		//Месторождение
		$sheet->setCellValue("C".$num_str, iconv("windows-1251","utf-8",$Bush[$nn]));		//Куст
		$sheet->setCellValue("D".$num_str, iconv("windows-1251","utf-8",$Well[$nn]));		//Скважина

		//Блок идентификационных данных измерения и информация о режиме измерения
		$sheet->setCellValue("E".$num_str, $date_time[$nn]);								//Дата начала замера
		$sheet->setCellValue("F".$num_str, $date_time2[$nn]);								//Дата конца замера
		$sheet->setCellValue("G".$num_str, $Time_m[$nn]);									//Время замера
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

		//Блок идентификационных данных измерения и информация о режиме измерения
		$sheet->setCellValue("J".$num_str, $OW_M_GD[$nn]);									//Масса газа деазации
		$sheet->setCellValue("K".$num_str, $OW_Dens_GD[$nn]);								//Плотность газа дегазации
		$sheet->setCellValue("L".$num_str, $OW_V_PO[$nn]);									//Водное число пробоотборника
		$sheet->setCellValue("M".$num_str, $OW_m_ZO[$nn]);									//Масса жидкого остатка дегазации
		$sheet->setCellValue("N".$num_str, $OW_Dens_SK[$nn]);								//Плотность стабильного конденсата
		$sheet->setCellValue("O".$num_str, $OW_m_PROB[$nn]);								//Масса пробы

		//Расчет из данных "блока параметров по скважине, вводимых оператором"
		$sheet->setCellValue("P".$num_str, $OR_m_RG[$nn]);									//Масса растворенного газа
		$sheet->setCellValue("Q".$num_str, $OR_W_RG[$nn]);									//Массовая доля растворенного газа

		//Блок параметров по замеру
		$sheet->setCellValue("R".$num_str, $Mass_brutto_Accum[$nn]);						//Накопленная масса брутто
		$sheet->setCellValue("S".$num_str, $Mass_netto_Accum[$nn]);							//Накопленная масса нетто
		$sheet->setCellValue("T".$num_str, $Mass_water_Accum[$nn]);							//Накопленная масса воды
		$sheet->setCellValue("U".$num_str, $V_Cond[$nn]);									//Накопленная масса чистого конд
		$sheet->setCellValue("V".$num_str, $Volume_Count_Forward_sc_Accum[$nn]);			//Накопл.объем газа в УИГ
		$sheet->setCellValue("W".$num_str, $V_Gaz[$nn]);									//Накопленный V чистого газа
		$sheet->setCellValue("X".$num_str, $Mg_GK[$nn]);									//Накопленная масса газа в линии ГЖС
		$sheet->setCellValue("Y".$num_str, $Vg_GK[$nn]);									//Накопленный объем газа в линии ГЖС
		$sheet->setCellValue("Z".$num_str, $Mass_Gaz_UVP_Accum[$nn]);						//Масса газа, прошедшая через УИГ
		$sheet->setCellValue("AA".$num_str, $WC5_Accum[$nn]);								//Масса WC5+
		$sheet->setCellValue("AB".$num_str, $Mass_water_UIG_Accum[$nn]);					//Масса воды, прошедшя через УИГ
		$sheet->setCellValue("AC".$num_str, $Mass_KG[$nn]);									//Масса КЖ, прошедшая через УИГ

		//Блок параметров по замеру
		$sheet->setCellValue("AD".$num_str, $Debit_liq[$nn]);								//Дебит жидкости
		$sheet->setCellValue("AE".$num_str, $Debit_cond[$nn]);								//Дебит конденсата
		//$sheet->setCellValue("AF".$num_str, $Debit_water[$nn]);							//Дебит воды
		$sheet->setCellValue("AF".$num_str, ($Debit_liq[$nn] - $Debit_cond[$nn]));			//Дебит воды
		$sheet->setCellValue("AG".$num_str, $Clean_Cond[$nn]);								//Дебит чистого конденсата
		$sheet->setCellValue("AH".$num_str, $Debit_KG[$nn]);								//Дебит кап.жидкости в газе сепар.
		$sheet->setCellValue("AI".$num_str, $Debit_gaz[$nn]);								//Дебит газа
		$sheet->setCellValue("AJ".$num_str, $Debit_gas_in_liq[$nn]);						//Дебит раств.газа в жидкости
		$sheet->setCellValue("AK".$num_str, $Debit_V_gas_in_liq[$nn]);						//Дебит раств.газа в жидкости
		$sheet->setCellValue("AL".$num_str, $Clean_Gaz[$nn]);

		//Общие технологические параметры установки при измерении
		$sheet->setCellValue("AM".$num_str, $TT100[$nn]);									//Температура во входном коллекторе
		$sheet->setCellValue("AN".$num_str, $PT100[$nn]);									//Давление во входном коллекторе
		$sheet->setCellValue("AO".$num_str, $PT201[$nn]);									//Давление на всасе Н-1
		$sheet->setCellValue("AP".$num_str, $PDT200[$nn]);									//Перепад давления на фильтре
		$sheet->setCellValue("AQ".$num_str, $PT202[$nn]);									//Давление на выкиде Н-1
		$sheet->setCellValue("AR".$num_str, $PT300[$nn]);									//Давление в газосепараторе ГС-1
		$sheet->setCellValue("AS".$num_str, $LT300[$nn]);									//Уровень в емкости Е-1
		$sheet->setCellValue("AT".$num_str, $TT300[$nn]);									//Темп в емкости Е-1
		$sheet->setCellValue("AU".$num_str, $TT500[$nn]);									//Темп в вых. коллек жидк
		$sheet->setCellValue("AV".$num_str, $PT500[$nn]);									//Давл в вых. коллек жидк
		$sheet->setCellValue("AW".$num_str, $TT700[$nn]);									//Темп в вых. коллек газа
		$sheet->setCellValue("AX".$num_str, $PT700[$nn]);									//Давл в вых. коллек газа

		//FLOWSIC
		$sheet->setCellValue("AY".$num_str, $FS_P[$nn]);									//Давление в линии газа
		$sheet->setCellValue("AZ".$num_str, $FS_T[$nn]);									//Температура в линии газа
		$sheet->setCellValue("BA".$num_str, $FS_Qw[$nn]);									//Дебит газа FLOWSIC
		$sheet->setCellValue("BB".$num_str, $FS_Qs[$nn]);									//Дебит газа FLOWSIC

		//ROTAMASS
		$sheet->setCellValue("BC".$num_str, $Debit_liq[$nn]);								//Дебит жидкости ROTAMASS
		$sheet->setCellValue("BD".$num_str, $Mass_brutto_Accum[$nn]);						//Масса жидкости ROTAMASS
		$sheet->setCellValue("BE".$num_str, $RT_Dens[$nn]);									//Плотность жидкости ROTAMASS

		//ВСН-2
		$sheet->setCellValue("BF".$num_str, $RT_Vlaj[$nn]);									//Обводнённость влагомер


	


		

		$num_str = $num_str +1;

		//echo ($nn."<br />");

	}




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