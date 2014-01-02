<?php
include_once 'config.php';
$dataCategoriasQuery = $mysql->query("SELECT * FROM categorias");
$nRegistrosCategorias = $mysql->f_num($dataCategoriasQuery);
$catNombres = array();
$dataReturn = "";
while ($dataCategoria = $mysql->f_obj($dataCategoriasQuery)) {
    $catNombres[] = $dataCategoria->Nombre;
    $dataReturn .= $dataCategoria->Nombre . ":" . $dataCategoria->Nombre . ";";
}
$dataReturn = substr($dataReturn, 0, -1);
//echo $dataReturn;