<!DOCTYPE html>
<html lang=es>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Consulta</title>
        <link rel="stylesheet" type="text/css" href="css/w3.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="css/mycss.css">
        <link rel="shortcut icon" href="css/images/p.ico" />
        <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui.js" type="text/javascript"></script>
        <script src="js/jquery_plug-tableToexcel.js" type="text/javascript"></script>
        <script src="js/js.js" type="text/javascript"></script>
    </head>
    <body class="my-bg--grey my-bg--blue">
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
                    <button class="w3-button w3-xxlarge my-burguer--02" onclick="w3_open()" style="z-index:4" >&#9776;</button>
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
            <form action="../controller/controller.php" method="post" class="w3-row" id="fConsultar" name="fConsultar" enctype="multipart/form-data">
                <input type=hidden name="act" value="fnConsultarPeticion">
                <div class="w3-content">
                    <div  class="w3-row">
                        <div class="w3-col s12 m8 l10 my-center--marginleft my-margin--top">
                            <div class="w3-card-2 w3-padding-large w3-rightbar w3-border-orange">
                                <div class="w3-row">

                                    <div class="w3-col l6 w3-center">
                                        <label class="w3-col l12">
                                            <p>Oficina</p>
                                            <select id="seOficina" name="seOficina"></select>
                                        </label>
                                        <label class="w3-col l12">
                                            <p>Solicitante</p>
                                            <select id="seSolicitante" name="seSolicitante"></select>
                                        </label>
                                    </div>

                                    <div class="w3-col l6 w3-center">
                                        <div class="w3-col l12">
                                            <label class="w3-col w3-half">
                                                <p>SPAIN</p>
                                                <input type="text" id="inSpain" name="inSpain" class="val__num" maxlength="6">
                                            </label>
                                            <label class="w3-col w3-half">
                                                <p>Estado</p>
                                                <select id="inEstado" name="inEstado"></select>
                                            </label>
                                        </div>
                                        <div class="w3-col l12">
                                            <label class="w3-col w3-half in__date">
                                                <p>Fecha Inicio</p>
                                                <input type="date" id="inFechaInicio" name="inFechaInicio">
                                            </label>
                                            <label class="w3-col w3-half in__date">
                                                <p>Fecha Fin</p>
                                                <input type="date" id="inFechaFin" name="inFechaFin">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="w3-col l12">
                                        <div class="w3-col l3 w3-container"></div>
                                        <div class="w3-col l6">
                                            <label class="w3-col">
                                                    <p>Centro de Estudios</p>
                                                    <input type="text" id="inNombreCentro" name="inNombreCentro" class="w3-col">
                                            </label>
                                        </div>
                                        <div class="w3-col l3 w3-container"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="w3-col s12 w3-section">
                            <div class="w3-center w3-hide">
                                    <div class="ui-widget">
                                            <input class="w3-input w3-border w3-padding" type="text" id="inSearch" name="inSearch" placeholder="Escribe al menos 3 caracteres para la busqueda automática, selecciona el libro y pincha en añadir.">
                                            <input type="hidden" id="inSearchCodBook" name="inSearchCodBook" value="">
                                    </div>
                            </div>

                            <div class="w3-col l12 w3-section">
                                <div class="w3-center">
                                    <div id="inSubmitFormConsulta" class="in__form--submit w3-button w3-white w3-border w3-border-blue w3-margin-left w3-margin-right w3-hover-border-orange"><b>Buscar</b></div>
                                    <input type="reset" value="Borrar" id="inVaciarTablaQuery" name="inVaciarTablaQuery" class="w3-button w3-white w3-border w3-border-blue w3-margin-left w3-margin-right w3-hover-border-orange">
                                    <div id="diExportToExcelConsultas" class="w3-button w3-white w3-border w3-border-blue w3-margin-left w3-margin-right w3-hover-border-orange"><b>Exportar a Excel</b></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="w3-section">
                    <div class="w3-responsive">
                        <table class="w3-table-all w3-hoverable w3-centered w3-card-2" id="taQuery">
                                <tr class="w3-blue">
                                    <th>Nº Fila</th>
                                    <th>ID Peticion</th>
                                    <th>Spain</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Solicitante</th>
                                    <th>Estado</th>
                                    <th>Detalles</th>
                                </tr>
                        </table>
                    </div>
                </div>
            </form>
        </main>
        <footer></footer>
    </body>
</html>
