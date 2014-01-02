<?php
include_once '../config.php';
if (isset($_POST['oper'])) {
    $Aviso = $_POST['Aviso'];
    $Contacto = $_POST['Contacto'];
    $DatosContacto = $_POST['DatosContacto'];
    $Estado = $_POST['Estado'];
    $EstadoCobro = $_POST['EstadoCobro'];
    $FecAceptada = $_POST['FecAceptada'];
    $FecGuia = $_POST['FecGuia'];

    $Garantia = $_POST['Garantia'];

    $NumFactura = $_POST['NumFactura'];
    $NumGuiaRemision = $_POST['NumGuiaRemision'];
    $NumOrdenCompra = $_POST['NumOrdenCompra'];
    $Observacion = $_POST['Observacion'];

    $Siaf = $_POST['Siaf'];
    $UserCorporativo = $_POST['UserCorporativo'];
    $id = $_POST['id'];
    $oper = $_POST['oper'];

    
    if($oper == "edit"){
        $queryTXT ="UPDATE general SET "
                . "Contacto='{$Contacto}', "
                . "Aviso='{$Aviso}', "
                . "DatosContacto = '{$DatosContacto}', "
                . "Estado = '{$Estado}', "
                . "EstadoCobro = '{$EstadoCobro}', "
                . "FecAceptada = '{$FecAceptada}', "
                . "FecGuia = '{$FecGuia}', "

                . "Garantia = '{$Garantia}', "

                . "NumFactura = '{$NumFactura}', "
                . "NumGuiaRemision = '{$NumGuiaRemision}', "
                . "NumOrdenCompra = '{$NumOrdenCompra}', "
                . "Observacion = '{$Observacion}', "

                . "Siaf = '{$Siaf}', "
                . "UserCorporativo = '{$UserCorporativo}' "

                . " WHERE idOrden = '{$id}'";
                if($mysql->freeQuery($queryTXT)){
                    echo "Modificacion Exitosa";
                }
    }
}
