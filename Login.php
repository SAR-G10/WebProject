<!DOCTYPE html>
<?php
if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $contrasenha = trim($_POST['password']);

    if (empty($email)) {
        echo "<script type='text/javascript'>alert('Email vacio');</script>";
    } else if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)) {
        echo "<script type='text/javascript'>alert('El email no cumple con lo establecido');</script>";
    } else if (!preg_match("/^[a-zA-Z0-9!@#\$%\^&\*\?_~\/\-\\\_]{6,20}$/", $contrasenha)) {
        echo "<script type='text/javascript'>alert('La contraseña no cumple con lo establecido');</script>";
    } else {

        $usuarios = simplexml_load_file('usuarios.xml');
        foreach ($usuarios->children() as $usuario) {
            if ($usuario->email == $email) {
                if($usuario->password == $contrasenha){
                    echo $usuario->email;
                    echo $usuario->password;
                    $user = $usuario->username;
                    echo "<script language='JavaScript'>
                            window.location.href = 'AddTask.php?user=$user';
                          </script>";
                exit(0);
                }
            }
        }
        echo "<script language='JavaScript'>
                alert('No eres un usuario registrado');
                    window.location.href = 'Registrar.php';    
            </script>";
    }
}

?>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
<body>
<div>
    <form id='freg' name='fregister' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="Post" enctype="multipart/form-data">
            Email*: &nbsp;<input type="text" size="50" id="email" name="email" placeholder="email@host.dom" /></br>
            Password*: &nbsp;<input type="password" size="50" id="pass" name="password" placeholder="Qwerty1234" /></br>
            <input type="submit" id="submit" name="submit" value="Enviar" align="center">&nbsp;
            <input type="reset" value="Limpiar"></br></br>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>