$('#datetimepicker').datetimepicker({
	format : 'YYYY-MM-DD'
});
$("#datetimepicker").on("dp.change", function(e) {

	var indirizzo = $("#colonnina option:selected").text();
  
	var dataFinal = timeConverter(e.date); 
	var orariSlot =["00:00","00:30","01:00","01:30","02:00","02:30","03:00","03:30",
					"04:00","04:30","05:00","05:30","06:00","06:30","07:00","07:30",
					"08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30",
					"12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30",
					"16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30",
					"20:00","20:30","21:00","21:30","22:00","22:30","23:00","23:30"];
	$.ajax({
		type : "POST",
		url : "/BasiDati/function/richiediPrenotazionisuColonnine.php",
		data : "indirizzo=" + indirizzo + "&data=" + dataFinal
	}).done(function(data) {
	 var outputSelectInizio =" <h4>Dalle ore</h4>  <select name=\"slotDisponibiliInizio\" id=\"slotDisponibiliInizio\">";
	 var outputSelectFine ="  <h4>Alle ore</h4>  <select  name=\"slotDisponibiliFine\" id=\"slotDisponibiliFine\">";
	        for( i=0; i<orariSlot.length;i++){
	        	var flag = true;
	        	    $.each(data, function(j, item){
	          	if(i<=item.Slot_Fine && i>=item.Slot_Inizio){
	          		flag = false;
	          	}
                  });
	        	if(flag){
	        		outputSelectInizio= outputSelectInizio+"<option value=\""+orariSlot[i]+"\" id=\""+i+"\">"+orariSlot[i]+"</option>";
	        		outputSelectFine= outputSelectFine+"<option value=\""+orariSlot[i]+"\" id=\""+i+"\">"+orariSlot[i]+"</option>";
	        	}
	        	
	        	
	        }
	    outputSelectInizio= outputSelectInizio + "</select>" ;
	       outputSelectFine= outputSelectFine + "</select>" ;
	 $('#slotDisponibiliInizio').html(outputSelectInizio);
	 $('#slotDisponibiliFine').html(outputSelectFine);
	 $('select').niceSelect();
	 $("#bottone").css("visibility","visible");
	});
});
$( document ).ready(function(){

$.ajax({
        url: '/BasiDati/function/getIndirizziColonnine.php',
        type:'POST',
        dataType: 'json',
        success: function(output_string){
                $('#indirizzi').append(output_string);
                $('select').niceSelect();
            } // End of success function of ajax form
        }); // End of ajax call    

});
function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  switch(month) {
	case "Jan":
	month = "01";
	break;
	case "Feb":
	month = "02";
	break;
	case "Mar":
	month = "03";
	break;
	case "Apr":
	month = "04";
	break;
	case "May":
	month = "05";
	break;
	case "Jun":
	month = "06";
	break;
	case "Jul":
	month = "07";
	break;
	case "Aug":
	month = "08";
	break;
	case "Sep":
	month = "09";
	break;
	case "Oct":
	month = "10";
	break;
	case "Nov":
	month = "11";
	break;
	case "Dec":
	month = "12";
	break;
 	
	}
	if(date<10){
		date= '0'+date;
	}
  var time =year+'-'+month+'-'+ date  ;
  return time;
}

 