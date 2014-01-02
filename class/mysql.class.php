<?php
//Clase conexion mysql
class mysql {

	var $server = "";
	var $user = "";
	var $pass = "";
	var $data_base = "";
	var $conexion;
	var $flag = false;
	var $error_conexion = "Error en la conexion a MYSQL";

	function connect(){
		$this->conexion = @mysql_connect($this->server,$this->user,$this->pass) or die($this->error_conexion);
		$this->flag = true;
		@mysql_query("SET NAMES utf8");
		return $this->conexion;
	}

	function close(){
		if($this->flag == true){
			@mysql_close($this->conexion);
		}
	}

	function query($query){
		return @mysql_db_query($this->data_base,$query);
	}

	function f_obj($query){
		return @mysql_fetch_object($query);
	}

	function f_array($query){
		return @mysql_fetch_assoc($query);
	}

	function f_num($query){
		return @mysql_num_rows($query);
	}

	function select($db){
		$result = @mysql_select_db($db,$this->conexion);
		if($result){
			$this->data_base = $db;
			return true;
		}else{
			return false;
		}
	}

	function free_sql($query){
		mysql_free_result($query);
	}
        function freeQuery($query){
            return mysql_query($query)or die(mysql_error());
        }
}
