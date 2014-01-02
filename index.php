<!DOCTYPE html >
<?php include_once 'config.php'; ?>
<html lang="es">
    <head>
        <title>LISTA DE ORDENES DE COMPRA - SE@CE</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/<?php echo $theme_widget; ?>/jquery-ui.min.css" /> 
        <link rel="stylesheet" type="text/css" href="css/ui.jqgrid.css" />
        <script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="js/grid.locale-es.js" type="text/javascript"></script>
        <script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui-1.9.1.custom.min.js" type="text/javascript"></script>
        
    </head>
    <body>
    <table id="ListaProductos"></table>
    <div id="ListaProductosPager"></div>
    <?php include_once 'subgrid_grid.php'; ?>
    <!-- <script src="subgrid_grid.js" type="text/javascript"></script> -->
    <br />
</body>
</html>
