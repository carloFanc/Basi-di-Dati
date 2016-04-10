
$(document).ready(function(){

});

function cambiaFinestra(string) {   
    $('#bici').hide("fast").css("visibility","hidden");
    $('#veicoli').hide("fast").css("visibility","hidden");
    $('#prenotazioni').hide("fast").css("visibility","hidden");
    $('#inbox').hide("fast").css("visibility","hidden");
    $('#forum').hide("fast").css("visibility","hidden");
    $('#altro').hide("fast").css("visibility","hidden");
    if(string=="bici"){
        $('#bici').show("fast").css("visibility","visible");
        cambiaContenuto('vuoto');
    }
       if(string=="veicoli"){
        $('#veicoli').show("fast").css("visibility","visible");
        cambiaContenuto('vuoto');
    } 
        if(string=="prenotazioni"){
        $('#prenotazioni').show("fast").css("visibility","visible");
        cambiaContenuto('vuoto');
    }
        if(string=="inbox"){
        $('#inbox').show("fast").css("visibility","visible");
        cambiaContenuto('vuoto');
    }
        if(string=="forum"){
        $('#forum').show("fast").css("visibility","visible");
        cambiaContenuto('vuoto');
    }
        if(string=="altro"){
        $('#altro').show("fast").css("visibility","visible");
        cambiaContenuto('vuoto');
    }
};

function cambiaContenuto(string){
	 if(string=="profilo"){
        $("#Contenuto").load("function/profilo.php");
    }
	if(string=="vuoto"){
        $("#Contenuto").load("function/htmlvuota.html");
    }
	
	
};
