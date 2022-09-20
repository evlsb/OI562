<?php
include "function.php";

$dateb      = $_POST["dateb"]; // дата начала
$datee      = $_POST["datee"]; // дата конца
$tsql       = $_POST["sql"];   //  sql запрос для списка документов
$ServerName = $_POST["ServerName"]; // имя сервера
$Database   = $_POST["Database"];  // имя БД
$UID        = $_POST["UID"];       // имя пользователя
$PWD        = $_POST["PWD"];       // пароль
$descr      = $_POST["descr"];     // шаблон для вывода списка документов
//$substance  = $_POST["substance"];     // шаблон для вывода списка документов
$n          = 0;

$tsql=str_replace("{#dateb}", $dateb, $tsql); // заменяем даты для sql запроса
$tsql=str_replace("{#datee}", $datee, $tsql);
//$tsql=str_replace("{#substance}", $substance, $tsql);

     
// Подключаемся к бд
connectBD($ServerName,$Database,$UID,$PWD);
$connectionInfo = array( "Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD);
$conn = sqlsrv_connect( $ServerName, $connectionInfo);
if( $conn ) //если соединение есть 
{
  $stmt = sqlsrv_query( $conn, $tsql);  //выполняем запрос

  if( $stmt === false)  // если не удачно выводим ошибки
  {  
    die( print_r(sqlsrv_errors(), true) );
  }
  
  
$str4 = "";
  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )   //пока элементы запроса есть выводим их в select 
  {
    $n              = $n + 1;

    if ($n == 1) echo '<select id="listdocs" style="width: 300px;" name="list_docs" size="5" onchange="show_html(this.value);">';

    $descr1         = $descr;
    eval ("\$descr1 = \"$descr1\";");
    echo '<option value="' .$descr1. '">' .$descr1. '</option>';

$str3 = $row['dDateBegin']->format('Ymd H:i:s');
$str4 = $str4  . $str3. "|||"; 

  }  

  
if ($n > 0) // если элементы есть, то говорим что  $n документов найдено
  {
    echo '</select> <br /><br /> <p style="text-align:center; color:blue; font-size:14px;">За данный период времени найдено документов: ' .$n. '!</p>';
    echo '<div id="dateDocs" style="display:none;"> <input id="datesDocs" value="' . $str4 . '"></div>';
  }
  else   // иначе говорим что документов не найдено
  {
    echo '<p style="text-align:center; color:blue; font-size:14px;">За данный период времени документов не найдено!</p>';
  } 

  sqlsrv_free_stmt($stmt); //очищаем запрос
  
}
else
{
  die( print_r( sqlsrv_errors(), true));
}     


?>    