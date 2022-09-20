<?php
session_start ();
if (!$_SESSION['admin'])     //если работаем не с сесией администратора, то выводим ошибку
{ 
   echo 'Нет доступа!'; 
}
else      // иначе проверяем был пост запрос или нет
{
   if ($_POST) {   // если был, то получаем все значения по запросу
	$MinYear       = $_POST['MinYear'];
	$Header_left   = $_POST['Header_left'];
	$Prjpath       = $_POST['Prjpath'];
	$Prjviewerpath = $_POST['Prjviewerpath'];

	for ($i = 0; $i < 8; $i++)
	{
	     $buttons = 'Button' . ($i+1) . '_func';
	     $Button_func[$i]  = $_POST[$buttons];
	     $buttons = 'Button' . ($i+1) . '_file_i';
	     $Button_file[$i]  = $_POST[$buttons];	
	}
	// заменяем все значения в реесторе и в файле config.php для DocViewer 
	include '../function.php';
 
	replace_file('../config.php', '$Prjpath = "' .$Prjpath. '";', 2);
	replace_file('../config.php', '$header_left = "' .$Header_left. '";', 2);
	replace_file('../config.php', '$minyear = "' .$MinYear. '";', 3);


	for ($i = 0; $i < 8; $i++)
	{	    
	     replace_file('../config.php', '$minyear = "' .$MinYear. '";', 3);
	     replace_file('../config.php', '$button' .($i+1). '_func = "' .str_replace('\\','\\\\',$Button_func[$i]). '";', 4+2*$i);
	     replace_file('../config.php', '$button' .($i+1). '_file = "' .str_replace('\\','\\\\',$Button_file[$i]). '";', 5+2*$i);	
	}

   }

   echo "Настройки сохранены!";    // выводим сообщение об успешном изменении настроек
}
?> 