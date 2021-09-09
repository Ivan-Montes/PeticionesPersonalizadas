function fnCargarOficinas(){//Carga oficinas en su select
    $.ajax({
        url: '../controller/controller.php',
        dataType: 'json',
        type: 'post',
        data: {'act':'fnCargarOficinas'},
        success: function(r){
            $('#seOficina').append('<option value="">Escoge una opción</option>');
            $.each(r, function (index, item){
                $('#seOficina').append('<option value="' + item.departamento_id + '">' + item.nombre_departamento + '</option>');
            });
        }
    });
}
function fnCargarEstados(){//Cargar tipos de estado en su select
    $.ajax({
        url: '../controller/controller.php',
        dataType: 'json',
        type: 'post',
        data: {'act':'fnCargarEstados'},
        success: function(r){
            $('#inEstado').append('<option value="">Escoge una opción</option>');
            $.each(r, function (index, item){
                $('#inEstado').append('<option value="' + item.estado_id + '">' + item.nombre_estado + '</option>');
            });
        }
    });
}
//Una vez elegido la oficina se dispara la funcion que llena el siguiente combo, el del solicitante ###################
function fnCargarSolicitantes(){
$('#seOficina').change(function (){
    if ($('#seOficina').val() == ""){
        $('#seSolicitante').html('');$('#seSolicitante').append('<option value="">Escoge una opción</option>');
  }
    else {
        $('#seSolicitante').html('');//$('#seSolicitante').append('<option value="99">Defecto</option>');
        var vItemSeleccionado = $('#seOficina').val();
        fnConsultarSolicitantes(vItemSeleccionado);
    }
});
}
function fnConsultarSolicitantes(pItemSeleccionado){//Consulta los solicitante por dpto y rellena el input correspondiente
    $.ajax({
        url: '../controller/controller.php',
        dataType: 'json',
        type: 'post',
        data: {'act':'fnConsultarSolicitantes', 'id_seleccionado': pItemSeleccionado},
        success: function(r){
            $('#seSolicitante').append('<option value="">Escoge una opción</option>');
            $.each(r, function (index, item){
                $('#seSolicitante').append('<option value="' + item.usuario_id + '">' + item.nombre_usuario + " " + item.apellido_usuario + '</option>');
            });
        }
    });
}
function fnBusquedaAuto00(){ //Funcionn del plugin de Jquery Autocomplete (Cuadro de busqueda de libros en Form Petición)No funciona en contenido creado dinamicamente
        $("#inSearch").autocomplete({
            source: function(request, response){
                $.ajax({
                    url:'../controller/controller.php',
                    contentType: "application/json; charset=utf-8",
                    dataType:'json',
                    data:{'act':'fnBusquedaAuto', 'keyword':request.term}, // El objeto request tiene los caracteres a buscar.
                    success: function(data){ //Opción de cache o coger de un Json en la documentación del plugin.
                        response(data);
                    }
        });
    },      //Número de caracteres mínimo para que la busqueda empiece
            minLength:5,
            select:function (event, ui){ //Conf que pasa tras seleccionar un elemento.
                $('#inSearch').attr("data-info", ui.item.value);
                $('#inSearchCodBook').val(ui.item.value); //Formulario Consulta: paso el value a un hidden, me sirve para la consulta por libro
                this.value = (ui.item.label + " " + ui.item.curso + " " + ui.item.formato + " " + ui.item.idioma + " (" + ui.item.value + ")");
                return false;
            },
            focus: function(event, ui){ //Conf que pasa tras hover sobre un elemento
                $('#inSearch').val(ui.item.label + " " + ui.item.curso + " " + ui.item.formato + " " + ui.item.idioma + " (" + ui.item.value + ")");
            },
        })
        .autocomplete("instance")._renderItem = function(ul, item){ //Conf lista del menú emergente
            return $("<li>")
            .append("<div>" + item.label + " " + item.curso + " " + item.formato + " " + item.idioma + " (" + item.value + ")</div>")
            .appendTo(ul);
        };
}
function fnBusquedaAuto(){ //Funcionn del plugin de Jquery Autocomplete (Cuadro de busqueda de libros en Form Petición)
    // $("#inSearch").autocomplete({
        $("body").on("click", "#inSearch", function(){
             $(this).autocomplete({
                source: function(request, response){
            $.ajax({
                url:'../controller/controller.php',
                contentType: "application/json; charset=utf-8",
                dataType:'json',
                data:{'act':'fnBusquedaAuto', 'keyword':request.term}, // El objeto request tiene los caracteres a buscar.
                success: function(data){ //Opción de cache o coger de un Json en la documentación del plugin.
                    response(data);
                }
    });
},      //Número de caracteres mínimo para que la busqueda empiece
        minLength:5,
        select: function (event, ui){ //Conf que pasa tras seleccionar un elemento.
            this.value = (ui.item.label + " " + ui.item.curso + " " + ui.item.formato + " " + ui.item.idioma + " (" + ui.item.value + ")");
            $('#inSearch').attr("data-info", ui.item.value);
            $('#inSearchCodBook').val(ui.item.value); //Formulario Consulta: paso el value a un hidden, me sirve para la consulta por libro
            $(this).attr("data-info2", ui.item.value); //Problema en Fgestion al intentar crear por el id del elemento html asi que lo duplico con otro atributo. Causado por ser contenido dinamico
            $(this).next().attr("data-info2", ui.item.value);
            $(this).next().val(ui.item.value); //Valor para el hidden
            return false;
        },
        focus: function(event, ui){ //Conf que pasa tras hover sobre un elemento
            $('#inSearch').val(ui.item.label + " " + ui.item.curso + " " + ui.item.formato + " " + ui.item.idioma + " (" + ui.item.value + ")");
        },
    })
    .autocomplete("instance")._renderItem = function(ul, item){ //Conf lista del menú emergente
        return $("<li>")
        .append("<div>" + item.label + " " + item.curso + " " + item.formato + " " + item.idioma + " (" + item.value + ")</div>")
        .appendTo(ul);
    };
})};
function fnAddToBookList(){ //La busqueda seleccionada la añado a la lista de libros.
    $("#btAddBook").click(function(e){
        var i = 0;
        var vSearchSelected = $('#inSearch').val();
        var vSearchSelectedDataInfo = $('#inSearch').attr("data-info");
        var vEmptyInputList = $('#taSearch :input');
        //Busco el primer input vacio y le cambio el valor
        $(vEmptyInputList).each(function (e){
            if((this.value == "") && (i < 1)) {
                this.value = vSearchSelected;
                $(this).attr("data-info", vSearchSelectedDataInfo);
                $(this).next().val(vSearchSelectedDataInfo);
                i++;
            }
        });
        $('#inSearch').val("");
        $('#inSearch').attr("data-info", "");$('#inSearch').attr("data-info2", "");
    });
}
function fnEventVaciarLineaDeTablaPeticion(){ //El boton de "borrar" de cada linea vaciará esa fila.
$("body").on("click", '.bt__reset--line', function(){

        var vParentClicked = $(this).closest('tr');
        var vInputsSelected = $(vParentClicked).find('input');
        $(vInputsSelected).each(function(e){
            if ($(this).is('input:text')){
                $(this).val(null);
                $(this).attr("data-info", "");
                $(this).next().val(null); //Vaciar hiddens
            }
            else{
                $(this).prop("checked",false);
            }
         });
    });
}
function fnEventVaciarLineaDeTablaPeticion00(){ //El boton de "borrar" de cada linea vaciará esa fila.
$('.bt__reset--line').click(function(e){
    var vParentClicked = $(this).closest('tr');
    var vInputsSelected = $(vParentClicked).find('input');
    $(vInputsSelected).each(function(e){
        if ($(this).is('input:text')){
            $(this).val(null);
            $(this).attr("data-info", "");
            $(this).next().val(null); //Vaciar hiddens
        }
        else{
            $(this).prop("checked",false);
        }
     });
});
}
function fnEventBorradoAttrDataInfo(){//Para que la info en los atributos con el  id del libro desaparezcan del html si no se recarga la página.
    $('#inVaciara').click(function(e){
        var vTextInput = $('#taSearch :input:text');
        $(vTextInput).each(function(e){
            $(this).attr("data-info", "");
            $(this).next().val(null); //Vaciar hiddens
        });
    });
}
function fnVaciarFormSolicitudOnClick(){
    $('#inVaciar').click(function(e){
    var vModalConfirmacion='<div id="diMessageConfirm" title="Confirme el borrado"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>La información de los campos será borrada, ¿Quiere continuar?</p></div>';
    $('body').append(vModalConfirmacion);
    $("#diMessageConfirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
              "OK": function() {
                fnVaciarFormSolicitud()
                $( this ).dialog( "close" );
                $("#diMessageConfirm").remove();
              },
              Cancel: function() {
                $( this ).dialog( "close" );
                $("#diMessageConfirm").remove();
              }
            }
          });
    });
}
function fnVaciarFormSolicitud(){
    var vInputsList = $('input');
    var vSelectsList =$('select');
        $(vInputsList).each(function(e){ //Vacio tabla
            if ($(this).is('input:text')){
                $(this).val(null);
                $(this).attr("data-info", "");
                $(this).next().val(null); //Vaciar hiddens
            }
            else if ($(this).is('input:checkbox')){
                $(this).prop("checked",false);
            }
            else if ($(this).is('.in__date')){
                $(this).val(null);
            }
        });
        $(vSelectsList).each(function(e){
                $(this).val("");
                $('#seSolicitante').html('');
        });
        fnAddDiaFecha();
}
function fnEnviarFormSolicitud(){ //Envia la petición
        if ((fnValidarRequiredAndLibros()) === true){    //Checkeo las validaciones
             $.ajax({
                 type:'post',
                 url:'../controller/controller.php',
                 data:$("#fPeticion").serialize(),
                 beforeSend:function(){
                 },
                 error:function(e){
                     fnErrorMessage();
                     fnVaciarFormSolicitud();
                 },
                 success:function(data){
                    if (data == 1){//Valido si la petición devuelve success(1) o fail(0)
                        fnVaciarFormSolicitud();
                        fnSuccessMessage();
                    }
                    else {
                        fnErrorMessage();
                        fnVaciarFormSolicitud();
                    }
                 }});
        }else{
            fnErrorRequiredFields();
            //fnVaciarFormSolicitud();
        }
}
function fnAskEnviarFormSolicitud(){//Muestro un cuadro para confirmar envio de petición.
    $('#inSubmitFormSolicitud').click(function(e){
    var vModalConfirmacion='<div id="diMessageConfirm" title="Confirme el envio"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>La peticíon será enviada, ¿Quiere continuar?</p></div>';
    $('body').append(vModalConfirmacion);
    $("#diMessageConfirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
              "OK": function() {
                fnEnviarFormSolicitud()
                $( this ).dialog( "close" );
                $("#diMessageConfirm").remove();
              },
              Cancel: function() {
                $( this ).dialog( "close" );
                $("#diMessageConfirm").remove();
              }
            }
          });
    });
}
function fnSuccessMessage(){//MessageBox de exito
var vDiMessageOk ='<div id="diMessageOk" title="Estado de petición" style="display:none;"><p>La petición ha sido procesada correctamente.</p></div>';
$('body').append(vDiMessageOk);
    $( function() {
        $( "#diMessageOk" ).dialog({
          modal: true,
          buttons: {
            Ok: function() {
              $( this ).dialog( "close" );
              $("#diMessageOk").remove();
            }
          }
        });
      });
}
function fnErrorMessage(){//MessageBox de error

    var vDiMessageError ='<div id="diMessageError" title="Estado de Consulta" style="display:none;"><p> Error en la operación. Solicitud/Cambio no realizado</p></div>';
    $('body').append(vDiMessageError);
        $( function() {
            $( "#diMessageError" ).dialog({
              modal: true,
              buttons: {
                Ok: function() {
                  $( this ).dialog( "close" );
                  $("#diMessageError").remove();
                }
              }
            });
          });
    }
function fnErrorRequiredFields(){
    //console.log("No hay libro seleccionados en la tabla o falta un required");
    $( function() {
        $( "#dialog-message" ).dialog({
            modal: true,
            buttons: {
            Ok: function() {
                $( this ).dialog( "close" );
            }
            }
        });
        } );
}
function fnAddDiaFecha() {//Añadir la fecha actual al input fecha
    'use strict';
    var vDate = new Date(), vYear = vDate.getFullYear(), vMes = vDate.getMonth() + 1, vDia = vDate.getDate();
    $("#inFechaSolicitud").val(vDia +"/" + vMes + "/" + vYear);
}
function fnValidarSelectsRequired(){//Vemos si los select[required] estan vacios o con valores no validos.
    i=0;
    $('select[data-required]').each(function(e){
        if (($(this).val() == "") || ($(this).val() == 99) || ($(this).val() == null)){
            i++;
        }
    });
    if (i > 0) {
        return 0;//0
    }
    else {
        return 1;
    }
}
function fnValidarInputsRequired(){//Comprobamos si los input[required] estan vacios.
    i=0;
    $('input[data-required]').each(function(e){
        if ($(this).val() == ""){
            i++;
        }
    });
    if (i > 0) {
        return 0;//0
    }
    else {
        return 1;
    }
}
function fnHayAlgunLibro(){//Comprobamos si la menos hay un libro añadido a la lista.
    i=0;
    $('#taSearch input:text').each(function(e){
    var vThisInput = $(this).val();
    var vThisInputNoSpaces = vThisInput.replace(/ /g, '');//Eliminamos espacios.
        if(vThisInputNoSpaces !== ""){
            i++;
        }
    });
    if (i > 0) {
        return 1;
    }
    else {
        return 0;
    }
}
function fnValidarRequiredAndLibros(){//Comprobamos todas las validaciones.
    vSentry=0;
    vSentry =(fnHayAlgunLibro() + fnValidarSelectsRequired() + fnValidarInputsRequired());
    console.log("fnValidartotal el Valor de vSentry es " + vSentry)
        if (vSentry === 3){
            return true;
        }else{
            return false;
        }
}
function fnInputSoloNumero() {//Borra los datos, en tiempo real, que no sean números
    $('.val__num').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });
}
function fnEnviarFormConsulta(){
    $('#inSubmitFormConsulta').click(function(e){

             $.ajax({
                 type:'post',
                 url:'../controller/controller.php',
                 data:$("#fConsultar").serialize(),
                 dataType: 'json',
                 type: 'post',
                 beforeSend:function(){
                    fnBorrarTablaFormConsulta();
                 },
                 error:function(e){
                    fnErrorMessage();
                 },
                 success:function(data){
                    var $vI=0;
                    $.each(data, function (index, item){
                        $vI++
                        $('#taQuery').append('<tr><td class="w3-blue">' + $vI + '</td><td>' + item.fk_peticion_id + '</td><td>' + item.spain + '</td><td>' + item.fecha_solicitud + '</td><td>' + item.solicitante_nombre + " " + item.solicitante_apellido + '</td><td>' + item.nombre_estado +'</td><td><div class="w3-button w3-black w3-padding-small w3-hover-orange bt__info--line" data-info="' + item.fk_peticion_id + '">Info</div></td></tr>');

                    });
                 }
            });
    });
}
function fnBorrarTablaFormConsultaOnBorrar(){
    $('#inVaciarTablaQuery').click(function(e){
        fnBorrarTablaFormConsulta();
    });
}
function fnBorrarTablaFormConsulta(){
        $('#taQuery tr:not(:first-child)').remove();
        fnVaciarFormSolicitud(); // Aprovechamos la funcion del fPeticion para vaciar campos
}
function fnCreateModalDetalles(p01){//Crea el modal de los detalles de una petición pero sin mostrarlo

    vModal='<div id="id01" class="w3-modal"><div class="w3-modal-content w3-card-4"><header class="w3-container w3-blue"><span id="spClose" class="w3-button w3-display-topright">&times;</span><h2>Detalles de Petición</h2></header><div class="w3-container"><label class="w3-col l4"><p>SPAIN</p><input type="text" id="inSpainDetalles" readonly></label><label class="w3-col l4"><p>Nombre Colegio</p><input type="text" id="inNombreColegioDetalles" readonly></label><label class="w3-col l4"><p>Peticionario</p><input type="text" id="inPeticionarioDetalles" readonly></label><label class="w3-col l4"><p>Fecha Solicitud</p><input type="text" id="inFechaSolicitudDetalles" readonly></label><label class="w3-col l4"><p>Sistema</p><input type="text" id="inSistemaDetalles" readonly></label><label class="w3-col l4"><p>Internet</p><input type="text" id="inInternetDetalles" readonly></label><label class="w3-col l4"><p>Fecha Entrega</p><input type="text" id="inFechaEntregaDetalles" readonly></label><label class="w3-col l4"><p>Entregado a:</p><input type="text" id="inEntregadoADetalles" readonly></label><label class="w3-col l4"><p>Estado</p><input type="text" id="inEstadoDetalles" readonly></label><label class="w3-col l12"><p>Observaciones</p><textarea id="inObservacionesDetalles" readonly></textarea></label><label class="w3-col l12"><p>Histórico Estados</p><div class="w3-button w3-black w3-padding-smal w3-hover-orange" id="btHistoricoPeticion">Ver</div></label></div><footer class="w3-container w3-blue"><div id="btCerrarDetalles" class="w3-button w3-white w3-border w3-border-blue w3-margin w3-hover-border-orange">Cerrar</div></footer></div></div>';

    if (p01 == 1){//Segun el parametro que reciba puedo cambiar la plantilla del cuadro modal, el 1 es para el FormGestión

        vModal='<div id="id01" class="w3-modal"><div class="w3-modal-content w3-card-4"><header class="w3-container w3-blue-grey"><span id="spClose" class="w3-button w3-display-topright">&times;</span><h2>Detalles de Petición <span id="pPeticionIdDetalles"></span></h2></header><div class="w3-container"><label class="w3-col l4"><p>SPAIN</p><input type="text" id="inSpainDetalles" readonly></label><label class="w3-col l4"><p>Nombre Colegio</p><input type="text" id="inNombreColegioDetalles" readonly></label><label class="w3-col l4"><p>Peticionario</p><input type="text" id="inPeticionarioDetalles" readonly></label><label class="w3-col l3"><p>Oficina</p><input type="text" id="inOficina" readonly></label><label class="w3-col l3"><p>Fecha Solicitud</p><input type="text" id="inFechaSolicitudDetalles" readonly></label><label class="w3-col l3"><p>Sistema</p><input type="text" id="inSistemaDetalles" readonly></label><label class="w3-col l3"><p>Internet</p><input type="text" id="inInternetDetalles" readonly></label><label class="w3-col l4"><p>Unidades</p><input type="text" id="inUnidadesDetalles" readonly></label><label class="w3-col l4"><p>Fecha Entrega</p><input type="text" id="inFechaEntregaDetalles" readonly></label><label class="w3-col l4"><p>Entregado a:</p><input type="text" id="inEntregadoADetalles" readonly></label><label class="w3-col l4 w3-hide"><p>Peticion ID</p><input type="text" id="inPeticionIdDetalles" readonly></label><label class="w3-col l12"><p>Observaciones</p><textarea id="inObservacionesDetalles"></textarea></label><label class="w3-col l3"><p>Guardar Observaciones</p><div class="w3-button w3-black w3-padding-smal w3-hover-orange" id="btGuardarObs">Guardar</div></label><label class="w3-col l3"><p>Editar Libros</p><div class="w3-button w3-black w3-padding-smal w3-hover-orange" id="btEditarLibros">Añadir</div></label><label class="w3-col l3"><p>Histórico Estados</p><div class="w3-button w3-black w3-padding-smal w3-hover-orange" id="btHistoricoPeticion">Ver</div></label><label class="w3-col l3"><p>Mandar Mail</p><div class="w3-button w3-black w3-padding-smal w3-hover-orange" id="btMandarMail">Mail</div></label></div><footer class="w3-container w3-blue-grey"><div id="btCerrarDetalles" class="w3-button w3-white w3-border w3-border-blue-grey w3-hover-border-orange w3-margin">Cerrar</div><div id="btImprimir" class="w3-button w3-white w3-border w3-border-blue-grey w3-hover-border-orange w3-margin imprimir">Imprimir</div></footer></div></div>';

    }

    $('#taQuery').append(vModal);
    $("#taQuery").one("click", "#spClose",function() {$('#id01').fadeOut(300);setTimeout(() => {$('#id01').remove();},400)});
    $("#taQuery").one("click", "#btCerrarDetalles",function() {$('#id01').fadeOut(300);setTimeout(() => {$('#id01').remove();},400)});

    if (p01 == 1){

        fnGuardarDatosObservacionesFormGestion(),fnMostrarCuadroAddBookFormGestion();
    }
}

function fnHistoricoEstados(){
    $('#id01').on('click', '#btHistoricoPeticion', function(){
        //alert("Alert de detalles");
        $('#diHistEst').toggle();
    });
}

function fnCreateModalHistoricoEstados(){
    vTablaHistoricoEstados='<div id="diHistEst" class=""><div class=" w3-card-4"><table class="w3-table-all w3-hoverable w3-centered w3-card-2 w3-col l12 w3-margin-top w3-margin-bottom" id="taHistEst"><tr class="w3-indigo"><th>Nº</th><th>Petición</th><th>Estado</th><th>Asignado</th><th>Fecha</th></table></div></div>'
    $('#id01 .w3-modal-content').append(vTablaHistoricoEstados);
    fnHistoricoEstados();
}

function fnCrearEnModalDetallesListaLibros(p01){
    vTablaDetallesLibro='<table class="w3-table-all w3-hoverable w3-centered w3-card-2 w3-col l12 w3-margin-top w3-margin-bottom" id="taQueryDetalles1"><tr class="w3-light-blue"><th>Nº</th><th>Libro</th><th>Audios</th><th>Test Factory</th></table>'
    if (p01 == 1){//Segun el parametro que reciba puedo cambiar la plantilla del cuadro modal
        vTablaDetallesLibro='<table class="w3-table-all w3-hoverable w3-centered w3-card-2 w3-col l12 w3-margin-top w3-margin-bottom ta__libros--fgestion" id="taQueryDetalles2"><tr class="w3-orange"><th>Nº</th><th>Libro</th><th>Audios</th><th>Test Factory</th><th>Eliminar</th></table>'
    }
    $('#id01 div.w3-container').append(vTablaDetallesLibro);
}

function fnMostrarCuadroDetallesConsulta(){// 3 peticiones ajax para cargar el Cuatro de detalles de una petición en form Consulta
    $("#taQuery").on("click", ".bt__info--line",function() {
        vIdPeticion=$(this).attr("data-info");
        $vIdPeticionSave= $(this).closest('tr').find('.bt__save--line').attr("data-info");//Busco si existe el boton de salvar
        if (vIdPeticion == $vIdPeticionSave){//Si existe este valor significa que estoy en el Form Gestión, asi que puedo alterar el funcionamiento de otras fn
            var vP01 = 1;
        }
$.when(
    $.ajax({
        type: 'post',
        url: '../controller/controller.php',
        data: {'act':'fnMostrarCuadroDetallesConsulta', 'pFiltro': vIdPeticion},
        dataType: 'json',
        success: function(d1){
            vResultados01 = d1;
        }
    }),
    $.ajax({
        type: 'post',
        url: '../controller/controller.php',
        data: {'act':'fnMostrarCuadroDetallesConsultaLibros', 'pFiltro': vIdPeticion},
        dataType: 'json',
        success: function(d2){
            vResultados02 = d2;
        }
    }),
    $.ajax({
        type: 'post',
        url: '../controller/controller.php',
        data: {'act':'fnMostrarCuadroDetallesConsultaEstado', 'pFiltro': vIdPeticion},
        dataType: 'json',
        success: function(d3){
            vResultados03 = d3;
        }
    }),
    $.ajax({
        type: 'post',
        url: '../controller/controller.php',
        data: {'act':'fnMostrarCuadroDetallesConsultaHistorico', 'pFiltro': vIdPeticion},
        dataType: 'json',
        success: function(d4){
            vResultados04 = d4;
        }
    }),$.ajax({
        type: 'post',
        url: '../controller/controller.php',
        data: {'act':'fnFormGestionDetallesSacarFechaEntrega', 'pFiltro': vIdPeticion},
        dataType: 'json',
        success: function(d5){
            vResultados05 = d5;
        }
    }),fnCreateModalDetalles(vP01),fnCreateModalHistoricoEstados(),fnCrearEnModalDetallesListaLibros(vP01),

).done(function(){ //Voy pintando los resultados de las consultas Ajax en el cuadro modal

      $.each(vResultados01, function (index, item){
        $('#inSpainDetalles').val(item.spain);
        $('#inPeticionarioDetalles').val(item.nombre_usuario + " " + item.apellido_usuario);
        $('#inFechaSolicitudDetalles').val(item.fecha_solicitud);
        $('#inNombreColegioDetalles').val(item.nombre_centro);
        $('#inObservacionesDetalles').val(item.observaciones_peticion);
        $('#inSistemaDetalles').val(item.sistema);
        $('#inInternetDetalles').val(item.internet);
        $('#inPeticionIdDetalles').val(item.peticion_id);
        $('#inUnidadesDetalles').val(item.unidades);
        $('#inEntregadoADetalles').val(item.entregado_a_n);
        $('#inOficina').val(item.nombre_departamento);
        $('#pPeticionIdDetalles').html(item.peticion_id);
    });

    $.each(vResultados02, function (index, item){
        index++;
        $vNombreCompuesto = item.nombre + " " + item.curso + " " + item.formato + " " + item.idioma + " [" + item.libro_id + "]";
        $('#taQueryDetalles1').append('<tr><td>' + index + '</td><td>' + $vNombreCompuesto + '</td><td>' + item.audios + '</td><td>' + item.test_factory + '</td></tr>');
        $('#taQueryDetalles2').append('<tr><td>' + index + '</td><td>' + $vNombreCompuesto + '</td><td>' + item.audios + '</td><td>' + item.test_factory + '</td><td><input id="inCodBookInDetalles' + index +'" class="w3-hide" value="' + item.libro_id +'"><div id="btBookRemover" class="w3-button w3-black w3-padding-small w3-hover-orange bt__remove--book">Borrar</div></td></tr>');
    });

    $.each(vResultados03, function (index, item){
        index++;
        $('#inEstadoDetalles').val(item.nombre_estado);
    });

    $.each(vResultados04, function (index, item){
        index++;
       $('#taHistEst').append('<tr><td>' + index + '</td><td>' + item.fk_peticion_id + '</td><td>' + item.nombre_estado + '</td><td>' + item.nombre_apellido_usuario + '</td><td>' + item.fecha_cambio + '</td></tr>');
    });

    $.each(vResultados05, function (index, item){
        index++;
        $('#inFechaEntregaDetalles').val(item.fecha_cambio);
    });

    $('#id01').fadeIn(150); // Muestra modal de los detalles de la petición
})

    });
}
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
    }
}
function fnExportTableConsultaToExcel(){
    $("#diExportToExcelConsultas").click(function(){
        $("#taQuery").table2excel({
            exclude: ".noExl",
            name: "TablaConsult",
            filename: "Consult.xls", // do include extension
            preserveColors: false // set to true if you want background colors and font colors preserved
        });
    });
}
function fnConsultarPeticionFormGestion(){
        $('#inSubmitFormGestion').click(function(e){

                 $.ajax({
                     type:'post',
                     url:'../controller/controller.php',
                     data:$("#fGestion").serialize(),
                     dataType: 'json',
                     type: 'post',
                     beforeSend:function(){
                        fnBorrarTablaFormConsulta();
                     },
                     error:function(e){
                        fnErrorMessage();
                     },
                     success:function(data){
                        var vI=0;
                        $.each(data, function (index, item){
                            vI++
                            $('#taQuery').append('<tr><td class="w3-blue-grey">' + item.fk_peticion_id + '</td><td>' + item.spain + '</td><td>' + item.fecha_solicitud + '</td><td>' + item.solicitante_nombre + " " + item.solicitante_apellido + '</td><td><select class="se__names--it"><option selected value="' + item.fk_usuario_id + '">' + item.nombre_usuario_asignado + " " + item.apellido_usuario_asignado + '</option></selected></td><td><select class="se__names--estados"><option selected value="' + item.fk_estado_id + '">' + item.nombre_estado +'</option></select></td><td><select class="se__names--entregadoa"><option selected value="' + item.entregado_a + '">' + item.nombre_entregado_a +'</option></select></td><td><div class="w3-button w3-padding-small w3-hover-orange w3-black bt__info--line" data-info="' + item.fk_peticion_id + '">Info</div></td><td><div class="w3-button w3-blue-grey w3-padding-small w3-hover-orange bt__save--line" data-info="' + item.fk_peticion_id + '">Salvar</div></td></tr>');
                        });
                        fnMostrarUsuariosDptoIT();fnMostrarEstadosTablaGestion(),fnMostrarPersonasEntregarPen();
                     }
                });
        });
    }
function fnMostrarUsuariosDptoIT(){//Carga auto en la tabla de resultados del Form Gestión los usuario de IT
        var vTarget=$(".se__names--it");
        var vItemSeleccionado=4;
        $.ajax({
            type: 'post',
            url: '../controller/controller.php',
            dataType: 'json',
            data: {'act':'fnConsultarSolicitantes', 'id_seleccionado': vItemSeleccionado},
            success: function(r){
                $(vTarget).each(function(e){
                    vThis=$(this);
                    $.each(r, function (index, item){
                        $(vThis).append('<option value="' + item.usuario_id + '">' + item.nombre_usuario + " " + item.apellido_usuario + '</option>');
                    });
                });
            }
        });
}
function fnMostrarEstadosTablaGestion(){//Carga auto en la tabla de resultados del Form Gestión los estados dispo de una peticion.
    var vTarget=$(".se__names--estados");
    $.ajax({
        type: 'post',
        url: '../controller/controller.php',
        dataType: 'json',
        data: {'act':'fnCargarEstados'},
        success: function(r){
            $(vTarget).each(function(e){
                vThis=$(this);
                $.each(r, function (index, item){
                    $(vThis).append('<option value="' + item.estado_id + '">' + item.nombre_estado + '</option>');
                });
            });
        }
    });
}
function fnMostrarPersonasEntregarPen(){//Carga auto en la tabla de resultados del Form Gestión las personas a las que se entregará
    var vTarget=$(".se__names--entregadoa");
    $.ajax({
        type: 'post',
        url: '../controller/controller.php',
        dataType: 'json',
        data: {'act':'fnCargarPersonasEntregarPen'},
        success: function(r){
            $(vTarget).each(function(e){
                vThis=$(this);
                $.each(r, function (index, item){
                    $(vThis).append('<option value="' + item.usuario_id+ '">' + item.nombre_usuario + " " + item.apellido_usuario +'</option>');
                });
            });
        }
    });
}
function fnSalvarDatosLineaPeticionFormGestion(){ // En el form gestion el boton salvar sirve para guardar los cambios de la linea donde se pulse
    $("#taQuery").on("click", ".bt__save--line",function() {
        var vParentClicked = $(this).closest('tr');
        var vUsuarioAsignado = $(vParentClicked).find('.se__names--it').val();
        var vEstadoPeticion = $(vParentClicked).find('.se__names--estados').val();
        var vEntregadoA = $(vParentClicked).find('.se__names--entregadoa').val();
        var vPeticionId = $(vParentClicked).find('.bt__info--line').attr("data-info");

        $.ajax({
            type:'post',
            url:'../controller/controller.php',
            dataType: 'json',
            data: {'act':'fnUpdatePeticionAsigAndEstado', 'pUsuarioAsignado': vUsuarioAsignado, 'pEstadoPeticion': vEstadoPeticion, 'pPeticionId': vPeticionId, 'pEntregadoA': vEntregadoA},
            beforeSend:function(){
            },
            error:function(e){
                fnErrorMessage();
            },
            success:function(data){
                vCheck = data.resultado;
                    if (vCheck == 1){//Valido si la petición devuelve success(1) o fail(0)
                        fnSuccessMessage();
                   }
                   else {
                       fnErrorMessage();
                   }

            }});
    });
}

function fnAskIfSalvarDatosLineaPeticionFormGestion(){ // En el form gestion el boton salvar sirve para guardar los cambios de la linea donde se pulse

    $("#taQuery").on("click", ".bt__save--line",function() {

        var vParentClicked = $(this).closest('tr');
        var vUsuarioAsignado = $(vParentClicked).find('.se__names--it option:selected').text();
        var vEstadoPeticion = $(vParentClicked).find('.se__names--estados option:selected').text();
        var vEntregadoA = $(vParentClicked).find('.se__names--entregadoa option:selected').text();
        var vPeticionId = $(vParentClicked).find('.bt__info--line').attr("data-info");


        $.ajax({
            type:'post',
            url:'../controller/controller.php',
            dataType: 'json',
            data: {'act':'fnDetallesConsultaPorId', 'pPeticionId': vPeticionId},
            beforeSend:function(){
            },
            error:function(e){
                fnErrorMessage();
            },
            success:function(data){
                var vModalConfirmacion
                var vModalInfo;
                $.each(data, function (index, item){

                    vModalInfo = '<div><table><tr><th></th><th>Info actual en BD</th><th>Info a Grabar</th></tr><tr><td>Asignado a</td><td>' + item.nombre_usuario_asignado + ' ' + item.apellido_usuario_asignado + '</td><td>' + vUsuarioAsignado + '</td></tr><tr><td>Estado</td><td>' + item.nombre_estado + '</td><td>' + vEstadoPeticion + '</td></tr><tr><td>Entregado a</td><td>' + item.nombre_entregado_a + '</td><td>' + vEntregadoA + '</td></tr></table></div>'
                    vModalConfirmacion='<div id="diMessageConfirm" title="Confirme la acción"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>La información de los campos será actualizada, ¿Quiere continuar?</p>' + vModalInfo + '</div>';

                });

                $('body').append(vModalConfirmacion);

                $("#diMessageConfirm").dialog({
                    resizable: false,
                    height: "auto",
                    width: 500,
                    modal: true,
                    buttons: {
                      "OK": function() {
                        $( this ).dialog( "close" );
                        $("#diMessageConfirm").remove();
                        fnOkToSalvarDatosLineaPeticionFormGestion(vParentClicked);
                      },
                      Cancel: function() {
                        $( this ).dialog( "close" );
                        $("#diMessageConfirm").remove();
                      }
                    }
                  })


            }});



    });
}

function fnOkToSalvarDatosLineaPeticionFormGestion(pParentClicked){ // En el form gestion el boton salvar sirve para guardar los cambios de la linea donde se pulse

        var vParentClicked = pParentClicked;
        var vUsuarioAsignado = $(vParentClicked).find('.se__names--it').val();
        var vEstadoPeticion = $(vParentClicked).find('.se__names--estados').val();
        var vEntregadoA = $(vParentClicked).find('.se__names--entregadoa').val();
        var vPeticionId = $(vParentClicked).find('.bt__info--line').attr("data-info");

        $.ajax({
            type:'post',
            url:'../controller/controller.php',
            dataType: 'json',
            data: {'act':'fnUpdatePeticionAsigAndEstado', 'pUsuarioAsignado': vUsuarioAsignado, 'pEstadoPeticion': vEstadoPeticion, 'pPeticionId': vPeticionId, 'pEntregadoA': vEntregadoA},
            beforeSend:function(){
            },
            error:function(e){
                fnErrorMessage();
            },
            success:function(data){
                vCheck = data.resultado;
                    if (vCheck == 1){//Valido si la petición devuelve success(1) o fail(0)
                        fnSuccessMessage();
                   }
                   else {
                       fnErrorMessage();
                   }

            }});

}

function fnGuardarDatosObservacionesFormGestion(){ // Guardar las observaciones del form gestión dentro de la ventana de detalles.
    $("#id01").on("click", "#btGuardarObs", function(){
        var vObservacionesText=$('#inObservacionesDetalles').val();
        var vPeticionId=$('#inPeticionIdDetalles').val();
        $.ajax({
            type:'post',
            url:'../controller/controller.php',
            dataType: 'json',
            data: {'act':'fnUpdateObservaciones', 'pObservacionesText': vObservacionesText, 'pPeticionId': vPeticionId},
            beforeSend:function(){
            },
            error:function(e){
                fnErrorMessage();
            },
            success:function(data){
                vCheck = data.resultado;
                    if (vCheck == 1){//Valido si la petición devuelve success(1) o fail(0)
                        fnSuccessMessage();
                   }
                   else {
                       fnErrorMessage();
                   }
            }});
    });
}

function fnMostrarCuadroAddBookFormGestion(){
    $("#id01").on("click", "#btEditarLibros", function(){
        var vCuadroAddBook='<div id="diForAddBook" class="w3-col l12 w3-section"><div class="w3-center"><div class="ui-widget"><input class="w3-input w3-border w3-padding" type="text" id="inSearch" placeholder="Escribe AQUI al menos 5 caracteres para la busqueda automática por NOMBRE, selecciona y pincha en añadir."><input type="hidden" id="inSearchCodBook" name="inSearchCodBook"></div><div id="btAddBookToEditedList" class="w3-button w3-white w3-border w3-border-orange w3-margin"><b>Añadir</b></div></div><table class="w3-table-all w3-hoverable w3-centered w3-card-2" id="taSearch"><tr class="w3-deep-orange"><th>Libro</th><th>Test</th><th>Audios</th><th>Borrar</th></tr><tr><td><input class="w3-input w3-border w3-padding" type="text" id="inSearch1" readonly><input type="hidden" id="inSearchCodBook1" name="inSearchCodBook1" value=""></td><td><input id="inTest01" class="w3-check" type="checkbox" name="inTest01"></td>                            <td><input id="inAudio01" class="w3-check" type="checkbox" name="inAudio01"></td><td><div id="btLineRemove01" class="w3-button w3-black w3-padding-small w3-hover-orange bt__reset--line">Borrar</div></td>                        </tr>                                            </table>                </div>                <div class="w3-col l12">                    <div class="w3-center"><div id="inSaveAddBook" class="w3-button w3-white w3-border w3-border-orange w3-margin-left w3-margin-right"><b>Guardar</b></div></div></div>';
        $('#id01 .w3-modal-content').append(vCuadroAddBook);
        fnAddToBookToEditedList();
        fnEventSaveNewBookAdded();
    });
}

function fnAddToBookToEditedList(){ // Añado un libro nuevo a la petición sin guardarlo todavía.
    $(document).on("click","#btAddBookToEditedList", function(){
        var i = 0;
        var vSearchSelected = $('#inSearch').val();
        var vSearchSelectedCod = $('#inSearchCodBook').val();

             //Opcion filter podría funcionar par contenido dinamico
        // var vSearchSelectedDataInfoDataFilter = $('#inSearch').filter(function(){return $(this).attr('data-info2')});

        var vEmptyInputList = $('#taSearch :input');


        //Busco el primer input vacio y le cambio el valor
        $(vEmptyInputList).each(function (e){
            if((this.value == "") && (i < 1)) {
                this.value = vSearchSelected;
                $('#inSearchCodBook1').val(vSearchSelectedCod);
                i++;
            }
        });

    });
}
function fnEventSaveNewBookAdded(){ // Salvamos el libro que queriamos añadir a la petición.
    $("body").on("click", "#inSaveAddBook",function(){
        var vSearchSelectedCod=$('#inSearchCodBook1').val();
        var vInTest01=$('#inTest01').prop("checked");
        var vInAudio01=$('#inAudio01').prop("checked");
        var vPeticionId=$('#inPeticionIdDetalles').val();
        $.ajax({
            type:'post',
            url:'../controller/controller.php',
            dataType: 'json',
            data: {'act':'fnEventSaveNewBookAdded', 'pSearchSelectedCod': vSearchSelectedCod, 'pInTest01': vInTest01, 'pPeticionId': vPeticionId, 'pInAudio01': vInAudio01},
            beforeSend:function(){
            },
            error:function(e){
                fnErrorMessage();
            },
            success:function(data){
                vCheck = data.resultado;
                    if (vCheck == 1){//Valido si la petición devuelve success(1) o fail(0)
                        fnSuccessMessage();
                }
                else {
                    fnErrorMessage();
                }
                $(function() {$('#id01').fadeOut(400);setTimeout(() => {$('#id01').remove();},500)});//Borramos el cuadro entero de detalles petición
            }});
    });
}
function fnAskEliminarLibroDePeticion(){
    $("body").on("click", ".bt__remove--book", function(e){
        var vModalConfirmacion='<div id="diMessageConfirm" title="Confirme el envio"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>La peticíon será enviada, ¿Quiere continuar?</p></div>';
        var vParentClicked = $(this).closest('tr');
        $('body').append(vModalConfirmacion);
        $("#diMessageConfirm").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                  "OK": function() {
                    fnEliminarLibroDePeticion(vParentClicked)
                    $( this ).dialog( "close" );
                    $("#diMessageConfirm").remove();
                  },
                  Cancel: function() {
                    $( this ).dialog( "close" );
                    $("#diMessageConfirm").remove();
                  }
                }
              });
        });
}
function fnEliminarLibroDePeticion(pParentClicked){
    var vPeticionId=$('#inPeticionIdDetalles').val();
    var vCodLibro=$(pParentClicked).find('input[class="w3-hide"').val();

    $.ajax({
        type:'post',
        url:'../controller/controller.php',
        dataType: 'json',
        data: {'act':'fnEliminarLibroDePeticion', 'pPeticionId': vPeticionId, 'pCodLibro': vCodLibro},
        beforeSend:function(){
        },
        error:function(e){
            fnErrorMessage();
        },
        success:function(data){
            vCheck = data.resultado;
                if (vCheck == 1){//Valido si la petición devuelve success(1) o fail(0)
                    fnSuccessMessage();
            }
            else {
                fnErrorMessage();
            }
            $(function() {$('#id01').fadeOut(400);setTimeout(() => {$('#id01').remove();},500)});//Borramos el cuadro entero de detalles petición
        }});
}
function fnImprimir(){
    $("body").on("click", "#btImprimir", function(){
        console.log("hemos pulsado el boton imprimir");
        window.print();
        return false;
    });
}

function fnMandarMailDetallesFormGestion(){
    $("body").on("click", "#btMandarMail", function(){

        var vPeticionId=$('#inPeticionIdDetalles').val();

        $.ajax({
            type:'post',
            url:'../controller/controller.php',
            dataType: 'json',
            data: {'act':'fnMandarMailDetallesFormGestion', 'pPeticionId': vPeticionId},
            beforeSend:function(){
            },
            error:function(e){
                fnErrorMessage();
            },
            success:function(data){
                vCheck = data.resultado;
                    if (vCheck == 1){//Valido si la petición devuelve success(1) o fail(0)
                        fnSuccessMessage();
                   }
                   else {
                       fnErrorMessage();
                   }
            }});

    });
}

//Cargamos las funciones que se ejecutarán al inicio.
$(function () {
    fnCargarOficinas();
    fnCargarSolicitantes();
    fnBusquedaAuto();
    fnAddToBookList();
    fnEventVaciarLineaDeTablaPeticion();
    fnEventBorradoAttrDataInfo();
    fnAskEnviarFormSolicitud();
    fnAddDiaFecha();
    fnEnviarFormConsulta();
    fnCargarEstados();
    fnInputSoloNumero();
    fnVaciarFormSolicitudOnClick();
    fnBorrarTablaFormConsultaOnBorrar();
    fnMostrarCuadroDetallesConsulta();
    fnExportTableConsultaToExcel();
    fnConsultarPeticionFormGestion();
    fnImprimir();
    fnAskEliminarLibroDePeticion();
    fnAskIfSalvarDatosLineaPeticionFormGestion();
    fnMostrarCuadroAddBookFormGestion();
    fnMandarMailDetallesFormGestion();
});
