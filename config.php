<?php
/*
 * Configuraciones Generales
 */

$theme_widget = "ui-lightness";


$mysql_data["server"] = "localhost";
$mysql_data["port"]= 3306;
$mysql_data["user"]= "antony";
$mysql_data["pwd"]="1234";

include_once 'class/mysql.class.php';

//Conectamos con mysql
$mysql = new mysql;
$mysql->server = $mysql_data["server"];
$mysql->user   = $mysql_data["user"];
$mysql->pass   = $mysql_data["pwd"];
$mysql->connect();
$mysql->select("conveniomarco");
include_once 'arrayTablasDB.php';

