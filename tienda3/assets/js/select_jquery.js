$(document).ready(function(){

//Initializing arrays with carreras names
var lun = [
    {display: "10 am", value: "10 am" }, 
    {display: "11 am", value: "11 am" }, 
    {display: "12 am", value: "12 am" }, 
    {display: "1 pm", value: "1 pm" }, 
    {display: "2 pm", value: "2 pm" }, 
    {display: "4 pm", value: "4 pm" }, 
    {display: "5 pm", value: "5 pm" }, 
    {display: "6 pm", value: "6 pm" }, 
    {display: "7 pm", value: "7 pm" }, 
    {display: "8 pm", value: "8 pm" }];
    
var mar = [ 
    {display: "10 am", value: "10 am" }, 
    {display: "11 am", value: "11 am" }, 
    {display: "12 am", value: "12 am" }, 
    {display: "1 pm", value: "1 pm" }, 
    {display: "2 pm", value: "2 pm" }, 
    {display: "4 pm", value: "4 pm" }, 
    {display: "5 pm", value: "5 pm" }, 
    {display: "6 pm", value: "6 pm" }, 
    {display: "7 pm", value: "7 pm" }, 
    {display: "8 pm", value: "8 pm" }];
    
var mier = [
   {display: "10 am", value: "10 am" }, 
    {display: "11 am", value: "11 am" }, 
    {display: "12 am", value: "12 am" }, 
    {display: "1 pm", value: "1 pm" }, 
    {display: "2 pm", value: "2 pm" }, 
    {display: "4 pm", value: "4 pm" }, 
    {display: "5 pm", value: "5 pm" }, 
    {display: "6 pm", value: "6 pm" }, 
    {display: "7 pm", value: "7 pm" }, 
    {display: "8 pm", value: "8 pm" }];

var jue = [
   	{display: "10 am", value: "10 am" }, 
    {display: "11 am", value: "11 am" }, 
    {display: "12 am", value: "12 am" }, 
    {display: "1 pm", value: "1 pm" }, 
    {display: "2 pm", value: "2 pm" }, 
    {display: "4 pm", value: "4 pm" }, 
    {display: "5 pm", value: "5 pm" }, 
    {display: "6 pm", value: "6 pm" }, 
    {display: "7 pm", value: "7 pm" }, 
    {display: "8 pm", value: "8 pm" }];

var vier = [
    {display: "10 am", value: "10 am" }, 
    {display: "11 am", value: "11 am" }, 
    {display: "12 am", value: "12 am" }, 
    {display: "1 pm", value: "1 pm" }, 
    {display: "2 pm", value: "2 pm" }, 
    {display: "4 pm", value: "4 pm" }, 
    {display: "5 pm", value: "5 pm" }, 
    {display: "6 pm", value: "6 pm" }, 
    {display: "7 pm", value: "7 pm" }, 
    {display: "8 pm", value: "8 pm" }];

var sab = [
    {display: "10 am", value: "10 am" }, 
    {display: "11 am", value: "11 am" }, 
    {display: "12 am", value: "12 am" }, 
    {display: "1 pm", value: "1 pm" }];

//Function executes on change of first select option field 
$("#dia").change(function(){

var select = $("#dia option:selected").val();

switch(select){
case "Lunes":
	hora(lun);
break;

case "Martes":
	hora(mar);
break;

case "Miercoles":
	hora(mier);
break;

case "Jueves":
	hora(jue);
break;

case "Viernes":
	hora(vier);
break;

case "Sabado":
	hora(sab);
break;

default:
	$("#hora").empty();
	$("#hora").append("<option>Selecciona la Hora de Interés</option>");
break;
}
});

//Function To List out Cities in Second Select tags
function hora(arr){
	$("#hora").empty();//To reset cities
	$("#hora").append("<option>Selecciona la Hora de Interés</option>");
	$(arr).each(function(i){//to list cities
		$("#hora").append("<option value=\""+arr[i].value+"\">"+arr[i].display+"</option>")
	});
}

});