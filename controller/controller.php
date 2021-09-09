<?php
//Importo clases de model.php
include '../model/model.php';
//Preparo el objeto que tiene acceeso a las funciones del modelo
$oModel = new c_model();

// obtengo las peticiones que vienen del front
extract($_REQUEST);
    switch ($act) {

    case 'fnCargarOficinas':
        $oModel->fnCargarOficinas();
        break;
    case 'fnConsultarSolicitantes':
        $oModel->fnConsultarSolicitantes($id_seleccionado);
        break;
    case 'fnBusquedaAuto':
        $oModel->fnBusquedaAuto($keyword);
        break;
    case 'fnInsertarPeticion':
        $oModel->fnInsertarPeticion();
        break;
    case 'fnConsultarPeticion':
        $oModel->fnConsultarPeticion();
        break;
    case 'fnCargarEstados':
        $oModel->fnCargarEstados();
        break;
    case 'fnMostrarCuadroDetallesConsulta':
        $oModel->fnMostrarCuadroDetallesConsulta();
        break;
    case 'fnMostrarCuadroDetallesConsultaLibros':
        $oModel->fnMostrarCuadroDetallesConsultaLibros();
        break;
    case 'fnMostrarCuadroDetallesConsultaEstado':
        $oModel->fnMostrarCuadroDetallesConsultaEstado();
        break;
    case 'fnMostrarCuadroDetallesConsultaHistorico':
        $oModel->fnMostrarCuadroDetallesConsultaHistorico();
        break;
    case 'fnConsultarPeticionFormGestion':
        $oModel->fnConsultarPeticionFormGestion();
        break;
    case 'fnUpdatePeticionAsigAndEstado':
        $oModel->fnUpdatePeticionAsigAndEstado();
        break;
    case 'fnUpdateObservaciones':
        $oModel->fnUpdateObservaciones();
        break;
    case 'fnCargarPersonasEntregarPen':
        $oModel->fnCargarPersonasEntregarPen();
        break;
    case 'fnFormGestionDetallesSacarFechaEntrega':
        $oModel->fnFormGestionDetallesSacarFechaEntrega();
        break;
    case 'fnEventSaveNewBookAdded':
        $oModel->fnEventSaveNewBookAdded();
        break;
    case 'fnEliminarLibroDePeticion':
        $oModel->fnEliminarLibroDePeticion();
        break;
    case 'fnDetallesConsultaPorId':
        $oModel->fnDetallesConsultaPorId();
        break;
    case 'fnMandarMailDetallesFormGestion':
        $oModel->fnMandarMailDetallesFormGestion();
        break;
    default:
        echo "Act de form no encontrado en controller";
    }
//}//No cierro la etiqueta php para evitar problemas de caracteres sueltos, incluidos saltos de lineas y espacios
