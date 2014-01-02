<?php
$legendJS = "";
$colsModel = "";
foreach ($tGeneral as $key => $data) {
    $estado = $data[0];
    $descripcion = $data[1];
    if($estado != 0){
        $legendJS .= "'".$data[1]. "',";
        $colsModel .= "{name:'{$key}', index:'{$key}'".$data[2]."},";
    }
}
$legendJS = substr($legendJS,0,-1);
$colsModel = substr($colsModel,0,-1);

$legendJS_subGrid = "";
$colsModel_subGrid = "";
foreach ($tProductos as $keySubGrid => $dataSubGrid) {
    if($dataSubGrid[0] != 0){
         $legendJS_subGrid .= "'".$dataSubGrid[1]. "',";
         $colsModel_subGrid .= "{name:'{$keySubGrid}', index:'{$keySubGrid}'".$dataSubGrid[2]."},";
    }
}
$legendJS_subGrid = substr($legendJS_subGrid,0,-1);
$colsModel_subGrid = substr($colsModel_subGrid,0,-1);
//echo $legendJS;
?>
<script type="text/javascript">

jQuery("#ListaProductos").jqGrid({
    //url:'server.php?q=1',
    url: 'ajax/returnOrdenes.php',
    editurl: 'ajax/editOrdenes.php',
    mtype: 'POST',
    
    datatype: "json",
    height: "auto",
    autowidth: true,
    //'Ord. Electronica', 'Categoria', 'Entidad', 'Fech. Publicacion', 'Plazo', 'Monto'
    colNames: [<?php echo $legendJS; ?>],
    colModel: [<?php echo $colsModel; ?>],
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
        datosFila = $("#ListaProductos").getRowData(row_id);
        //alert(row_id);
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
            url: "ajax/returnProductos.php?idOrden=" + row_id,
            datatype: "json",
            colNames: [<?php echo $legendJS_subGrid; ?>],
            colModel: [<?php echo $colsModel_subGrid; ?>],
            rowNum: 20,
            pager: pager_id,
            sortname: 'Cantidad',
            sortorder: "asc",
            autowidth: true,
            caption: datosFila.Categoria +" > " + datosFila.ordenElectronica,
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
{width: 400, left: 250, modal: true, viewPagerButtons: false, reloadAfterSubmit: true, resize: false, recreateForm: true, closeAfterEdit: true,
afterSubmit:function(data,postd){
        alert(data.responseText);
				console.log(data);
				console.log(postd);
				return {0:true};
			},
			afterComplete:function(data,postd){
				return true;
			}
}, //opciones edit
        {}, //opciones add
        {}, //opciones del
        {multipleSearch: false, closeAfterSearch: true, closeOnEscape: true}//opciones search
).jqGrid("filterToolbar");
//jQuery("#listsg11");//.jqGrid('navGrid', '#pagersg11', {add: true, edit: true, del: true});
</script>