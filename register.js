// (c) 2018 Юрий Лазаренко, г. Севастополь
// Почта lazarenkoyv@mail.ru
// Скайп lazarenkoyv
// МСП
// v 1.0.0.1
// 23.04.2018

function captchaRefresh(){
	var captchaspan = getElement("captchaspan");
	if(captchaspan){
		// Открыта форма регистрации нового пользователя
		captchaspan.innerHTML = "<img onclick='captchaRefresh()' src = 'ajax/captcha.php?t=" + Math.random() +"'>";
	}
}
