//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$.getJSON("data.json", function( data ) {
  var estado_combo = $("#estados");
  var ciudad_combo = $("#ciudad");
  var parroquia_combo = $("#parroquia");

  estado_combo.append($('<option>', {
	value: "",
	text : "Elije un estado"
  }));

  // Populate first combobox "Estados"
  data.forEach(function(item){
      estado_combo.append($('<option>', {
          value: item.estado,
          text : item.estado
      }));
  });

  //Populate "ciudad" when change "estado"
  estado_combo.change(function(){
      var select = $(this).val();
      ciudad_combo.html("");

      data.forEach(function(item){
          if (select == item.estado) {
              var ciudades = item.municipios;
			  ciudad_combo.append($('<option>', {
					value: "",
					text : "Elije una ciudad"
				}));
              ciudades.forEach(function(ciudad){
                  ciudad_combo.append($('<option>', {
                      value: ciudad.municipio,
                      text : ciudad.municipio
                  }));
              });
          }
      });
  });

	//Populate "parroquia" when change "ciudad"
  ciudad_combo.change(function(){
      var select = $(this).val();
      var select_state = $("#estados").val();

      data.forEach(function(item){
          if (select_state == item.estado) {
              var data = item.municipios;
              parroquia_combo.html("");
              data.forEach(function(municipio){
                  if (municipio.municipio == select) {
                      municipio.parroquias.forEach(function(parroquia){
                          parroquia_combo.append($('<option>', {
                              value: parroquia,
                              text : parroquia
                          }));
                      });
                  }
              });
          }
      });
  });
});


function go_top() {
	$('html, body').animate({ scrollTop: 0 }, 'fast');
}

// Disable enter for submit a form
$(document).on("keypress", '#msform', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$('#cedula').change(function(){
	var numero = $(this).val();
	var cedula = $(this).val();
	numero     = numero.length;

	if (numero > 5 && numero < 10 && (cedula.charAt(0) === 'V' || cedula.charAt(0) === 'P' || cedula.charAt(0) === 'E')) {
		$(this).removeClass("warning");
		$(".fs-warning").text("");
	} else {
		$(this).addClass("warning");
		$(".fs-warning").text("¡Debe de ingresar una cédula válida!");
	}

});

$('#rif').change(function(){
	var numero = $('#rif').val().length;
	var primero = $('#rif').val().substring(0, 1);
	if(primero!='J'&primero!='V'&primero!='E'&primero!='G'&primero!='v'){
		$('#rif').addClass("warning");
    $(".fs-warning").text("¡Debe de especificar el tipo de documento!");
	}
	else if(numero<10&&primero=='V'){
		$('#rif').addClass("warning");
    $(".fs-warning").text("El RIF no tiene la cantidad de caracteres correctos.");
	} else {
		$('#rif').removeClass("warning");
		$(".fs-warning").text("");
	}
});

$('#email').change(function(){
	var re      = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var email   = $("#email");
  var isEmail = re.test(email.val());

	if (!isEmail) {
		email.addClass("warning");
		$(".fs-warning").text("El email no es válido.");
		go_top();
	} else {
		email.removeClass("warning");
		$(".fs-warning").text("");
	}
});

// Animacion para el step form
$(".next").click(function(){
	if(animating) return false;
	animating = true;

	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	current_missing = 0;

	// Detectar cuantos campos requeridos estan vacios
	$(current_fs).find('input, select, textarea')
		.each(function() {
			if($(this).prop('required')) {
				if ($(this).val() == "" || $(this).val() == null) {
					$(this).addClass("warning");
					current_missing++;
					console.log(this);
				}
			} else {
				$(this).removeClass("warning");
			}
    });

	// Si hay campos requeridos vacios
	if (current_missing != 0) {
		console.log("Campos faltantes: " + current_missing);
		current_missing = 0;
		$(".fs-warning").text("¡Campos faltantes!");
		animating = false;
		go_top();
		return false;
	} else {
		$(".fs-warning").text("");
	}

	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

	//show the next fieldset
	next_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
			next_fs.css({'left': left, 'opacity': opacity});
		},
		duration: 800,
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".start").click(function(){
	$('.pre_postulacion').addClass("hide");
	$("#msform").removeClass("hide");
	$("#msform").addClass("animated bounceIn");
});

$("#submit").click(function(e){
	e.preventDefault();
	var fs   = $(this).parent();
	var current_missing = 0;	

	// Detectar cuantos campos requeridos estan vacios
	$(fs).find('input, select, textarea')
		.each(function() {
			if($(this).prop('required')) {
				if ($(this).val() == "" || $(this).val() == null) {
					$(this).addClass("warning");
					current_missing++;
					console.log(this);
				} else {
					$(this).removeClass("warning");	
				}
			} else {
				$(this).removeClass("warning");
			}
    });

	// Si hay campos requeridos vacios
	if (current_missing != 0) {
		console.log("Campos faltantes: " + current_missing);
		current_missing = 0;
		$(".fs-warning").text("¡Campos faltantes!");
		animating = false;
		go_top();
		return false;
	} else {
		$(".fs-warning").text("");
	}

	$(fs).loading();
	var cv_data   = $('#cv');
	var form      = document.getElementById("msform");
	var form_data = new FormData(form);

	/*
	//Verify ext of CV
	var filename = $("#cv").val();
	var parts    = filename.split('.');
	var ext      = parts[parts.length - 1];
	var ext      = ext.toLowerCase();


	// only CV PDFs
	if (ext != "pdf") {
		$(".fs-warning").text("Solo se pueden subir archivos PDF");
		e.preventDefault();
		return false;
	}*/

	$.ajax({
		url: "https://sensevzla.com/sistema/api/v1/clientes/create",		    	
    	dataType: 'json',
    	data: {
			"nombre":$("#nombre").val(),
			"cedula":$("#cedula").val(),
			"telefono":$("#telefono").val(),
			"email":$("#email").val(),
			"estado": $("#estados").val(),
			"ciudad":$("#ciudad").val(),
			"instagram":$("#instagram").val(),
			"host":$("#host").val()
		},
		type: 'post',
			success: function(response) {
				if (response.settings.message==='Cliente creado'){
					$("#msform").addClass("hide");
					$('#post_postulacion').removeClass("hide");
					$('#post_postulacion').addClass("animated bounceIn");
					$(fs).loading('stop');
				} else {
					$(".fs-warning").text("ERROR SERVIDOR");
					$(fs).loading('stop');
				}
			}
	});
	return false;
});

$(function() {
	// Todos los calendarios del formulario
	$(".datepicker").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy"
	});

	var host_combo = $("#host");
	host_combo.append($('<option>', {
		value: "",
		text : "Elije al host que conoces"
	}));

	host_combo.append($('<option>', {
		value: "Noreh",
		text : "Noreh"
	}));

	host_combo.append($('<option>', {
		value: "David Muci",
		text : "David Muci"
	}));

	host_combo.append($('<option>', {
		value: "Ernesto Isaac",
		text : "Ernesto Isaac"
	}));	

	host_combo.append($('<option>', {
		value: "No conozco a ninguno",
		text : "No conozco a ninguno"
	}));
});
