<!DOCTYPE html>
<?php

if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $nombre = trim($_POST['nombre']);
    $apellidos = trim(($_POST['apellidos']));
    $username = trim($_POST['username']);
    $contrasenha = trim($_POST['password']);
    $rep_contrasenha = trim($_POST['rep_password']);


    if (empty($email)) {
        echo "<script type='text/javascript'>alert('Email vacio');</script>";
    } else if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)) {
        echo "<script type='text/javascript'>alert('El email no cumple con lo establecido');</script>";
    } else if (!preg_match("/^([a-zA-Z ]{1,})$/", $nombre)) {
        echo "<script type='text/javascript'>alert('El nombre no cumple con lo establecido');</script>";
    } else if (!preg_match("/^([a-zA-Z ]{1,})$/", $apellidos)) {
        echo "<script type='text/javascript'>alert('El nombre no cumple con lo establecido');</script>";
    } else if (!preg_match("/^(([a-zA-Z0-9\_\-]{1,}))$/", $username)) {
        echo "<script type='text/javascript'>alert('El username no cumple con lo establecido');</script>";
    } else if (!preg_match("/^[a-zA-Z0-9!@#\$%\^&\*\?_~\/\-\\\_]{6,20}$/", $contrasenha)) {
        echo "<script type='text/javascript'>alert('La contraseña no cumple con lo establecido');</script>";
    } else if (!preg_match("/^[a-zA-Z0-9!@#\$%\^&\*\?_~\/\\\-\_]{6,20}$/", $rep_contrasenha)) {
        echo "<script type='text/javascript'>alert('La contraseñas no concuerda con su predecesora');</script>";
    } else if ($rep_contrasenha !== $contrasenha) {
        echo "<script type='text/javascript'>alert('Las contraseñas no concuerdan entre si');</script>";
    }else{


        $usuariosXml = simplexml_load_file('usuarios.xml');
        $usuarioXml = $usuariosXml->addChild('usuario');
        $emailXml = $usuarioXml->addChild('email', $email);
        $nombreXml = $usuarioXml->addChild('nombre', $nombre);
        $apellidosXml = $usuarioXml->addChild('apellidos', $apellidos);
        $usernameXml =  $usuarioXml->addChild('username', $username);
        $passwordXml = $usuarioXml->addChild('password', $contrasenha);
        $domxml = new DOMDocument('1.0');
        $domxml->preserveWhiteSpace = false;
        $domxml->formatOutput = true;
        $domxml->loadXML($usuariosXml->asXML());
        $domxml->save('usuarios.xml');

    }
}
?>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
<body>
<div>
    <form name="fregistrar" id="freg" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="Post" enctype="multipart/form-data">
        Email*: </br><input type="email" name="email" id="email" size="50" placeholder="email@host.dom" required /></br>
        Nombre*: </br><input type="text" name="nombre" id="name" size="50" placeholder="Alice" pattern="[A-Za-z]{1,}" required /></br>
        Apellidos*: </br><input type="text" name="apellidos" id="lastNames" size="50" placeholder="Smith" pattern="([a-zA-Z ]{1,})" required /></br>
        Username*: </br><input type="text" name="username" id="nick" size="50" placeholder="Anonym" pattern="[a-zA-Z0-9_-]{1,}" required /></br>
        Password*: </br><input type="password" name="password" id="pass" size="50" required /></br>
        Repetir password*:</br><input type="password" name="rep_password" id="rep_pass" size="50" required /></br>
        <input type="submit" name="submit" id="submit" value="Enviar" align="center" style="margin-left: 5%"/>
        <input type="reset" value="reset" id="rst" value="Limpiar"/></br></br>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>