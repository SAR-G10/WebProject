<!DOCTYPE html>
<?php
if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $tarea = trim($_POST['tarea']);
    $descripcion = trim($_POST['descripcion']);
    $fecha = trim($_POST['fecha']);
    $user = trim($_POST['user']);

        $ActividadesXml = simplexml_load_file('actividad2.xml');
        $ActividadXml = $ActividadesXml->addChild('actividad');
        $ActividadXml->addAttribute('usuario', $user);
        $ActividadXml->addAttribute('id', $ActividadesXml['ult_id']+1);
        $ActividadesXml['ult_id'] = $ActividadesXml['ult_id']+1;
        $fechaXml = $ActividadXml->addChild('fecha', $fecha);
        $tituloXml = $ActividadXml->addChild('titulo', $tarea);
        $descripcionXml = $ActividadXml->addChild('descripcion', $descripcion);

        $id = $ActividadesXml['ult_id'];

    if(!isset($_FILES["image"]) || $_FILES["image"]["error"] > 0){
        $pathImg = $ActividadXml->addChild('pathImg');
        $pathImg->addAttribute('subida', 'no');
    }
    else {
            // Archivo temporal
            $imagen_temporal = $_FILES['image']['tmp_name'];

            // Tipo de archivo
            $type = $_FILES['image']['type'];
            $tipo = substr($type, strlen('image/'));

            $permitidos = array("jpg", "jpeg", "gif", "png");

            if(!in_array($tipo, $permitidos)){
                echo "<script type='text/javascript'>alert('la imagen contiene un formato invalido -> $tipo ' +
                       '\\n los formatos validos son : jpg, jpeg, gif, png ');
                            window.location.href = 'AddTask.php?user=$user';
                       </script>";
                exit(0);
            }

        $data = file_get_contents($imagen_temporal);
        $pathImg = $ActividadXml->addChild('pathImg', "fotos/$id.$tipo");
        $pathImg->addAttribute('subida', 'si');
        file_put_contents("fotos/$id.$tipo", $data);


    }

    $direccionMaps = $ActividadXml->addChild('direccionMaps');
    $direccionMaps->addAttribute('subida', 'no');
    $domxml = new DOMDocument('1.0');
    $domxml->preserveWhiteSpace = false;
    $domxml->formatOutput = true;
    $domxml->loadXML($ActividadesXml->asXML());
    $domxml->save('actividad2.xml');

    echo "<script type='text/javascript'>
        alert('Su tarea ha quedado registrada.');
         window.location.href = 'AddTask.php?user=$user';
        $('#rst').click();
        </script>";

    }

?>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
<body>
<div>
    <form name="ftask" id="ftask" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="Post" enctype="multipart/form-data">
        <input type="text" name="user" style="visibility: hidden" value="<?php echo $_GET['user']; ?>"/>
        Tarea*: </br><input type="text" name="tarea" id="tarea" size="50" placeholder="Añade un titulo a la tarea" value="tarea" required /></br>
        Fecha*: </br><input type="date" name="fecha" id="fecha" size="50" placeholder="dd-mm-yy" value="19-12-2017" required /></br>
        Descripción*: </br><input type="text" name="descripcion" id="descripcion" size="50" placeholder="Añade tu descripción"  value="Descripcion" required /></br>
        <input type="submit" name="submit" id="submit" value="Enviar" align="center" style="margin-left: 5%"/>
        <input type="reset" id="rst" value="Limpiar"/></br></br>

            <div align="left">
                <img id="imagen" name="imagen" src="fotos/add-image.png" alt="imagen" align="center" width="256px"/>
            </div>
        <input type="file" name="image" id="img" align="center" src="fotos/add-image.png" style="margin-left: 4%"/>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    function mostrarImagen(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagen').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#img").change(function(){
        mostrarImagen(this);
    });
</script>
</body>
</html>
