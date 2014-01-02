<?php

ini_set('max_execution_time', 0);
$done = true;
if ($done == true) {
    include_once 'config.php';
    $DataQuery = $mysql->query("SELECT idOrden, ordenElectronica, Categoria, UrlPDF FROM general");
    while ($dataGeneral = $mysql->f_obj($DataQuery)) {
        $ArchivoRemoto = $dataGeneral->UrlPDF;
        $nOrdenElectronica = $dataGeneral->ordenElectronica;
        $categoria = $dataGeneral->Categoria;
        $exttension = pathinfo($ArchivoRemoto, PATHINFO_EXTENSION);
        $ArchivoLocal = 'PDF/' . $categoria . '/' . $nOrdenElectronica . '.' . $exttension;
        if (file_exists($ArchivoLocal)) {
            echo $dataGeneral->idOrden . "El fichero $ArchivoLocal existe <br />";
        } else {
            $datos = file_get_contents($ArchivoRemoto) or die("No se piede leer el archivo remoto");
            file_put_contents($ArchivoLocal, $datos) or die("No se puede escribir el archivo local");
            echo $dataGeneral->idOrden . "El archivo [$ArchivoRemoto] fue copiado a [$ArchivoLocal] <br>";
        }
    }
}

