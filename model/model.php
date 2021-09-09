<?php
class c_model { //creamos la clase base del modelo
  private $attr00;

  function __construct() { // funcion constructora
    include '../config/c_db_connection.php';
      $this->attr00 = new c_db_connection(); // Tenemos los atributos y funciones de la clase que conecta con el sql

}
  public function fnCargarOficinas() { // Query para cargar oficinas
    try {
        $sql = "SELECT *
                FROM departamento
                WHERE departamento_id NOt IN(4,9,10)
                ORDER BY departamento_id";
        $vQueryResult = $this->attr00->link->query($sql);

        $rawdata = array(); //creamos un array

        //guardamos en un array multidimensional todos los datos de la consulta
        $i=0;

        while($row = mysqli_fetch_array($vQueryResult))
        {
            $rawdata[$i] = $row;
            $i++;
        }

        //Print array in JSON format
        echo json_encode($rawdata);

        //Cerramos conexión
        //mysqli_close($this->attr00->link);
        $this->attr00->link->close();
    } catch (exception $e){
        echo $e->getMessage();
        die();
    }
  }

  public function fnCargarEstados() {
    try {
      $sql = "SELECT *
              FROM estado;";
      $vQueryResult = $this->attr00->link->query($sql);

      $rawdata = array(); //creamos un array

      //guardamos en un array multidimensional todos los datos de la consulta
      $i=0;

      while($row = mysqli_fetch_array($vQueryResult))
      {
          $rawdata[$i] = $row;
          $i++;
      }

      //Print array in JSON format
      echo json_encode($rawdata);

      //Cerramos conexión
      $this->attr00->link->close();
  } catch (exception $e){
      echo $e->getMessage();
      die();
  }

  }
  public function fnConsultarSolicitantes($pIdSeleccionado){
    try {
      $sql = "SELECT *
              FROM usuario
              WHERE fk_departamento_id = '$pIdSeleccionado';";

      $vQueryResult = $this->attr00->link->query($sql);

          $rawdata = array(); //creamos un array

      //guardamos en un array multidimensional todos los datos de la consulta
      $i=0;

      while($row = mysqli_fetch_array($vQueryResult))
      {
          $rawdata[$i] = $row;
          $i++;
      }

      //Print array in JSON format
      echo json_encode($rawdata);

      //Cerramos conexión
      //mysqli_close($this->attr00->link);
      $this->attr00->link->close();

    }
    catch (exception $e){
      echo $e->getMessage();
      die();
    }

  }
  public function fnBusquedaAuto($pKeyWord){ // Función para el plugin autocomplete de jQuery que busca los libros en el form de petición
    try{
      $sql = "SELECT *
              FROM libro
              WHERE nombre like '%$pKeyWord%'
              ORDER BY nombre, curso, formato, idioma, libro_id;";

      $vQueryResult = $this->attr00->link->query($sql);

        $return_array = array(); //creamos un array

        while ($row = $vQueryResult->fetch_array(MYSQLI_ASSOC))
          {
              $rawdata['value'] = $row['libro_id'];
              $rawdata['label'] = $row['nombre'];
              $rawdata['curso'] = $row['curso'];
              $rawdata['formato'] = $row['formato'];
              $rawdata['idioma'] = $row['idioma'];

             array_push($return_array, $rawdata);
          }

        //Print array in JSON format
        echo json_encode($return_array);


      $this->attr00->link->close();
    }

    catch (exception $e){
      echo $e->getMessage();
      die();
    }

  }
  public function fnInsertarPeticion(){
    $vSentryLibros=0;
    try{ //Si la variable existe y sanitizo y vuelco.
      if(isset($_POST['seOficina'])){$vOficina = fnSanitizar01($_POST['seOficina']);}
      if(isset($_POST['seSolicitante'])){$vSolicitante = fnSanitizar01($_POST['seSolicitante']);}
      if(isset($_POST['inSpain'])){$vSpain = fnSanitizar01(($_POST['inSpain']));}
      if(isset($_POST['inFechaSolicitud'])){$vFechaSolicitud = fnSanitizar01(($_POST['inFechaSolicitud']));}//Sin uso
      if(isset($_POST['seSistema'])){$vSistema = fnSanitizar01(($_POST['seSistema']));}
      if(isset($_POST['seInternet'])){$vInternet = fnSanitizar01(($_POST['seInternet']));}
      if(isset($_POST['inUnidades'])){$vUnidades = fnSanitizar01(($_POST['inUnidades']));}
      if(isset($_POST['seEnviara'])){$vEnviarA = fnSanitizar01(($_POST['seEnviara']));}
      if(isset($_POST['inNombreCentroEstudios'])){$vNombreCentroEstudios = fnSanitizarTxt($_POST['inNombreCentroEstudios']);}
      if(isset($_POST['inFormConsultaObservaciones'])){$vFormConsultaObservaciones = fnSanitizarTxt($_POST['inFormConsultaObservaciones']);}
      if(isset($_POST['inSearch1'])){$vLibroNombre1 = fnSanitizar01(($_POST['inSearch1']));}else{$vLibroNombre1 = "";};
      if(isset($_POST['inTest01'])){$vTestFactory1 = 1;}else{$vTestFactory1 = 0;}; //recibo true o false, si el check no esta marcado el post está vacio por lo que discrimino con isset
      if(isset($_POST['inAudio01'])){$vAudios1 = 1;}else{$vAudios1 = 0;};

    if (isset($_POST['inSearchCodBook1'])){
      if (!empty($_POST['inSearchCodBook1'])){
        $vLibroId1 = fnSanitizar01(($_POST['inSearchCodBook1']));
        $vSentryLibros++;//Si hay libro añado 1 al centinela
      }
      else{$vLibroId1 = "";}
    };

      if(isset($_POST['inSearch2'])){$vLibroNombre2 = fnSanitizar01(($_POST['inSearch2']));}else{$vLibroNombre2 = "";};
      if(isset($_POST['inTest02'])){$vTestFactory2 = 1;}else{$vTestFactory2 = 0;}; //recibo true o false, si el check no esta marcado el post está vacio por lo que discrimino con isset
      if(isset($_POST['inAudio02'])){$vAudios2 = 1;}else{$vAudios2 = 0;};

      if (isset($_POST['inSearchCodBook2'])){
        if (!empty($_POST['inSearchCodBook2'])){
          $vLibroId2 = fnSanitizar01(($_POST['inSearchCodBook2']));
          $vSentryLibros++;       //Si hay libro añado 1 al centinela
        }
        else{$vLibroId2 = "";}
      };

      if(isset($_POST['inSearch3'])){$vLibroNombre3 = fnSanitizar01(($_POST['inSearch3']));}else{$vLibroNombre3 = "";};
      if(isset($_POST['inTest03'])){$vTestFactory3 = 1;}else{$vTestFactory3 = 0;}; //recibo true o false, si el check no esta marcado el post está vacio por lo que discrimino con isset
      if(isset($_POST['inAudio03'])){$vAudios3 = 1;}else{$vAudios3 = 0;};

      if (isset($_POST['inSearchCodBook3'])){
        if (!empty($_POST['inSearchCodBook3'])){
          $vLibroId3 = fnSanitizar01(($_POST['inSearchCodBook3']));
          $vSentryLibros++;  //Si hay libro añado 1 al centinela
        }
        else{$vLibroId3 = "";}
      };

      if(isset($_POST['inSearch4'])){$vLibroNombre4 = fnSanitizar01(($_POST['inSearch4']));}else{$vLibroNombre4 = "";};
      if(isset($_POST['inTest04'])){$vTestFactory4 = 1;}else{$vTestFactory4 = 0;}; //recibo true o false, si el check no esta marcado el post está vacio por lo que discrimino con isset
      if(isset($_POST['inAudio04'])){$vAudios4 = 1;}else{$vAudios4 = 0;};

      if (isset($_POST['inSearchCodBook4'])){
        if (!empty($_POST['inSearchCodBook4'])){
          $vLibroId4 = fnSanitizar01(($_POST['inSearchCodBook4']));
          $vSentryLibros++;        //Si hay libro añado 1 al centinela
        }
        else{$vLibroId4 = "";}
      };

      if(isset($_POST['inSearch5'])){$vLibroNombre5 = fnSanitizar01(($_POST['inSearch5']));}else{$vLibroNombre5 = "";};
      if(isset($_POST['inTest05'])){$vTestFactory5 = 1;}else{$vTestFactory5 = 0;}; //recibo true o false, si el check no esta marcado el post está vacio por lo que discrimino con isset
      if(isset($_POST['inAudio05'])){$vAudios5 = 1;}else{$vAudios5 = 0;};

      if (isset($_POST['inSearchCodBook5'])){
        if (!empty($_POST['inSearchCodBook5'])){
          $vLibroId5 = fnSanitizar01(($_POST['inSearchCodBook5']));
          $vSentryLibros++;        //Si hay libro añado 1 al centinela
        }
        else{$vLibroId5 = "";}
      };

      if(isset($_POST['inSearch6'])){$vLibroNombre6 = fnSanitizar01(($_POST['inSearch6']));}else{$vLibroNombre6 = "";};
      if(isset($_POST['inTest06'])){$vTestFactory6 = 1;}else{$vTestFactory6 = 0;}; //recibo true o false, si el check no esta marcado el post está vacio por lo que discrimino con isset
      if(isset($_POST['inAudio06'])){$vAudios6 = 1;}else{$vAudios6 = 0;};

      if (isset($_POST['inSearchCodBook6'])){
        if (!empty($_POST['inSearchCodBook6'])){
          $vLibroId6 = fnSanitizar01(($_POST['inSearchCodBook6']));
          $vSentryLibros++;
        }
        else{$vLibroId6 = "";}
      };

  if ($vSentryLibros >= 1){ // Valido si ha llegado algún código de libro al php que se haya saltado JS, si es así preparo query y transacción.
        $sql = "INSERT INTO peticion (spain, fk_usuario_id, internet, sistema, enviar_a, unidades, fecha_solicitud, nombre_centro, observaciones_peticion)
        VALUES ('$vSpain', '$vSolicitante', '$vInternet', '$vSistema', '$vEnviarA', '$vUnidades', NOW(), '$vNombreCentroEstudios', '$vFormConsultaObservaciones' );";

      //Preparo transacción
      $this->attr00->link->autocommit(false);
      //$this->attr00->link->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
      $vQueryResult00 = $this->attr00->link->query($sql);
      $vLastId = $this->attr00->link->insert_id;

      if ( $vLibroId1 !== "" ){
      $sql01 = "INSERT INTO peticion_libro (fk_peticion_id, fk_libro_id, test_factory, audios)
              VALUES ('$vLastId', '$vLibroId1', '$vTestFactory1', '$vAudios1');";
      $vQueryResult01 = $this->attr00->link->query($sql01);
      }else {$vQueryResult01 = True;}

      if ( $vLibroId2 !== "" ){
        $sql02 = "INSERT INTO peticion_libro (fk_peticion_id, fk_libro_id, test_factory, audios)
        VALUES ('$vLastId', '$vLibroId2', '$vTestFactory2', '$vAudios2');";
        $vQueryResult02 = $this->attr00->link->query($sql02);
      }else {$vQueryResult02 = True;}

      if ( $vLibroId3 !== "" ){
      $sql03 = "INSERT INTO peticion_libro (fk_peticion_id, fk_libro_id, test_factory, audios)
              VALUES ('$vLastId', '$vLibroId3', '$vTestFactory3', '$vAudios3');";
      $vQueryResult03 = $this->attr00->link->query($sql03);
      }else {$vQueryResult03 = True;}

      if ( $vLibroId4 !== "" ){
        $sql04 = "INSERT INTO peticion_libro (fk_peticion_id, fk_libro_id, test_factory, audios)
                VALUES ('$vLastId', '$vLibroId4', '$vTestFactory4', '$vAudios4');";
        $vQueryResult04 = $this->attr00->link->query($sql04);
      }else {$vQueryResult04 = True;}

      if ( $vLibroId5 !== "" ){
        $sql05 = "INSERT INTO peticion_libro (fk_peticion_id, fk_libro_id, test_factory, audios)
                VALUES ('$vLastId', '$vLibroId5', '$vTestFactory5', '$vAudios5');";
        $vQueryResult05 = $this->attr00->link->query($sql05);
      }else {$vQueryResult05 = True;}

      if ( $vLibroId6 !== "" ){
        $sql06 = "INSERT INTO peticion_libro (fk_peticion_id, fk_libro_id, test_factory, audios)
                VALUES ('$vLastId', '$vLibroId6', '$vTestFactory6', '$vAudios6');";
        $vQueryResult06 = $this->attr00->link->query($sql06);
      }else {$vQueryResult06 = True;}

      $sqlCambioEstado = "INSERT INTO cambioestado (fk_estado_id, fecha_cambio, fk_usuario_id, fk_peticion_id)
                    VALUES ('1', NOW(), '$vSolicitante', '$vLastId');";
      $vQueryResultEstado = $this->attr00->link->query($sqlCambioEstado);

      // Valido la transaccion para lanzar un rollback si es necesario
      if ($vQueryResult00 && $vQueryResult01 && $vQueryResult02 && $vQueryResult03 && $vQueryResult04 && $vQueryResult05 && $vQueryResult06 && $vQueryResultEstado) {
        $vStatus=1; // Cargo la respuesta con un OK
        $this->attr00->link->commit(); //Envio datos de la transaccion.
        $this->attr00->link->autocommit(true); // Dejo valores de autoenvio activados para finalizar la transacción.
        $this->fnEnviarMailNuevaPeticion($vLastId, 0);
        }
        else {
        $vStatus=0; // Cargo la respuesta con un FAIL
        $this->attr00->link->rollback();
        $this->attr00->link->autocommit(true);
        }
      }
    else{
      $vStatus=0;
    }
  $this->attr00->link->close();
  echo $vStatus;//Envio respuesta para evaluar exito o fracaso.
}
  catch (exception $e){
      $this->attr00->link->rollback(); // La transacción deshace los cambio si hay un excepción.
      $this->attr00->link->autocommit(true);
      echo $e->getMessage();
      die();
    }
  }
  public function fnConsultarPeticion(){
    $vOficina ="";
    $vSolicitante ="";
    $vSpain ="";
    $vSelectedBook="";
    $aFiltros = array();
    $aFiltroFecha = array();
    $i=0;
    $aFiltrosLenght;
    $aFiltroFechaLenght;
    $key="";
    $value="";
    $filtro="";
    $vWhereFiltro="";
    $vQueryChunk="";
    $rawdata = array();
    $j=0;
    $vFechaFinTemp;
    $vQueryTail="ORDER BY p.peticion_id desc;";
    $vNombreCentro = "";
        try {

         if(isset($_POST['seOficina']) && !empty($_POST['seOficina'])){
            $vOficina = fnSanitizar01($_POST['seOficina']);
            $aFiltros += array(
              'us.fk_departamento_id' => $vOficina
            );
          }

         if(isset($_POST['seSolicitante']) && !empty($_POST['seSolicitante'])){
            $vSolicitante = fnSanitizar01($_POST['seSolicitante']);
            $aFiltros += array(
              'us.usuario_id' => $vSolicitante
            );
          }

          if(isset($_POST['inSpain']) && !empty($_POST['inSpain'])){
            $vSpain = fnSanitizar01($_POST['inSpain']);
            $aFiltros += array(
              'p.spain' => $vSpain
            );
          }

          if(isset($_POST['inEstado']) && !empty($_POST['inEstado'])){
            $vEstado = fnSanitizar01($_POST['inEstado']);
            $aFiltros += array(
              'ce.fk_estado_id' => $vEstado
            );

          }

          if(isset($_POST['inFechaInicio']) && !empty($_POST['inFechaInicio']) && isset($_POST['inFechaFin']) && !empty($_POST['inFechaFin'])){
            $vFechaInicio = fnSanitizar01(($_POST['inFechaInicio']));
            $vFechaFin = fnSanitizar01(($_POST['inFechaFin']));
            $vFechaFinTemp = new Datetime($vFechaFin);//Instancio Datetime
            $vFechaFinTemp->modify("+23 hour");$vFechaFinTemp->modify("+59 minutes");$vFechaFinTemp->modify("+59 seconds");//Añado tiempo para que salgan las querys
            $vFechaFin=$vFechaFinTemp->format('Y-m-d H:i:s');//Paso a string para el array
            $aFiltroFecha = array('p.fecha_solicitud', $vFechaInicio, $vFechaFin);
          }

          if(isset($_POST['inSearchCodBook']) && !empty($_POST['inSearchCodBook'])){
            $vSelectedBook = fnSanitizar01($_POST['inSearchCodBook']);
            $aFiltros += array(
              'f.fk_libro_id' => $vSelectedBook
            );
          }

          if(isset($_POST['inNombreCentro']) && !empty($_POST['inNombreCentro'])){
            $vNombreCentro = fnSanitizarTxt($_POST['inNombreCentro']);
          }

          $aFiltrosLenght = count($aFiltros);
          $aFiltroFechaLenght = count($aFiltroFecha);

          if (isset($aFiltrosLenght)){
            if (!empty($aFiltrosLenght)){

                foreach($aFiltros as $key => $value){
                  $i++;
                  $vWhereFiltro=$key;
                  $filtro=$value;
                  if($i == 1){
                    $vQueryChunk .= "WHERE $vWhereFiltro='$filtro' ";
                  }else{
                    $vQueryChunk .= "AND $vWhereFiltro='$filtro' ";
                  }
              }
            }
          }

          if (isset($aFiltroFechaLenght)){
            if (!empty($aFiltroFechaLenght)){
              if (!empty($aFiltrosLenght)){
                $vQueryChunk .= "AND $aFiltroFecha[0] >= '$aFiltroFecha[1]' AND $aFiltroFecha[0] <= '$aFiltroFecha[2]' ";
              }
              else{
                $vQueryChunk .= "WHERE $aFiltroFecha[0] >= '$aFiltroFecha[1]' AND $aFiltroFecha[0] <= '$aFiltroFecha[2]' ";
              }
            }
          }

          if ( !empty( $vNombreCentro ) ){

              if ( !empty( $aFiltrosLenght ) || !empty( $aFiltroFechaLenght ) ){

                $vQueryChunk .= "AND p.nombre_centro like '%$vNombreCentro%' ";

              }
              else {

                $vQueryChunk .= "WHERE p.nombre_centro like '%$vNombreCentro%' ";

              }
          }

          $vQuery="SELECT ce.cambio_estado_id, ce.fk_estado_id, ce.fk_usuario_id, u.nombre_usuario as nombre_usuario_asignado, u.apellido_usuario AS apellido_usuario_asignado, ce.fecha_cambio, e.nombre_estado, ce.fk_peticion_id, p.spain, us.nombre_usuario AS solicitante_nombre, us.apellido_usuario AS solicitante_apellido, p.fecha_solicitud, p.nombre_centro
          FROM cambioestado AS ce
          INNER JOIN
            (SELECT MAX(fecha_cambio), cambio_estado_id
            FROM cambioestado
            GROUP BY fk_peticion_id desc)
          AS ce_se ON ce.cambio_estado_id = ce_se.cambio_estado_id
          INNER JOIN estado AS e ON ce.fk_estado_id = e.estado_id
          INNER JOIN peticion AS p ON ce.fk_peticion_id = p.peticion_id
          INNER JOIN usuario AS u ON ce.fk_usuario_id = u.usuario_id
          INNER JOIN usuario AS us ON p.fk_usuario_id = us.usuario_id
          INNER JOIN departamento AS d ON us.fk_departamento_id = d.departamento_id ";

          $vQuery .= $vQueryChunk;

          $vQuery .= $vQueryTail;
          $vQueryResult = $this->attr00->link->query($vQuery);

          while($row = mysqli_fetch_array($vQueryResult))//guardamos en un array multidimensional todos los datos de la consulta
          {
              $rawdata[$j] = $row;
              $j++;
          }

          //Print array in JSON format
          echo json_encode($rawdata);

          //Cerramos conexión
          $this->attr00->link->close();

        }
        catch (exception $e){
          echo $e->getMessage();
          die();
        }
  }

  public function fnMostrarCuadroDetallesConsulta(){ //Pedmos parte de la info para el cuadro de detalles de la peticion del form de consulta
    try{
      $vFiltro;
      $vQuery;
      $vQueryResult;
      $i=0;
      $aData = array();
      $vLinea;
      if(isset($_POST['pFiltro'])){$vFiltro = fnSanitizar01($_POST['pFiltro']);}

      $vQuery ="SELECT a.*, b.*, concat(usu.nombre_usuario, ' ', usu.apellido_usuario) AS entregado_a_n, d.nombre_departamento
                FROM peticion as a
                INNER JOIN usuario As b ON a.fk_usuario_id = b.usuario_id
                LEFT JOIN usuario As usu ON usu.usuario_id = a.entregado_a
                INNER JOIN departamento AS d ON d.departamento_id = b.fk_departamento_id
                WHERE peticion_id = $vFiltro;";

      $vQueryResult = $this->attr00->link->query($vQuery);

      while($vLinea = mysqli_fetch_array($vQueryResult))
      {
          $aData[$i] = $vLinea;
          $i++;
      }
      echo json_encode($aData);

      $this->attr00->link->close();

    }
    catch (exception $e){
      echo $e->getMessage();
      die();
    }

  }
  public function fnMostrarCuadroDetallesConsultaLibros(){//Pedimos parte de la info para el cuadro de detalles de la peticion del form de consulta
    try{
      $vFiltro;
      $vQuery;
      $vQueryResult;
      $i=0;
      $aData = array();
      $vLinea;
      if(isset($_POST['pFiltro'])){$vFiltro = fnSanitizar01($_POST['pFiltro']);}

      $vQuery ="SELECT *
                FROM peticion_libro as a
                INNER JOIN libro As b ON a.fk_libro_id = b.libro_id
                WHERE fk_peticion_id = $vFiltro;";

      $vQueryResult = $this->attr00->link->query($vQuery);

      while($vLinea = mysqli_fetch_array($vQueryResult))
      {
          $aData[$i] = $vLinea;
          $i++;
      }
      echo json_encode($aData);

      $this->attr00->link->close();

    }
    catch (exception $e){
      echo $e->getMessage();
      die();
    }

  }
  public function fnMostrarCuadroDetallesConsultaEstado() {//Pedimos parte de la info para el cuadro de detalles de la peticion del form de consulta
    try{
      $vFiltro;
      $vQuery;
      $vQueryResult;
      $i=0;
      $aData = array();
      $vLinea;
      if(isset($_POST['pFiltro'])){$vFiltro = fnSanitizar01($_POST['pFiltro']);}

      $vQuery ="SELECT e.nombre_estado
                FROM cambioestado AS ce
                INNER JOIN
                    (SELECT MAX(fecha_cambio), cambio_estado_id
                    FROM cambioestado
                    GROUP BY fk_peticion_id desc)
                AS ce_se ON ce.cambio_estado_id = ce_se.cambio_estado_id
                INNER JOIN estado AS e ON ce.fk_estado_id = e.estado_id
                WHERE ce.fk_peticion_id = '$vFiltro'
                ORDER BY ce.cambio_estado_id DESC";

      $vQueryResult = $this->attr00->link->query($vQuery);

      while($vLinea = mysqli_fetch_array($vQueryResult))
      {
          $aData[$i] = $vLinea;
          $i++;
      }
      echo json_encode($aData);

      $this->attr00->link->close();

    }
    catch (exception $e){
      echo $e->getMessage();
      die();
    }

  }
public function fnMostrarCuadroDetallesConsultaHistorico(){
  try{
    $vFiltro;
    $vQuery;
    $vQueryResult;
    $i=0;
    $aData = array();
    $vLinea;
    if(isset($_POST['pFiltro'])){$vFiltro = fnSanitizar01($_POST['pFiltro']);}

    $vQuery ="SELECT a.fecha_cambio, b.nombre_estado, a.fk_peticion_id, concat(u.nombre_usuario, ' ', u.apellido_usuario) as nombre_apellido_usuario
              FROM cambioestado As a
              INNER JOIN estado As b ON a.fk_estado_id = b.estado_id
              INNER JOIN usuario as u ON u.usuario_id = a.fk_usuario_id
              WHERE a.fk_peticion_id = $vFiltro
              ORDER BY a.fecha_cambio";

    $vQueryResult = $this->attr00->link->query($vQuery);

    while($vLinea = mysqli_fetch_array($vQueryResult))
    {
        $aData[$i] = $vLinea;
        $i++;
    }
    echo json_encode($aData);

    $this->attr00->link->close();

  }
  catch (exception $e){
    echo $e->getMessage();
    die();
  }

}
public function fnConsultarPeticionFormGestion(){
  $vOficina ="";
  $vSolicitante ="";
  $vSpain ="";
  $vSelectedBook="";
  $aFiltros = array();
  $aFiltroFecha = array();
  $i=0;
  $aFiltrosLenght;
  $aFiltroFechaLenght;
  $key="";
  $value="";
  $filtro="";
  $vWhereFiltro="";
  $vQueryChunk="";
  $rawdata = array();
  $j=0;
  $vFechaFinTemp;
  $vQueryTail="ORDER BY p.fecha_solicitud desc;";
      try {
       if(isset($_POST['seOficina']) && !empty($_POST['seOficina'])){
          $vOficina = fnSanitizar01($_POST['seOficina']);
          $aFiltros += array(
            'us.fk_departamento_id' => $vOficina
          );
        }
       if(isset($_POST['seSolicitante']) && !empty($_POST['seSolicitante'])){
          $vSolicitante = fnSanitizar01($_POST['seSolicitante']);
          $aFiltros += array(
            'us.usuario_id' => $vSolicitante
          );
        }
        if(isset($_POST['inSpain']) && !empty($_POST['inSpain'])){
          $vSpain = fnSanitizar01($_POST['inSpain']);
          $aFiltros += array(
            'p.spain' => $vSpain
          );
        }
        if(isset($_POST['inEstado']) && !empty($_POST['inEstado'])){
          $vEstado = fnSanitizar01($_POST['inEstado']);
          $aFiltros += array(
            'ce.fk_estado_id' => $vEstado
          );
        }
        if(isset($_POST['inFechaInicio']) && !empty($_POST['inFechaInicio']) && isset($_POST['inFechaFin']) && !empty($_POST['inFechaFin'])){
          $vFechaInicio = fnSanitizar01(($_POST['inFechaInicio']));
          $vFechaFin = fnSanitizar01(($_POST['inFechaFin']));
          $vFechaFinTemp = new Datetime($vFechaFin);//Instancio Datetime
          $vFechaFinTemp->modify("+23 hour");$vFechaFinTemp->modify("+59 minutes");$vFechaFinTemp->modify("+59 seconds");//Añado tiempo para que salgan las querys
          $vFechaFin=$vFechaFinTemp->format('Y-m-d H:i:s');//Paso a string para el array
          $aFiltroFecha = array('p.fecha_solicitud', $vFechaInicio, $vFechaFin);
        }
        if(isset($_POST['inSearchCodBook']) && !empty($_POST['inSearchCodBook'])){ //Sin uso
          $vSelectedBook = fnSanitizar01($_POST['inSearchCodBook']);
          $aFiltros += array(
            'f.fk_libro_id' => $vSelectedBook
          );
        }
        $aFiltrosLenght = count($aFiltros);
        $aFiltroFechaLenght = count($aFiltroFecha);
        if (isset($aFiltrosLenght)){
          if (!empty($aFiltrosLenght)){

              foreach($aFiltros as $key => $value){
                $i++;
                $vWhereFiltro=$key;
                $filtro=$value;
                if($i == 1){
                  $vQueryChunk .= "WHERE $vWhereFiltro='$filtro' ";
                }else{
                  $vQueryChunk .= "AND $vWhereFiltro='$filtro' ";
                }
            }
          }
        }
        if (isset($aFiltroFechaLenght)){
          if (!empty($aFiltroFechaLenght)){
            if (!empty($aFiltrosLenght)){
              $vQueryChunk .= "AND $aFiltroFecha[0] >= '$aFiltroFecha[1]' AND $aFiltroFecha[0] <= '$aFiltroFecha[2]' ";
            }
            else{
              $vQueryChunk .= "WHERE $aFiltroFecha[0] >= '$aFiltroFecha[1]' AND $aFiltroFecha[0] <= '$aFiltroFecha[2]' ";
            }
          }
        }
      $vQuery="SELECT ce.cambio_estado_id, ce.fk_estado_id, ce.fk_usuario_id, u.nombre_usuario as nombre_usuario_asignado, u.apellido_usuario AS apellido_usuario_asignado, ce.fecha_cambio, e.nombre_estado, ce.fk_peticion_id, p.spain, us.nombre_usuario AS solicitante_nombre, us.apellido_usuario AS solicitante_apellido, p.fecha_solicitud, p.entregado_a, CONCAT(IfNULL(usu.nombre_usuario, '-'), ' ', IfNULL(usu.apellido_usuario, '-')) AS nombre_entregado_a
      FROM cambioestado AS ce
      INNER JOIN
        (SELECT MAX(fecha_cambio), cambio_estado_id
        FROM cambioestado
        GROUP BY fk_peticion_id desc)
      AS ce_se ON ce.cambio_estado_id = ce_se.cambio_estado_id
      INNER JOIN estado AS e ON ce.fk_estado_id = e.estado_id
      INNER JOIN peticion AS p ON ce.fk_peticion_id = p.peticion_id
      INNER JOIN usuario AS u ON ce.fk_usuario_id = u.usuario_id
      INNER JOIN usuario AS us ON p.fk_usuario_id = us.usuario_id
      INNER JOIN departamento AS d ON us.fk_departamento_id = d.departamento_id
      LEFT JOIN usuario AS usu ON usu.usuario_id = p.entregado_a ";

      $vQuery .= $vQueryChunk;

        $vQuery .= $vQueryTail;
        $vQueryResult = $this->attr00->link->query($vQuery);

        while($row = mysqli_fetch_array($vQueryResult))//guardamos en un array multidimensional todos los datos de la consulta
        {
            $rawdata[$j] = $row;
            $j++;
        }

        //Print array in JSON format
        echo json_encode($rawdata);

        //Cerramos conexión
        $this->attr00->link->close();
      }
      catch (exception $e){
        echo $e->getMessage();
        die();
      }
}
  public function fnUpdatePeticionAsigAndEstado(){//Salvamos datos del form gestion de Usuario asignado, estado peticion y persona a la se se entrega
    $vSentry=0;
    $vUsuarioAsignado;
    $vEstadoPeticion;
    $vPeticionID;
    $vEntregadoA;
    $vStatus=0;
    $vQuery;
    $vQueryResult01;
    $vQueryResult02;
    $aStatus=array();
    try{
      if(isset($_POST['pUsuarioAsignado']) && !empty($_POST['pUsuarioAsignado'])){
        $vUsuarioAsignado = fnSanitizar01($_POST['pUsuarioAsignado']);
        $vSentry++;
      }
     if(isset($_POST['pEstadoPeticion']) && !empty($_POST['pEstadoPeticion'])){
        $vEstadoPeticion = fnSanitizar01($_POST['pEstadoPeticion']);
        $vSentry++;
      }
      if(isset($_POST['pPeticionId']) && !empty($_POST['pPeticionId'])){
        $vPeticionID = fnSanitizar01($_POST['pPeticionId']);
        $vSentry++;
      }
      if(isset($_POST['pEntregadoA']) && !empty($_POST['pEntregadoA'])){
        $vEntregadoA = fnSanitizar01($_POST['pEntregadoA']);
        $vSentry++;
      }else{$vEntregadoA = NULL;$vQueryResult02 = TRUE;}

      if ($vSentry >= 3){ // Compruebo si están los 3 datos que necesito, si es así preparo query y transacción.

          //Preparo transacción
          $this->attr00->link->autocommit(false);

          $vQuery = "INSERT INTO cambioestado (fk_estado_id, fecha_cambio, fk_usuario_id, fk_peticion_id)
                        VALUES ('$vEstadoPeticion', NOW(), '$vUsuarioAsignado', '$vPeticionID');";
          $vQueryResult01 = $this->attr00->link->query($vQuery);

          if (!is_null($vEntregadoA)){ //Si es null es que el dato estaba vacio asi que no hace falta que haga el update
            $vQuery="UPDATE peticion
            SET entregado_a = $vEntregadoA
            WHERE peticion_id = '$vPeticionID';";
            $vQueryResult02 = $this->attr00->link->query($vQuery);
          }



          // Valido la transaccion para lanzar un rollback si es necesario
            if ($vQueryResult01 && $vQueryResult02) {
                  $this->attr00->link->commit(); //Envio datos de la transaccion.
                  $vStatus=1; // Cargo la respuesta con un OK

                  if ( $vEstadoPeticion == 4 ) { //Aviso al Solicitante para que facture
                    $this->fnEnviarMailNuevaPeticion($vPeticionID, 1);
                  }
              }
              else {
                $vStatus=0; // Cargo la respuesta con un FAIL
                $this->attr00->link->rollback();
            }
              $this->attr00->link->autocommit(true); // Dejo valores de autoenvio activados para finalizar la transacción.
        }

      $this->attr00->link->close();
      $aStatus = array(
        'resultado'=>$vStatus
      );
      echo json_encode($aStatus);

    }
    catch (exception $e){
      echo $e->getMessage();
      die();
    }
  }


  public function fnUpdateObservaciones(){//Actualizamos el campo Observaciones desde Form Gestión.
    $vSentry=0;
    $vObservaciones;
    $vPeticionID;
    $vStatus=0;
    $vQuery;
    $vQueryResult;
    $aStatus=array();
    try{
      if(isset($_POST['pObservacionesText']) && !empty($_POST['pObservacionesText'])){
        $vObservaciones = fnSanitizarTxt($_POST['pObservacionesText']);
        $vSentry++;
      }
      if(isset($_POST['pPeticionId']) && !empty($_POST['pPeticionId'])){
        $vPeticionID = fnSanitizar01($_POST['pPeticionId']);
        $vSentry++;
      }
      if ($vSentry >= 2){ // Compruebo si están los 2 datos que necesito, si es así preparo query y transacción.

          //Preparo transacción
          $this->attr00->link->autocommit(false);

          $vQuery = "UPDATE peticion SET observaciones_peticion = '$vObservaciones' WHERE peticion_id = '$vPeticionID'";
          $vQueryResult = $this->attr00->link->query($vQuery);

          // Valido la transaccion para lanzar un rollback si es necesario
            if ($vQueryResult) {
                  $this->attr00->link->commit(); //Envio datos de la transaccion.
                  $vStatus=1; // Cargo la respuesta con un OK
              }
              else {
                $vStatus=0; // Cargo la respuesta con un FAIL
                $this->attr00->link->rollback();
            }
              $this->attr00->link->autocommit(true); // Dejo valores de autoenvio activados para finalizar la transacción.
        }

      $this->attr00->link->close();
      $aStatus = array(
        'resultado'=>$vStatus
      );
      echo json_encode($aStatus);
    }
    catch (exception $e){
      echo $e->getMessage();
      die();
    }
  }
  public function fnEnviarMailNuevaPeticion($pLastId, $pMod){     //Usamos PHPmailer para enviar mail
    $vLastId=strval($pLastId);
    $vMensaje="";
    $vFiltro=$pLastId;
    $vQuery;
    $vQueryResult;
    $i=0;
    $aData = array();
    $vLinea;
    $oData;
    $oDataLibro;
    $aDataLibro = array();
    $vTablaLibros="";
    try{
      $vQuery ="SELECT *
                FROM peticion as a
                INNER JOIN usuario As b ON a.fk_usuario_id = b.usuario_id
                WHERE peticion_id = $vFiltro;";
      $vQueryResult = $this->attr00->link->query($vQuery);
      $oData = mysqli_fetch_object($vQueryResult); //Guarda solo una linea, aunque aquí es lo unico que se va a recibir.

      $vQuery ="SELECT *
                FROM peticion_libro as a
                INNER JOIN libro As b ON a.fk_libro_id = b.libro_id
                WHERE fk_peticion_id = $vFiltro;";
      $vQueryResult = $this->attr00->link->query($vQuery);

      $vTablaLibros = '<table><tbody><tr><th>Libro</th><th>Código</th><th>Audios</th><th>Test Factory</th></tr>';
      while ($oDataLibro=mysqli_fetch_array($vQueryResult)){
        $vTablaLibros .='<tr><td>' . $oDataLibro["nombre"] . " " . $oDataLibro["curso"] . " " .  $oDataLibro["idioma"] . " " .  $oDataLibro["formato"] . '</td><td>' . $oDataLibro["fk_libro_id"] . '</td><td>' . $oDataLibro["audios"] . '</td><td>' . $oDataLibro["test_factory"] . '</td></tr>';
      }
      $vTablaLibros .= '</tbody></table>';

    require  '../config/PHPMailer5.2/class.phpmailer.php';
    require  '../config/PHPMailer5.2/class.smtp.php';

    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.midominio.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'peticiones@midominio.com';                 // SMTP username
    $mail->Password = '**********';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //$mail->setFrom('peticiones@midominio.com', $oData->nombre_usuario . " " . $oData->apellido_usuario);
    $mail->setFrom('peticiones@midominio.com', 'Plataforma de Petición');

    //Aprovecho la funcion para nuevas peticiones o para avisar de peticiones cerradas
    if ( $pMod == 0 ) {

      $mail->addAddress('peticiones@midominio.com');     // Add a recipient
      $mail->AddCC($oData->mail_usuario);     // Add a recipient as Carbon Copy

    }
    else {

      $mail->addAddress($oData->mail_usuario);

    }

    $mail->setLanguage('es', '../config/PHPMailer5.2/language'); // Set language
    $mail->CharSet = 'UTF-8'; // Set codification

    $mail->Subject = 'Peticion de ' . $oData->nombre_usuario . ' ' . $oData->apellido_usuario;

    if ( $pMod == 0 ) {

      $vMensajeCopy='<div><h1> == Detalles de la petición == </h1><p>Solicitante: ' . $oData->nombre_usuario . " " . $oData->apellido_usuario . '</p><p>Fecha: ' . $oData->fecha_solicitud . ' </p><p>ID de petición: ' . $vLastId . '</p><p>Cliente: ' . $oData->spain . '</p><p>Centro de estudios: ' . $oData->nombre_centro . '</p><p>Sistema: ' . $oData->sistema . '</p><p>Unidades: ' . $oData->unidades . '</p><p>Observaciones: ' . $oData->observaciones_peticion . '</p></div>';
      $vMensaje='<div><h1> == Detalles de la petición == </h1><p>Solicitante: ' . $oData->nombre_usuario . " " . $oData->apellido_usuario . '</p><p>Fecha: ' . $oData->fecha_solicitud . ' </p><p>ID de petición: ' . $vLastId . '</p><p>Cliente: ' . $oData->spain . '</p><p>Centro de estudios: ' . $oData->nombre_centro . '</p><p>Sistema: ' . $oData->sistema . '</p><p>Unidades: ' . $oData->unidades . '</p><p>Observaciones: ' . $oData->observaciones_peticion . '</p></div>';

    }
    else {

      $vMensajeCopy='<div><h1> == Detalles de la petición == </h1><p>Solicitante: ' . $oData->nombre_usuario . " " . $oData->apellido_usuario . '</p><p>Fecha: ' . $oData->fecha_solicitud . ' </p><p>ID de petición: ' . $vLastId . '</p><p>Cliente: ' . $oData->spain . '</p><p>Centro de estudios: ' . $oData->nombre_centro . '</p><p>Sistema: ' . $oData->sistema . '</p><p>Unidades: ' . $oData->unidades . '</p><p>Observaciones: ' . $oData->observaciones_peticion . '</p><h1>Estado Actual de la petición:Listo para envio</h1><h2>Ya puede realizar la facturación.</h2></div>';
      $vMensaje='<div><h1> == Detalles de la petición == </h1><p>Solicitante: ' . $oData->nombre_usuario . " " . $oData->apellido_usuario . '</p><p>Fecha: ' . $oData->fecha_solicitud . ' </p><p>ID de petición: ' . $vLastId . '</p><p>Cliente: ' . $oData->spain . '</p><p>Centro de estudios: ' . $oData->nombre_centro . '</p><p>Sistema: ' . $oData->sistema . '</p><p>Unidades: ' . $oData->unidades . '</p><p>Observaciones: ' . $oData->observaciones_peticion . '</p><h1>Estado Actual de la petición:Listo para envio</h1><h2>Ya puede realizar la facturación.</h2</div>';

    }


    $mail->Body    = $vMensaje . $vTablaLibros;
    $mail->AltBody = '== Detalles de la petición ==  Solicitante: ' . $oData->nombre_usuario . " " . $oData->apellido_usuario . ' Fecha: ' . $oData->fecha_solicitud . ' ID de petición: ' . $vLastId . ' SPAIN: ' . $oData->spain . ' Centro de estudios: ' . $oData->nombre_centro . 'Unidades: ' . $oData->unidades . 'Observaciones: ' . $oData->observaciones_peticion;

    $mail->send();
    // if(!$mail->send()) {
    //     echo 'Message could not be sent.';
    //     echo 'Mailer Error: ' . $mail->ErrorInfo;
    // } else {
    //     echo 'Message has been sent';
    // }
  }
    catch (exception $e){
      echo $e->getMessage();
      die();
    }
  }
public function fnCargarPersonasEntregarPen(){//Las personas a las que se les entregan en mano
  try {
    $sql = "SELECT *
            FROM usuario
            WhERE usuario_id IN (77,37,55,169)";
    $vQueryResult = $this->attr00->link->query($sql);

    $rawdata = array(); //creamos un array

    //guardamos en un array multidimensional todos los datos de la consulta
    $i=0;

    while($row = mysqli_fetch_array($vQueryResult))
    {
        $rawdata[$i] = $row;
        $i++;
    }

    //Print array in JSON format
    echo json_encode($rawdata);

    //Cerramos conexión
    $this->attr00->link->close();

} catch (exception $e){
    echo $e->getMessage();
    die();
  }
}
public function fnFormGestionDetallesSacarFechaEntrega(){ //La fecha en la que ehemos marcada como entregada una peticion
  $vPeticionID;
  $sql;
  $vQueryResult;
  $rawdata = array(); //creamos un array
  $i;
  $row;
  try {
    if(isset($_POST['pFiltro']) && !empty($_POST['pFiltro'])){
      $vPeticionID = fnSanitizar01($_POST['pFiltro']);
    }

    $sql = "SELECT fecha_cambio
    FROM CAMBIOESTADO
    WHERE fk_peticion_id = $vPeticionID AND fk_estado_id = 4";

    $vQueryResult = $this->attr00->link->query($sql);

    //guardamos en un array multidimensional todos los datos de la consulta
    $i=0;

    while($row = mysqli_fetch_array($vQueryResult))
    {
        $rawdata[$i] = $row;
        $i++;
    }

    //Print array in JSON format
    echo json_encode($rawdata);

    //Cerramos conexión
    $this->attr00->link->close();

} catch (exception $e){
    echo $e->getMessage();
    die();
  }
}
public function fnEventSaveNewBookAdded(){
    $vSentry=0;
    $VSearchSelectedCod;
    $vInTest01;
    $vInAudio01;
    $vPeticionID;
    $vStatus=0;
    $vQuery;
    $vQueryResult;
    $aStatus=array();
    try{
      if(isset($_POST['pSearchSelectedCod']) && !empty($_POST['pSearchSelectedCod'])){
        $VSearchSelectedCod = fnSanitizar01($_POST['pSearchSelectedCod']);
        $vSentry++;
      }
      if(filter_var(($_POST['pInTest01']), FILTER_VALIDATE_BOOLEAN)){
          $vInTest01 = 1;}
          else{
          $vInTest01 = 0;}

      if(filter_var(($_POST['pInAudio01']),FILTER_VALIDATE_BOOLEAN)){
        $vInAudio01 = 1;}
        else{
          $vInAudio01 = 0;}

      if(isset($_POST['pPeticionId']) && !empty($_POST['pPeticionId'])){
        $vPeticionID = fnSanitizar01($_POST['pPeticionId']);
        $vSentry++;
      }
      if ($vSentry >= 2){ // Compruebo si están los 4 datos que necesito, si es así preparo query y transacción.

          //Preparo transacción
          $this->attr00->link->autocommit(false);

          $vQuery = "INSERT INTO peticion_libro (fk_peticion_id, fk_libro_id, test_factory, audios)
          VALUES ('$vPeticionID', '$VSearchSelectedCod', $vInTest01, $vInAudio01);";

          $vQueryResult = $this->attr00->link->query($vQuery);

          // Valido la transaccion para lanzar un rollback si es necesario
            if ($vQueryResult) {
                  $this->attr00->link->commit(); //Envio datos de la transaccion.
                  $vStatus=1; // Cargo la respuesta con un OK
              }
              else {
                $vStatus=0; // Cargo la respuesta con un FAIL
                $this->attr00->link->rollback();
            }
              $this->attr00->link->autocommit(true); // Dejo valores de autoenvio activados para finalizar la transacción.
        }
      $this->attr00->link->close();
      $aStatus = array(
        'resultado'=>$vStatus
      );
      echo json_encode($aStatus);
    }
    catch (exception $e){
      echo $e->getMessage();
      die();
    }
}
public function fnEliminarLibroDePeticion(){
  $vSentry=0;
  $vCodLibro;
  $vPeticionID;
  $vStatus=0;
  $vQuery;
  $vQueryResult;
  $aStatus=array();
  try{
    if(isset($_POST['pCodLibro']) && !empty($_POST['pCodLibro'])){
      $vCodLibro = fnSanitizar01($_POST['pCodLibro']);
      $vSentry++;
    }

    if(isset($_POST['pPeticionId']) && !empty($_POST['pPeticionId'])){
      $vPeticionID = fnSanitizar01($_POST['pPeticionId']);
      $vSentry++;
    }
    if ($vSentry >= 2){ // Compruebo si están los datos que necesito, si es así preparo query y transacción.

        //Preparo transacción
        $this->attr00->link->autocommit(false);

        $vQuery = "DELETE FROM  peticion_libro
                   WHERE fk_peticion_id = $vPeticionID AND fk_libro_id = $vCodLibro;";

        $vQueryResult = $this->attr00->link->query($vQuery);

        // Valido la transaccion para lanzar un rollback si es necesario
          if ($vQueryResult) {
                $this->attr00->link->commit(); //Envio datos de la transaccion.
                $vStatus=1; // Cargo la respuesta con un OK
            }
            else {
              $vStatus=0; // Cargo la respuesta con un FAIL
              $this->attr00->link->rollback();
          }
            $this->attr00->link->autocommit(true); // Dejo valores de autoenvio activados para finalizar la transacción.
      }
    $this->attr00->link->close();
    $aStatus = array(
      'resultado'=>$vStatus
    );
    echo json_encode($aStatus);
  }
  catch (exception $e){
    echo $e->getMessage();
    die();
  }
}

public function fnDetallesConsultaPorId(){ //Pedimos info para el salvado de datos de asignado,estado, entregado a, en peticion del form de consulta
  try{
    $vFiltro;
    $vQuery;
    $vQueryResult;
    $i=0;
    $aData = array();
    $vLinea;
    if(isset($_POST['pPeticionId'])){$vFiltro = fnSanitizar01($_POST['pPeticionId']);}

    $vQuery="SELECT CONCAT(IfNULL(usu.nombre_usuario, '-'), ' ', IfNULL(usu.apellido_usuario, '-')) AS nombre_entregado_a, nombre_estado, u.nombre_usuario as nombre_usuario_asignado, u.apellido_usuario AS apellido_usuario_asignado
      FROM cambioestado AS ce
      INNER JOIN
        (SELECT MAX(fecha_cambio), cambio_estado_id
        FROM cambioestado
        GROUP BY fk_peticion_id desc)
      AS ce_se ON ce.cambio_estado_id = ce_se.cambio_estado_id
      INNER JOIN estado AS e ON ce.fk_estado_id = e.estado_id
      INNER JOIN peticion AS p ON ce.fk_peticion_id = p.peticion_id
      INNER JOIN usuario AS u ON ce.fk_usuario_id = u.usuario_id
      INNER JOIN usuario AS us ON p.fk_usuario_id = us.usuario_id
      INNER JOIN departamento AS d ON us.fk_departamento_id = d.departamento_id
      LEFT JOIN usuario AS usu ON usu.usuario_id = p.entregado_a
      WHERE p.peticion_id = $vFiltro;";

    $vQueryResult = $this->attr00->link->query($vQuery);

    while($vLinea = mysqli_fetch_array($vQueryResult))
    {
        $aData[$i] = $vLinea;
        $i++;
    }
    echo json_encode($aData);

    $this->attr00->link->close();

  }
  catch (exception $e){
    echo $e->getMessage();
    die();
  }

}

  public function fnMandarMailDetallesFormGestion(){

      $vPeticionId;
      $vQuery;
      $vQueryResult;
      $i=0;
      $aData = array();
      $vLinea;
      $vResult=1; // Fake
      $aStatus=array();

      try{
      if(isset($_POST['pPeticionId'])){$vPeticionId = fnSanitizar01($_POST['pPeticionId']);}

      $vQuery="SELECT estado_id
      FROM cambioestado AS ce
      INNER JOIN
        (SELECT MAX(fecha_cambio), cambio_estado_id
        FROM cambioestado
        GROUP BY fk_peticion_id desc)
      AS ce_se ON ce.cambio_estado_id = ce_se.cambio_estado_id
      INNER JOIN estado AS e ON ce.fk_estado_id = e.estado_id
      INNER JOIN peticion AS p ON ce.fk_peticion_id = p.peticion_id
      WHERE p.peticion_id = $vPeticionId;";

      $vQueryResult = $this->attr00->link->query($vQuery);

      while($vLinea = mysqli_fetch_array($vQueryResult))
      {
          $aData[$i] = $vLinea;
          $i++;
      }

      if ($aData[0]['estado_id'] == "4"){
        $this->fnEnviarMailNuevaPeticion($vPeticionId, 1);

      }else {
        $this->fnEnviarMailNuevaPeticion($vPeticionId, 0);
      }

      $this->attr00->link->close();

      $aStatus = array(
        'resultado'=>$vResult
      );

      echo json_encode($aStatus);


    }
    catch (exception $e){
      echo $e->getMessage();
      die();
    }


  }


}
function fnSanitizar01($pItem){//Eliminamos espacios al principio y al final & caracteres especiales anti XSS, esto ultimo me dio un error si introducen comillas
  return trim(htmlspecialchars($pItem));
  //return trim($pItem);
}
function fnSanitizarTxt($pInput) {//Permite solo los caracteres del patron
  $vSustitucion='';
  $vOutput = "";
  $vPatron = '([^a-zA-Z0-9áéíóúÁÉÍÓÚüÜñÑ\s\:\.\,\;\-\¿\?\!\¡\@\(\)\€\_\º\ª])';
  $vOutput = preg_replace("$vPatron", "$vSustitucion", "$pInput");
  return trim($vOutput);
  }
function fnSanitizarNum($pInput) {//Permite solo los caracteres del patron
  $vSustitucion='';
  $vOutput = "";
  $vPatron = '([^0-9])';
  $vOutput = preg_replace("$vPatron", "$vSustitucion", "$pInput");
  return trim($vOutput);
  }
//   var_dump($item);
//   print_r($item);
?>
