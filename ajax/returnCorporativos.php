<?php
include_once 'config.php';
$dataCorporativosQuery = $mysql->query("SELECT * FROM corporativos");
$nRegistrosCorporativos = $mysql->f_num($dataCorporativosQuery);
$catNombres = array();
$dataReturnCorporativos = "";
while ($dataCorporativos = $mysql->f_obj($dataCorporativosQuery)) {
    $catNombres[] = $dataCorporativos->User;
    $dataReturnCorporativos .= $dataCorporativos->User . ":" . $dataCorporativos->Nombres . " " . $dataCorporativos->Apellidos . ";";
}
$dataReturnCorporativos = substr($dataReturnCorporativos, 0, -1);
//echo $dataReturn;