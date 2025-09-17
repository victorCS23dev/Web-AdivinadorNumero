<?php
session_start();

if (!isset($_SESSION['numero_secreto'])) {
    $_SESSION['numero_secreto'] = rand(1, 100);
    $_SESSION['intentos'] = 0;
    $_SESSION['mensaje'] = '';
}else{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['intentos']++;
        $adivinanza = intval($_POST['adivinanza']);
        
        if ($adivinanza < $_SESSION['numero_secreto']) {
            $_SESSION['mensaje'] = 'El número es mayor.';
        } elseif ($adivinanza > $_SESSION['numero_secreto']) {
            $_SESSION['mensaje'] = 'El número es menor.';
        } else {
            $mensaje_final = '¡Felicidades! Has adivinado el número en ' . $_SESSION['intentos'] . ' intentos.';
            unset($_SESSION['numero_secreto']);
            unset($_SESSION['intentos']);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Adivina el Número</title>
    <link rel="stylesheet" href="styles.css">
    </head>
<body>
    <div>
        <h1>Adivina el Número</h1>
    </div>
    <div>
        <?php if (isset($_SESSION['numero_secreto'])) {?>
        <form method="POST">
            <label for="adivinanza">Introduce un número entre 1 y 100:</label>
            <input type="number" id="adivinanza" name="adivinanza" min="1" max="100" required>
            <button type="submit">Adivinar</button>
            <p><?php echo $_SESSION['mensaje']; ?></p>
        </form>
        <?php }else{?>
            <form method="POST">
            <button type="submit" name="reiniciar">Reiniciar</button>
            <p><?php echo $mensaje_final; ?></p>
            </form>
        <?php }?>
    </div>
    </body>
</html>