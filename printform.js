// (c) 2018 Юрий Лазаренко, г. Севастополь
// Почта lazarenkoyv@mail.ru
// Скайп lazarenkoyv
// ПСГ
// v 1.0.0.1
// 08.02.2019

// Загрузка страницы
function printformPageLoad(){
	УстановитьCookie('vcanSessionID', ЭлементHTMLДокумента('vcan_sessionid').value, 30);
	var ДополнительныеПараметры = document.location.search;
	if (ДополнительныеПараметры.length > 1){
		ДополнительныеПараметры = "&" + ДополнительныеПараметры.slice(1);
	}
	arrParams = {};
	ЗапросК1С('КэнСайтСервер.ФормаПечатиДокументов(ПараметрыЗапроса)', arrParams, 'mainpage', true, {'onLoad':'printformPageInit()'});
}

// Инициализация страницы
function printformPageInit(){
}

// Загрузка документа
function ЗагрузитьДокумент(){
	var newa = document.createElement('a');
	newa.href = "ajax/userscripts/loadfile.php" + document.location.search; 
	newa.click();
}
