<?php

?>
        <script>
jQuery("#ListaProductos").jqGrid({
    //url:'server.php?q=1',
    url: 'ajax/returnOrdenes.php',
    datatype: "json",
    height: "auto",
    autowidth: true,
    colNames: ['Ord. Electronica', 'Categoria', 'Entidad', 'Fech. Publicacion', 'Plazo', 'Monto'],
    colModel: [
        {name: 'ordenElectronica', index: 'ordenElectronica', width: 45,searchrules: {string:true}},
        {name: 'Categoria', index: 'Categoria', width: 90, stype: "select", searchoptions: {value: ":;Accesorios de Impresion:Accesorios de Impresion;Computadoras de Escritorio:Computadoras de Escritorio;Computadoras Portatiles:Computadoras Portatiles;Consumibles:Consumibles;Escaneres:Escaneres;Impresoras:Impresoras;Proyectores:Proyectores"}},
        {name: 'Entidad', index: 'Entidad', width: 100, searchrules: {string:true}},
        {name: 'FecPublicada', index: 'FecPublicada', width: 50, searchoptions: {sopt: ['eq'], dataInit: function(elem) {
                                    $(elem).datepicker({dateFormat: 'yy-mm-dd',numberOfMonths: 3,onSelect: function(){$(this).focus();}});
                                }}},
        {name: 'Plazo', index: 'Plazo', width: 80, align: "right",editable:true},
        {name: 'Monto', index: 'Monto', width: 80, align: "right"}
    ],
    rowNum: 20,
    rowList: [20, 30, 40, 50],
    pager: '#ListaProductosPager',
    sortname: 'FecPublicada',
    viewrecords: true,
    altRows: true,
    sortorder: "desc",
    multiselect: false,
    subGrid: true,
    caption: "OK Computer EIRL",
    subGridRowExpanded: function(subgrid_id, row_id) {
        // we pass two parameters
        // subgrid_id is a id of the div tag created whitin a table data
        // the id of this elemenet is a combination of the "sg_" + id of the row
        // the row_id is the id of the row
        // If we wan to pass additinal parameters to the url we can use
        // a method getRowData(row_id) - which returns associative array in type name-value
        // here we can easy construct the flowing
        var subgrid_table_id, pager_id;
        subgrid_table_id = subgrid_id + "_t";
        pager_id = "p_" + subgrid_table_id;
        $("#" + subgrid_id).html("<table id='" + subgrid_table_id + "' class='scroll'></table><div id='" + pager_id + "' class='scroll'></div>");
        jQuery("#" + subgrid_table_id).jqGrid({
            url: "subgrid.php?q=2&id=" + row_id,
            datatype: "xml",
            colNames: ['No', 'Item', 'Qty', 'Unit', 'Line Total'],
            colModel: [
                {name: "num", index: "num", width: 80, key: true},
                {name: "item", index: "item", width: 130},
                {name: "qty", index: "qty", width: 70, align: "right"},
                {name: "unit", index: "unit", width: 70, align: "right"},
                {name: "total", index: "total", width: 70, align: "right", sortable: false}
            ],
            rowNum: 20,
            pager: pager_id,
            sortname: 'num',
            sortorder: "asc",
            height: '100%'
        });
        jQuery("#" + subgrid_table_id).jqGrid('navGrid', "#" + pager_id, {edit: false, add: false, del: false})
    },
    subGridRowColapsed: function(subgrid_id, row_id) {
        // this function is called before removing the data
        //var subgrid_table_id;
        //subgrid_table_id = subgrid_id+"_t";
        //jQuery("#"+subgrid_table_id).remove();
    }
}).navGrid('#ListaProductosPager', {view: false, del: false, add: false, edit: true, search: false},
{}, //opciones edit
        {}, //opciones add
        {}, //opciones del
        {multipleSearch: false, closeAfterSearch: true, closeOnEscape: true}//opciones search
).jqGrid("filterToolbar");
//jQuery("#listsg11");//.jqGrid('navGrid', '#pagersg11', {add: true, edit: true, del: true});
</script>