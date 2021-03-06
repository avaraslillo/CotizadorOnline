<?php require_once('Connections/ConexionCotizador.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO movil (ID_MOVIL, MARCA, MODELO, TAMANO_PANTALLA, SISTEMA_OPERATIVO, CAMARA_TRASERA, CAMARA_FRONTAL, PROCESADOR, MEMORIA_INTERNA, EXPANSION_DE_MEMORIA, PESO, CONECTIVIDAD, BATERIA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_MOVIL'], "text"),
                       GetSQLValueString($_POST['MARCA'], "text"),
                       GetSQLValueString($_POST['MODELO'], "text"),
                       GetSQLValueString($_POST['TAMANO_PANTALLA'], "text"),
                       GetSQLValueString($_POST['SISTEMA_OPERATIVO'], "text"),
                       GetSQLValueString($_POST['CAMARA_TRASERA'], "text"),
                       GetSQLValueString($_POST['CAMARA_FRONTAL'], "text"),
                       GetSQLValueString($_POST['PROCESADOR'], "text"),
                       GetSQLValueString($_POST['MEMORIA_INTERNA'], "text"),
                       GetSQLValueString($_POST['EXPANSION_DE_MEMORIA'], "int"),
                       GetSQLValueString($_POST['PESO'], "text"),
                       GetSQLValueString($_POST['CONECTIVIDAD'], "text"),
                       GetSQLValueString($_POST['BATERIA'], "text"));

  mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
  $Result1 = mysql_query($insertSQL, $ConexionCotizador) or die(mysql_error());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="estilos/estiloadmin.css" />
<link rel="stylesheet" type="text/css" href="estilos/menu.css" />
<link rel="stylesheet" type="text/css" href="estilos/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>

<body>
	<div id="cabecera-admin">
<img src="imagenes/logo/logo.PNG" width="140" height="152" style="position:relative; left:45%;"  /></div>  
	</div>
	<div id="cabecera-admin2">
	</div>
	<div id="ZonaCentral">

		<div id="PanelIngreso">
			<div id="IngresoAdmin">
            	<h4 style="margin-left:10px;">Ingreso administrativo</h4><br />
                <form name="AccesoAdmin" method="post">
                <span style="margin-left:10px;">                
            	<tr><th scope="row">Nombre de usuario</th> <td><input name="UsuarioAdmin" type="text" size="30" maxlength="30" /></td></tr>
                </span>
                <br />
              	<span style="margin-left:10px;">  
                <tr><th scope="row">Contraseña</th> <td><input name="Contrasena" type="text" size="30" maxlength="30" /></td></tr>
                </span>
                <br />
                <span style="position:relative; left:50%;">
                <input name="botonAcceso" type="submit" value="Acceder" /></span>
                </form>
			</div>  
		</div>
	</div> 
     
</body>
</html>