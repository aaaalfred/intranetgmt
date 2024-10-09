<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
    // Ajusta esta ruta según la estructura de tu proyecto
    include("../../actions/conexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $reqpersonal_id = isset($_POST['reqpersonal_id']) ? $_POST['reqpersonal_id'] : '';
        $selected_users = isset($_POST['selected_users']) ? $_POST['selected_users'] : [];

        if (!empty($reqpersonal_id) && !empty($selected_users)) {
            foreach ($selected_users as $user_id) {
                $user_id = mysqli_real_escape_string($con, $user_id);
                $reqpersonal_id = mysqli_real_escape_string($con, $reqpersonal_id);

                $sql = "UPDATE usuarios SET solicitudes = '$reqpersonal_id' WHERE id = '$user_id'";
                $result = mysqli_query($con, $sql);
                if (!$result) {
                    die('Error en la consulta: ' . mysqli_error($con));
                }
            }

            echo "Actualización exitosa.";
        } else {
            echo "Por favor, seleccione usuarios y una requisición.";
        }
    }

    // Redirigir de vuelta a la página de preaprobados después de 3 segundos
    header("refresh:3;url=preaprobados.php");
}
else 
{
    header('Location: ../../login.php');
}
?>