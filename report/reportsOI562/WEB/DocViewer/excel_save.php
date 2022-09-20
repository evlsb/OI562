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
	$sheet->getColumnDimension("A")->setWidth(38,56);
	$sheet->getColumnDimension("B")->setWidth(8,33);
	$sheet->getColumnDimension("C")->setWidth(27,22);
	$sheet->getColumnDimension("D")->setWidth(76,78);
	$sheet->getColumnDimension("E")->setWidth(24);

	//$sheet->getNumberFormat("E12")->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);


	//Подписываем лист
	$sheet->setTitle('Отчет по замеру');

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

	$sheet->setCellValue("E2", $Date_);								//Дата записи в журнал
	$sheet->setCellValue("E3", $Date1_);							//Время записи в журнал
	$sheet->setCellValue("E4", $Field);								//Месторождение
	$sheet->setCellValue("E5", $Bush);								//Куст
	$sheet->setCellValue("E6", $Well);								//Скважина

	$sheet->setCellValue("E7", $Date2_);							//Дата начала замера
	$sheet->setCellValue("E8", $Date3_);							//Дата конца замера
	$sheet->setCellValue("E9", $Time_measure);						//Время замера
	$sheet->setCellValue("E10", $Rejim);							//Режим
	$sheet->setCellValue("E11", $Method);							//Метод

	$sheet->setCellValue("E12", $Dol_mech_prim_Read);				//Доля механических примесей
	$sheet->setCellValue("E13", $Konc_hlor_sol_Read);				//Концентрация хлористых солей
	$sheet->setCellValue("E14", $Vlaj_oil_Read);					//Влагосодержание
	$sheet->setCellValue("E15", $Dol_ras_gaz_mass);					//Доля растворенного газа
	$sheet->setCellValue("E16", $Dens_gaz_KGN);						//Плотность выделевшегося из КГН газа

	$sheet->setCellValue("E17", $Mass_brutto_Accum);				//Накопленная масса брутто
	$sheet->setCellValue("E18", $Mass_netto_Accum);					//Накопленная масса нетто
	$sheet->setCellValue("E19", $V_Water);							//Накопленная масса воды
	$sheet->setCellValue("E20", $V_Cond);							//Накопленная масса чистого конд
	$sheet->setCellValue("E21", $Volume_Count_Forward_sc_Accum);	//Накопленный объем газа в УИГ
	$sheet->setCellValue("E22", $V_Gaz);							//Накопленный V чистого газа
	$sheet->setCellValue("E23", $Mg_GK);							//Накопленная масса газа в линии ГЖС
	$sheet->setCellValue("E24", $Vg_GK);							//Накопленный объем газа в линии ГЖС
	$sheet->setCellValue("E25", $Mass_Gaz_UVP_Accum);				//Масса газа, прошедшая через УИГ
	$sheet->setCellValue("E26", $WC5_Accum);						//Масса WC5+
	$sheet->setCellValue("E27", $Mass_water_UIG_Accum);				//Масса воды, прошедшя через УИГ
	$sheet->setCellValue("E28", $Mass_KG);							//Масса КЖ, прошедшая через УИГ
	
	$sheet->setCellValue("E29", $Debit_liq);						//Дебит жидкости
	$sheet->setCellValue("E30", $Debit_cond);						//Дебит конденсата
	$sheet->setCellValue("E31", $Debit_water);						//Дебит воды
	$sheet->setCellValue("E32", $Clean_Cond);						//Дебит чистого конденсата
	$sheet->setCellValue("E33", $Debit_KG);							//Дебит кап.жидкости в газе сепар.
	$sheet->setCellValue("E34", $Debit_gaz);						//Дебит газа
	$sheet->setCellValue("E35", $Debit_gas_in_liq);					//Дебит раств.газа в  жидкости
	$sheet->setCellValue("E36", $Clean_Gaz);						//Дебит чистого газа
	
	$sheet->setCellValue("E37", $TT100);							//Температура во входном коллекторе
	$sheet->setCellValue("E38", $PT100);							//Давление во входном коллекторе
	$sheet->setCellValue("E39", $PT201);							//Давление на всасе Н-1
	$sheet->setCellValue("E40", $PDT200);							//Перепад давления на фильтре
	$sheet->setCellValue("E41", $PT202);							//Давление на выкиде Н-1
	$sheet->setCellValue("E42", $PT300);							//Давление в газосепараторе ГС-1
	$sheet->setCellValue("E43", $LT300);							//Уровень в емкости Е-1
	$sheet->setCellValue("E44", $TT300);							//Темп в емкости Е-1
	$sheet->setCellValue("E45", $TT500);							//Темп в вых. коллек жидк
	$sheet->setCellValue("E46", $PT500);							//Давл в вых. коллек жидк
	$sheet->setCellValue("E47", $TT700);							//Темп в вых. коллек газа
	$sheet->setCellValue("E48", $PT700);							//Давл в вых. коллек газа

	$sheet->setCellValue("E49", $FS_P);								//Давление в линии газа
	$sheet->setCellValue("E50", $FS_T);								//Температура в линии газа
	$sheet->setCellValue("E51", $FS_Qw);							//Дебит газа FLOWSIC
	$sheet->setCellValue("E52", $FS_Qs);							//Дебит газа FLOWSIC

	$sheet->setCellValue("E53", $Debit_liq);						//Дебит жидкости ROTAMASS
	$sheet->setCellValue("E54", $Mass_brutto_Accum);				//Масса жидкости ROTAMASS
	$sheet->setCellValue("E55", $RT_Dens);							//Плотность жидкости ROTAMASS
	$sheet->setCellValue("E56", $RT_Vlaj);							//Обводнённость влагомер


	//Массив строк столбца D
	$arr_D = [
				"Дата записи измерения в журнал",
			 	"Время записи измерения в журнал",
			 	"Название месторождения (вводится оператором)",
			 	"Номер куста (вводится оператором)",
			 	"Номер скважины (вводится оператором)",

			 	//"Номер замера в серии",
			 	"Дата/Время стара замера",
			 	"Дата/Время окончания замера",
			 	"Время замера в минутах",
			 	"Режим работы и расчёта установки (с поддержкой уровня или слив/налив)",
			 	"Расчет обводненности по влагомеру или по данным ХАЛ",

			 	"Доля механических примесей, % масс (вводится оператором)",
			 	"Доля хлористых солей, % масс (вводится оператором)",
			 	"Влагосодержание, % масс (вводится оператором или расчет по влагомеру)",
			 	"Доля растворенного газа, % масс (расчет по пробе КГН)",
			 	"Плотность газа, выделевшегося из КГН, кг/м3 (вводится оператором)",

			 	"Накопленная масса жидкости",
			 	"Накопленная масса конденсата",
			 	"Накопленная масса воды (расчет)",
			 	"Накопленная масса общего конденсата (расчет)",
			 	"Накопленный объем газа в газовом трубопроводе",
			 	"Накопленный объем общего газа (расчет)",
			 	"Накопленная масса газа в линии ГЖС",
			 	"Накопленный объем газа в линии ГЖС",
			 	"Масса газа, прошедшая через УИГ",
			 	"Масса WC5+",
			 	"Масса воды, прошедшя через УИГ",
			 	"Масса капельной жидкости, прошедшая через УИГ",
			 	
			 	"Дебит жидкости",
			 	"Дебит конденсата",
			 	"Дебит воды (расчет)",
			 	"Дебит общего конденсата (расчет)",
			 	"Дебит капельной жидкости в газе сепарации",
			 	"Дебит газа",
			 	"Дебит растворенного газа в  жидкости",
			 	"Дебит общего газа (расчет)",
			 	
			 	"[TT100] Температура во входном коллекторе (сред. значение)",
			 	"[PT100] Давление во входном коллекторе (сред. значение)",
			 	"[PT201] Давление на всасе Н-1 (сред. значение)",
			 	"[PDT200] Перепад давления на фильтре (сред. значение)",
			 	"[PT202] Давление на выкиде Н-1 (сред. значение)",
			 	"[PT300] Давление в газосепараторе ГС-1 (сред. значение)",
			 	"[LT300] Уровень в емкости Е-1 (сред. значение)",
			 	"[TT300] Температура в емкости Е-1 (сред. значение)",
			 	"[TT500] Температура в выходном коллекторе жидкости (сред. значение)",
			 	"[PT500] Давление в выходном коллекторе жидкости (сред. значение)",
			 	"[TT700] Температура в выходном коллекторе газа (сред. значение)",
			 	"[PT700] Давление в выходном коллекторе газа (сред. значение)",

			 	"Давление в линии газа  (сред. значение)",
			 	"Температура в линии газа (сред. значение)",
			 	"Дебит газа FLOWSIC (р.у.)",
			 	"Дебит газа FLOWSIC (ст.у.)",

			 	"Дебит жидкости ROTAMASS",
			 	"Масса жидкости ROTAMASS",
			 	"Плотность жидкости ROTAMASS (сред. значение)",
			 	"Обводнённость по влагомеру (сред. значение)",
			];

	for ($i=0; $i < count($arr_D); $i++) { 
		$dd = $i+2;
		$ss = $arr_D[$i];
		//echo "D".$dd."-".$arr_D[$i]."<br />";
		$sheet->setCellValue("D".$dd, $arr_D[$i]);
		$sheet->getStyle("D".$dd)->getAlignment()->setWrapText(true);
	}

	//Массив строк столбца C
	$arr_C = [
				"Дата",
				"Время",
				"Месторождение",
				"Куст",
				"Скважина",

				//"id",
				"Время старта",
				"Время окончания",
				"Время измерения, мин",
				"Режим",
				"Расчет",

				"W м.п., %масс",
				"W х.с., %масс",
				"W в, %масс",
				"W р.г., %масс",
				"p г. кгн, кг/м3",

				"т",
				"т",
				"т",
				"т",
				"м³ ст.у.",
				"м³ ст.у.",
				"т",
				"м³ ст.у.",
				"т",
				"т",
				"т",
				"т",
				
				"т/сут",
				"т/сут",
				"т/сут",
				"т/сут",
				"т/сут",
				"ст.м³/сут",
				"т/сут",
				"ст.м³/сут",
				
				"°С",
				"МПа",
				"кПа",
				"кПа",
				"МПа",
				"МПа",
				"%",
				"°С",
				"°С",
				"МПа",
				"°С",
				"МПа",

				"МПа",
				"°С",
				"м³/сут",
				"ст.м³/сут",

				"т/сут",
				"т",
				"кг/м³",
				"% объем.",
			];

	for ($i=0; $i < count($arr_C); $i++) { 
		$dd = $i+2;
		$ss = $arr_C[$i];
		//echo "C".$dd."-".$arr_C[$i]."<br />";
		$sheet->setCellValue("C".$dd, $arr_C[$i]);
		$sheet->getStyle("C".$dd)->getAlignment()->setWrapText(true);
		//Цвет шрифта
		$sheet->getStyle("C".$dd)->getFont()->getColor()->setRGB('701d18');
		//Жирный шрифт
		$sheet->getStyle("C".$dd)->getFont()->setBold(true);
	}




	//Массив строк столбца A
	$arr_A = [
				"Блок идентификационных параметров скважины" => [2=>6],
				"Блок идентификационных данных измерения и информация о режиме измерения" => [7=>11],
				"Блок параметров по скважине, вводимых оператором" => [12=>16],
				"Блок параметров по замеру" => [17=>28],
				"Блок основных результатов по скважине" => [29=>36],
				"Общие технологические параметры установки при измерении" => [37=>48],
				"Блок параметров по газовой линии, связанных с работой и расчетом по ултразвуковому расходомеру - FLOWSIC" => [49=>52],
				"Результаты измерения кориолисовым расходомером жидкости ROTAMASS" => [53=>56],
			];


	$p = 0;

	foreach ($arr_A as $k => $v) {
		foreach ($v as $key => $value) {
			// Объединение ячеек в колонке
			$sheet->mergeCells("A".$key.":A".$value);
			$p = $key;
		}

		$sheet->setCellValue("A".$p, $k);
		//Выравнивание по вертикали по центру
		$sheet->getStyle("A".$p)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//Перенос на следующую строчку т екста
		$sheet->getStyle("A".$p)->getAlignment()->setWrapText(true);
		//Выравнивание по горизонтали по центру
		$sheet->getStyle("A".$p)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
	}

	//Внешняя рамка у ячеек
	$arr_out_bord1 = [
				"2" => "6",
				"7" => "11",
				"12" => "16",
				"17" => "28",
				"29" => "36",
				"37" => "48",
				"49" => "52",
				"53" => "56",
			];

	foreach ($arr_out_bord1 as $k => $v) {

			//Внешняя рамка для ячеек
			$border = array(
				'borders'=>array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
				)
			);
 
			$sheet->getStyle("A".$k.":E".$v)->applyFromArray($border);
			$sheet->getStyle("B".$k.":E".$v)->applyFromArray($border);

			//Внутренняя рамка для ячеек
			$border = array(
				'borders'=>array(
					'inside' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
				)
			);
 
			$sheet->getStyle("B".$k.":E".$v)->applyFromArray($border);
	}

	//Формирование столбца B, E
	for ($i=1; $i < 56; $i++) { 
		$dd = $i+1;
		$sheet->setCellValue("B".$dd, $i);
		$sheet->getStyle("B".$dd)->getAlignment()->setWrapText(true);
		$sheet->getStyle("B".$dd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//Выравнивание по горизонтали по центру
		$sheet->getStyle("E".$dd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C".$dd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//Выравнивание по вертикали по центру
		$sheet->getStyle("E".$dd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle("C".$dd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	}


	//Выводим содержимое файла
	$objWriter = new PHPExcel_Writer_Excel2007($xls);
	//$objWriter->save('../Report_Excel.xlsx');
	$objWriter->save('C:\Users\admin\Desktop\Reports\Zamer_PKIOS.xlsx');

	


?>

	<h1>Excel документ сформирован</h1>

	<form action="/web/docviewer/index.php" method="post">

		<input type="submit" name="ok" value="вернуться к отчетам">

	</form>

		<br />
		<br />