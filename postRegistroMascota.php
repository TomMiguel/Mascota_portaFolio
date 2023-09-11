<?php

include ("BDClass.php");

if (isset($_FILES['profilepic'])) {


  $nombreArchivo = $_FILES["profilepic"]["name"];
  $rutaTemporal = $_FILES["profilepic"]["tmp_name"];
  $rutaDestino = "mascotasFotos/" . $nombreArchivo;

  if(move_uploaded_file($rutaTemporal, $rutaDestino)) {

    $usuario_HDusr  = $_REQUEST["HDusr"];
    $Nombre = $_REQUEST["NombreMascota"];
    $Edad =$_REQUEST["EdadMascota"];
    $Sexo =$_REQUEST["SexoMascota"];
    $TipoMascota =$_REQUEST["TipoMascota"];
    $RazaMascota =$_REQUEST["RazaMascota"];
    $FechaNacimientoMascota =$_REQUEST["FechaNacimientoMascota"];
    $PesoMascota =$_REQUEST["PesoMascota"];
    $foto = "mascotasFotos/" . $nombreArchivo;
    $radEsterilizado =$_REQUEST["radEsterilizado"];
    $vacunas = $_REQUEST["HDvc"];
    $InformacionVet =$_REQUEST["InformacionVet"];
    $InformacionAdicional =$_REQUEST["InformacionAdicional"];

    $old_date = explode("/", $FechaNacimientoMascota);
    $fechaNacimiento_formatSQL = $old_date[2]."/".$old_date[1]."/".$old_date[0];

    $pdo = BD::obtenerBD()->obtenerConexion();
    $comando = 'Call SP_I_Registrar_Mascota(?,?,?,?,?,?,?,?,?,?,?,?,?);';
    $stmt = BD::obtenerBD()->obtenerConexion()->prepare($comando);
    $stmt->bindParam(1, $usuario_HDusr, PDO::PARAM_INT, 20);
    $stmt->bindParam(2, $Nombre, PDO::PARAM_STR,250);
    $stmt->bindParam(3, $Edad, PDO::PARAM_STR, 50);
    $stmt->bindParam(4, $Sexo, PDO::PARAM_STR, 1);
    $stmt->bindParam(5, $TipoMascota, PDO::PARAM_INT, 20);
    $stmt->bindParam(6, $RazaMascota, PDO::PARAM_INT, 20);
    $stmt->bindParam(7, $fechaNacimiento_formatSQL, PDO::PARAM_STR, 25);
    $stmt->bindParam(8, $PesoMascota, PDO::PARAM_STR, 50);
    $stmt->bindParam(9, $foto, PDO::PARAM_STR, 100);
    $stmt->bindParam(10, $radEsterilizado, PDO::PARAM_INT, 20);
    $stmt->bindParam(11, $InformacionVet, PDO::PARAM_STR, 250);
    $stmt->bindParam(12, $InformacionAdicional, PDO::PARAM_STR, 500);
    $stmt->bindParam(13, $vacunas, PDO::PARAM_STR, 500);

    $stmt->execute();

    $tabResultat = $stmt->fetch();
    $NuevaMascota = $tabResultat['nuevaMascota'];

   session_start();
   $_SESSION['NuevaMascota'] =$NuevaMascota;
   $_SESSION['form'] = 2;
   header('Location: loading.php');

  }
  else {
    echo "si encontró el archivo pero hay error guardando el archivo";
  }


}
else {
  echo $_FILES['profilepic'];
}

 ?>
