<?php

	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
 	require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/IOFactory.php';

 	include "function.php";

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

	//Блок идентификационных параметров скважины
	$Date_      					= $_POST["Date_"];							//Дата записи в журнал
	$Date1_      					= $_POST["Date1_"];							//Время записи в журнал
	$Field      					= $_POST["Field"];							//Месторождение
	$Bush      						= $_POST["Bush"];							//Куст
	$Well      						= $_POST["Well"];							//Скважина

	//Блок идентификационных данных измерения и информация о режиме измерения
	$Date2_      					= $_POST["Date2_"];							//Дата начала замера
	$Date3_      					= $_POST["Date3_"];							//Дата конца замера
	$Time_measure   				= $_POST["Time_measure"];					//Время замера
	$Rejim   						= $_POST["Rejim"];							//Режим
	$Method   						= $_POST["Method"];							//Метод

	//Блок параметров по скважине, вводимых оператором
	$OW_M_GD						= $_POST["OW_M_GD"];						//Масса газа деазации
	$OW_Dens_GD						= $_POST["OW_Dens_GD"];						//Плотность газа дегазации
	$OW_V_PO						= $_POST["OW_V_PO"];						//Водное число пробоотборника
	$OW_m_ZO						= $_POST["OW_m_ZO"];						//Масса жидкого остатка дегазации
	$OW_Dens_SK						= $_POST["OW_Dens_SK"];						//Плотность стабильного конденсата
	$OW_m_PROB						= $_POST["OW_m_PROB"];						//Масса пробы

	//Расчет из данных "блока параметров по скважине, вводимых оператором"
	$OR_m_RG						= $_POST["OR_m_RG"];						//Плотность стабильного конденсата
	$OR_W_RG						= $_POST["OR_W_RG"];						//Масса пробы

	//Блок параметров по замеру
	$Mass_brutto_Accum   			= $_POST["Mass_brutto_Accum"];				//Накопленная масса брутто
	$Mass_netto_Accum   			= $_POST["Mass_netto_Accum"];				//Накопленная масса нетто
	$Mass_water_Accum   			= $_POST["Mass_water_Accum"];				//Накопленная масса воды
	$V_Cond  						= $_POST["V_Cond"];							//Накопленная масса чистого конд
	$Volume_Count_Forward_sc_Accum  = $_POST["Volume_Count_Forward_sc_Accum"];	//Накопл.объем газа в УИГ
	$V_Gaz   						= $_POST["V_Gaz"];							//Накопленный V чистого газа
	$Mg_GK   						= $_POST["Mg_GK"];							//Накопленная масса газа в линии ГЖС
	$Vg_GK   						= $_POST["Vg_GK"];							//Накопленный объем газа в линии ГЖС
	$Mass_Gaz_UVP_Accum   			= $_POST["Mass_Gaz_UVP_Accum"];				//Масса газа, прошедшая через УИГ
	$WC5_Accum   					= $_POST["WC5_Accum"];						//Масса WC5+
	$Mass_water_UIG_Accum   		= $_POST["Mass_water_UIG_Accum"];			//Масса воды, прошедшя через УИГ
	$Mass_KG   						= $_POST["Mass_KG"];						//Масса КЖ, прошедшая через УИГ

	//Блок основных результатов по скважине
	$Debit_liq   					= $_POST["Debit_liq"];						//Дебит жидкости
	$Debit_cond   					= $_POST["Debit_cond"];						//Дебит конденсата
	$Debit_water   					= $_POST["Debit_water"];					//Дебит воды
	$Clean_Cond   					= $_POST["Clean_Cond"];						//Дебит чистого конденсата
	$Debit_KG   					= $_POST["Debit_KG"];						//Дебит кап.жидкости в газе сепар.
	$Debit_gaz   					= $_POST["Debit_gaz"];						//Дебит газа
	$Debit_gas_in_liq   			= $_POST["Debit_gas_in_liq"];				//Дебит раств.газа в жидкости
	$Debit_V_gas_in_liq   			= $_POST["Debit_V_gas_in_liq"];				//Дебит раств.газа в жидкости
	$Clean_Gaz   					= $_POST["Clean_Gaz"];						//Дебит чистого газа



	//Блок основных результатов по скважине
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

	//FLOWSIC
	$FS_P   						= $_POST["FS_P"];							//Давление в линии газа
	$FS_T   						= $_POST["FS_T"];							//Температура в линии газа
	$FS_Qw   						= $_POST["FS_Qw"];							//Дебит газа FLOWSIC
	$FS_Qs   						= $_POST["FS_Qs"];							//Дебит газа FLOWSIC

	//ROTAMASS
	$Debit_liq   					= $_POST["Debit_liq"];						//Дебит жидкости ROTAMASS
	$Mass_brutto_Accum   			= $_POST["Mass_brutto_Accum"];				//Масса жидкости ROTAMASS
	$RT_Dens   						= $_POST["RT_Dens"];						//Плотность жидкости ROTAMASS

	//ВСН-2
	$RT_Vlaj   						= $_POST["RT_Vlaj"];						//Обводнённость влагомер

	//echo $RT_Vlaj;				echo "<br />";   




	//Блок идентификационных параметров скважины
	$sheet->setCellValue("E2", $Date_);														//Дата записи в журнал
	$sheet->setCellValue("E3", $Date1_);													//Время записи в журнал
	$sheet->setCellValue("E4", $Field);														//Месторождение
	$sheet->setCellValue("E5", $Bush);														//Куст
	$sheet->setCellValue("E6", $Well);														//Скважина

	//Блок идентификационных данных измерения и информация о режиме измерения
	$sheet->setCellValue("E7", $Date2_);													//Дата начала замера
	$sheet->setCellValue("E8", $Date3_);													//Дата конца замера
	$sheet->setCellValue("E9", $Time_measure);												//Время замера
	$sheet->setCellValue("E10", $Rejim);													//Режим
	$sheet->setCellValue("E11", $Method);													//Метод

	//Блок параметров по скважине, вводимых оператором
	$sheet->setCellValue("E12", FormatEx($OW_M_GD, 5, $NULL));								//Масса газа дегазации, кг
	$sheet->setCellValue("E13", FormatEx($OW_Dens_GD, 5, $NULL));							//Плотность газа дегазации, кг/м3
	$sheet->setCellValue("E14", FormatEx($OW_V_PO, 5, $NULL));								//Водное число пробоотборника, дм3
	$sheet->setCellValue("E15", FormatEx($OW_m_ZO, 5, $NULL));								//Масса жидкого остатка дегазации, кг
	$sheet->setCellValue("E16", FormatEx($OW_Dens_SK, 5, $NULL));							//Плотность стабильного конденсата, г/см3
	$sheet->setCellValue("E17", FormatEx($OW_m_PROB, 5, $NULL));							//Масса пробы, кг

	//Расчет из данных "блока параметров по скважине, вводимых оператором"
	$sheet->setCellValue("E18", FormatEx($OR_m_RG, 5, $NULL));								//Масса растворенного газа (расчет), кг
	$sheet->setCellValue("E19", FormatEx($OR_W_RG, 5, $NULL));								//Массовая доля растворенного газа (расчет), % масс

	//Блок параметров по замеру
	$sheet->setCellValue("E20", FormatEx($Mass_brutto_Accum, 5, $NULL));					//Накоп масса жидкости в линии ГСЖ (ГК брутто)
	$sheet->setCellValue("E21", FormatEx($Mass_netto_Accum, 5, $NULL));						//Накоп масса конденсата в линии ГСЖ (ГК нетто)
	$sheet->setCellValue("E22", FormatEx($Mass_water_Accum, 5, $NULL));						//Накопленная масса воды (расчет)
	$sheet->setCellValue("E23", FormatEx($V_Cond, 5, $NULL));								//Накоп масса конд
	$sheet->setCellValue("E24", FormatEx($Volume_Count_Forward_sc_Accum, 5, $NULL));		//Накопленный объем газа в УИГ
	$sheet->setCellValue("E25", FormatEx($V_Gaz, 5, $NULL));								//Накоп объем газа
	$sheet->setCellValue("E26", FormatEx($Mg_GK, 5, $NULL));								//Накоп масса газа в ГЖС
	$sheet->setCellValue("E27", FormatEx($Vg_GK, 5, $NULL));								//Накоп объем газа в ГЖС
	$sheet->setCellValue("E28", FormatEx(($Mass_Gaz_UVP_Accum/1000), 5, $NULL));					//Масса газа, прошедшая через УИГ
	$sheet->setCellValue("E29", FormatEx(($WC5_Accum/1000), 5, $NULL));							//Масса WC5+
	$sheet->setCellValue("E30", FormatEx(($Mass_water_UIG_Accum/1000), 5, $NULL));					//Масса воды, прошедшя через УИГ
	$sheet->setCellValue("E31", FormatEx(($Mass_KG/1000), 5, $NULL));								//Масса КЖ, прошедшая через УИГ

	//Блок основных результатов по скважине
	$sheet->setCellValue("E32", FormatEx($Debit_liq, 5, $NULL));							//Дебит жидкости
	$sheet->setCellValue("E33", FormatEx($Debit_cond, 5, $NULL));							//Дебит конденсата
	$sheet->setCellValue("E34", FormatEx($Debit_water, 5, $NULL));							//Дебит воды
	$sheet->setCellValue("E35", FormatEx($Clean_Cond, 5, $NULL));							//Дебит чистого конденсата
	$sheet->setCellValue("E36", FormatEx($Debit_KG, 5, $NULL));								//Дебит кап.жидкости в газе сепар.
	$sheet->setCellValue("E37", FormatEx($Debit_gaz, 5, $NULL));							//Дебит газа  $Debit_gas_in_liq
	$sheet->setCellValue("E38", FormatEx($Debit_gas_in_liq, 5, $NULL));						//Дебит раств.газа в жидкости
	$sheet->setCellValue("E39", FormatEx($Debit_V_gas_in_liq, 5, $NULL));					//Дебит раств.газа в жидкости
	$sheet->setCellValue("E40", FormatEx($Clean_Gaz, 5, $NULL));							//Дебит чистого газа

	//Общие технологические параметры установки при измерении
	$sheet->setCellValue("E41", FormatEx($TT100, 5, $NULL));								//[TT100] Температура во входном коллекторе
	$sheet->setCellValue("E42", FormatEx($PT100, 5, $NULL));								//[PT100] Давление во входном коллекторе
	$sheet->setCellValue("E43", FormatEx($PT201, 5, $NULL));								//[PT201] Давление на всасе Н-1
	$sheet->setCellValue("E44", FormatEx($PDT200, 5, $NULL));								//[PDT200] Перепад давления на фильтре
	$sheet->setCellValue("E45", FormatEx($PT202, 5, $NULL));								//[PT202] Давление на выкиде Н-1
	$sheet->setCellValue("E46", FormatEx($PT300, 5, $NULL));								//[PT300] Давление в газосепараторе ГС-1
	$sheet->setCellValue("E47", FormatEx($LT300, 5, $NULL));								//[LT300] Уровень в емкости Е-1
	$sheet->setCellValue("E48", FormatEx($TT300, 5, $NULL));								//[TT300] Темп в емкости Е-1
	$sheet->setCellValue("E49", FormatEx($TT500, 5, $NULL));								//[TT500] Темп в вых. коллек жидк
	$sheet->setCellValue("E50", FormatEx($PT500, 5, $NULL));								//[PT500] Давл в вых. коллек жидк
	$sheet->setCellValue("E51", FormatEx($TT700, 5, $NULL));								//[TT700] Темп в вых. коллек газа
	$sheet->setCellValue("E52", FormatEx($PT700, 5, $NULL));								//[PT700] Давл в вых. коллек газа

	//FLOWSIC
	$sheet->setCellValue("E53", FormatEx($FS_P, 5, $NULL));									//Давление в линии газа
	$sheet->setCellValue("E54", FormatEx($FS_T, 5, $NULL));									//Температура в линии газа
	$sheet->setCellValue("E55", FormatEx($FS_Qw, 5, $NULL));								//Дебит газа FLOWSIC
	$sheet->setCellValue("E56", FormatEx($FS_Qs, 5, $NULL));								//Дебит газа FLOWSIC

	//ROTAMASS
	$sheet->setCellValue("E57", FormatEx($Debit_liq, 5, $NULL));							//Дебит жидкости ROTAMASS
	$sheet->setCellValue("E58", FormatEx($Mass_brutto_Accum, 5, $NULL));					//Масса жидкости ROTAMASS
	$sheet->setCellValue("E59", FormatEx($RT_Dens, 5, $NULL));								//Плотность жидкости ROTAMASS

	//ВСН-2
	$sheet->setCellValue("E60", FormatEx($RT_Vlaj, 5, $NULL));								//Обводнённость влагомер
/*
	





				//Блок параметров по замеру
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
*/


	//Массив строк столбца D
	$arr_D = [
				//Блок идентификационных параметров скважины
				"Дата записи измерения в журнал",
			 	"Время записи измерения в журнал",
			 	"Название месторождения (вводится оператором)",
			 	"Номер куста (вводится оператором)",
			 	"Номер скважины (вводится оператором)",

			 	//Блок идентификационных данных измерения и информация о режиме измерения
			 	"Дата/Время стара замера",
			 	"Дата/Время окончания замера",
			 	"Время замера в минутах",
			 	"Режим работы и расчёта установки (с поддержкой уровня или слив/налив)",
			 	"Расчет обводненности по влагомеру или по данным ХАЛ",

			 	//Блок параметров по скважине, вводимых оператором
			 	"Масса газа дегазации, кг",
			 	"Плотность газа дегазации, кг/м3",
			 	"Водное число пробоотборника, дм3",
			 	"Масса жидкого остатка дегазации, кг)",
			 	"Плотность стабильного конденсата, г/см3",
			 	"Масса пробы, кг",

			 	//Расчет из данных "блока параметров по скважине, вводимых оператором"
			 	"Масса растворенного газа (расчет), кг",
			 	"Массовая доля растворенного газа (расчет), % масс",

			 	//Блок параметров по замеру
			 	"Накоп масса жидкости в линии ГСЖ (ГК брутто)",
			 	"Накоп масса конденсата в линии ГСЖ (ГК нетто)",
			 	"Накопленная масса воды (расчет)",
			 	"Накоп масса конд",
			 	"Накопленный объем газа в УИГ",
			 	"Накоп объем газа",
			 	"Накоп масса газа в ГЖС (газ дегазации)",
			 	"Накоп объем газа в ГЖС (газ дегазации)",
			 	"Масса газа, прошедшая через УИГ",
			 	"Масса WC5+",
			 	"Масса воды, прошедшя через УИГ",
			 	"Масса КЖ, прошедшая через УИГ",

			 	//Блок основных результатов по скважине
			 	"Дебит жидкости",
			 	"Дебит конденсата",
			 	"Дебит воды",
			 	"Дебит чистого конденсата",
			 	"Дебит кап.жидкости в газе сепар.",
			 	"Дебит газа сепарации",
			 	"Дебит раств.газа в жидкости",
			 	"Дебит раств.газа в жидкости",
			 	"Дебит чистого газа",

			 	//Общие технологические параметры установки при измерении
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

			 	//FLOWSIC
			 	"Давление в линии газа",
			 	"Температура в линии газа",
			 	"Дебит газа FLOWSIC",
			 	"Дебит газа FLOWSIC",

			 	//ROTAMASS
			 	"Дебит жидкости",
			 	"Масса жидкости",
			 	"Плотность жидкости",

			 	//ВСН-2
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
				//Блок идентификационных параметров скважины
				"Дата",
				"Время",
				"Месторождение",
				"Куст",
				"Скважина",

				//Блок идентификационных данных измерения и информация о режиме измерения
				"Время старта",
				"Время окончания",
				"Время измерения, мин",
				"Режим",
				"Расчет",

				//Блок параметров по скважине, вводимых оператором
				"M_GD, кг",
				"Dens_GD, кг/м3",
				"V_PO, дм3",
				"m_ZO, кг",
				"Dens_SK, г/см3",
				"m_PROB, кг",

				//Расчет из данных "блока параметров по скважине, вводимых оператором"
				"m_RG, кг",
				"W_RG, %масс",

				//Блок параметров по замеру
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

				//Блок основных результатов по скважине
				"т/сут",
				"т/сут",
				"т/сут",
				"т/сут",
				"т/сут",
				"ст.м³/сут",
				"т/сут",
				"ст.м³/сут",
				"ст.м³/сут",

				//Общие технологические параметры установки при измерении
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

				//FLOWSIC
				"МПа",
				"°С",
				"м³/сут",
				"ст.м³/сут",

				//ROTAMASS 
				"т/сут",
				"т",
				"кг/м³",

				//ВСН-2
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
				"Блок параметров по скважине, вводимых оператором" => [12=>17],
				"Блок параметров по скважине (расчет)" => [18=>19],
				"Блок параметров по замеру" => [20=>31],
				"Блок основных результатов по скважине" => [32=>40],
				"Общие технологические параметры установки при измерении" => [41=>52],
				"Блок параметров по газовой линии, связанных с работой и расчетом по ултразвуковому расходомеру - FLOWSIC" => [53=>56],
				"Результаты измерения кориолисовым расходомером жидкости ROTAMASS" => [57=>59],
				"Результаты измерения Влагомером ВСН-2" => [60=>60],
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
				"12" => "17",
				"18" => "19",
				"20" => "31",
				"32" => "40",
				"41" => "52",
				"53" => "56",
				"57" => "59",
				"60" => "60",
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
	for ($i=1; $i < 60; $i++) { 
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