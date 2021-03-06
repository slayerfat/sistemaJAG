<?php
/**
 * @author [slayerfat] <[slayerfat@gmail.com]>
 *
 * {@internal [si tienen dudas sobre este archivo
 * pregunten, no es tan dificil, solo sigan el flujo del
 * mismo, para registrar a un personal interno que no es usuario:
 *
 * 1. se inserta persona.
 * 2. se inserta personal.
 * 3. se inserta direccion.
 *
 * y listo.
 *
 * este archivo fue cambiado para ajustarse a la nueva base de datos.]}
 *
 * @version [1.2]
 */

if(!isset($_SESSION)){
  session_start();
}
$enlace = $_SERVER['DOCUMENT_ROOT']."/github/sistemaJAG/php/master.php";
require_once($enlace);
// invocamos validarUsuario desde master.php
validarUsuario(1, 3, $_SESSION['cod_tipo_usr']);

if ( isset($_POST['cedula']) && strlen($_POST['cedula']) == 8 ) :
  //datos para saber si es docente o no:
  if (isset($_POST['tipo_personal'])) :
    if ($_POST['tipo_personal'] === '1') {
      $asume = false;
    } elseif ($_POST['tipo_personal'] === '2') {
      $asume = true;
    } elseif ($_POST['tipo_personal'] === '3') {
      $asume = false;
    }else{
      header("Location: form_reg_PI.php?tipo_personal=MalDefinido");
    }
  else:
    header("Location: form_reg_PI.php?tipo_personal=MalDefinido");
  endif;
  //iniciamos datos restantes del formulario:
  $codUsrMod = $_SESSION['codUsrMod'];
  $p_apellido = $_POST['p_apellido'];
  $s_apellido = $_POST['s_apellido'];
  $p_nombre = $_POST['p_nombre'];
  $s_nombre = $_POST['s_nombre'];
  $nacionalidad = $_POST['nacionalidad'];
  $cedula = $_POST['cedula'];
  $celular = $_POST['celular'];
  $telefono = $_POST['telefono'];
  $telefonoOtro = $_POST['telefono_otro'];
  $nivel_instruccion = $_POST['nivel_instruccion'];
  $certificado_1 = $_POST['certificado_1'];
  $descripcion_1 = $_POST['descripcion_1'];
  $certificado_2 = $_POST['certificado_2'];
  $descripcion_2 = $_POST['descripcion_2'];
  $certificado_3 = $_POST['certificado_3'];
  $descripcion_3 = $_POST['descripcion_3'];
  $certificado_4 = $_POST['certificado_4'];
  $descripcion_4 = $_POST['descripcion_4'];
  $fecNac = $_POST['fec_nac'];
  $sexo = $_POST['sexo'];
  $email = $_POST['email'];
  $codCargo = $_POST['cod_cargo'];
  $tipo_personal = $_POST['tipo_personal'];
  $codTipoUsr = 'null';
  //validamos los datos restantes:
  $validarPI = new ChequearPI(
    $codUsrMod,
    $p_apellido,
    $s_apellido,
    $p_nombre,
    $s_nombre,
    $nacionalidad,
    $cedula,
    $celular,
    $telefono,
    $telefonoOtro,
    $nivel_instruccion,
    $certificado_1,
    $descripcion_1,
    $certificado_2,
    $descripcion_2,
    $certificado_3,
    $descripcion_3,
    $certificado_4,
    $descripcion_4,
    $fecNac,
    $sexo,
    $email,
    $codTipoUsr,
    $codCargo,
    $tipo_personal
    );
  if ($validarPI->valido()) :
    //validamos campos de direccion antes de insertar:
    $direccion = new ChequearDireccion(
      1,
      1,
      $_POST['cod_parro'],
      $_POST['direcc']
      );
    if ($direccion->valido()) :
      // se inserta un usuario con seudonimo y clase como la cédula de la persona.
      $hash = password_hash($_POST['cedula'], PASSWORD_BCRYPT, ['cost' => 12]);
      $query = "INSERT INTO usuario
      VALUES
      (null, $validarPI->cedula, '".$hash."',
        5, 1, 1, null, 1, current_timestamp );";
      $resultado = conexion($query);
      $query = "SELECT usuario.codigo from usuario where seudonimo = $validarPI->cedula;";
      $resultado = conexion($query);
      $codigoUsuario = mysqli_fetch_assoc($resultado);
      //se inserta en persona
      //los datos comunes o basicos:
      $query = "INSERT INTO persona
      values
      (null, $validarPI->p_nombre, $validarPI->s_nombre, $validarPI->p_apellido,
        $validarPI->s_apellido, $validarPI->nacionalidad, $validarPI->cedula,
        $validarPI->fecNac, $validarPI->telefono, $validarPI->telefonoOtro,
        $validarPI->sexo, 1, $codUsrMod, null, $codUsrMod, current_timestamp);";
      $resultado = conexion($query);
      //averiguamos codigo (y de una vez el resto de campos):
      $query = "SELECT * from persona where cedula = $validarPI->cedula;";
      $resultado = conexion($query);
      if ($resultado->num_rows == 1) :
        $datosDePersona = mysqli_fetch_assoc($resultado);
      endif;

      //se inserta en personal
      //los datos no comunes o especificos:
      $query = "INSERT INTO personal
      values
      (null, $datosDePersona[codigo],
        $validarPI->celular,
        $validarPI->nivelInstruccion,
        $validarPI->certificado_1,
        $validarPI->descripcion_1,
        $validarPI->certificado_2,
        $validarPI->descripcion_2,
        $validarPI->certificado_3,
        $validarPI->descripcion_3,
        $validarPI->certificado_4,
        $validarPI->descripcion_4,
        $validarPI->email, $codigoUsuario[codigo],
        $validarPI->codCargo, $validarPI->tipoPersonal,
        1, $codUsrMod, null, $codUsrMod, current_timestamp);";
      $resultado = conexion($query);

      $query = "SELECT codigo
      from personal
      where cod_persona = $datosDePersona[codigo];";
      $resultado = conexion($query);
      $codigoPersonal = mysqli_fetch_assoc($resultado);

      //validamos campos de direccion:
      $direccion = new ChequearDireccion(
        $codUsrMod,
        $datosDePersona['codigo'],
        $_POST['cod_parro'],
        $_POST['direcc']
        );
      //insertamos datos:
      $query = "INSERT INTO direccion
      VALUES
      (null, $direccion->codPersona,
        $direccion->codParroquia,
        $direccion->direccionExacta,
        1, $codUsrMod, null,  $codUsrMod, current_timestamp);";
      $resultado = conexion($query);
      if ($asume) :
        $query = "INSERT INTO asume values
        (null, $codigoPersonal[codigo], 34, 0,
          'Autogenerado en registro, por sistema.',
          1, $codUsrMod, null, $codUsrMod, current_timestamp);";
        $resultado = conexion($query);
      endif;
      empezarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr']); ?>
      <div id="insertar_sinU_PUI">
        <div id="blancoAjax">
          <div class="container">
            <div class="row">
              <div class="jumbotron">
                <h1>Registro completo!</h1>
                <h4>
                  El registro de <?php echo $p_apellido.", ".$p_nombre ?> fue realizado exitosamente!
                </h4>
                <p>
                   <a href="menucon.php">Crear otro Registro</a>
                </p>
                <p>
                  <?php $index = enlaceDinamico(); ?>
                  <a href="<?php echo $index ?>" class="btn btn-primary btn-lg">Regresar al sistema</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php else :
      $error = true;
      $info = $direccion->info();
    endif;
  else :
    $error = true;
    $info = $validarPI->info();
  endif;
  if (isset($error)) :
    empezarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr'], 'sistemaJAG | Registro de usuario');?>
    <div id="contenido_insertar_U">
      <div id="blancoAjax">
        <div class="container">
          <div class="row">
            <div class="jumbotron">
              <h1>Ups!</h1>
              <p>
                Error en el proceso de registro!
              </p>
              <h3>
                Los datos suministrados al sistema parecen ser inválidos!
              </h3>
              <div class="bg-danger">
                <p>
                  <em>Específicamente el sistema declara:</em>
                </p>
                <p>
                   <strong>
                     <em>
                        <?php echo $info ?>
                     </em>
                   </strong>
                </p>
              </div>
              <p>
                ¿O será que entro en esta pagina erróneamente?
              </p>
              <p class="bg-warning">
                Si este es un problema recurrente, contacte a un administrador del sistema.
              </p>
              <p>
                <?php $index = enlaceDinamico(); ?>
                <a href="<?php echo $index ?>" class="btn btn-primary btn-lg">Regresar al sistema</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif;
else :
  empezarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr']); ?>
  <div id="insertar_sinU_PI">
    <div id="blancoAjax">
      <div class="container">
        <div class="row">
          <div class="jumbotron">
            <h1>Ups!</h1>
            <p>
              Error en el proceso de registro!
            </p>
            <h3>
              <small>
                la cédula: <?php echo $_POST['cedula'] ?> es incorrecta.
              </small>
            </h3>
            <p>
              Si desea hacer otra intento por favor dele
              <a href="menucon.php">click a este enlace</a>
            </p>
            <p>
              ¿O será que entro en esta pagina erróneamente?
            </p>
            <p class="bg-warning">
              Si este es un problema recurrente, contacte a un administrador del sistema.
            </p>
            <p>
              <?php $index = enlaceDinamico(); ?>
              <a href="<?php echo $index ?>" class="btn btn-primary btn-lg">Regresar al sistema</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php finalizarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr']); ?>
