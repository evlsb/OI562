<?php

	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
 	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/IOFactory.php';


 	//Создаем объект класса PHPExcel
	$xls = new PHPExcel();
	//Устанавливаем индекс активного листа
	$xls->setActiveSheetIndex();
	//Получаем активный лист
	$sheet = $xls->getActiveSheet();

	//Настройка ширины столбцов
	/*$sheet->getColumnDimension("A")->setWidth(12);
	$sheet->getColumnDimension("B")->setWidth(13);
	$sheet->getColumnDimension("C")->setWidth(18);
	$sheet->getColumnDimension("D")->setWidth(13);
	$sheet->getColumnDimension("E")->setWidth(13);
	$sheet->getColumnDimension("F")->setWidth(20);
	$sheet->getColumnDimension("G")->setWidth(20);
	$sheet->getColumnDimension("H")->setWidth(15);
	$sheet->getColumnDimension("I")->setWidth(17);
	$sheet->getColumnDimension("J")->setWidth(15);
	$sheet->getColumnDimension("K")->setWidth(11);
	$sheet->getColumnDimension("L")->setWidth(14);
	$sheet->getColumnDimension("M")->setWidth(14);
	$sheet->getColumnDimension("N")->setWidth(17);
	$sheet->getColumnDimension("O")->setWidth(14);
	$sheet->getColumnDimension("P")->setWidth(15);

	$sheet->getColumnDimension("Q")->setWidth(13);
	$sheet->getColumnDimension("R")->setWidth(13);
	$sheet->getColumnDimension("S")->setWidth(15);
	$sheet->getColumnDimension("T")->setWidth(13);
	$sheet->getColumnDimension("U")->setWidth(13);
	$sheet->getColumnDimension("V")->setWidth(12);
	$sheet->getColumnDimension("W")->setWidth(12);
	$sheet->getColumnDimension("X")->setWidth(12);
	$sheet->getColumnDimension("Y")->setWidth(12);
	$sheet->getColumnDimension("Z")->setWidth(12);
	
	$sheet->getColumnDimension("AA")->setWidth(10);
	$sheet->getColumnDimension("AB")->setWidth(12);
	$sheet->getColumnDimension("AC")->setWidth(11);
	$sheet->getColumnDimension("AD")->setWidth(12);
	$sheet->getColumnDimension("AE")->setWidth(10);
	$sheet->getColumnDimension("AF")->setWidth(14);
	$sheet->getColumnDimension("AG")->setWidth(11);
	$sheet->getColumnDimension("AH")->setWidth(10);
	$sheet->getColumnDimension("AI")->setWidth(11);
	$sheet->getColumnDimension("AJ")->setWidth(12);
	$sheet->getColumnDimension("AK")->setWidth(14);
	$sheet->getColumnDimension("AL")->setWidth(14);
	$sheet->getColumnDimension("AM")->setWidth(13);
	$sheet->getColumnDimension("AN")->setWidth(12);
	$sheet->getColumnDimension("AO")->setWidth(12);
	$sheet->getColumnDimension("AP")->setWidth(11);
	$sheet->getColumnDimension("AQ")->setWidth(11);
	$sheet->getColumnDimension("AR")->setWidth(1);
	$sheet->getColumnDimension("AS")->setWidth(15);
	$sheet->getColumnDimension("AT")->setWidth(15);
	$sheet->getColumnDimension("AU")->setWidth(15);
	$sheet->getColumnDimension("AV")->setWidth(15);
	$sheet->getColumnDimension("AW")->setWidth(15);
	$sheet->getColumnDimension("AX")->setWidth(15);
	$sheet->getColumnDimension("AY")->setWidth(15);
	$sheet->getColumnDimension("AZ")->setWidth(15);

	$sheet->getColumnDimension("BA")->setWidth(15);
	$sheet->getColumnDimension("BB")->setWidth(15);
	$sheet->getColumnDimension("BC")->setWidth(15);
	$sheet->getColumnDimension("BD")->setWidth(15);
	$sheet->getColumnDimension("BE")->setWidth(15);
	$sheet->getColumnDimension("BF")->setWidth(15);*/


	//Объединяем нужные ячейки в шапке
	$sheet->mergeCells("A1:E1");
	$sheet->mergeCells("F1:J1");
	$sheet->mergeCells("K1:P1");
	$sheet->mergeCells("Q1:Z1");
	$sheet->mergeCells("AA1:AL1");
	$sheet->mergeCells("AM1:AX1");
	$sheet->mergeCells("AY1:BB1");
	$sheet->mergeCells("BC1:BF1");


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
	// первая строка шапки
	$sheet->setCellValue("A1", "Блок идентификационных параметров скважины");
	$sheet->setCellValue("F1", "Блок идентификационных данных о режиме измерения");
	$sheet->setCellValue("K1", "Блок параметров по скважине, вводимых оператором");
	$sheet->setCellValue("Q1", "Блок параметров по скважине");
	$sheet->setCellValue("AA1", "Блок основных результатов по скважине");
	$sheet->setCellValue("AM1", "Общие технологические параметры установки при измерении");
	$sheet->setCellValue("AY1", "Результаты измерения ультразвуковым расходомером FLOWSIC");
	$sheet->setCellValue("BC1", "Результаты измерения кориолисовым расходомером ROTAMASS");

	// вторая строка шапки
	$sheet->setCellValue("A2", "Дата записи\n в журнал");
	$sheet->setCellValue("B2", "Время записи\n в журнал");
	$sheet->setCellValue("C2", "Месторождение");
	$sheet->setCellValue("D2", "Куст");
	$sheet->setCellValue("E2", "Скважина");

	$sheet->setCellValue("F2", "Дата/Время старта");
	$sheet->setCellValue("G2", "Дата/Время окончания");
	$sheet->setCellValue("H2", "Время замера");
	$sheet->setCellValue("I2", "Режим");
	$sheet->setCellValue("J2", "Расчёт\nобводненности");

	$sheet->setCellValue("K2", "Доля мех.\nпримесей");
	$sheet->setCellValue("L2", "Концентрация\nхлор. солей");
	$sheet->setCellValue("M2", "Доля\nрастворенного\nгаза");
	$sheet->setCellValue("N2", "Влагосодержание\n(ХАЛ)");
	$sheet->setCellValue("O2", "Доля\nрастворенного\nгаза");
	$sheet->setCellValue("P2", "Плотность\nвыделевшегося\nиз КГН газа");

	$sheet->setCellValue("Q2", "Накопленная\nмасса брутто");
	$sheet->setCellValue("R2", "Накопленная\nмасса нетто");
	$sheet->setCellValue("S2", "Накопленный\nобъем газа\nв газовом трубопроводе");
	$sheet->setCellValue("T2", "Накопленная\nмасса газа\nв линии ГЖС");
	$sheet->setCellValue("U2", "Накопленный\nобъем газа\nв линии ГЖС");
	$sheet->setCellValue("V2", "Масса газа,\nпрошедшая через УИГ");
	$sheet->setCellValue("W2", "Масса WC5+");
	$sheet->setCellValue("X2", "Масса воды,\nпрошедшя через УИГ");
	$sheet->setCellValue("Y2", "Масса КЖ,\nпрошедшая через УИГ");
	$sheet->setCellValue("Z2", "Объем КЖ,\n прошедший через УИГ");

	$sheet->setCellValue("AA2", "Дебит\nжидкости");
	$sheet->setCellValue("AB2", "Дебит\nраств.газа\nв  жидкости");
	$sheet->setCellValue("AC2", "Дебит\nконденсата");
	$sheet->setCellValue("AD2", "Дебит воды");
	$sheet->setCellValue("AE2", "Дебит газа ");
	$sheet->setCellValue("AF2", "Дебит\nкап.жидкости\nв газе сепар.");
	$sheet->setCellValue("AG2", "Объём газа");
	$sheet->setCellValue("AH2", "Дебит\nчистого\nгаза");
	$sheet->setCellValue("AI2", "Дебит\nчистого\nконденсата");
	$sheet->setCellValue("AJ2", "Накопленная\nмасса воды");
	$sheet->setCellValue("AK2", "Накопленная\nмасса\nчистого конд");
	$sheet->setCellValue("AL2", "Накопленный\nобъем\nчистого газа");

	$sheet->setCellValue("AM2", "[TT100] Температура\nво входном\nколлекторе");
	$sheet->setCellValue("AN2", "[PT100] Давление\nво входном\nколлекторе");
	$sheet->setCellValue("AO2", "[PT201] Давление\nна всасе Н-1");
	$sheet->setCellValue("AP2", "[PDT200] Перепад\nдавления\nна фильтре");
	$sheet->setCellValue("AQ2", "[PT202] Давление\nна выкиде\nН-1");
	$sheet->setCellValue("AR2", "[PT300] Давление в\nгазосепараторе\nГС-1");
	$sheet->setCellValue("AS2", "[LT300] Уровень в\nемкости Е-1");
	$sheet->setCellValue("AT2", "[TT300] Темп в\nемкости Е-1");
	$sheet->setCellValue("AU2", "[TT500] Темп в вых.\nколлек жидк");
	$sheet->setCellValue("AV2", "[PT500] Давл в вых.\nколлек жидк");
	$sheet->setCellValue("AW2", "[TT700] Темп в вых.\nколлек газа");
	$sheet->setCellValue("AX2", "[PT700] Давл в вых.\nколлек газа");

	$sheet->setCellValue("AY2", "Давление в\nлинии газа");
	$sheet->setCellValue("AZ2", "Температура\nв линии газа");
	$sheet->setCellValue("BA2", "Дебит газа\nFLOWSIC");
	$sheet->setCellValue("BB2", "Дебит газа\nFLOWSIC");

	$sheet->setCellValue("BC2", "Дебит\nжидкости\nROTAMASS");
	$sheet->setCellValue("BD2", "Масса\nжидкости\nROTAMASS");
	$sheet->setCellValue("BE2", "Плотность\nжидкости\nROTAMASS");
	$sheet->setCellValue("BF2", "Обводнённость\nвлагомер");


	// третья строка шапки			
	$sheet->setCellValue("A3", "-");
	$sheet->setCellValue("B3", "-");
	$sheet->setCellValue("C3", "-");
	$sheet->setCellValue("D3", "-");
	$sheet->setCellValue("E3", "-");

	$sheet->setCellValue("F3", "-");
	$sheet->setCellValue("G3", "-");
	$sheet->setCellValue("H3", "сек.");
	$sheet->setCellValue("I3", "-");
	$sheet->setCellValue("J3", "-");

	$sheet->setCellValue("K3", "% масс.");
	$sheet->setCellValue("L3", "г/м3");
	$sheet->setCellValue("M3", "% объемн.");
	$sheet->setCellValue("N3", "% объемн.");
	$sheet->setCellValue("O3", "% масс.");
	$sheet->setCellValue("P3", "кг/м3");

	$sheet->setCellValue("Q3", "т");
	$sheet->setCellValue("R3", "т");
	$sheet->setCellValue("S3", "м³ ст.у.");
	$sheet->setCellValue("T3", "т");
	$sheet->setCellValue("U3", "м³ ст.у.");
	$sheet->setCellValue("V3", "кг");
	$sheet->setCellValue("W3", "кг");
	$sheet->setCellValue("X3", "кг");
	$sheet->setCellValue("Y3", "кг");
	$sheet->setCellValue("Z3", "м³ ст.у.");

	$sheet->setCellValue("AA3", "т/сут");
	$sheet->setCellValue("AB3", "т/сут");
	$sheet->setCellValue("AC3", "т/сут");
	$sheet->setCellValue("AD3", "т/сут");
	$sheet->setCellValue("AE3", "ст.м³/сут");
	$sheet->setCellValue("AF3", "ст.м³/сут");
	$sheet->setCellValue("AG3", "ст.м³");
	$sheet->setCellValue("AH3", "ст.м³/сут");
	$sheet->setCellValue("AI3", "т/сут");
	$sheet->setCellValue("AJ3", "т");
	$sheet->setCellValue("AK3", "т");
	$sheet->setCellValue("AL3", "м³");

	$sheet->setCellValue("AM3", "С");
	$sheet->setCellValue("AN3", "кг/см2");
	$sheet->setCellValue("AO3", "кг/см2");
	$sheet->setCellValue("AP3", "кг/см2");
	$sheet->setCellValue("AQ3", "кг/см2");
	$sheet->setCellValue("AR3", "кг/см2");
	$sheet->setCellValue("AS3", "см");
	$sheet->setCellValue("AT3", "С");
	$sheet->setCellValue("AU3", "С");
	$sheet->setCellValue("AV3", "кг/см2");
	$sheet->setCellValue("AW3", "С");
	$sheet->setCellValue("AX3", "кг/см2");

	$sheet->setCellValue("AY3", "кг/см2");
	$sheet->setCellValue("AZ3", "°С");
	$sheet->setCellValue("BA3", "м³/сут");
	$sheet->setCellValue("BB3", "ст.м³/сут");

	$sheet->setCellValue("BC3", "т/сут");
	$sheet->setCellValue("BD3", "т");
	$sheet->setCellValue("BE3", "кг/м³");
	$sheet->setCellValue("BF3", "%об");





	// Перекладываем данные
	$Date_      					= $_POST["Date_"];							//Дата записи в журнал
	$Date1_      					= $_POST["Date1_"];							//Время записи в журнал
	$Field      					= $_POST["Field"];							//Месторождение
	$Bush      						= $_POST["Bush"];							//Куст
	$Well      						= $_POST["Well"];							//Скважина

	$Date2_      					= $_POST["Date2_"];							//Дата начала замера
	$Date3_      					= $_POST["Date3_"];							//Дата конца замера
	$Time_measure   				= $_POST["Time_measure"];					//Время замера
	$Rejim   						= $_POST["Rejim"];							//Режим
	$Method   						= $_POST["Method"];							//Метод

	$Dol_mech_prim_Read				= $_POST["Dol_mech_prim_Read"];				//Доля механических примесей
	$Konc_hlor_sol_Read   			= $_POST["Konc_hlor_sol_Read"];				//Концентрация хлористых солей
	$Dol_ras_gaz_Read   			= $_POST["Dol_ras_gaz_Read"];				//Доля растворенного газа
	$Vlaj_oil_Read   				= $_POST["Vlaj_oil_Read"];					//Влагосодержание
	$Dol_ras_gaz_mass   			= $_POST["Dol_ras_gaz_mass"];				//Доля растворенного газа
	$Dens_gaz_KGN   				= $_POST["Dens_gaz_KGN"];					//Плотность выделевшегося из КГН газа

	$Mass_brutto_Accum   			= $_POST["Mass_brutto_Accum"];				//Накопленная масса брутто
	$Mass_netto_Accum   			= $_POST["Mass_netto_Accum"];				//Накопленная масса нетто
	$Volume_Count_Forward_sc_Accum  = $_POST["Volume_Count_Forward_sc_Accum"];	//Накопленный объем газа в УИГ
	$Mg_GK   						= $_POST["Mg_GK"];							//Накопленная масса газа в линии ГЖС
	$Vg_GK   						= $_POST["Vg_GK"];							//Накопленный объем газа в линии ГЖС
	$Mass_Gaz_UVP_Accum   			= $_POST["Mass_Gaz_UVP_Accum"];				//Масса газа, прошедшая через УИГ
	$WC5_Accum   					= $_POST["WC5_Accum"];						//Масса WC5+
	$Mass_water_UIG_Accum   		= $_POST["Mass_water_UIG_Accum"];			//Масса воды, прошедшя через УИГ
	$Mass_KG   						= $_POST["Mass_KG"];						//Масса КЖ, прошедшая через УИГ
	$V_KG   						= $_POST["V_KG"];							//Объем КЖ, прошедший через УИГ

	$Debit_liq   					= $_POST["Debit_liq"];						//Дебит жидкости
	$Debit_gas_in_liq   			= $_POST["Debit_gas_in_liq"];				//Дебит раств.газа в  жидкости
	$Debit_cond   					= $_POST["Debit_cond"];						//Дебит конденсата
	$Debit_water   					= $_POST["Debit_water"];					//Дебит воды
	$Debit_gaz   					= $_POST["Debit_gaz"];						//Дебит газа
	$Debit_KG   					= $_POST["Debit_KG"];						//Дебит кап.жидкости в газе сепар.

	$Clean_Gaz   					= $_POST["Clean_Gaz"];						//Дебит чистого газа
	$Clean_Cond   					= $_POST["Clean_Cond"];						//Дебит чистого конденсата
	$V_Water   						= $_POST["V_Water"];						//Накопленная масса воды
	$V_Cond   						= $_POST["V_Cond"];							//Накопленная масса чистого конд
	$V_Gaz   						= $_POST["V_Gaz"];							//Накопленный V чистого газа

	$TT100   						= $_POST["TT100"];							//Температура во входном коллекторе
	$PT100   						= $_POST["PT100"];							//Давление во входном коллекторе
	$PT201   						= $_POST["PT201"];							//Давление на всасе Н-1
	$PDT200   						= $_POST["PDT200"];							//Перепад давления на фильтре
	$PT202   						= $_POST["PT202"];							//Давление на выкиде Н-1
	$PT300   						= $_POST["PT300"];							//Давление в газосепараторе ГС-1
	$LT300   						= $_POST["LT300"];							//Уровень в емкости Е-1
	$TT300   						= $_POST["TT300"];							//Темп в емкости Е-1
	$TT500   						= $_POST["TT500"];							//Темп в вых. коллек жидк
	$PT500   						= $_POST["PT500"];							//Давл в вых. коллек жидк
	$TT700   						= $_POST["TT700"];							//Темп в вых. коллек газа
	$PT700   						= $_POST["PT700"];							//Давл в вых. коллек газа

	$FS_P   						= $_POST["FS_P"];							//Давление в линии газа
	$FS_T   						= $_POST["FS_T"];							//Температура в линии газа
	$FS_Qw   						= $_POST["FS_Qw"];							//Дебит газа FLOWSIC
	$FS_Qs   						= $_POST["FS_Qs"];							//Дебит газа FLOWSIC

	$RT_Dens   						= $_POST["RT_Dens"];						//Плотность жидкости ROTAMASS
	$RT_Vlaj   						= $_POST["RT_Vlaj"];						//Обводнённость влагомер

	$sheet->setCellValue("A4", $Date_);								//Дата записи в журнал
	$sheet->setCellValue("B4", $Date1_);							//Время записи в журнал
	$sheet->setCellValue("C4", $Field);								//Месторождение
	$sheet->setCellValue("D4", $Bush);								//Куст
	$sheet->setCellValue("E4", $Well);								//Скважина

	$sheet->setCellValue("F4", $Date2_);							//Дата начала замера
	$sheet->setCellValue("G4", $Date3_);							//Дата конца замера
	$sheet->setCellValue("H4", $Time_measure);						//Время замера
	$sheet->setCellValue("I4", $Rejim);							//Режим
	$sheet->setCellValue("J4", $Method);							//Метод

	$sheet->setCellValue("K4", $Dol_mech_prim_Read);				//Доля механических примесей
	$sheet->setCellValue("L4", $Konc_hlor_sol_Read);				//Концентрация хлористых солей
	$sheet->setCellValue("M4", $Dol_ras_gaz_Read);					//Доля растворенного газа
	$sheet->setCellValue("N4", $Vlaj_oil_Read);					//Влагосодержание
	$sheet->setCellValue("O4", $Dol_ras_gaz_mass);					//Доля растворенного газа
	$sheet->setCellValue("P4", $Dens_gaz_KGN);						//Плотность выделевшегося из КГН газа

	$sheet->setCellValue("Q4", $Mass_brutto_Accum);				//Накопленная масса брутто
	$sheet->setCellValue("R4", $Mass_netto_Accum);					//Накопленная масса нетто
	$sheet->setCellValue("S4", $Volume_Count_Forward_sc_Accum);	//Накопленный объем газа в УИГ
	$sheet->setCellValue("T4", $Mg_GK);							//Накопленная масса газа в линии ГЖС
	$sheet->setCellValue("U4", $Vg_GK);							//Накопленный объем газа в линии ГЖС
	$sheet->setCellValue("V4", $Mass_Gaz_UVP_Accum);				//Масса газа, прошедшая через УИГ
	$sheet->setCellValue("W4", $WC5_Accum);						//Масса WC5+
	$sheet->setCellValue("X4", $Mass_water_UIG_Accum);				//Масса воды, прошедшя через УИГ
	$sheet->setCellValue("Y4", $Mass_KG);							//Масса КЖ, прошедшая через УИГ
	$sheet->setCellValue("Z4", $V_KG);								//Объем КЖ, прошедший через УИГ

	$sheet->setCellValue("AA4", $Debit_liq);						//Дебит жидкости
	$sheet->setCellValue("AB4", $Debit_gas_in_liq);					//Дебит раств.газа в  жидкости
	$sheet->setCellValue("AC4", $Debit_cond);						//Дебит конденсата
	$sheet->setCellValue("AD4", $Debit_water);						//Дебит воды
	$sheet->setCellValue("AE4", $Debit_gaz);						//Дебит газа
	$sheet->setCellValue("AF4", $Debit_KG);							//Дебит кап.жидкости в газе сепар.
	$sheet->setCellValue("AG4", $Volume_Count_Forward_sc_Accum);	//Накопленный объем газа в УИГ
	$sheet->setCellValue("AH4", $Clean_Gaz);						//Дебит чистого газа
	$sheet->setCellValue("AI4", $Clean_Cond);						//Дебит чистого конденсата
	$sheet->setCellValue("AJ4", $V_Water);							//Накопленная масса воды
	$sheet->setCellValue("AK4", $V_Cond);							//Накопленная масса чистого конд
	$sheet->setCellValue("AL4", $V_Gaz);							//Накопленный V чистого газа

	$sheet->setCellValue("AM4", $TT100);							//Температура во входном коллекторе
	$sheet->setCellValue("AN4", $PT100);							//Давление во входном коллекторе
	$sheet->setCellValue("AO4", $PT201);							//Давление на всасе Н-1
	$sheet->setCellValue("AP4", $PDT200);							//Перепад давления на фильтре
	$sheet->setCellValue("AQ4", $PT202);							//Давление на выкиде Н-1
	$sheet->setCellValue("AR4", $PT300);							//Давление в газосепараторе ГС-1
	$sheet->setCellValue("AS4", $LT300);							//Уровень в емкости Е-1
	$sheet->setCellValue("AT4", $TT300);							//Темп в емкости Е-1
	$sheet->setCellValue("AU4", $TT500);							//Темп в вых. коллек жидк
	$sheet->setCellValue("AV4", $PT500);							//Давл в вых. коллек жидк
	$sheet->setCellValue("AW4", $TT700);							//Темп в вых. коллек газа
	$sheet->setCellValue("AX4", $PT700);							//Давл в вых. коллек газа

	$sheet->setCellValue("AY4", $FS_P);								//Давление в линии газа
	$sheet->setCellValue("AZ4", $FS_T);								//Температура в линии газа
	$sheet->setCellValue("BA4", $FS_Qw);							//Дебит газа FLOWSIC
	$sheet->setCellValue("BB4", $FS_Qs);							//Дебит газа FLOWSIC

	$sheet->setCellValue("BC4", $Debit_liq);						//Дебит жидкости ROTAMASS
	$sheet->setCellValue("BD4", $Mass_brutto_Accum);				//Масса жидкости ROTAMASS
	$sheet->setCellValue("BE4", $RT_Dens);							//Плотность жидкости ROTAMASS
	$sheet->setCellValue("BF4", $RT_Vlaj);							//Обводнённость влагомер*/

	
	//Выводим содержимое файла
	$objWriter = new PHPExcel_Writer_Excel2007($xls);
	$objWriter->save('../PKIOS.xlsx');
	//$objWriter->save('C:\Users\admin\Desktop\Reports\PKIOS.xlsx');

	


?>

	<h1>Excel документ сформирован</h1>

	<form action="/web/docviewer/index.php" method="post">

		<input type="submit" name="ok" value="вернуться к отчетам">

	</form>

		<br />
		<br />