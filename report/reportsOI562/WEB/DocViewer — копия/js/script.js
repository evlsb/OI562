
//----------------------------------------------------------------------------------------------------------------//
//                                                                                                                //
//                                      Функция парсинга XML документа.		                                  //
//              Данная функция открывает XML файл с названием dname с помощью GET запроса и возвращает  xmlDoc    //
//                                                                                                                //
//----------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                //
//----------------------------------------------------------------------------------------------------------------// 
// dname - название XML файла.  				                                                  //  
//----------------------------------------------------------------------------------------------------------------//

function loadXMLDoc(dname) 
{
 try //подключение для Internet Explorer
 {
  xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
  xmlDoc.async=false;
  xmlDoc.load(dname);
 }
 catch(e)
 {
  try //подключение для Firefox, Google Chrome, Opera, etc.
  {
   xmlhttp=new XMLHttpRequest();
   xmlhttp.open("GET",dname,false);
   if (xmlhttp.overrideMimeType)
   {
     xmlhttp.overrideMimeType('text/xml');
   }
   xmlhttp.send();
   xmlDoc=xmlhttp.responseXML;
  }
  catch(e)
  {
   alert(e.message)
  }
 }
 try 
 {
  return(xmlDoc);
 }
 catch(e) {alert(e.message)}
 return(null);
}


//----------------------------------------------------------------------------------------------------------------//
//                                                                                                                //
//                    Функция чтения определенного столбца XML файла и вывод его значения в массив.               //
//            	Данная функция считывает определенный элемент XML файла и выводит его значения в массив		  //
//                                                                                                                //
//----------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                //
//----------------------------------------------------------------------------------------------------------------//  
// xmlDoc - XML файла;		  				                                                  //  
// row - название необходимого элемента.			                                                  //  
//----------------------------------------------------------------------------------------------------------------//

function rw_XML_row(xmlDoc, row)
{
  var x   = xmlDoc.getElementsByTagName(row);
  var arr = [];  
  for (i = 0; i < x.length; i++)
  { 
    arr[i] = x[i].childNodes[0].nodeValue;
  } 
  return arr;
}


//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
// 	Функция чтения определенного столбца XML файла, сравнение его со строкой и вывод столбца элемента по тегу.   	     	//
// Данная функция считывает определенный элемент XML файла находит неоходимую нам строку и выводит значение второго столбца 	//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// xmlDoc - XML файла;		  				                                                  		//  
// row1   - имя первого столбца;  				                                                  		//   
// str    - значения первого столбца;	  				                                                  	// 
// row2   - имя второго столбца.				                                                 		//  
//------------------------------------------------------------------------------------------------------------------------------//

function rw_XML_rows(xmlDoc, row1, str, row2)
{
  var x = xmlDoc.getElementsByTagName(row1); //получаем значения столбца 1 в массив x
  var y = xmlDoc.getElementsByTagName(row2); //получаем значения столбца 2 в массив y

  for (i=0;i<x.length;i++) // Проходим по циклу и ищем совпадения значения 1 столбца, если находим то возвращаем индентичное ему по индексу значение 2 столбца
  { 
    if (x[i].childNodes[0].nodeValue == str)
    {
	return y[i].childNodes[0].nodeValue;
    }
  }
}


//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
// 					Функция создания переменной для запроса XMLHttpRequest.   			     	//
//				 Данная функция создает переменну. для создания запросов GET и POST.			 	//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// Нет входных данных		  				                                                  		//  
//------------------------------------------------------------------------------------------------------------------------------//

function CreateRequest()
{
	var Request = false;

	if (window.XMLHttpRequest)
	{
		//Gecko-совместимые браузеры, IE7+, Firefox, Chrome, Opera, Safari
		Request = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		//IE6, IE5
		Request = new ActiveXObject("Microsoft.XMLHTTP");
	
		if (!Request)
		{
			HRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}
	}
 
	if (!Request)
	{
		alert("Невозможно создать XMLHttpRequest");
	}
	
	return Request;
}


//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
// 							Функция отправки запроса к файлу.   				     	//
//				 Данная функция отправляет запрос GET или POST по пути r_path с аргументами r_args.	 	//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// r_method  — тип запроса: GET или POST;			                                                  		//  
// r_path    — путь к файлу;		 			                                                  		//  
// r_args    — аргументы вида a=1&b=2&c=3...			                                                  		//  
// id        — id блока в который выводим значения.		                                                  		//  
//------------------------------------------------------------------------------------------------------------------------------//

function SendRequest(r_method, r_path, r_args, id)
{
	//Создаём запрос
	var Request = CreateRequest();
	
	//Проверяем существование запроса еще раз
	if (!Request)
	{
		return;
	}
	
	Request.onreadystatechange=function()
    	{
    		if (Request.readyState == 4) // если запрос выполнен
    		{
    		   if (Request.status == 200) // выполнен успешно
    		   {
    		       if (Request.responseText != null )   // если не ноль вернулось
    		       {
      			    document.getElementById(id).innerHTML = Request.responseText; // выводим полученный результат в наш блок
      		       }
		       else document.getElementById(id).innerHTML = "Ошибка! Содержимого нет!";  // выводим сообщение, что файл ничего не возвращает
                   }
                   else
		   {                                                                
      			document.getElementById(id).innerHTML = "error_html(404)"; // выводим ошибку в виде формы 404 ошибки (файл не найден)
                   }
    		}
    	}



	//Проверяем, если требуется сделать GET-запрос
	if (r_method.toLowerCase() == "get" && r_args.length > 0) r_path += "?" + r_args;
	
	//Инициализируем соединение
	Request.open(r_method, r_path, true);

	if (r_method.toLowerCase() == "post")
	{
		//Если это POST-запрос
	
		//Устанавливаем заголовок
		Request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=utf-8");
		//Посылаем запрос
		Request.send(r_args);
	}
	else
	{
		//Если это GET-запрос
	
		//Посылаем нуль-запрос
		Request.send(null);
	}                                                                                                               
}





//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
// 							Функция форматирования даты.  	 				     	//
//	 Данная функция получает дату и необходимый формат и возвращает новую дату, типа String, в формате format.	 	//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// dateb  — дата;			                                                  					//  
// format — формат даты.		 			                                                  		//  
//------------------------------------------------------------------------------------------------------------------------------//


function format_date(dateb, format)
{
   var datee = "";
   // по длине формата определяем как выглядит формат даты
   for (i=0; i < format.length; i++)
   {
      // по ключевым значениям проверяем и выводим определенное значение даты
      switch (format.charAt(i))
      {
         case "Y": // если год, то присваиваем год в числовом формате "****"
		datee += dateb.getFullYear();
		break;
         case "m": // если месяц, то присваиваем месяц в виде числа от 1 до 12 в формате "**"
		var month = dateb.getMonth() + 1;
		if (month < 10) datee += "0" + month;
		else datee += month;
		break;
         case "d": // если день, то присваиваем в виде числа от 1 до 31 в формате "**"
		if (dateb.getDate() < 10) datee += "0" + dateb.getDate();
		else datee += dateb.getDate();
		break;
         case "H": // если час, то присваиваем в виде числа от 1 до 24 в формате "**"
		if (dateb.getHours() < 10) datee += "0" + dateb.getHours();
		else datee += dateb.getHours();
		break;
         case "M": // если минута, то присваиваем в виде числа от 0 до 59 в формате "**"
		if (dateb.getMinutes() < 10) datee += "0" + dateb.getMinutes();
		else datee += dateb.getMinutes();
		break;
         case "S": // если секунда, то присваиваем в виде числа от 0 до 59 в формате "**"
		if (dateb.getSeconds() < 10) datee += "0" + dateb.getSeconds();
		else datee += dateb.getSeconds();
		break;
         default:  // если другого типа, то присваиваем этот символ
		datee += format.charAt(i);
		break;
      }      
   }
   return datee;   // возвращаем полученную дату
}


//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//				Функция для перевода текстового представления месяца в числовой.  	 			//
//			 Данная функция переводит месяц в формате String в тип Int по порядку начиная с 0.		 	//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// month1  — название месяца в Им. падеже.                                                  					//   
//------------------------------------------------------------------------------------------------------------------------------//

function get_month_atoi(month1)
{
   var month;
   switch (month1)
   {
      case "Январь":  //если Январь, то 0
		month = 0;
		break;
      case "Февраль": //если Февраль, то 1
		month = 1;
		break;
      case "Март":  //если Март, то 2
		month = 2;
		break;
      case "Апрель": //если Апрель, то 3
		month = 3;
		break;
      case "Май":    //если Май, то 4
		month = 4;
		break;
      case "Июнь":   //если Июнь, то 5
		month = 5;
		break;
      case "Июль":   //если Июль, то 6
		month = 6;
		break;
      case "Август":  //если Август, то 7
		month = 7;
		break;
      case "Сентябрь": //если Сентябрь, то 8
		month = 8;
		break;
      case "Октябрь":  //если Октябрь, то 9
		month = 9;
		break;
      case "Ноябрь":   //если Ноябрь, то 10
		month = 10;
		break;
      case "Декабрь":  //если Декабрь, то 11
		month = 11;
		break;
   }

   return month; //возвращаем число
}



//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//				Функция для перевода численного представления месяца в текстовый.  	 			//
//			 Данная функция переводит месяц в формате Int в тип String по порядку начиная с 0.		 	//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// month1  — число месяца начиная с 0.                                                  					//   
//------------------------------------------------------------------------------------------------------------------------------//

function get_month_itoa(month1)
{
   var month;
   switch (month1)
   {
      case 0:
		month = "Январь";
		break;
      case 1:
		month = "Февраль";
		break;
      case 2:
		month = "Март";
		break;
      case 3:
		month = "Апрель";
		break;
      case 4:
		month = "Май";
		break;
      case 5:
		month = "Июнь";
		break;
      case 6:
		month = "Июль";
		break;
      case 7:
		month = "Август";
		break;
      case 8:
		month = "Сентябрь";
		break;
      case 9:
		month = "Октябрь";
		break;
      case 10:
		month = "Ноябрь";
		break;
      case 11:
		month = "Декабрь";
		break;
   }

   return month;
}



//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//						Функция для записи html элемента типа Select.  		 			//
//		 Данная функция создает элемент Select в текстовом представлении с использованием html тегов.		 	//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// min         — число начала элемента в теге option.                                        					//          
// max         — число конца элемента в теге option.                                           					//        
// select_num  — число определяющее выделенный элемент.                                       					//    
// selectname  — название и ID для select, начинатся должен с d, m или y.                     					//    
// s_onchange  — функция на изменение значения Select.                                         					//   
//------------------------------------------------------------------------------------------------------------------------------//

function get_selectnumber(min, max, select_num, selectname, s_onchange)
{
  // записываем в переменную select с помощью HTML тегов тип select
  var select = "<select name='" + selectname +"' id='" + selectname +"' onchange='" + s_onchange + "' >";
  var option = "";
  for (i=min; i <= max; i++)
  {
    switch (selectname.charAt(0)) //определяем тип select
    {
      case "d": // день
       if (i <= 9) option = "0" + i;
       else option = i;     
       if (i != select_num) select += "<option ";
       else select += "<option selected='selected' ";
       select += "value='" + option + "' >" + option + "</option>";
       break;

      case "m": // месяц  	
       option = get_month_itoa(i);
       if (i != select_num) select += "<option ";
       else select += "<option selected='selected' ";
       select += "value='" + option + "' >" + option + "</option>";       
       break;

      case "y": // год
       if (i != select_num) select += "<option ";
       else select += "<option selected='selected' ";
       select += "value='" + i + "' >" + i + "</option>";
       break; 
    }
  }
  select += "</select>&nbsp;";
  return select;  
}


//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//						Функция скрытия и появления блока.  		 				//
//		 Данная функция позволяет создать анимирование блока с ID под названием ddd скрытия и появления.	 	//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// ddd — имя ID блока.                                				        					//   
//------------------------------------------------------------------------------------------------------------------------------//

function displ(ddd) 
{ 
  if (document.getElementById(ddd).style.display == 'none')  //если стиль блока "display" имеет значение "none"
  {
   document.getElementById(ddd).style.display = 'block';  // то изменить значение стиля на  "block" (показать)
  } 
  else
  {
   document.getElementById(ddd).style.display = 'none'; // иначе изменить значение стиля на  "none" (скрыть)
  }
}



//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     		//
//							Функция получения типов субстанции.  		 				//
//		 	Данная функция позволяет отобразить тип соответствующий определенному типу субстанции.	 							//
//                                                                                                                				//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                				//
//------------------------------------------------------------------------------------------------------------------------------//  
// data — ID субстанции.                         				        					//   
//------------------------------------------------------------------------------------------------------------------------------//
//function show_typeSubstance(data)
//{
//	document.getElementById('txtDOCS').innerHTML   = '';
//}



//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//							Функция получения типов.  		 				//
//		 	Данная функция позволяет отобразить тип соответствующий определенному типу документов.	 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// data — название документа.                         				        					//   
//------------------------------------------------------------------------------------------------------------------------------//


function show_type(data)
{
  if (data != "---")    // если у документа имя есть и оно не равно  "---"
  {
   var filexml    = document.getElementById("pathxml").value;   // получаем путь к XML файлу "list.xml" 
   xmlDoc         = loadXMLDoc(filexml+'list.xml');             // открываем XML файл "list.xml"
   var type       = rw_XML_rows(xmlDoc, "name", data, 'type');  // получаем тип документа типа "data"
   var sql        = rw_XML_rows(xmlDoc, "name", data, 'sql');   // получаем sql запрос для отображения списка документов типа "data"
   var dateb      = new Date();                                 // создаем актуальную дату
   var now_day    = dateb.getDate();                            // получаем день даты
   var now_month  = dateb.getMonth();                           // получаем месяц даты
   var now_year   = dateb.getFullYear();                        // получаем год даты
   var min_year   = document.getElementById("minyear").value;   // получаем начальный год для документов
   var dayCount   = new Date(now_year, now_month + 1, 0).getDate(); //получаем количество дней в следующем месяце
 
   var datee      = dateb; // создаем новую дату с присвоением "dateb"
   datee.setDate(datee.getDate() - 1); // изменяем дату "datee" на 1 день назад
   var last_day   = datee.getDate();   // получаем прошлый день 
   var last_month = datee.getMonth();  // получаем прошлый месяц
   var last_year  = datee.getFullYear(); //получаем прошлый год

   var html       = "";  //создаем html теги для отображения
   var myForm     = document.getElementById('txtType');  // получаем блок  "txtType"

   //alert(last_year);

   switch (type) // проверяем к какому типу относится документ
   {
      case "Day":  // если день выводим селекты к day1, month1 и year1
		//day1
		html += get_selectnumber(1, dayCount, now_day, "day1", 'show_docs();');
		//month1
		html += get_selectnumber(0, 11, now_month, "month1", 'edit_day("day1", "day1", "month1", "year1"); show_docs();'); 
   		//year1
   		html += get_selectnumber(min_year, now_year, now_year, "year1", 'edit_day("day1", "day1", "month1", "year1"); show_docs();');
		break;

      case "Month": // если месяц выводим селекты к month1 и year1
		//month1
		html += get_selectnumber(0, 11, now_month, "month1", "show_docs();"); 
   		//year1
   		html += get_selectnumber(min_year, now_year, now_year, "year1", "show_docs();");
		break;

      case "Year": // если год выводим селект year1
   		//year1
   		html += get_selectnumber(min_year, now_year, now_year, "year1", "show_docs();");
		break;

      case "P_day":  // если Периодичный по дням, то выводим селекты к (day1, month1, year1) и (day2, month2, year2)
		//day1
		html += get_selectnumber(1, dayCount, last_day, "day1", "");
		//month1
		html += get_selectnumber(0, 11, last_month, "month1", 'edit_day("day1", "day1", "month1", "year1");'); 
   		//year1
   		html += get_selectnumber(min_year, now_year, last_year, "year1", 'edit_day("day1", "day1", "month1", "year1");');
   		html += "<br />";

		//day2
		html += get_selectnumber(1, dayCount, now_day, "day2", "");
		//month2
		html += get_selectnumber(0, 11, now_month, "month2", 'edit_day("day2", "day2", "month2", "year2");'); 
   		//year2
   		html += get_selectnumber(min_year, now_year, now_year, "year2", 'edit_day("day2", "day2", "month2", "year2");');
   		html += "<br />";
		html += "<input type='button' class='button_print' value='Показать документы' onclick='show_docs();'>";
		break;

      case "P_hour": // если Периодичный по дням, то выводим селекты к (day1, month1, year1, clock1) и (day2, month2, year2, clock2)
		//day1
		html += get_selectnumber(1, dayCount, last_day, "day1", "");
		//month1
		html += get_selectnumber(0, 11, last_month, "month1", 'edit_day("day1", "day1", "month1", "year1");'); 
   		//year1
   		html += get_selectnumber(min_year, now_year, last_year, "year1", 'edit_day("day1", "day1", "month1", "year1");');
   		//clock1 - часы и минуты
   		html  += "<input id='clock1' class='clock' type='text' value='" + format_date(datee,"H:M") + "' size='4'><br />";
		
		//day2
		html += get_selectnumber(1, dayCount, now_day, "day2", "");
		//month2
		html += get_selectnumber(0, 11, now_month, "month2", 'edit_day("day2", "day2", "month2", "year2");'); 
   		//year2
   		html += get_selectnumber(min_year, now_year, now_year, "year2", 'edit_day("day2", "day2", "month2", "year2");');   		
   		html  += "<input id='clock2' class='clock' type='text' value='" + format_date(datee,"H:M") + "' size='4' ><br />";
		html += "<input type='button' class='button_print' value='Показать документы' onclick='show_docs();'>";
		break;
   }

   myForm.innerHTML = html; // выводим полученный html тег в блок myForm
   if ((type == "P_hour") || (type == "P_day")) // если периодический тип то txtDOCS не выводим
   {
		document.getElementById('txtDOCS').innerHTML   = '';
   }
   else         show_docs();   // иначе выводим спосок документов если есть
  }
}


//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//					Функция изменения значения в Input или Select.  	 				//
//		 	Данная функция позволяет изменить значение Input и Select с определенным id.		 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// id     — id Input или Select.	              				        					//  
// set    — на какое значение изменить.                				        					//  
// format — тип элемента Input или Select.      				        					//   
//------------------------------------------------------------------------------------------------------------------------------//

function set_value_id(id, set, format)
{
   switch (format)  //определяем ти элемента
   {
      case "Select":  //если Select
		     for (var i = 0; i <= document.getElementById(id).options.length - 1; i++) //проверяем все опции элемента
		     {
			      if (document.getElementById(id).options[i].value == set) // если опция set есть 
			      {
			         document.getElementById(id).selectedIndex = i; //то выбераем её
			         break;
			      }
		     }
                     break;

      case "Input":   // если  Input
   		     document.getElementById(id).value = set; //изменяем значение элемента
                     break;
   }
}


//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//						Функция получение даты по типу.  		 				//
//	Данная функция позволяет получить дату в формате "date" соответствующее определенному типу документов.	 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// type     — тип документа.	    	          				        					//  
// type_be  — нынешняя дата или дата следующего дня.          				        				//   
//------------------------------------------------------------------------------------------------------------------------------//

function get_date_to_type(type, type_be)
{
   switch (type)   // проверяем тип документа
   {
      case "Day":    //если день, то получаем из элементов типа Select "year1", "month1", "day1" дату 
		     obj_year    = document.getElementById('year1');
	   	     obj_year    = parseInt(obj_year.value);
	   	     obj_month   = document.getElementById('month1');
		     obj_month   = get_month_atoi(obj_month.value);
		     obj_day     = document.getElementById('day1');
		     obj_day     = parseInt(obj_day.value);
		     dateb       = new Date(obj_year, obj_month, obj_day, 0, 0, 0); 
		     if (type_be == "e") dateb.setDate(dateb.getDate()+1);  //если нам нужна дата следующего дня, то получаем её
                     break;

      case "Month": //если месяц, то получаем из элементов типа Select "year1", "month1" дату 		
		     obj_year    = document.getElementById('year1');
		     obj_year    = parseInt(obj_year.value);
		     //alert(obj_year);
		     obj_month   = document.getElementById('month1');
		     obj_month   = get_month_atoi(obj_month.value);
		     //alert(obj_month);
		     dateb       = new Date(obj_year, obj_month, 1, 0, 0, 0);
		     if (type_be == "e") dateb.setMonth(dateb.getMonth()+1); //если нам нужна дата следующего месяца, то получаем её
                     break;

      case "Year":  //если год, то получаем из элементов типа Select "year1" дату 		
		     obj_year    = document.getElementById('year1');
		     obj_year    = parseInt(obj_year.value);
		     dateb       = new Date(obj_year, 0, 1, 0, 0, 0);
		     if (type_be == "e") dateb = new Date(obj_year+1, 0, 1, 0, 0, 0);  //если нам нужна дата следующего года, то получаем её
                     break;

      case "P_day": //если периодический по дням, то получаем из элементов типа Select дату
			if (type_be == "b")  //если первую периодическую дату
			{
		           obj_year    = document.getElementById('year1');
		           obj_year    = parseInt(obj_year.value);
		           obj_month   = document.getElementById('month1');
		           obj_month   = get_month_atoi(obj_month.value);
		           obj_day     = document.getElementById('day1');
		           obj_day     = parseInt(obj_day.value);
		           dateb       = new Date(obj_year, obj_month, obj_day, 0, 0, 0);		     
			}
			if (type_be == "e") //если вторуюпериодическую дату 
			{
                               obj_year    = document.getElementById('year2');
		               obj_year    = parseInt(obj_year.value);
		               obj_month   = document.getElementById('month2');
		               obj_month   = get_month_atoi(obj_month.value);
		               obj_day     = document.getElementById('day2');
		               obj_day     = parseInt(obj_day.value);
                               dateb       = new Date(obj_year, obj_month, obj_day, 0, 0, 0);
			}
		        break;

      case "P_hour":  //если периодический по дням, то получаем из элементов типа Select и Input дату
			if (type_be == "b") //если первую периодическую дату
			{
		           obj_year    = document.getElementById('year1');
		           obj_year    = parseInt(obj_year.value);
		           obj_month   = document.getElementById('month1');
		           obj_month   = get_month_atoi(obj_month.value);
		           obj_day     = document.getElementById('day1');
		           obj_day     = parseInt(obj_day.value);
		           obj_clock   = String(document.getElementById('clock1').value);
		           obj_hour    = parseInt(obj_clock.charAt(0)+obj_clock.charAt(1));
		           obj_minutes = parseInt(obj_clock.charAt(3)+obj_clock.charAt(4));
		           dateb       = new Date(obj_year, obj_month, obj_day, obj_hour, obj_minutes, 0);		     
			}
			if (type_be == "e") //если вторуюпериодическую дату  
			{
                               obj_year    = document.getElementById('year2');
		               obj_year    = parseInt(obj_year.value);
		               obj_month   = document.getElementById('month2');
		               obj_month   = get_month_atoi(obj_month.value);
		               obj_day     = document.getElementById('day2');
		               obj_day     = parseInt(obj_day.value);
		               obj_clock   = String(document.getElementById('clock2').value);
		               obj_hour    = parseInt(obj_clock.charAt(0)+obj_clock.charAt(1));
		               obj_minutes = parseInt(obj_clock.charAt(3)+obj_clock.charAt(4));
                               dateb       = new Date(obj_year, obj_month, obj_day, obj_hour, obj_minutes, 0);
			}
		        break;
   }
   return dateb;
}

//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//						Функция для получения документов.  		 				//
//			Данная функция позволяет получить список документов по заданной выборке и отобразить в Web формате	 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// Входных данных нет.	    	          				        						//   
//------------------------------------------------------------------------------------------------------------------------------//

function show_docs_select(){
	var filexml     = document.getElementById("pathxml").value; // получаем путь к XML файлу list.xml
	xmlDoc          = loadXMLDoc(filexml+'list.xml');           // открываем list.xml
}

//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//						Функция для получения документов.  		 				//
//			Данная функция позволяет получить список документов определенного типа и отобразить их.	 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// Входных данных нет.	    	          				        						//   
//------------------------------------------------------------------------------------------------------------------------------//

function show_docs()
{
   var filexml     = document.getElementById("pathxml").value; // получаем путь к XML файлу list.xml
   var data        = document.getElementById("listDocType").value;    // получаем название типа документов
   xmlDoc          = loadXMLDoc(filexml+'list.xml');           // открываем list.xml
   var type        = rw_XML_rows(xmlDoc, "name", data, 'type'); // определяем тип документа 
 //  var substance_get = document.getElementById("listSubstance").value; // определяем тип документа 
   var sql         = rw_XML_rows(xmlDoc, "name", data, 'sql');  // получаем  sql запрос для отображения списка документов
   var descr       = rw_XML_rows(xmlDoc, "name", data, 'descr'); // получаем шаблон для отображения списка
   var ServerName  = rw_XML_row(xmlDoc, "ServerName");   // получаем имя сервера БД
   var Database    = rw_XML_row(xmlDoc, "Database");     // получаем имя БД
   var UID         = rw_XML_row(xmlDoc, "UID");          // получаем имя пользователя БД
   var PWD         = rw_XML_row(xmlDoc, "PWD");          // получаем пароль для БД
   var error       = false;
   var obj_year, obj_month, obj_day, obj_clock, obj_hour, obj_minutes;  
   var year, month, day, hour, minutes;  
   var dateb, datee;

   dateb = get_date_to_type(type,"b"); // получаем начальную дату для списка
   datee = get_date_to_type(type,"e"); // получаем конечную дату для списка

   //alert(datee);
	
   if ((type == "P_hour") ||(type == "P_day")) // если периодический, то проверяем на соответствие верности начальной и конечной даты иначе изменяем даты +-1 секунду
   {
 	if (dateb >= datee)
	{
	    document.getElementById('errorType').innerHTML = '<p style="text-align:center; color:red;'+
                                                             ' font-size:14px;">Ошибка!!! Период введён не корректно!'+
                                                             '</p>';
	    document.getElementById('txtDOCS').innerHTML   = '';

	    error                                          = true;
	}
   }
   else
   {
	dateb.setSeconds(dateb.getSeconds() - 1);   
   	datee.setSeconds(datee.getSeconds() + 1);
   }
   
   if (!error) //если ошибок с датой нет
   {
       document.getElementById('errorType').innerHTML = '';
       var dateb_get, datee_get;

	//приводим к определенному шаблону дату начала и конца
       dateb_get = format_date(dateb, "'Ymd H:M:S'");
       //alert(dateb_get); 
       datee_get = format_date(datee, "'Ymd H:M:S'");
       //alert(datee_get);

	//записываем все аргументы для отправки GET запроса
       var params    = 'dateb='+ dateb_get + '&datee=' + datee_get +  '&sql=' + encodeURIComponent(sql) + '&descr=' + encodeURIComponent(descr) + '&ServerName=' + encodeURIComponent(ServerName)
                     + '&Database=' + encodeURIComponent(Database) + '&UID=' + encodeURIComponent(UID) + '&PWD=' + encodeURIComponent(PWD);
       var pathprog  =  document.getElementById("pathprog").value;   // получаем путь к программе
       //alert(pathprog);

       SendRequest("POST", pathprog + "getDOCS.php", params, "txtDOCS"); // отправляем запрос и выводим результат на левую панель  юлок "txtDOCS"
   }

}

// Функция добавления элемента в Select с выделением '&substance=' + substance_get + 
function addOption (oListbox, text, value, isDefaultSelected, isSelected)
{
  var oOption = document.createElement("option");
  oOption.appendChild(document.createTextNode(text));
  oOption.setAttribute("value", value);

  if (isDefaultSelected) oOption.defaultSelected = true;
  else if (isSelected) oOption.selected = true;

  oListbox.appendChild(oOption);
}

// Функция зменения дней
function edit_day(IDSelectDay, IDDay, IDMonth, IDYear)
{
	var day      = document.getElementById(IDDay).value; // блок  IDDay
	var month    = get_month_atoi(document.getElementById(IDMonth).value); // блок  IDMonth
	var year     = document.getElementById(IDYear).value; // блок  IDDay
	var select   = document.getElementById(IDSelectDay);
	
	select.options.length = 0;
	var dayCount =  new Date(year, month + 1, 0).getDate();
	if (dayCount >= day) 
	{
		for (i=0;i<dayCount; ++i) 
		{
			if (i == day-1)
			{
				addOption(select, i+1, i+1, false, true);
			}
			else {addOption(select, i+1, i+1, true, false);}
		}
	}
	else
	{
		for (i=0;i<dayCount; ++i) 
		{
			if (i == 0)
			{
				addOption(select, i+1, i+1, true);
			}
			else {addOption(select, i+1, i+1, false);}
		}
	}
}

//------------Преобразование символьного обозначения месяца в числовое-----------------------------------------------

	function month_num(mnt){

		var num = "";

		if (mnt == "Январь") {
			num = "01";
		}else if(mnt == "Февраль"){
			num = "02";
		}else if(mnt == "Март"){
			num = "03";
		}else if(mnt == "Апрель"){
			num = "04";
		}else if(mnt == "Май"){
			num = "05";
		}else if(mnt == "Июнь"){
			num = "06";
		}else if(mnt == "Июль"){
			num = "07";
		}else if(mnt == "Август"){
			num = "08";
		}else if(mnt == "Сентябрь"){
			num = "09";
		}else if(mnt == "Октябрь"){
			num = "10";
		}else if(mnt == "Ноябрь"){
			num = "11";
		}else if(mnt == "Декабрь"){
			num = "12";
		}

		return num;

	}

//------------Преобразование символьного обозначения месяца в числовое-----------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//					Функция для отображения полученных документов.  	 				//
//				Данная функция позволяет отобразить необходимый документ по заданной выборке.			 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// 	    	          							//   
//------------------------------------------------------------------------------------------------------------------------------//

function show_html_select(){
	var filexml     = document.getElementById("pathxml").value;  // путь к XML файлу 'list.xml'
	xmlDoc          = loadXMLDoc(filexml+'list.xml'); // открытие XML файла 'list.xml'
	var ServerName  = rw_XML_row(xmlDoc, "ServerName");  // получения Имя сервера
	var Database    = rw_XML_row(xmlDoc, "Database");    // получение имя БД
	var UID         = rw_XML_row(xmlDoc, "UID");         // получение имени пользователя для БД
	var PWD         = rw_XML_row(xmlDoc, "PWD");         // получение пароля
	var template_excel       = "template/template_excel.php"; // получение шаблона списка

	//считываем параметры из формы
	var day_start     	= document.getElementById("day3").value;
	var month_start     = month_num(document.getElementById("month3").value);
	var year_start     	= document.getElementById("year3").value;
	var day_end     	= document.getElementById("day4").value;
	var month_end     	= month_num(document.getElementById("month4").value);
	var year_end     	= document.getElementById("year4").value;

	var field     	= document.getElementById("s_field").value;
	var bush     	= document.getElementById("s_bush").value;
	var well     	= document.getElementById("s_well").value;

	// подготавливаем аргументы для отправки запроса
    var params    = 'field='+ field + '&bush='+ bush + '&well='+ well + '&day_start='+ day_start + '&month_start=' + month_start + '&year_start=' + year_start + '&day_end=' + day_end + '&month_end=' + month_end + '&year_end=' + year_end + '&ServerName=' + encodeURIComponent(ServerName)
                 + '&Database=' + encodeURIComponent(Database) + '&UID=' + encodeURIComponent(UID) + '&PWD=' + encodeURIComponent(PWD);

    //var params = 'UID=12';
	//alert (filexml);

	SendRequest("POST", filexml + template_excel, params, "PrintContent"); // отправляем запрос и выводим его в блоке "PrintContent"

	//var var12     = document.getElementById('PrintContent');
	//var12.innerHTML = "fffff";
	//alert(month_start);

}

//----------------------------------Формирует excel по выборке------------------------------------------------------------------

function excel_select(){
	var filexml     = document.getElementById("pathxml").value;  // путь к XML файлу 'list.xml'
	xmlDoc          = loadXMLDoc(filexml+'list.xml'); // открытие XML файла 'list.xml'
	var ServerName  = rw_XML_row(xmlDoc, "ServerName");  // получения Имя сервера
	var Database    = rw_XML_row(xmlDoc, "Database");    // получение имя БД
	var UID         = rw_XML_row(xmlDoc, "UID");         // получение имени пользователя для БД
	var PWD         = rw_XML_row(xmlDoc, "PWD");         // получение пароля
	var template_excel       = "excel_save_group.php"; // получение шаблона списка

	//считываем параметры из формы
	var day_start     	= document.getElementById("day3").value;
	var month_start     = month_num(document.getElementById("month3").value);
	var year_start     	= document.getElementById("year3").value;
	var day_end     	= document.getElementById("day4").value;
	var month_end     	= month_num(document.getElementById("month4").value);
	var year_end     	= document.getElementById("year4").value;

	var field     	= document.getElementById("s_field").value;
	var bush     	= document.getElementById("s_bush").value;
	var well     	= document.getElementById("s_well").value;

	// подготавливаем аргументы для отправки запроса
    var params    = 'field='+ field + '&bush='+ bush + '&well='+ well + '&day_start='+ day_start + '&month_start=' + month_start + '&year_start=' + year_start + '&day_end=' + day_end + '&month_end=' + month_end + '&year_end=' + year_end + '&ServerName=' + encodeURIComponent(ServerName)
                 + '&Database=' + encodeURIComponent(Database) + '&UID=' + encodeURIComponent(UID) + '&PWD=' + encodeURIComponent(PWD);

    //var params = 'UID=12';
	//alert (params);
	alert(field);

	SendRequest("POST", filexml + template_excel, params, "en_file"); // отправляем запрос и выводим его в блоке "PrintContent"

	//var var12     = document.getElementById('PrintContent');
	//var12.innerHTML = "fffff";
	//alert(month_start);

}

//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//					Функция для отображения полученных документов.  	 				//
//				Данная функция позволяет отобразить необходимый документ.			 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// descr1 - название документа из списка документов.	    	          							//   
//------------------------------------------------------------------------------------------------------------------------------//


function show_html(descr1)
{
   var filexml     = document.getElementById("pathxml").value;  // путь к XML файлу 'list.xml'
   filefunc        = '../function.php';  //путь к function.php

   xmlDoc          = loadXMLDoc(filexml+'list.xml'); // открытие XML файла 'list.xml'
   var data        = document.getElementById('listDocType').value; // получение типа документа
   var descr       = rw_XML_rows(xmlDoc, "name", data, 'descr'); // получение шаблона списка
   //var substance_get = document.getElementById("listSubstance").value; // определяем тип документа 
   var html        = rw_XML_rows(xmlDoc, "name", data, 'template');  // получение нужного html файла
   var type        = rw_XML_rows(xmlDoc, "name", data, 'type');  // получение типа документа
   var vars        = rw_XML_rows(xmlDoc, "name", data, 'vars');  // получения дополнительных переменных
   var ServerName  = rw_XML_row(xmlDoc, "ServerName");  // получения Имя сервера
   var Database    = rw_XML_row(xmlDoc, "Database");    // получение имя БД
   var UID         = rw_XML_row(xmlDoc, "UID");         // получение имени пользователя для БД
   var PWD         = rw_XML_row(xmlDoc, "PWD");         // получение пароля
   var SIKN        = rw_XML_row(xmlDoc, "NameObjectOwner");        // получение # СИКН
   var OWNER       = rw_XML_row(xmlDoc, "Owner");       // получение Владелеца СИКН
   var myForm      = document.getElementById('txtHTML'); // блок  txtHTML

   var dateb, datee, dateb_get, datee_get, docdate, docdates;

   dateb = get_date_to_type(type,"b");  // получаем начальную дату
   //alert(dateb);
   datee = get_date_to_type(type,"e");  // получаем конечную дату

   //форматируем даты
   dateb_get = format_date(dateb, "'Ymd H:M:S'"); 
   datee_get = format_date(datee, "'Ymd H:M:S'");
   //alert(datee_get);

var sel = document.getElementById('listdocs');
var val = descr1;
for(var i = 0, j = sel.options.length; i < j; ++i) {
        if(sel.options[i].innerHTML === val) {
           index = i; 
           docdates = document.getElementById('datesDocs').value; 
           docdate  = docdates.split('|||')[index];
           break;
        }
    }



   
	
   // подготавливаем аргументы для отправки запроса
   var params    = 'dateb='+ dateb_get + '&datee=' + datee_get + '&descr=' + encodeURIComponent(descr) + '&descr1=' + encodeURIComponent(descr1) + '&docdate=' + encodeURIComponent(docdate) + '&ServerName=' + encodeURIComponent(ServerName)
                 + '&Database=' + encodeURIComponent(Database) + '&UID=' + encodeURIComponent(UID) + '&PWD=' + encodeURIComponent(PWD)+'&file_func='+encodeURIComponent(filefunc)
                 + '&SIKN=' + encodeURIComponent(SIKN) + '&OWNER=' + encodeURIComponent(OWNER);
   
   if (vars != "-")   // если дополнительные переменные есть, то добавляем их
   {
	vars = encodeURIComponent(vars);	
        vars = vars.replace(/%3F/g,"&");	
        vars = vars.replace(/%3D/g,"=");
	params += '&'+ vars;
   }


   SendRequest("POST", filexml + html, params, "PrintContent"); // отправляем запрос и выводим его в блоке "PrintContent"
}



//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//						Функция печати блока. 	 			 				//
//				Данная функция позволяет распечатать выбранный документ.			 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// elem - название блок.	   			 	          							//   
//------------------------------------------------------------------------------------------------------------------------------//

function PrintElem(elem)
{

		$("#slide_panel").css({left:'-500px'});
		$("#container").css({"padding-left":'0px'});
		$("#container").css({"padding-right":'0px'});
window.print(); 
		$("#slide_panel").css({left:'0'});
		$("#container").css({"padding-left":'401px'});
		$("#container").css({"padding-right":'60px'});
    //Popup($(elem).html()); // выводит блок див в новое окни и печатает его
}


//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//				Функция открытия нового окна для печати блока. 	 		 				//
//				Данная функция позволяет распечатать содержимеое data.				 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// data - текст.	   				 	          							//   
//------------------------------------------------------------------------------------------------------------------------------//
function Popup(data) 
{
   var mywindow = window.open('', 'to_print', 'height=600,width=800');
   var html     = '<html><head><title>Распечатать</title>' +
                  '</head><body onload="window.focus(); window.print(); window.close()">' +
                  data +
                  '</body></html>';
    mywindow.document.write(html);
    mywindow.document.close();
    return true;
}



//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//							Функция ошибок. 	 		 				//
//						Данная функция отображает ошибку data.				 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// data - номер ошибки.	   				 	          							//   
//------------------------------------------------------------------------------------------------------------------------------//

        
function error_html(data) 
{
 var pathprog  =  document.getElementById("pathprog").value;

  var html  =   '<div align="center">'+
		'<div style="width:50%;text-align:center; padding-bottom:40px !important;">'+
		'<div style="font-size:120px; color:#333; margin:0px 0 0 -90px;"><img src="' +
                pathprog + 'images/error.png" style="padding-left:90px;"></div>'+
		'<h1>'+data +' ОШИБКА СТРАНИЦЫ</h1>'+
		'<p style="padding-bottom:20px; margin-bottom:20px; border-bottom:1px solid #e8e8e8;">'+
		'Запрошенная страница не существует или не может быть найдена.</p>'+
		'<span style="display:inline-block"><a href="index.php" class="button-home">'+
		'Главная страница</a></span>'+
		'</div></div>';

/*
  var html  ="<div class='center error-404'>" +
		"<h1 class='error'><span>" + data + "</span>" +
		"</h1><h2 class='title'>Страница не найдена!</h2>"+
		"<p class='message'>Страница, которую вы ищете, не существует или произошла другая ошибка. " +
                "Перейдите на  <a href='http://localhost:8000/'>Главную страницу</a>, чтобы выбрать другой документ.</p></div>";*/
  return html;
}	
	

//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//					Функция сохранения элементов в панеле управления. 	 				//
//				Данная функция сохраняет все изменения в панели управления.			 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// Входных данных нет.	   				 	          							//   
//------------------------------------------------------------------------------------------------------------------------------//


function save_php() 
{
  var MinYear        =  document.getElementById("MinYear").value;   //получение нового года начала документов
  var Header_left    =  document.getElementById("Header_left").value; // новый заголовок левой панели
  var Prjpath        =  document.getElementById("Prjpath").value;    // новый путь к проекту
  var Prjviewerpath  =  document.getElementById("Prjviewerpath").value; // новы путь к oznaflow

  // Подготавливаем аргументы к запрусу
  var params  = "MinYear=" + MinYear + "&Header_left=" + Header_left + "&Prjpath=" + Prjpath + "&Prjviewerpath=" + Prjviewerpath;

  var buttons = "";   // изменение иконок и функций для кнопок

  for (var i = 1; i < 9; i++) 
  {
	buttons = "Button" + i + "_func"
	params += "&" + buttons + "=" + document.getElementById(buttons).value;

	buttons = "Button" + i + "_file_i"
	params += "&" + buttons + "=" + document.getElementById(buttons).value;
  }
 

  SendRequest("POST", 'save.php', params, "message");  //отправка запроса и вывода результата обработки в блок "message"
}	



//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//							Изменение значения в input. 		 				//
//				Данная функция сохраняет все изменения в панели управления.			 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//  
// id_file - новое значение;	   			 	          							//          
// id_text - id input.	   				 	          							//   
//------------------------------------------------------------------------------------------------------------------------------//


function Change_File(id_file, id_text)
{
	document.getElementById(id_text).value = id_file;
}



//------------------------------------------------------------------------------------------------------------------------------//
//                                                                                                                	     	//
//							Переход на новый url. 			 				//
//					Данная функция автоматически перейти на новую ссылку.			 		//
//                                                                                                                		//
//------------------------------------------------------------------------------------------------------------------------------//
//                                             Входные переменные:                                                		//
//------------------------------------------------------------------------------------------------------------------------------//          
// url_site - ссылка.	   				 	          							//   
//------------------------------------------------------------------------------------------------------------------------------//

function Get_URL(url_site)
{
	return location.href = url_site;
}

	