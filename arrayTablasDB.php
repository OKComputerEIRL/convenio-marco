<?php

$dataEstadosNoDB = ":;Anulada:Anulada;En proceso de entrega:En proceso de entrega;Entregada:Entregada;Hacer pedido:Hacer pedido;Importacion en espera:Importacion en espera;Observada por anular:Observada por anular;Rechazada:Rechazada";
$editEstadoSelect = ", stype: 'select', searchoptions: {value: '{$dataEstadosNoDB}'} ,edittype:'select', editoptions:{value:'{$dataEstadosNoDB}'}";

$opcBusquedaFecha = 'searchoptions: {sopt: ["eq"], dataInit: function(elem) {$(elem).datepicker({dateFormat: "yy-mm-dd",numberOfMonths: 3,onSelect: function(){$(this).focus();}});}';

$buscar["texto"] = ',searchrules: {string:true}';
$editReadOnly = ',readonly: "readonly", style: "color: red; text-weight: bold; font-size: 120%;"';
$editDateTimePickerRules = ', editoptions:{dataEvents:[{type: "focus", fn: function(){$("#"+this.id).datepicker({dateFormat: "yy-mm-dd",numberOfMonths: 2});}}]}';
$editTextHidden = ', editable:true, editrules:{edithidden:true}';
$editTextArea = ', edittype:"textarea", editoptions: {rows:"3",cols:"40"}';
function editTextArea($rows,$cols){
    return ", edittype:'textarea', editoptions: {rows:'{$rows}',cols:'{$cols}'}";
}
include_once 'ajax/returnCorporativos.php';

$editSelect = " ,edittype:'select', editoptions:{value:'{$dataReturnCorporativos}'}";

include_once 'ajax/returnCategorias.php';

$tGeneral = array();
$tGeneral["idOrden"]                = array(1, "Id Orden",          ',hidden:true, width: 45');
$tGeneral["ordenElectronica"]       = array(1, "N. O. Electronica", ',width: 40, editable: true, editoptions: {size: 20'.$editReadOnly.'}'.$buscar["texto"]);
$tGeneral["Categoria"]              = array(1, "Categoria",         ',width: 70, stype: "select", searchoptions: {value: ":;'.$dataReturn.'"}');
$tGeneral["Entidad"]                = array(1, "Entidad",           ',width: 100, searchrules: {string:true}');
$tGeneral["FecPublicada"]           = array(1, "Fec.Publicada",     ',width: 30, align: "right", editable: true, editoptions: {size: 20'.$editReadOnly.'}, '.$opcBusquedaFecha.'}');
$tGeneral["FecAceptada"]            = array(1, "Fec.Aceptada",      ',hidden:true, width: 45'.$editTextHidden.$editDateTimePickerRules);
$tGeneral["Plazo"]                  = array(1, "Plazo",             ',width: 10, align: "right",editable:true, editoptions: {size: 20'.$editReadOnly.'}');
$tGeneral["FecVencimiento"]         = array(1, "Fec.Vencimiento",   ',width: 45, align: "right", '.$opcBusquedaFecha.'}');
$tGeneral["NumFactura"]             = array(1, "N Factura",         ',hidden:true, width: 45'.$editTextHidden);
$tGeneral["NumGuiaRemision"]        = array(1, "N Guia",            ',hidden:true, width: 45'.$editTextHidden);
$tGeneral["Monto"]                  = array(1, "Monto",             ',hidden:true,width: 30'.$editTextHidden.', editoptions: {size:30'.$editReadOnly.'}');
$tGeneral["MontoIGV"]               = array(1, "Monto Inc. IGV",    ',width: 30, align: "right",editable:true, editoptions: {size: 20'.$editReadOnly.'}');
$tGeneral["FecGuia"]                = array(1, "Fec. Guia",         ',hidden:true, width: 45'.$editTextHidden.$editDateTimePickerRules);
$tGeneral["NumOrdenCompra"]         = array(1, "N Orden Compra",    ',hidden:true, width: 45'.$editTextHidden);
$tGeneral["Garantia"]               = array(1, "Garantia",          ',hidden:true, width: 45'.$editTextHidden);
$tGeneral["Estado"]                 = array(1, "Estado",            ',width: 45, editable: true'.$editEstadoSelect);
$tGeneral["EstadoCobro"]            = array(1, "Estado Cobro",      ',hidden:true, width: 45'.$editTextHidden);
$tGeneral["UserCorporativo"]        = array(1, "Corporativo",       ',hidden:true, width: 45'.$editTextHidden.$editSelect);
$tGeneral["Contacto"]               = array(1, "Contacto",          ',hidden:true, width: 45'.$editTextHidden);
$tGeneral["DatosContacto"]          = array(1, "Datos Contacto",    ',hidden:true, width: 45'.$editTextHidden.editTextArea(2,40));
$tGeneral["Siaf"]                   = array(1, "Siaf",              ',hidden:true, width: 45'.$editTextHidden);
$tGeneral["Aviso"]                  = array(1, "Aviso",             ',hidden:true, width: 45'.$editTextHidden);
$tGeneral["Observacion"]            = array(1, "Observacion",       ',width: 45, editable:true'.$buscar["texto"].editTextArea(3,40));
$tGeneral["UrlPDF"]                 = array(1, "Url PDF",           ',hidden:true, width: 45');
$tGeneral["idOrdenDigital"]         = array(1, "idOrden Seace",     ',hidden:true, width: 45');
$tGeneral["OpcDescargar"]           = array(1, "Ver",               ',hidden:false, search: false, width: 20, align: "center"');

$tProductos = array();
$tProductos["idOrden"]              = array(0,"Id Orden",', width: 45');
$tProductos["ordenElectronica"]     = array(0,"N. O. Electronica",', width: 45');
$tProductos["Ficha"]                = array(1,"Descripcion",', width: 100');
$tProductos["Marca"]                = array(1,"Marca",', width: 60, align: "center"');
$tProductos["Modelo"]               = array(1,"Modelo",', width: 60, align: "center"');
$tProductos["PrecioUnitario"]       = array(1,"P. Unitario",', width: 30, align: "right"');
$tProductos["Cantidad"]             = array(1,"Cantidad",', width: 10, align: "right"');
$tProductos["PrecioTotal"]          = array(1,"P. Total",', width: 30, align: "right"');
