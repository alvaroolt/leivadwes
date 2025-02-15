<?php
include "config/config.php";
include "class/Usuario.php";
include "class/Log.php";
include "class/Obra.php";
include "class/Entrada.php";
include "class/Tarifa.php";

session_start();

if (!isset($_SESSION["intentos"])) {
    $_SESSION["intentos"] = 0;
}
if (!isset($_SESSION["userErr"])) {
    $_SESSION["userErr"] = "";
}

if (!isset($_SESSION["perfil"])) {
    $_SESSION["usuario"] = Usuario::getInstancia();
    $_SESSION["obra"] = Obra::getInstancia();
    $_SESSION["log"] = Log::getInstancia();
    $_SESSION["entrada"] = Entrada::getInstancia();
    $_SESSION["tarifa"] = Tarifa::getInstancia();
    $_SESSION["perfil"] = "invitado";
}
if (isset($_POST["login"])) {
    $arrayUsuario = $_SESSION["usuario"]->get($_POST["user"]);
    if (sizeof($arrayUsuario) == 1) {
        $_SESSION["id_usuario"] = $arrayUsuario[0]["id"];
        $_SESSION["user"] = $arrayUsuario[0]["usuario"];
        if ($arrayUsuario[0]["password"] == $_POST["pass"]) {
            $_SESSION["perfil"] = $arrayUsuario[0]["perfiles_perfil"];
            $_SESSION["password"] = $arrayUsuario[0]["password"];
            $_SESSION["correo"] = $arrayUsuario[0]["email"];
            $_SESSION["estado"] = $arrayUsuario[0]["bloqueado"];
            $_SESSION["intentos"] = 0;
            $_SESSION["userErr"] = "";
            $arrayLog = array("usuario" => $arrayUsuario[0]["usuario"], "descripcion" => "Inicio de sesión correcto.");
            $_SESSION["log"]->set($arrayLog);
        } else {
            $_SESSION["intentos"]++;
            $arrayLog = array("usuario" => $arrayUsuario[0]["usuario"], "descripcion" => "Inicio de sesión incorrecto.");
            $_SESSION["log"]->set($arrayLog);
            if ($_SESSION["user"] == $_SESSION["userErr"]) {
                if ($_SESSION["intentos"] >= 3) {
                    $_SESSION["usuario"]->desactivarUser($_SESSION["id_usuario"]);
                    echo "El usuario " . $_SESSION["user"] . " ha sido desactivado.";
                } else {
                    echo "Error al iniciar sesión. Te quedan " . (3 - $_SESSION["intentos"]) . " intentos.";
                }
            } else {
                if ($_SESSION["userErr"] !== "") {
                    $_SESSION["intentos"] = 1;
                }
                $_SESSION["userErr"] = $_SESSION["user"];
                echo "Error al iniciar sesión. Te quedan " . (3 - $_SESSION["intentos"]) . " intentos.";
            }
        }
        if ($_SESSION["perfil"] == "gerente") {
            header("Location: index.php?page=gerente");
        } else if ($_SESSION["perfil"] == "amigo") {
            header("Location: index.php?page=amigo");
        }
    }
}

if (isset($_POST["cerrarSesion"])) {
    include "include/logout.php";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <title>Examen Marzo - Teatro</title>
</head>

<body>
    <?php include "include/header.php"; ?>
    <?php
    if ($_SESSION["perfil"] == "invitado") {
        if (!isset($_POST["registro"])) {
            include "include/login.php";
        } else {
            include "include/registro.php";
        }
    } else {
        echo "<form action='index.php' method='post'>";
        echo "<input type='submit' name='cerrarSesion' value='Cerrar Sesión'>";
        echo "</form>";
    }
    ?>
    <main>
        <?php
        if (isset($_GET["page"])) {
            if ($_GET["page"] == "index") {
                header("Location: index.php");
            } else if ($_GET["page"] == "gerente") {
                include("pages/gerente.php");
            } else if (($_GET["page"] == "amigo")) {
                include("pages/amigo.php");
            }
        } else {
            include "pages/home.php";
        }
        ?>
    </main>
</body>
<footer><?php include "include/footer.php" ?></footer>

</html>