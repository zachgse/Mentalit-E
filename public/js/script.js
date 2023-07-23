var num1 = 0;
var num2 = 0;
var num3 = 0;
var num4 = 0;        
var num5 = 0;
var num6 = 0;
var num7 = 0;
var num8 = 0;
var num9 = 0;
var num10 = 0;
var num11 = 0;
var num12 = 0;
var num13 = 0;
var num14 = 0;
var num15 = 0;

//Questions

var question001 = ["1.) I was very anxious, worried or scared about a lot of things in my life."];
var choices001 = ["<input onclick=num1ans01() name=question1 type=radio required/> Never<br /><input onclick=num1ans02() name=question1 type=radio required/> A few times <br /><input onclick=num1ans03() name=question1 type=radio required/> Sometimes <br /><input onclick=num1ans04() name=question1 type=radio required/> Often <br /><input onclick=num1ans05() name=question1 type=radio required/> Constantly<br />"];

var question002 = ["2.) I felt that my worry was out of my control."];
var choices002 = ["<input onclick=num2ans01() name=question2 type=radio required /> Never<br /><input onclick=num2ans02() name=question2 type=radio /> A few times <br /><input onclick=num2ans03() name=question2 type=radio /> Sometimes <br /><input onclick=num2ans04() name=question2 type=radio /> Often <br /><input onclick=num2ans05() name=question2 type=radio /> Constantly<br />"];

var question003 = ["3.) I felt restless, agitated, frantic, or tense."];
var choices003 = ["<input onclick=num3ans01() name=question3 type=radio required /> Never<br /><input onclick=num3ans02() name=question3 type=radio /> A few times <br /><input onclick=num3ans03() name=question3 type=radio /> Sometimes <br /><input onclick=num3ans04() name=question3 type=radio /> Often <br /><input onclick=num3ans05() name=question3 type=radio /> Constantly<br />"];

var question004 = ["4.) I had trouble sleeping - I could not fall or stay asleep, and/or didn't feel well-rested when I woke up."];
var choices004 = ["<input onclick=num4ans01() name=question4 type=radio required /> Never<br /><input onclick=num4ans02() name=question4 type=radio /> A few times <br /><input onclick=num4ans03() name=question4 type=radio /> Sometimes <br /><input onclick=num4ans04() name=question4 type=radio /> Often <br /><input onclick=num4ans05() name=question4 type=radio /> Constantly<br />"];

var question005 = ["5.) My heart would skip beat, was pounding, or my heart rate increased."];
var choices005 = ["<input onclick=num5ans01() name=question5 type=radio required /> Never<br /><input onclick=num5ans02() name=question5 type=radio /> A few times <br /><input onclick=num5ans03() name=question5 type=radio /> Sometimes <br /><input onclick=num5ans04() name=question5 type=radio /> Often <br /><input onclick=num5ans05() name=question5 type=radio /> Constantly<br />"];

var question006 = ["6.) I was sweating profusely."];
var choices006 = ["<input onclick=num6ans01() name=question6 type=radio required /> Never<br /><input onclick=num6ans02() name=question6 type=radio /> A few times <br /><input onclick=num6ans03() name=question6 type=radio /> Sometimes <br /><input onclick=num6ans04() name=question6 type=radio /> Often <br /><input onclick=num6ans05() name=question6 type=radio /> Constantly<br />"];

var question007 = ["7.) My hands, legs or entire body were shaking, trembling, or felt tingly."];
var choices007 = ["<input onclick=num7ans01() name=question7 type=radio required /> Never<br /><input onclick=num7ans02() name=question7 type=radio /> A few times <br /><input onclick=num7ans03() name=question7 type=radio /> Sometimes <br /><input onclick=num7ans04() name=question7 type=radio /> Often <br /><input onclick=num7ans05() name=question7 type=radio /> Constantly<br />"];

var question008 = ["8.) I had difficulty breathing or swallowing"];
var choices008 = ["<input onclick=num8ans01() name=question8 type=radio required /> Never<br /><input onclick=num8ans02() name=question8 type=radio /> A few times <br /><input onclick=num8ans03() name=question8 type=radio /> Sometimes <br /><input onclick=num8ans04() name=question8 type=radio /> Often <br /><input onclick=num8ans05() name=question8 type=radio /> Constantly<br />"];

var question009 = ["9.) I had pain in my chest, almost like I was having a heart attack."];
var choices009 = ["<input onclick=num9ans01() name=question9 type=radio required /> Never<br /><input onclick=num9ans02() name=question9 type=radio /> A few times <br /><input onclick=num9ans03() name=question9 type=radio /> Sometimes <br /><input onclick=num9ans04() name=question9 type=radio /> Often <br /><input onclick=num9ans05() name=question9 type=radio /> Constantly<br />"];

var question0010 = ["10.) I felt sick to my stomach, like I was going to throw up, or had diarrhea."];
var choices0010 = ["<input onclick=num10ans01() name=question10 type=radio required /> Never<br /><input onclick=num10ans02() name=question10 type=radio /> A few times <br /><input onclick=num10ans03() name=question10 type=radio /> Sometimes <br /><input onclick=num10ans04() name=question10 type=radio /> Often <br /><input onclick=num10ans05() name=question10 type=radio /> Constantly<br />"];

var question0011 = ["11.) I felt dizzy, my head was spinning, or felt like I was going to faint."];
var choices0011 = ["<input onclick=num11ans01() name=question11 type=radio required /> Never<br /><input onclick=num11ans02() name=question11 type=radio /> A few times <br /><input onclick=num11ans03() name=question11 type=radio /> Sometimes <br /><input onclick=num11ans04() name=question11 type=radio /> Often <br /><input onclick=num11ans05() name=question11 type=radio /> Constantly<br />"];

var question0012 = ["12.) I was scared that I would lose control, go crazy, or die."];
var choices0012 = ["<input onclick=num12ans01() name=question12 type=radio required /> Never<br /><input onclick=num12ans02() name=question12 type=radio /> A few times <br /><input onclick=num12ans03() name=question12 type=radio /> Sometimes <br /><input onclick=num12ans04() name=question12 type=radio /> Often <br /><input onclick=num12ans05() name=question12 type=radio /> Constantly<br />"];

var question0013 = ["13.) How frequently did you experience panic attacks in the last 6 months?"];
var choices0013 = ["<input onclick=num13ans01() name=question13 type=radio required /> Never<br /><input onclick=num13ans02() name=question13 type=radio /> A few times <br /><input onclick=num13ans03() name=question13 type=radio /> Sometimes <br /><input onclick=num13ans04() name=question13 type=radio /> Often <br /><input onclick=num13ans05() name=question13 type=radio /> Constantly<br />"];

var question0014 = ["14.) Did you purposely avoid situations or activities in which you might experience a panic attack?"];
var choices0014 = ["<input onclick=num14ans01() name=question14 type=radio required /> Never<br /><input onclick=num14ans02() name=question14 type=radio /> A few times <br /><input onclick=num14ans03() name=question14 type=radio /> Sometimes <br /><input onclick=num14ans04() name=question14 type=radio /> Often <br /><input onclick=num14ans05() name=question14 type=radio /> Constantly<br />"];

var question0015 = ["15.) My body has that sinking feeling whenever I have a panic attack"];
var choices0015 = ["<input onclick=num15ans01() name=question15 type=radio required /> Never<br /><input onclick=num15ans02() name=question15 type=radio /> A few times <br /><input onclick=num15ans03() name=question15 type=radio /> Sometimes <br /><input onclick=num15ans04() name=question15 type=radio /> Often <br /><input onclick=num15ans05() name=question15 type=radio /> Constantly<br />"];

var information001 = ["75-50 Severe Anxiety and Panic Attacks<br/>49-30 Moderate Anxiety and Panic Attacks<br/>29-16 Mild Anxiety and Panic Attacks<br/>15 No Anxiety and Panic Attacks<br/>"];
var information002 = ["<i> Disclaimer: This questionnaire was made by PsychologyToday and this test should not be substituted as a professional diagnosis or mental health treatment. If you wish to book a consultation with a mental health professional, Mentalit-E can connect you to clinics that offers therapy sessions. </i>"]


window.onload = function set001 () {

	message001.innerHTML = question001;
	options001.innerHTML = choices001;
	message002.innerHTML = question002;
	options002.innerHTML = choices002;
	message003.innerHTML = question003;
	options003.innerHTML = choices003;
	message004.innerHTML = question004;
	options004.innerHTML = choices004;
	message005.innerHTML = question005;
	options005.innerHTML = choices005;
	
	click001.innerHTML = "<button class='btn btn-outline pull-right' onclick=set002()>Next</button>";
}

//Number 1
function num1ans01() {
	num1 = 1;
}

function num1ans02() {
	num1 = 2;
}

function num1ans03() {
	num1 = 3;
}

function num1ans04() {
	num1 = 4;
}

function num1ans05() {
	num1 = 5;
}

//Number 2
function num2ans01() {
	num2 = 1;
}

function num2ans02() {
	num2 = 2;
}

function num2ans03() {
	num2 = 3;
}

function num2ans04() {
	num2 = 4;
}

function num2ans05() {
	num2 = 5;
}

//Number 3
function num3ans01() {
	num3 = 1;
}

function num3ans02() {
	num3 = 2;
}

function num3ans03() {
	num3 = 3;
}

function num3ans04() {
	num3 = 4;
}

function num3ans05() {
	num3 = 5;
}

//Number 4
function num4ans01() {
	num4 = 1;
}

function num4ans02() {
	num4 = 2;
}

function num4ans03() {
	num4 = 3;
}

function num4ans04() {
	num4 = 4;
}

function num4ans05() {
	num4 = 5;
}

//Number 5   
function num5ans01() {
	num5 = 1;
}

function num5ans02() {
	num5 = 2;
}

function num5ans03() {
	num5 = 3;
}

function num5ans04() {
	num5 = 4;
}

function num5ans05() {
	num5 = 5;
}

//set002 2
function set002() {

	message001.innerHTML = question006;
	options001.innerHTML = choices006;
	message002.innerHTML = question007;
	options002.innerHTML = choices007;
	message003.innerHTML = question008;
	options003.innerHTML = choices008;
	message004.innerHTML = question009;
	options004.innerHTML = choices009;
	message005.innerHTML = question0010;
	options005.innerHTML = choices0010;
	click001.innerHTML = "<button class='btn btn-outline pull-right' onclick=set003()>Next</button>";
}

//Number 6
function num6ans01() {
	num6 = 1;
}

function num6ans02() {
	num6 = 2;
}

function num6ans03() {
	num6 = 3;
}

function num6ans04() {
	num6 = 4;
}

function num6ans05() {
	num6 = 5;
}

//Number 7
function num7ans01() {
	num7 = 1;
}

function num7ans02() {
	num7 = 2;
}

function num7ans03() {
	num7 = 3;
}

function num7ans04() {
	num7 = 4;
}

function num7ans05() {
	num7 = 5;
}

//Number 8
function num8ans01() {
	num8 = 1;
}

function num8ans02() {
	num8 = 2;
}

function num8ans03() {
	num8 = 3;
}

function num8ans04() {
	num8 = 4;
}

function num8ans05() {
	num8 = 5;
}

//Number 9
function num9ans01() {
	num9 = 1;
}

function num9ans02() {
	num9 = 2;
}

function num9ans03() {
	num9 = 3;
}

function num9ans04() {
	num9 = 4;
}

function num9ans05() {
	num9 = 5;
}

//Number 10
function num10ans01() {
	num10 = 1;
}

function num10ans02() {
	num10 = 2;
}

function num10ans03() {
	num10 = 3;
}

function num10ans04() {
	num10 = 4;
}

function num10ans05() {
	num10 = 5;
}

//Question Set 3
function set003() {

	message001.innerHTML = question0011;
	options001.innerHTML = choices0011;
	message002.innerHTML = question0012;
	options002.innerHTML = choices0012;
	message003.innerHTML = question0013;
	options003.innerHTML = choices0013;
	message004.innerHTML = question0014;
	options004.innerHTML = choices0014;
	message005.innerHTML = question0015;
	options005.innerHTML = choices0015;
	click001.innerHTML = "<button class='btn btn-outline pull-right' onclick=result001() data-bs-toggle='modal' data-bs-target='#EMA-results'>Submit</button>";
}

//Number 10
function num10ans01() {
	num10 = 1;
}

function num10ans02() {
	num10 = 2;
}

function num10ans03() {
	num10 = 3;
}

function num10ans04() {
	num10 = 4;
}

function num10ans05() {
	num10 = 5;
}

//Number 11
function num11ans01() {
	num11 = 1;
}

function num11ans02() {
	num11 = 2;
}

function num11ans03() {
	num11 = 3;
}

function num11ans04() {
	num11 = 4;
}

function num11ans05() {
	num11 = 5;
}

//Number 12
function num12ans01() {
	num12 = 1;
}

function num12ans02() {
	num12 = 2;
}

function num12ans03() {
	num12 = 3;
}

function num12ans04() {
	num12 = 4;
}

function num12ans05() {
	num12 = 5;
}
//Number 13
function num13ans01() {
	num13 = 1;
}

function num13ans02() {
	num13 = 2;
}

function num13ans03() {
	num13 = 3;
}

function num13ans04() {
	num13 = 4;
}

function num13ans05() {
	num13 = 5;
}

//Number 14
function num14ans01() {
	num14 = 1;
}

function num14ans02() {
	num14 = 2;
}

function num14ans03() {
	num14 = 3;
}

function num14ans04() {
	num14 = 4;
}

function num14ans05() {
	num14 = 5;
}

//Number 15
function num15ans01() {
	num15 = 1;
}

function num15ans02() {
	num15 = 2;
}

function num15ans03() {
	num15 = 3;
}

function num15ans04() {
	num15 = 4;
}

function num15ans05() {
	num15 = 5;
}


function result001() {
	sum = num1 + num2 + num3 + num4 + num5 + num6 + num7 + num8 + num9 + num10 + num11 + num12 + num13 + num14 + num15 ;
	message001.innerHTML = "";
	options001.innerHTML = "";
	message002.innerHTML = "";
	options002.innerHTML = "";
	message003.innerHTML = "";
	options003.innerHTML = "";
	message004.innerHTML = "";
	options004.innerHTML = "";
	message005.innerHTML = "";
	options005.innerHTML = "";
	comment001.innerHTML = "<b class='text-center' style='font-size:30px;'>Your score is: " + sum + "</b>";
	comment002.innerHTML = information001;
	disclaimer001.innerHTML = information002;
	click001.innerHTML = "<p class='text-center'>Thank you for answering the Ecological Momentary Assessment!</p>";

}