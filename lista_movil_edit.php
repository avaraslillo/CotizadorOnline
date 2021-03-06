<?php require_once('Connections/ConexionCotizador.php');
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "ingresoadmin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "ingresoadmin.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType,  $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

?>
<?php
mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_ListaMoviles = "SELECT movil.MODELO, imagen.RUTA_IMAGEN, movil.ID_MOVIL FROM movil, imagen WHERE  imagen.ORDEN_IMAGEN='1' AND imagen.ID_MOVIL=movil.ID_MOVIL GROUP BY movil.ID_MOVIL";
$ListaMoviles = mysqli_query($ConexionCotizador, $query_ListaMoviles) or die(mysqli_error($ListaMoviles));
$row_ListaMoviles = mysqli_fetch_assoc($ListaMoviles);
$totalRows_ListaMoviles = mysqli_num_rows($ListaMoviles);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CotizPhone-Administración</title>
<link rel="stylesheet" type="text/css" href="estilos/estiloadmin.css" />
<link rel="stylesheet" type="text/css" href="estilos/menu.css" />
<link rel="stylesheet" type="text/css" href="estilos/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="scripts/funciones.js"></script>
</head>

<body>
<div id="cabecera-admin">
<img src="imagenes/logo/logo.PNG" width="140" height="152" style="position:relative; left:45%;"  /></div>  
</div>
<div id="cabecera-admin2">
<div id="cabecera-admin2">
<span style="float:right; margin-right:15px; "><a href="<?php echo $logoutAction ?>" style="color:#FFF;">Cerrar Sesión</a></span>
<h3 style="position:relative; top:40%; color:#FFF; font:Arial, Helvetica, sans-serif; font-size:24px; text-align:center;">Administración</h3>
</div>
<div id="ZonaCentral">
<div class="sidenav">
<div id="menu" class="vertical-menu">
		<ul>
        <li class="admin"><a href="admin.php">Volver al Home</a></li>
    		<li class="admin"><a href="add_movil.php">Agregar nuevo móvil</a></li>
        	<li class="admin"><a href="lista_movil_edit.php">Modificar información de un móvil</a></li>
        	<li class="admin"><a href="add_marca.php">Agregar nueva marca</a></li>
        	<li class="admin">Eliminar marca</li>        	<li class="admin"><a href="add_tienda.php">Agregar nueva tienda</a> </li>
        	<li class="admin">Eliminar tienda </li>                                       
    	</ul>
    </div>
</div>
<div id="PanelAdmin">
	<div id="ListaMoviles">
 		<?php
			if($totalRows_ListaMoviles==0){
	print ("<h3 style='padding-left:10px; text-align:center;'>NO HAY RESULTADOS</h3>");
	}		

	else{
		do { 
	print ('<div id="Resultado">
<img src="'.$row_ListaMoviles['RUTA_IMAGEN'].'" width="60%" height="60%" />
<br /><span style="position:inherit; left:15%;">'.$row_ListaMoviles['MODELO'].'</span><br /> <span style="float:left; margin-left:20px; "><a href=edit_movil.php?IDMovil='.$row_ListaMoviles['ID_MOVIL'].' style="color:#000;">Editar</a></span> <span style="float:right; margin-right:20px; "><a onclick="return ConfirmarEliminacion();" href="delete_movil.php?IDMovil='.$row_ListaMoviles['ID_MOVIL'].'"style="color:#000;">Eliminar</a></span></div>');
	} while ($row_ListaMoviles = mysqli_fetch_assoc($ListaMoviles));
}	

		?>
 
    </div>
</div>            
</div>
   <div id="footer">
  Proyecto de Fin de Grado <br />
  Universidad Europea de Madrid-Ingeniería Civil Informática <br />
  Alex Antonio Varas Lillo-2017
  </div> 
</body>
</html>
<?php
mysqli_free_result($MostrarMarcas);

mysqli_free_result($ListaMoviles);

mysqli_free_result($MostrarMarcas);
?>
