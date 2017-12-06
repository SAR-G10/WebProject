<?
//Inicio la sesión
session_start();
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if ($_SESSION["autentificado"] != "SI") {
 //si no existe, envio a la página de autentificación
 header("Location: Login.php");
 //además salgo de este script
 exit();
}
?>

