<?php

include_once '../config.php';

//Creamos un arreglo con los datos que envia JqGrid
$post = array(
    'limit' => (isset($_REQUEST['rows'])) ? $_REQUEST['rows'] : '',
    'page' => (isset($_REQUEST['page'])) ? $_REQUEST['page'] : '',
    'orderby' => (isset($_REQUEST['sidx'])) ? $_REQUEST['sidx'] : '',
    'orden' => (isset($_REQUEST['sord'])) ? $_REQUEST['sord'] : '',
    'search' => (isset($_REQUEST['_search'])) ? $_REQUEST['_search'] : '',
);
$se = "";
//creamos la consulta de busqueda. 
if ($post['search'] == 'true') {
    $b = array();
    //Usamos la funci{on elements para crear un arreglo con los datos que van a ser para buscar por like
    $search['like'] = elements(array('Categoria', 'Entidad','ordenElectronica','FecPublicada','Plazo','FecVencimiento','Monto','Estado','Observacion'), $_REQUEST);
    //haciendo un recorrido sobre ellos vamos creando al consulta.
    foreach ($search['like'] as $key => $value) {
        if ($value != false)
            $b[] = "$key like '%$value%'";
    }
    //Usamos la funci{on elements para crear un arreglo con los datos que van a ser para buscar por like
    $search['where'] = elements(array('fecha', 'cantidad', 'taza', 'cliente'), $_REQUEST);
    //haciendo un recorrido sobre ellos vamos creando al consulta.
    foreach ($search['where'] as $key => $value) {
        if ($value != false)
            $b[] = "$key = '$value'";
    }
    //Creamos la consulta where
    $se = " where " . implode(' and ', $b);
}
//Realizamos la consulta para saber el numero de filas que hay en la tabla con los filtros
$query = $mysql->query("select count(*) as count from general" . $se);
if (!$query){
    echo mysql_error();
}
//$count = mysql_result($query, 0);
$count = $mysql->f_obj($query);
$count = $count->count;
if ($count > 0 && $post['limit'] > 0) {
    //Calculamos el numero de paginas que tiene el sistema
    $total_pages = ceil($count / $post['limit']);
    if ($post['page'] > $total_pages)
        $post['page'] = $total_pages;
    //calculamos el offset para la consulta mysql.
    $post['offset'] = $post['limit'] * $post['page'] - $post['limit'];
} else {
    $total_pages = 0;
    $post['page'] = 0;
    $post['offset'] = 0;
}
//Creamos la consulta que va a ser enviada de una ves con la parte de filtrado
$sql = "SELECT * FROM general  " . $se;
if (!empty($post['orden']) && !empty($post['orderby']))
//Añadimos de una ves la parte de la consulta para ordenar el resultado
    $sql .= " ORDER BY $post[orderby] $post[orden] ";
if ($post['limit'] && $post['offset'])
    $sql.=" limit $post[offset], $post[limit]";
//añadimos el limite para solamente sacar las filas de la apgina actual que el sistema esta consultando
elseif ($post['limit'])
    $sql .=" limit 0,$post[limit]";


$query = $mysql->query($sql);
if (!$query)
    echo mysql_error();
$result = array();
$i = 0;
while ($row = $mysql->f_obj($query)) {
    $result[$i]['id'] = $row->idOrden;
    ///////////
    $exttension = pathinfo($row->UrlPDF, PATHINFO_EXTENSION);
    $ArchivoLocal = '../PDF/' . $row->Categoria . '/' . $row->ordenElectronica . '.' . $exttension;
    if (file_exists($ArchivoLocal)){
        $urlPDF = 'PDF/' . $row->Categoria . '/' . $row->ordenElectronica . '.' . $exttension;
    } else {
        $urlPDF = $row->UrlPDF;
    }
    //$urlPDF = (file_exists($ArchivoLocal))? $ArchivoLocal : /*$row->UrlPDF*/ "HOLA";
    ///////////////////////
    $result[$i]['cell'] = array(
        $row->idOrden,
        $row->ordenElectronica,
        $row->Categoria,
        $row->Entidad,
        $row->FecPublicada,
        $row->FecAceptada,
        $row->Plazo,
        $row->FecVencimiento,
        $row->NumFactura,
        $row->NumGuiaRemision,
        $row->Monto,
        round($row->Monto * 1.18,2),
        $row->FecGuia,
        $row->NumOrdenCompra,
        $row->Garantia,
        $row->Estado,
        $row->EstadoCobro,
        $row->UserCorporativo,
        $row->Contacto,
        $row->DatosContacto,
        $row->Siaf,
        $row->Aviso,
        $row->Observacion,
        $row->UrlPDF,
        $row->idOrdenDigital,
        "<a href='http://servidor/conveniomarco/HTML%20Digital/{$row->Categoria}/{$row->ordenElectronica}.htm' target='_blank'><img src='img/iconhtml.gif' height='70%' /></a> <a href='{$urlPDF}' target='_blank'><img src='img/iconpdf.gif' height='70%' /></a>"
        );
    $i++;
}
//Asignamos todo esto en variables de json, para enviarlo al navegador.
@$json->rows = $result;
$json->total = $total_pages;
$json->page = $post['page'];

$json->records = $count;
echo json_encode($json);

//mysql_close($link);

function elements($items, $array, $default = FALSE) {
    $return = array();
    if (!is_array($items)) {
        $items = array($items);
    }
    foreach ($items as $item) {
        if (isset($array[$item])) {
            $return[$item] = $array[$item];
        } else {
            $return[$item] = $default;
        }
    }
    return $return;
}

$asXML = false;
if ($asXML) {
    @$page = $_REQUEST['page']; // get the requested page
    @$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
    @$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
    @$sord = $_REQUEST['sord']; // get the direction

    $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
    if ($totalrows) {
        $limit = $totalrows;
    } else {
        $limit = 1;
    }
    $wh = "";
    $result = $mysql->query("SELECT COUNT(*) AS count FROM general");
//$result = mysql_query("SELECT COUNT(*) AS count, SUM(amount) AS amount, SUM(tax) AS tax, SUM(total) AS total FROM invheader a, clients b WHERE a.client_id=b.client_id " . $wh);
    $row = $mysql->f_array($result);
//$row = mysql_fetch_array($result, MYSQL_ASSOC);
    $count = $row['count'];
    if ($count > 0) {
        $total_pages = ceil($count / $limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages)
        $page = $total_pages;
    $start = $limit * $page - $limit; // do not put $limit*($page - 1)
    if ($start < 0) {
        $start = 0;
    }
    $result = $mysql->query("SELECT ordenElectronica,Categoria, Entidad, FecPublicada, Plazo,Monto FROM general");
//$SQL = "SELECT a.id, a.invdate, b.name, a.amount,a.tax,a.total,a.note FROM invheader a, clients b WHERE a.client_id=b.client_id" . $wh . " ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . " , " . $limit;
//$result = mysql_query($SQL) or die("Couldn t execute query." . mysql_error());
    if (stristr($_SERVER["HTTP_ACCEPT"], "application/xhtml+xml")) {
        header("Content-type: application/xhtml+xml;charset=utf-8");
    } else {
        header("Content-type: text/xml;charset=utf-8");
    }
    $et = ">";
    echo "<?xml version='1.0' encoding='utf-8'?$et\n";
    echo "<rows>";
    echo "<page>" . $page . "</page>";
    echo "<total>" . $total_pages . "</total>";
    echo "<records>" . $count . "</records>";
//echo "<userdata name='tamount'>" . $row['amount'] . "</userdata>";
//echo "<userdata name='ttax'>" . $row['tax'] . "</userdata>";
//echo "<userdata name='ttotal'>" . $row['total'] . "</userdata>";
// be sure to put text data in CDATA
    while ($orden = $mysql->f_obj($result)) {
        echo "<row id='" . $orden->ordenElectronica . "'>";
        echo "<cell>" . $orden->ordenElectronica . "</cell>";
        echo "<cell>" . $orden->Categoria . "</cell>";
        echo "<cell>" . $orden->Entidad . "</cell>";
        echo "<cell>" . $orden->FecPublicada . "</cell>";
        echo "<cell>" . $orden->Plazo . "</cell>";
        echo "<cell>" . $orden->Monto . "</cell>";
        //echo "<cell><![CDATA[" . $row[name] . "]]></cell>";
        //echo "<cell>" . $row[amount] . "</cell>";
        //echo "<cell>" . $row[tax] . "</cell>";
        //echo "<cell>" . $row[total] . "</cell>";
        //echo "<cell><![CDATA[" . $row[note] . "]]></cell>";
        echo "</row>";
    }
    /*
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      echo "<row id='" . $row[id] . "'>";
      echo "<cell>" . $row[id] . "</cell>";
      echo "<cell>" . $row[invdate] . "</cell>";
      echo "<cell><![CDATA[" . $row[name] . "]]></cell>";
      echo "<cell>" . $row[amount] . "</cell>";
      echo "<cell>" . $row[tax] . "</cell>";
      echo "<cell>" . $row[total] . "</cell>";
      echo "<cell><![CDATA[" . $row[note] . "]]></cell>";
      echo "</row>";
      }
     *
     */
    echo "</rows>";
}