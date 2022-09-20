<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"> 
<html>
<head>
  <meta charset="utf-8">
<Title>Документы</Title>
<?php  
   echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
   echo '<script type="text/javascript" src="js/jquery.animate-enhanced.min.js"></script>';
   echo '<script type="text/javascript" src="js/script.js"></script>';
   echo '<script type="text/javascript" src="js/panel.js"></script>';
   echo '<link type="text/css" href="css/style.css" rel="stylesheet">';
   echo '<link type="text/css" href="css/error.css" rel="stylesheet">';
   echo '<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">';  
   //-- Bootstrap CSS -->
  //echo '<link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css" >';
  //<!-- Bootstrap JS + Popper JS -->
  //echo '<script defer src="js/bootstrap/js/bootstrap.bundle.min.js"></script>';
   include "config.php";
   include "function.php";
?>

</head>
<body> 
   <!-- Скрипт для отображения левой панели со списком документов -->
<script>       
   window.onload = function()
   {
    	var myForm   = document.getElementById('sideLeft');

    	<?php
    		echo 'var path_xml  = "' . $prjpath . 'list.xml";';
    		echo 'document.getElementById("pathxml").value  = "' .$prjpath. '";';
    		echo 'document.getElementById("pathprog").value = "' .$prjpath. '";';
    		echo 'document.getElementById("minyear").value = "' .$minyear. '";';
      ?>
  
        var xmlDoc   = loadXMLDoc(path_xml);    
        var typeDoc       = [];
        typeDoc           = rw_XML_row(xmlDoc, "name");
 
        var htmlform = "<form><div class='cpanel-head'><?php echo $header_left ?></div> <br />";
			
        htmlform += "<select id='listDocType' name='listDoc' style='width: 300px;' size='5' onchange='show_type(this.value);'>"; 
		

        for (i = 0; i < typeDoc.length; i++)
        {
             htmlform += '<option value="' + typeDoc[i] + '">' + typeDoc[i] + '</option>';
        }
        htmlform        += "</select><br /><div id='txtType'></div><div id='errorType'></div><div id='txtDOCS'></div><div id='button_print'><input type='button' class='button_print' value='Распечатать' onclick='" + 'PrintElem("#PrintContent");'+"' /></div></form>";
   
        myForm.innerHTML = htmlform;

        //------------------------------------------выборка по месторождению---------------------------------------------------------------------- 

        //var htmlform_field = "<select name='field' onchange='undefined'>"; 


        //------------------------------------------отчет excel----------------------------------------------------------------------
        var dateb      = new Date();                                 // создаем актуальную дату
        var now_day    = dateb.getDate();                            // получаем день даты
        var now_month  = dateb.getMonth();                           // получаем месяц даты
        var now_year   = dateb.getFullYear();                        // получаем год даты
        var dayCount   = new Date(now_year, now_month + 1, 0).getDate(); //получаем количество дней в следующем месяце

        var myForm_excel_start     = document.getElementById('txtType_excel_start');  // получаем блок  "txtType"
        var myForm_excel_end     = document.getElementById('txtType_excel_end');  // получаем блок  "txtType"
        var html_excel_start       = "";  //создаем html теги для отображения
        var html_excel_end       = "";  //создаем html теги для отображения
        //day1
        html_excel_start += get_selectnumber(1, dayCount, now_day, "day3");
        html_excel_end += get_selectnumber(1, dayCount, now_day, "day4");
        //month1
        html_excel_start += get_selectnumber(0, 11, now_month, "month3"); 
        html_excel_end += get_selectnumber(0, 11, now_month, "month4"); 
        //year1
        html_excel_start += get_selectnumber(2020, now_year, now_year, "year3");
        html_excel_end += get_selectnumber(2020, now_year, now_year, "year4");

        myForm_excel_start.innerHTML = html_excel_start + '<h3>Начальная дата</h3>'; // выводим полученный html тег в блок myForm
        myForm_excel_end.innerHTML = html_excel_end + '<h3>Конечная дата</h3>'; // выводим полученный html тег в блок myForm

       
//----------------------------------------------------------------------------------------------------------------
    var year_start      = document.getElementById("day3").value;
    //alert (year_start);

   }
      
</script>       
<div id="left_panel" class="left_panel"></div>
        <div id="container" class="container">
        	<div id="vars" style="display: none;">
        		<input id='pathxml' type='text'>
        		<input id='pathprog' type='text'>
        		<input id='minyear' type='text'>
        	</div>
        	<div id="content"></div>				
        	<div id="error"></div>
        	<div id="PrintContent"></div>
        </div>	 
	<div id="slide_panel" class="slide_panel">
<!-- кнопка скрытия и появления левой панели -->
		<p class="open"></p>
<!-- кнопка печати документа -->
		<p class="print" onclick="PrintElem('#PrintContent');"></p>    
  <!-- дополнительные документы -->
	<?php 
		$jj = 0;

		for ($ii = 1; $ii < 9; $ii ++)
		{	 
		  $buttons = "\$button" . ($ii) . "_func";
		  $buttons_func = $buttons;
   		  eval ("\$buttons_func = \"$buttons_func\";");
		  
		  $buttons = "\$button" . ($ii) . "_file";
		  $buttons_file = $buttons;
   		  eval ("\$buttons_file = \"$buttons_file\";");

		  $buttons_file = "images/buttons/" . $buttons_file;

		  if (($buttons_func != "") or ($buttons_file != "images/buttons/"))
		  {
			echo ('<p class="buttons" onclick="' .$buttons_func. '" style="margin-top: ' . 40*($jj+1) . 'px; background: url(' . $buttons_file . ') no-repeat #E6E6E6;"></p>');
			$jj++;
		  }
		 }

	?>
		<div id="sideLeft"></div>		

    <div class="sideLeft_excel">
      <form class="form_excel" action="excel_save_group.php" method="post">
        
          <p>Параметры запроса</p>
          <div id='txtType_excel_param'>
            
              <?php 

                $xmll = simplexml_load_file('list.xml');
                $xml2 = $xmll->confBD;

                $objArray = (array) $xml2;
                $ServerName = $objArray["ServerName"];
                $Database = $objArray["Database"];
                $UID = $objArray["UID"];
                $PWD = $objArray["PWD"];

                $sql_query_1 = "SELECT DISTINCT Field FROM Zamer";
                $sql_query_2 = "SELECT DISTINCT Bush FROM Zamer";
                $sql_query_3 = "SELECT DISTINCT Well FROM Zamer";

                $connectionInfo = array( "Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD);
                $conn = sqlsrv_connect( $ServerName, $connectionInfo);

                //-----------------месторождение-----------------------------------
                echo '<div class="span_select"><select id="s_field" name="field" onchange="undefined"><option>Все</option>';

                if( $conn ) {
                     $stmt = sqlsrv_query( $conn, $sql_query_1);  //выполняем запрос

                     if( $stmt === false){  // если не удачно выводим ошибки
                        die( print_r(sqlsrv_errors(), true) );
                      }

                      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
                        //echo $row['Field'].'</br>';
                        echo '<option>'.(iconv("windows-1251","utf-8",$row['Field'])).'</option>';
                      }   

 
                }else{
                     echo "Connection could not be established.<br />";
                     die( print_r( sqlsrv_errors(), true));
                }
                echo '</select><h3>Месторождение</h3></div>';
                
                //-----------------------------------------------------------------

                //-----------------куст-----------------------------------
                echo '<div class="span_select"><select id="s_bush" name="bush" onchange="undefined"><option>Все</option>';

                if( $conn ) {
                     $stmt = sqlsrv_query( $conn, $sql_query_2);  //выполняем запрос

                     if( $stmt === false){  // если не удачно выводим ошибки
                        die( print_r(sqlsrv_errors(), true) );
                      }

                      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
                        //echo $row['Bush'].'</br>';
                        echo '<option>'.(iconv("windows-1251","utf-8",$row['Bush'])).'</option>';
                      }   

 
                }else{
                     echo "Connection could not be established.<br />";
                     die( print_r( sqlsrv_errors(), true));
                }
                echo '</select><h3>Куст</h3></div>';
                //-----------------------------------------------------------------

                //-----------------Скважина-----------------------------------
                echo '<div class="span_select"><select id="s_well" name="well" onchange="undefined"><option>Все</option>';

                if( $conn ) {
                     $stmt = sqlsrv_query( $conn, $sql_query_3);  //выполняем запрос

                     if( $stmt === false){  // если не удачно выводим ошибки
                        die( print_r(sqlsrv_errors(), true) );
                      }

                      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
                        //echo $row['Well'].'</br>';
                        echo '<option>'.(iconv("windows-1251","utf-8",$row['Well'])).'</option>';
                      }   

 
                }else{
                     echo "Connection could not be established.<br />";
                     die( print_r( sqlsrv_errors(), true));
                }
                echo '</select><h3>Скважина</h3></div>';
                //-----------------------------------------------------------------

              //<option>var1</option>
              //<option>var2</option>
              //<option>var3</option>
              ?>

              <!--<div id='button_print3'><input id="btn3" class='button_print but_weight' type="submit" name="Go3" value="Сформировать Excel"></div>-->
            
          </div>
          <p>Выборка по дате </p>
          <div id='txtType_excel_start'>
            
          </div>
          <div id='txtType_excel_end'></div>
          <!--<div id='button_print2'><input id="btn2" class='button_print but_weight' type="submit" name="Go2" value="Просмотр (WEB)" onclick="show_html_select()" ></div>-->
          <div id='button_print3'><input id="btn3" class="button_print but_weight" type="submit" name="send" value="Сформировать Excel"></div>
          <div id="en_file"></div>
          <!--<div id='button_print4'><input id="btn4" class='button_print but_weight' type="submit" name="Go4" value="Обновить страницу" onclick="location.reload()"></div>
          <div id="en_file"></div>-->
          <!--<input name="send" type="submit" value="send"/>-->
      </form>  
    </div>

  </div>


</body>
   <?php include "print_preview.php"; ?>

</html>