<?php
class CM extends mysql {

    function __construct() {

    }
    function listarCategorias(){
        $query = "SELECT * FROM categorias";
        return parent::f_obj(parent::query($query));
    }

}