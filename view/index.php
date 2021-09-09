<!DOCTYPE html>
<html lang=es>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Petición de Pendrives</title>
    <link rel="stylesheet" type="text/css" href="css/w3.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/mycss.css">
    <link rel="shortcut icon" href="css/images/pendrive.ico" />
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script>
    <script src="js/js.js" type="text/javascript"></script>
</head>
<body class="my-bg--green">
    <header class="header--abs">
        <nav>
            <div class="w3-sidebar w3-bar-block w3-animate-left" style="display:none;z-index:5" id="mySidebar">
                <button class="w3-bar-item w3-button w3-large w3-green" onclick="w3_close()">Cerrar Menú</button>
                <a href="./index.php" class="w3-bar-item w3-button">Petición</a>
                <a href="./fConsulta.php" class="w3-bar-item w3-button">Consulta</a>
                <a href="./fGestion.php" class="w3-bar-item w3-button">Gestión</a>
            </div>

            <div class="w3-overlay w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

            <div class="my-burguer__dad--separations">
                <button class="w3-button w3-xxlarge my-burguer--01" onclick="w3_open()" style="z-index:4" >&#9776;</button>
            </div>
        </nav>
    </header>
        <script>
        function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
        }

        function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
        }
        </script>
    <main>
        <div class="w3-content">
            <form action="../controller/controller.php" method="post" class="w3-row" id="fPeticion" name="fPeticion" enctype="multipart/form-data">
                <input type=hidden name="act" value="fnInsertarPeticion">
                    <div class="w3-col s12 l4 w3-left">
                        <div class="w3-card-2 w3-margin">
                            <div class="w3-container w3-padding-large">
                                    <label class="w3-col l12">
                                        <p class="deco-line">Oficina</p>
                                            <select id="seOficina" name="seOficina" data-required></select>
                                    </label>
                                    <label class="w3-col l12">
                                        <p>Solicitante</p>
                                        <select id="seSolicitante" name="seSolicitante" data-required title="Elige primero tu oficina">
                                        </select>
                                    </label>
                                    <label class="w3-col l12">
                                        <p>SPAIN</p>
                                        <input type="text" id="inSpain" name="inSpain" data-required maxlength="6" class="val__num" title="Campo Obligatorio">
                                    </label>
                                    <label class="w3-col l12 in__date">
                                        <p>Fecha de Hoy</p>
                                        <input type="text" id="inFechaSolicitud" name="inFechaSolicitud" readonly title="Campo automático no editable">
                                    </label>
                            </div>
                        </div>
                    </div>
                    <div class="w3-col s12 l4 w3-center">
                        <div class="w3-card-2 w3-margin">
                            <div class="w3-container w3-padding-large">
                                <label class="w3-col l12">
                                    <p>Nombre Centro Estudios</p>
                                    <input type="text" id="inNombreCentroEstudios" name="inNombreCentroEstudios" placeholder="Opcional" title="Campo opcional">
                                </label>
                                <label class="w3-col l12">
                                    <p>Observaciones</p>
                                    <input type="text" id="inFormConsultaObservaciones" name="inFormConsultaObservaciones" placeholder="Opcional" maxlength="140" title="Max 140 Caracteres">
                                </label>

                            </div>
                        </div>
                    </div>

                    <div class="w3-col s12 l4 w3-right">
                        <div class="w3-card-2 w3-margin">
                            <div class="w3-container w3-padding-large">
                                <label class="l12">
                                    <p>Sistema</p>
                                    <select id="seSistema" name="seSistema" data-required>
                                            <option value="">Escoge una opción</option>
                                            <option value="Dual">Windows/Linux</option>
                                            <option value="MacOs">MacOs</option>
                                    </select>
                                </label>
                                <label class="w3-col l12">
                                    <p>Internet</p>
                                    <select id="seInternet" name="seInternet" data-required>
                                            <option value="">Escoge una opción</option>
                                            <option value="1">Si</option>
                                            <option value="0">No</option>     </select>
                                </label>
                                <label class="w3-col l12">
                                    <p>Unidades</p>
                                    <input type="text" id="inUnidades" name="inUnidades" data-required maxlength="2" class="val__num">
                                </label>
                                <label class="w3-col l12">
                                    <p>Enviar a...</p>
                                    <select id="seEnviara" name="seEnviara" data-required>
                                        <option value="">Escoge una opción</option>
                                        <option value="Oficina">Oficina</option>
                                        <option value="Centro">Centro</option>
                                        <option value="Domicilio">Domicilio</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                <div class="w3-col l12 w3-section">
                    <div class="w3-center">
                            <div class="ui-widget">
                                    <input class="w3-input w3-border w3-padding" type="text" id="inSearch" placeholder="Escribe AQUI al menos 5 caracteres para la busqueda automática por NOMBRE, selecciona y pincha en añadir.">
                                    <input type="hidden" id="inSearchCodBook" name="inSearchCodBook" value="">

                            </div>
                            <div id="btAddBook" class="w3-button w3-white w3-border w3-border-green w3-margin"><b>Añadir</b></div>
                    </div>
                    <table class="w3-table-all w3-hoverable w3-centered w3-card-2" id="taSearch">
                        <tr class="w3-green">
                            <th>Libro</th>
                            <th>Test</th>
                            <th>Audios</th>
                            <th>Borrar</th>
                        </tr>
                        <tr>
                            <td>
                                <input class="w3-input w3-border w3-padding" type="text" id="inSearch1" readonly>
                                <input type="hidden" id="inSearchCodBook1" name="inSearchCodBook1" value="">
                            </td>
                            <td><input id="inTest01" class="w3-check" type="checkbox" name="inTest01"></td>
                            <td><input id="inAudio01" class="w3-check" type="checkbox" name="inAudio01"></td>
                            <td><div id="btLineRemove01" class="w3-button w3-black w3-padding-small w3-hover-green bt__reset--line">Borrar</div></td>
                        </tr>
                        <tr>
                            <td>
                                <input class="w3-input w3-border w3-padding" type="text" id="inSearch2" readonly>
                                <input type="hidden" id="inSearchCodBook2" name="inSearchCodBook2" value="">
                            </td>
                            <td><input id="inTest02" class="w3-check" type="checkbox" name="inTest02"></td>
                            <td><input id="inAudio02" class="w3-check" type="checkbox" name="inAudio02"></td>
                            <td><div id="btLineRemove02" class="w3-button w3-black w3-padding-small w3-hover-green bt__reset--line">Borrar</div></td>
                        </tr>
                        <tr>
                            <td>
                                <input class="w3-input w3-border w3-padding" type="text" id="inSearch3" readonly>
                                <input type="hidden" id="inSearchCodBook3" name="inSearchCodBook3" value="">
                            </td>
                            <td><input id="inTest03" class="w3-check" type="checkbox" name="inTest03"></td>
                            <td><input id="inAudio03" class="w3-check" type="checkbox" name="inAudio03"></td>
                            <td><div id="btLineRemove03" class="w3-button w3-black w3-padding-small w3-hover-green bt__reset--line">Borrar</div></td>
                        </tr>
                        <tr>
                            <td>
                                <input class="w3-input w3-border w3-padding" type="text" id="inSearch4" readonly>
                                <input type="hidden" id="inSearchCodBook4" name="inSearchCodBook4" value="">
                            </td>
                            <td><input id="inTest04" class="w3-check" type="checkbox" name="inTest04"></td>
                            <td><input id="inAudio04" class="w3-check" type="checkbox" name="inAudio04"></td>
                            <td><div id="btLineRemove04" class="w3-button w3-black w3-padding-small w3-hover-green bt__reset--line">Borrar</div></td>
                        </tr>
                        <tr>
                            <td>
                                <input class="w3-input w3-border w3-padding" type="text" id="inSearch5" readonly>
                                <input type="hidden" id="inSearchCodBook5" name="inSearchCodBook5" value="">
                            </td>
                            <td><input id="inTest05" class="w3-check" type="checkbox" name="inTest05"></td>
                            <td><input id="inAudio05" class="w3-check" type="checkbox" name="inAudio05"></td>
                            <td><div id="btLineRemove05" class="w3-button w3-black w3-padding-small w3-hover-green bt__reset--line">Borrar</div></td>
                        </tr>
                        <tr>
                            <td>
                                <input class="w3-input w3-border w3-padding" type="text" id="inSearch6" readonly>
                                <input type="hidden" id="inSearchCodBook6" name="inSearchCodBook6" value="">
                            </td>
                            <td><input id="inTest06" class="w3-check" type="checkbox" name="inTest06"></td>
                            <td><input id="inAudio06" class="w3-check" type="checkbox" name="inAudio06"></td>
                            <td><div id="btLineRemove06" class="w3-button w3-black w3-padding-small w3-hover-green bt__reset--line">Borrar</div></td>
                        </tr>
                    </table>
                </div>
                <div class="w3-col l12">
                    <div class="w3-center">
                    <div id="inSubmitFormSolicitud" class="in__form--submit w3-button w3-white w3-border w3-border-green w3-margin-left w3-margin-right"><b>Enviar</b></div>
                    <div id="inVaciar" name="inVaciar" class="w3-button w3-white w3-border w3-border-green w3-margin-left w3-margin-right"><b>Vaciar</b></div>
                    </div>
                </div>
            </form>
            <div id="dialog-message" title="Errores en el envio" style="display:none;">
                <p>Campos obligatorios vacios.</p>
            </div>
    </main>
    <footer></footer>
</body>
</html>
