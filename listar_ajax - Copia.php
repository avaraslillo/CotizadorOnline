<?php require_once('Connections/conexioncreacion.php');
mysqli_select_db($database_telegrow_conexion, $telegrow_conexion);

//print urlencode("palavra ".$_GET['digito']."");
$query_ListaIncidencias = "select * from tbl_tien_pedido where strNombre like '%".$_GET['digito']."%' ORDER BY strNombre ASC";
$ListaIncidencias = mysqli_query($query_ListaIncidencias, $telegrow_conexion) or die(mysqli_error());
$row_ListaIncidencias = mysqli_fetch_assoc($ListaIncidencias);

do{
	if ($row_ListaIncidencias['intTipo'] == 1) $valoricono = "<img src=images/telefono.jpg align=absmiddle>";
	if ($row_ListaIncidencias['intTipo'] == 2) $valoricono = "<img src=images/notelefono.jpg  align=absmiddle>";

print urlencode($valoricono."  <a href=pedidos_edit.php?id=".$row_ListaIncidencias['idPedido'].">".$row_ListaIncidencias['strNombre']."</a><br>");
} while ($row_ListaIncidencias = mysqli_fetch_assoc($ListaIncidencias)); 



mysqli_free_result($ListaIncidencias);
?>