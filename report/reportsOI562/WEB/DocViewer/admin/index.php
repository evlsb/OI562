<?php
session_start ();   // начало сессии
if (!empty ($_SESSION['admin']))   
{
	if ($_SESSION['admin'])
	{          
 	 exit;
	}
}

$_SESSION['admin'] = false;

// функция отображения формы входа в панель администратора 

function not_logged_in ()
{
?>
<html>
<head>
<title>Административная панель</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
<style type=text/css>
#wrap
{
width: 100%;
height: 100%;
}
#wraptd
{
padding: 20px;
}
.loginbox1
{
width: 300px;
padding: 4px;
border: 1px solid #777;
background-color: #777;
color: white;
font-weight: bold;
}
.loginbox2
{
width: 300px;
padding: 4px;
border: 1px solid #777;
color: #777;
}
.loginbox2 input
{
width: 200px;
margin: 3px 0;
border-color: #888;
color: #777;
}
</style>
</head>



<body>
<center>
<table cellpadding="0" cellspacing="0" id="wrap"><tr><td align="center" id="wrap">
<table cellpadding="0" cellspacing="0">
<tr><td class="loginbox1" align="center">Вход в административную панель</td></tr>
<tr><td class="loginbox2" align="center">
<form action="index.php" method="post">
<input type="text" name="login" value="Логин"><br>
<input type="password" name="password" value="Пароль"><br>
<input type="submit" value="Войти">
</form>
</td></tr>
</table>
</td></tr></table>
</center>
</body>
</html>
<?php
exit;
}                        
if (!$_POST) not_logged_in (); // если Post запросов не выполнено выводим форму входа
if (!$_POST['login']) not_logged_in (); //если логин не введен 
if (!$_POST['password']) not_logged_in (); //если пароль не введен  выводим форму входа
include "config.php";    //получаем пароль и логин и сравниваем если не удачно, то  выводим форму входа       
if ($_POST['login']!= $adminlogin) not_logged_in ();
if ($_POST['password']!= $adminpassw) not_logged_in ();
$_SESSION['admin'] = true;
if ($_SESSION['admin'])  //если логин и пароль введены верно начинаем сессию админ и переходим в окно панели администратора
{ 
	header ('Location: admin_main.php');
}
?>