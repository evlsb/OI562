<?php

session_start ();  // начало сессии
if (!$_SESSION['admin']) {    //если это не админ то выводим нет доступа
	die ('Нет доступа.');
} 
?>
<!-- Отображение панели администратора -->
<html>
<head>
<title>Панель Администратора DocViewer</title>
<link type="text/css" href="../css/style.css" rel="stylesheet">
<link type="text/css" href="../css/error.css" rel="stylesheet">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script type="text/javascript" src="../js/script.js"></script>
</head>
<?php
include "../function.php";
$app_name              = 'Панель администратора';
$message_save          = 'Для изменения настроек нажмите кнопку "Сохранить".'; 
include '../config.php';
?>
<body>

<div class="container" style="width: 100%; margin-left: 4%; margin-right: 4%;">
  <div id="cpanel_wrapper" style="width: 90%; display: block;">
    <div class="panel row-fluid" id="ytcpanel_panel">
        <div class="cpanel-head"><?php echo $app_name; ?></div>
    	<!--Tools-->
      <div id="panel_wrapper" style="width:100%"><div class="panel-group" style="width:35%;float: left;">
            <div class="panel-heading">
<span class="panel-toggle">Настройки </span>		
            </div>
            <div class="collapse">
                <div class="panel-inner">
                    <!-- PATH -->
                    <h4 class="clear" style="padding:0;"><span>Пути</span></h4>
                    <table>

		    <tbody><tr>
		    <td>Текст в Header лувой панели:</td>
      <td><input id="Header_left" name="Header_left" type="text" value="<?php echo $header_left; ?>"></td>		    <td></td>
		    <td></td>
		    </tr>


		    <tr>
		    <td>Минимальная дата года:</td>
		    <td><input id="MinYear" name="MinYear" type="text" value="<?php echo $minyear; ?>"></td>		    <td style="width:20px;"></td>
		    <td></td>
		    </tr>

		    <tr>
		    <td>Путь к проекту:</td>
      <td><input id="Prjpath" name="Prjpath" type="text" value="<?php echo $Prjpath; ?>"></td>		    <td></td>
		    <td></td>
		    </tr>



                    </tbody></table>
      <div id="message"><?php echo $message_save; ?></div>                    
		</div>
            </div>

        </div>
<div class="panel-group" style="width:63.8%; margin-left:10px;float: left;">
            <div class="panel-heading">
<span class="panel-toggle">Дополнительные кнопки</span>		
            </div>
            <div class="collapse">
                <div class="panel-inner" style="height: 130px;">
                    <!-- PATH -->
                    <h4 class="clear" style="padding:0;"><span>Боковые кнопки</span></h4>
                    <table>

		    <tbody><tr>
		    <td>Кнопка 1: </td>
      		    <td style="padding-right:10px"> 
			<input id="Button1_func" name="Button1_func" type="text" value="<?php echo $button1_func; ?>" style="width:110px; float:left;">
			<input id="Button1_file" name="Button1_file" type="file" accept="image/*" onchange="Change_File(this.value, 'Button1_file_i');" style="margin-left:5px; width:70px; float:left;">
			<input id="Button1_file_i" name="Button1_file_i" type="text" value="<?php echo $button1_file; ?>" style="margin-left:5px; width:110px; float:left;">
		    </td>	
		    <td>Кнопка 5: </td>
                    <td>
			<input id="Button5_func" name="Button5_func" type="text" value="<?php echo $button5_func; ?>" style="width:110px; float:left;">
			<input id="Button5_file" name="Button5_file" type="file" accept="image/*" onchange="Change_File(this.value, 'Button5_file_i');" style="margin-left:5px; width:70px; float:left;">
			<input id="Button5_file_i" name="Button5_file_i" type="text" value="<?php echo $button5_file; ?>" style="margin-left:5px; width:110px; float:left;">
		     </td>	
		    </tr>

		    <tr>
		    <td>Кнопка 2: </td>		    
                    <td>
			<input id="Button2_func" name="Button2_func" type="text" value="<?php echo $button2_func; ?>" style="width:110px; float:left;">
			<input id="Button2_file" name="Button2_file" type="file" accept="image/*" onchange="Change_File(this.value, 'Button2_file_i');" style="margin-left:5px; width:70px; float:left;">
			<input id="Button2_file_i" name="Button2_file_i" type="text" value="<?php echo $button2_file; ?>" style="margin-left:5px; width:110px; float:left;">
		     </td>		 
		    <td>Кнопка 6: </td>
                    <td>
			<input id="Button6_func" name="Button6_func" type="text" value="<?php echo $button6_func; ?>" style="width:110px; float:left;">
			<input id="Button6_file" name="Button6_file" type="file" accept="image/*" onchange="Change_File(this.value, 'Button6_file_i');" style="margin-left:5px; width:70px; float:left;">
			<input id="Button6_file_i" name="Button6_file_i" type="text" value="<?php echo $button6_file; ?>" style="margin-left:5px; width:110px; float:left;">
		     </td>	
		    </tr>

		    <tr>
		    <td>Кнопка 3: </td>
                    <td>
			<input id="Button3_func" name="Button3_func" type="text" value="<?php echo $button3_func; ?>" style="width:110px; float:left;">
			<input id="Button3_file" name="Button3_file" type="file" accept="image/*" onchange="Change_File(this.value, 'Button3_file_i');" style="margin-left:5px; width:70px; float:left;">
			<input id="Button3_file_i" name="Button3_file_i" type="text" value="<?php echo $button3_file; ?>" style="margin-left:5px; width:110px; float:left;">
		     </td>
		    <td>Кнопка 7: </td>
                    <td>
			<input id="Button7_func" name="Button7_func" type="text" value="<?php echo $button7_func; ?>" style="width:110px; float:left;">
			<input id="Button7_file" name="Button7_file" type="file" accept="image/*" onchange="Change_File(this.value, 'Button7_file_i');" style="margin-left:5px; width:70px; float:left;">
			<input id="Button7_file_i" name="Button7_file_i" type="text" value="<?php echo $button7_file; ?>" style="margin-left:5px; width:110px; float:left;">
		     </td>
		    </tr>


		    <tr>
		    <td>Кнопка 4: </td>
                    <td>
			<input id="Button4_func" name="Button4_func" type="text" value="<?php echo $button4_func; ?>" style="width:110px; float:left;">
			<input id="Button4_file" name="Button4_file" type="file" accept="image/*" onchange="Change_File(this.value, 'Button4_file_i');" style="margin-left:5px; width:70px; float:left;">
			<input id="Button4_file_i" name="Button4_file_i" type="text" value="<?php echo $button4_file; ?>" style="margin-left:5px; width:110px; float:left;">
		      </td>
		    <td>Кнопка 8: </td>
                    <td>	
			<input id="Button8_func" name="Button8_func" type="text" value="<?php echo $button8_func; ?>" style="width:110px; float:left;">
			<input id="Button8_file" name="Button8_file" type="file" accept="image/*" onchange="Change_File(this.value, 'Button8_file_i');" style="margin-left:5px; width:70px; float:left;">
			<input id="Button8_file_i" name="Button8_file_i" type="text" value="<?php echo $button8_file; ?>" style="margin-left:5px; width:110px; float:left;">
		      </td>
		    </tr>

                    </tbody></table>                 
		</div>
            </div>

        </div>
</div>
  <input type="button" class="btn btn-save" value="Сохранить" onclick="save_php();" >   <a href = "logout.php"><input type="button" class="btn btn-out" value="Выйти" ></a>
  </div>
</div>
</div>


</body>
</html>