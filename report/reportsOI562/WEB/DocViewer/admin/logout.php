<?php
session_start ();
if (!$_SESSION['admin']) die ( '���������' );   //���� ������ �� ��������������, �� ������� ������
session_destroy ();  //����� ��������� ������ �������������� � ������� ����� ��������� ������
?>
<html>
<head>
<title>���������������� ������</title>
<style type=text/css>
#wrap
{
width: 100%;
height: 100%;
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
</style>
</head>
<body>
<center>
<table cellpadding="0" cellspacing="0" id="wrap"><tr><td align="center" id="wrap">
<table cellpadding="0" cellspacing="0">
<tr><td class="loginbox1" align="center">����� ��������</td></tr>
<tr><td class="loginbox2" align="center"><a href="../index.php">��������� �� ������� ��������</a></td></tr>
</td></tr>
</table>
</td></tr></table>
</center>
</body>
</html>