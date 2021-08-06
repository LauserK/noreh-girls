<?php

function clean($value)
{
  $check = $value;

  $search = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(',
  'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
  'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=',
  'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(',
  'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm',
  'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(',
  'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(',
  'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall',
  'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20',
  'insert%20into', 'select%20', 'fopen', 'fwrite', '%20like', 'like%20',
  '$_request', '$_get', '$request', '$get', '.system', 'HTTP_PHP', '&aim', '%20getenv', 'getenv%20',
  'new_password', '&icq','/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow',
  'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id',
  '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python',
  'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', 'lsof%20',
  '/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml',
  'file\://', 'window.open', '<script>', 'javascript\://','img src', 'img%20src','.jsp','ftp.exe',
  'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd',
  'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history',
  'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20',
  'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con',
  '<script', 'UPDATE', 'SELECT', 'DROP', '/robot.txt' ,'/perl' ,'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from',
  'select from', 'drop%20', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=');

  $value = str_replace($search, '', $value);

  $value = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$value);
  $value = trim($value);
  $value = strip_tags($value);
  $value = addslashes($value);
  $value = str_replace("'", "''", $value);

  if( $check != $value ){
    return("");
  }

  return( $value );
}
?>

<?php
  //$_FILES || $_POST
  /*  GENERALES  */
  $general                     = array();
  $general["nombre"]           = clean($_POST["nombre"]);
  $general["cedula"]           = clean($_POST["cedula"]);
  $general["rif"]              = clean($_POST["rif"]);
  $general["sexo"]             = clean($_POST["sexo"]);
  $general["fecha_nacimiento"] = clean($_POST["nacimiento"]);
  $general["estado_civil"]     = clean($_POST["estado_civil"]);
  $general["estatura"]         = clean($_POST["estatura"]);
  $general["peso"]             = clean($_POST["peso"]);
  $general["estado"]           = clean($_POST["estado"]);
  $general["ciudad"]           = clean($_POST["ciudad"]);
  $general["parroquia"]        = clean($_POST["parroquia"]);
  $general["celular"]          = clean($_POST["personal"]);
  $general["fijo"]             = clean($_POST["hogar"]);
  $general["email"]            = clean($_POST["email"]);
  $general["vivienda"]         = clean($_POST["vivienda"]);
  $general["nacionalidad"]     = clean($_POST["nacionalidad"]);

  /*  ESTUDIOS  */
  $estudios                    = array();
  $estudios["activo"]          = clean($_POST["universitario"]);

  if ($estudios["activo"] == "si") {
    $estudios["universidad"]   = clean($_POST["universidad"]);
    $estudios["carrera"]       = clean($_POST["carrera"]);
    $estudios["ano_inicio"]    = clean($_POST["ano-inicio"]);
    $estudios["ano_fin"]       = clean($_POST["ano-fin"]);
    $estudios["turno"]         = clean($_POST["turno"]);
  } else {
    $estudios["universidad"]   = "";
    $estudios["carrera"]       = "";
    $estudios["ano_inicio"]    = "";
    $estudios["ano_fin"]       = "";
    $estudios["turno"]         = "";
  }

  /*  FAMILIAR  */
  $familiar                        = array();
  $familiar["companero"]           = clean($_POST["companero"]);
  $familiar["hijo"]                = clean($_POST["hijo"]);
  if ($familiar["companero"] == "si") {
    $familiar["companero_nombre"]    = clean($_POST["companero-nombre"]);
    $familiar["companero_cedula"]    = clean($_POST["companero-cedula"]);
    $familiar["companero_profesion"] = clean($_POST["companero-profesion"]);
  } else {
    $familiar["companero_nombre"]    = "";
    $familiar["companero_cedula"]    = "";
    $familiar["companero_profesion"] = "";
  }

  if ($familiar["hijo"] === "si") {
    $familiar["hijo_cantidad"]     = (int)clean($_POST["hijo-cantidad"]);
    if ($familiar["hijo_cantidad"] >= 1 && $familiar["hijo_cantidad"] <=6) {
      $range = range(1, $familiar["hijo_cantidad"]);

      foreach ($range as $i) {
        $familiar["hijo_" . $i]    = clean($_POST["hijo-edad-" . $i]);
      }
    }
  } else {
    $familiar["hijo_cantidad"]     = 0;
    $familiar["hijo_1"]            = "";
    $familiar["hijo_2"]            = "";
    $familiar["hijo_3"]            = "";
    $familiar["hijo_4"]            = "";
    $familiar["hijo_5"]            = "";
    $familiar["hijo_6"]            = "";
  }

  /*  DOCUMENTOS  */
  $documentos                   = array();
  $documentos["curso"]          = clean($_POST["cursos"]);
  $documentos["certificado"]    = clean($_POST["certificado"]);

  // SINTESIS CURRICULAR
  if ($_FILES['cv']['error'] == 0) {
    //HANDLE UPLODAD FILE
    $file = $_FILES["cv"];
    $allowed = array("pdf" => "application/pdf");
    $filename = $_FILES["cv"]["name"];
    $filetype = $_FILES["cv"]["type"];
    $filesize = $_FILES["cv"]["size"];

    // Verify file size - 5MB maximum
    $maxsize = 5 * 1024 * 1024;
    if($filesize > $maxsize) {
      echo "Error: El archivo debe pesar menos de 5MB.";
    }

    // Verify MYME type of the file
    if(in_array($filetype, $allowed)){
        date_default_timezone_set('America/Caracas');
        $date = date('d-m-Y', time());
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $nuevo_nombre = $date . "-" . $general["cedula"] . "." . $ext;
        // Check whether file exists before uploading it
        if(file_exists("upload/" . $nuevo_nombre)){
            echo "Error: " . $general["cedula"] . " ya tu solicitud esta en proceso.";
            return false;
        } else{
            move_uploaded_file($_FILES["cv"]["tmp_name"], "upload/" . $nuevo_nombre);
            echo "Your file was uploaded successfully.";
        }
    } else {
        echo "Error: El archivo que intenta enviar no es compatible.";
        return false;
    }
  }

  // Informacion de la base de datos

  $debug = FALSE;
  if ($debug == FALSE) {
    $dbhost = 'localhost';
    $dbuser = 'c0220064_RUU';
    $dbpass = 'toGU11tate';
    $dbname = 'c0220064_RUU';
  } else {
    $dbhost = '10.10.2.200';
  	$dbuser = 'root';
  	$dbpass = '123';
  	$dbname = 'c0220064_RUU';
  }

	$conn     = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error: Ocurrio un error al conectarse al servidor de bases de datos');
	mysql_select_db($dbname);

  $sql_pre  = "INSERT INTO postulacion (nombre, cedula, rif, sexo, fecha_nacimiento, estado_civil, estatura, peso, estado, ciudad, parroquia, celular, fijo, email, vivienda, nacionalidad, universidad, carrera, ano_inicio, ano_fin, turno, companero, companero_nombre, companero_cedula, companero_profesion, hijo, hijo_cantidad, edad_hijo_1, edad_hijo_2, edad_hijo_3, edad_hijo_4, edad_hijo_5, edad_hijo_6, curso, certificado)";

  $sql_post = "VALUES ('". $general["nombre"] ."', '". $general["cedula"] ."', '". $general["rif"] ."', '". $general["sexo"] ."', '". $general["fecha_nacimiento"] ."', '". $general["estado_civil"] ."', '". $general["estatura"] ."', '". $general["peso"] ."', '". $general["estado"] ."', '". $general["ciudad"] ."', '". $general["parroquia"] ."', '". $general["celular"] ."', '". $general["fijo"] ."', '". $general["email"] ."', '". $general["vivienda"] ."', '". $general["nacionalidad"] ."', '". $estudios["universidad"] ."', '". $estudios["carrera"] ."', '". $estudios["ano_inicio"] ."', '". $estudios["ano_fin"] ."', '". $estudios["turno"] ."', '". $familiar["companero"] ."', '". $familiar["companero_nombre"] ."', '". $familiar["companero_cedula"] ."', '". $familiar["companero_profesion"] ."', '". $familiar["hijo"] ."', '". $familiar["hijo_cantidad"] ."', '". $familiar["hijo_1"] ."', '". $familiar["hijo_2"] ."', '". $familiar["hijo_3"] ."', '". $familiar["hijo_4"] ."', '". $familiar["hijo_5"] ."', '". $familiar["hijo_6"] ."', '". $documentos["curso"] ."', '". $documentos["certificado"] ."')";

  $sql = "" . $sql_pre . " " . $sql_post;

  if (mysql_query($sql)) {
    require 'PHPMailer/PHPMailerAutoload.php';
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    $mail->Host = "smtp.gmail.com";
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 587;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    //Username to use for SMTP authentication
    $mail->Username = "cvgrupopaseo@gmail.com";
    //Password to use for SMTP authentication
    $mail->Password = "Grup0p4s30";
    //Set who the message is to be sent from
    $mail->setFrom('cv@grupopaseo.com', 'Grupo Paseo');
    //Set who the message is to be sent to
    $mail->addAddress($general["email"], $general["nombre"]);
    //Set the subject line
    $mail->Subject = 'GRUPO PASEO';
    //Replace the plain text body with one created manually
    $mail->Body = "Hola " . $general['nombre'] . " gracias por postularte a Grupo Paseo, tu solicitud va a ser revisada por el equipo administrativo y si quedad seleccionado nos contactaremos contigo por esta via.";

    //send the message, check for errors
    if (!$mail->send()) {
        echo "Error: Tenemos problemas al realizar tu postulacion " . $mail->ErrorInfo;
        return false;
    }
  } else {
    echo "Error: ¡Intente mas tarde!";
  }

  mysql_close($conn);

?>
