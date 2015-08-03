<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Upload</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <body>
        <?php
        $tammax = 2000000;
        if (!isset($_FILES['imagen']))
            echo 'Error del formulario HTML';
        else {
            if ($_FILES['imagen']['size'] > $tammax)
                echo 'Supera el tama�o permitido';
            else
            if (substr($_FILES['imagen']['type'], 0, 5) != 'image')
                echo 'El archivo no es una imagen';
            else
            if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                move_uploaded_file($_FILES['imagen']['tmp_name'], $_FILES['imagen']['name']);
                echo 'Archivo subido ' . $_FILES['imagen']['name'];
                echo '<br>';
                echo '<img src="' . $_FILES['imagen']['name'] . '">';
            } else
                echo 'Problemas en el envío ' . $_FILES['imagen']['name'];
        }
        ?>

    </body>
</html>
