// (с) Юрий Лазаренко, Севастополь
// e-mail lazarenkoyv@mail.ru
// v-can.Voice
// v 1.1.0.2
// 11.09.2018

function vcanVoice(p){
	var o = this;
	this.varName = (typeof p.varName == "undefined") ? "" : p.varName;
	this.recognizer = new webkitSpeechRecognition();
	this.recСontinuous = (typeof p.recСontinuous == "undefined") ? false : p.recСontinuous;
	this.recInProcess = false;
	this.recResultElem = (typeof p.recResultElem == "undefined") ? null : p.recResultElem;
	this.speaker = new SpeechSynthesisUtterance();
	this.soundLevelMin = (typeof p.soundLevelMin == "undefined") ? 10 : p.soundLevelMin;
	this.soundLevelMax = (typeof p.soundLevelMax == "undefined") ? 100 : p.soundLevelMax;
	this.soundLevel = this.soundLevelMin;
	this.soundLevelIncStep = (typeof p.soundLevelIncStep == "undefined") ? 20 : p.soundLevelIncStep;
	this.soundLevelDecStep = (typeof p.soundLevelDecStep == "undefined") ? 100 : p.soundLevelDecStep;
	this.soundLevelElem = (typeof p.soundLevelElem == "undefined") ? null : p.soundLevelElem;
	this.additionalProps = (typeof p.additionalProps == "undefined") ? {} : p.additionalProps; // Дополнительные произвольные свойства
	this.init = function(){
		this.initRecognizer();
		this.initSoundLevel();
		this.initSpeaker();
	}
}

///////////////////////////////////////////////////////////////////////
// Распознавание речи                                                //
///////////////////////////////////////////////////////////////////////

vcanVoice.prototype.initRecognizer = function(){
	var o = this;
	if(o.recognizer){
		o.recognizer.interimResults = true;
		o.recognizer.lang = 'ru-Ru';
		o.recognizer.continuous = o.recСontinuous;

		o.recognizer.onresult = function (event) {
		  var result = event.results[event.resultIndex];
		  if (result.isFinal) {
			o.recResultElem.value = result[0].transcript;
			o.soundLevelElem.style.background = "#e6e6e6";	
			o.recInProcess = false;
			o.recognizer_onresult_final();
		  }else{
			o.recResultElem.value = result[0].transcript;
			o.soundLevelChange(soundLevel + o.soundLevelIncStep * 3);
			o.recognizer_onresult_temp();
		  }
		};

		// События распознавания речи
		o.recognizer.onsoundstart = function () {
			o.soundLevelChange(o.soundLevel + o.soundLevelIncStep);
			o.recognizer_onsoundstart();
		};
		o.recognizer.onsoundend = function () {
			o.recognizer_onsoundend();
		};
		o.recognizer.onspeechstart = function () {
			o.recognizer_onspeechstart();
		};
		o.recognizer.onspeechend = function () {
			o.recognizer_onspeechend();
		};
		o.recognizer.onaudiostart = function () {
			o.recognizer_onaudiostart();
		};
		o.recognizer.onaudioend = function () {
			o.recInProcess = false;
			o.soundLevelElem.style.background = "#e6e6e6";	
			o.recognizer_onaudioend();
		};
	}
}

vcanVoice.prototype.startRecognition = function(){
	var o = this;
	if(o.recognizer){
		o.recInProcess = true;
		o.soundLevelElem.style.background = "#8ff1bb";	
		try{
			o.recognizer.start();
		}catch (e){
			return false;
		}
	}else{
		o.startRecognitionFail();
	}	
}

// Событие ошибки запуска распознавания речи
vcanVoice.prototype.startRecognitionFail = function(){
}

// Событие распознавания окончательного результата
vcanVoice.prototype.recognizer_onresult_final = function(){
}

// Событие распознавания промежуточного результата
vcanVoice.prototype.recognizer_onresult_temp = function(){
}

// События распознавания речи
vcanVoice.prototype.recognizer_onsoundstart = function(){
}

vcanVoice.prototype.recognizer_onsoundend = function(){
}

vcanVoice.prototype.recognizer_onspeechstart = function(){
}

vcanVoice.prototype.recognizer_onspeechend = function(){
}

vcanVoice.prototype.recognizer_onaudiostart = function(){
}

vcanVoice.prototype.recognizer_onaudioend = function(){
}

///////////////////////////////////////////////////////////////////////
// Уровень звука                                                     //
///////////////////////////////////////////////////////////////////////

vcanVoice.prototype.initSoundLevel = function(){
	var o = this;
	o.soundLevel = o.soundLevelMin;
	o.soundLevelChange(o.soundLevel);
	setInterval(o.varName + '.soundLevelDecrease()', 200);
	setInterval(o.varName + '.soundLevelPulse()', 900);
}

vcanVoice.prototype.soundLevelChange = function(soundLevelValue){
	var o = this;
	if(soundLevelValue < o.soundLevelMin){
		soundLevelValue = o.soundLevelMin;
	}
	if(soundLevelValue > o.soundLevelMax){
		soundLevelValue = o.soundLevelMax;
	}
	if(soundLevelValue != o.soundLevel){
		if(soundLevelValue > o.soundLevel){
			o.soundLevelElem.style.transition = '0.1s';
		}else{
			o.soundLevelElem.style.transition = '0.5s';
		}
		o.soundLevel = soundLevelValue;
		o.soundLevelElem.style.height = '' + o.soundLevel + 'px';
		o.soundLevelElem.style.top = '' + ((o.soundLevelMax - o.soundLevel) + o.soundLevel/2) + 'px';
		o.soundLevelElem.style.width = '' + soundLevelValue + 'px';
		o.soundLevelElem.style.left = '' + ((o.soundLevelMax - o.soundLevel) + o.soundLevel/2) + 'px';
	}
}

vcanVoice.prototype.soundLevelDecrease = function(){
	var o = this;	
	o.soundLevelChange(o.soundLevel - o.soundLevelDecStep);
}

vcanVoice.prototype.soundLevelPulse = function(){
	var o = this;	
	if(o.recInProcess && o.soundLevel <= o.soundLevelMin){
		o.soundLevelChange(o.soundLevel + o.soundLevelIncStep / 2);
	}
}

///////////////////////////////////////////////////////////////////////
// Синтез речи                                                       //
///////////////////////////////////////////////////////////////////////

// Иниицализация синтезатора речи
vcanVoice.prototype.initSpeaker = function(){
	var o = this;	
	var voices = speechSynthesis.getVoices();
	o.speaker.voice = voices[17];
	o.speaker.voiceURI = '16';
	o.speaker.volume = 1;	// 0 - 1
	o.speaker.rate = 1;	// 0.1 - 10
	o.speaker.pitch = 1;	//0 - 2
	o.speaker.lang = 'ru-RU';
	o.speaker.onend = function(e) {
		// Запуск распознавания речи
		o.startRecognition();
		// !!!!! Добавить функцию
	};	
}

// Произнести фразу
vcanVoice.prototype.speak = function(textToSpeak){
	var o = this;
	o.speaker.text = textToSpeak;
	speechSynthesis.speak(o.speaker);
}