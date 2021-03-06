<?php
if(!isset($_SESSION)){
  session_start();
}
$enlace = $_SERVER['DOCUMENT_ROOT']."/github/sistemaJAG/php/master.php";
require_once($enlace);

// invocamos validarUsuario.php desde master.php
validarUsuario(1, 2, $_SESSION['cod_tipo_usr']);

if ( isset($_GET['cedula']) ):
  $con = conexion();
  $cedula = mysqli_escape_string($con, trim($_GET['cedula']));
  if (strlen($cedula) <> 8 ) :
    header("Location: menucon.php?error=cedula&valor=".$cedula);
  endif;
  $query = "SELECT
    persona.codigo as codigo_persona,
    persona.nacionalidad as nacionalidad,
    persona.cedula as cedula,
    persona.p_nombre as p_nombre,
    persona.s_nombre as s_nombre,
    persona.p_apellido as p_apellido,
    persona.s_apellido as s_apellido,
    persona.fec_nac as fec_nac,
    persona.sexo as sexo,
    persona.telefono as telefono,
    persona.telefono_otro as telefono_otro,
    personal.codigo as codigo_personal,
    personal.email as email,
    personal.certificado_1,
    personal.certificado_2,
    personal.certificado_3,
    personal.certificado_4,
    personal.descripcion_1,
    personal.descripcion_2,
    personal.descripcion_3,
    personal.descripcion_4,
    personal.nivel_instruccion as nivel_instruccion,
    personal.celular as celular,
    personal.cod_cargo as cod_cargo,
    personal.tipo_personal as tipo_personal,
    direccion.direccion_exacta as direcc,
    direccion.codigo as codigo_dir,
    parroquia.codigo as cod_parro,
    municipio.codigo as cod_mun,
    estado.codigo as cod_est,
    usuario.codigo as cod_usr,
    usuario.seudonimo as seudonimo,
    usuario.cod_tipo_usr as cod_tipo_usr
    from persona
    inner join personal
    on personal.cod_persona = persona.codigo
    inner join usuario
    on personal.cod_usr = usuario.codigo
    inner join direccion
    on persona.codigo = direccion.cod_persona
    inner join parroquia
    on direccion.cod_parroquia = parroquia.codigo
    inner join municipio
    on parroquia.cod_mun = municipio.codigo
    inner join estado
    on municipio.cod_edo = estado.codigo
    where persona.cedula = '$cedula';";
  $resultado = conexion($query);
  if ($resultado->num_rows == 1) :
    empezarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr'], 'sistemaJAG | Actualizacion de usuario');
    $datos = mysqli_fetch_assoc($resultado);
    $_SESSION['codigo_persona'] = $datos['codigo_persona'];
    $_SESSION['codigo_direccion'] = $datos['codigo_dir'];
    $_SESSION['codigo_personal'] = $datos['codigo_personal'];
    $_SESSION['codigo_usuario'] = $datos['cod_usr'];
    //CONTENIDO:?>
    <div id="contenido_form_act_PI">
      <div id="blancoAjax">
        <!-- CONTENIDO EMPIEZA DEBAJO DE ESTO: -->
        <!-- DETALLESE QUE NO ES UN ID SINO UNA CLASE. -->
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <!-- botones de control -->
              <div class="margen">
                <div class="row margen">
                  <div class="col-sm-4 col-sm-offset-4">
                    <?php if ($_SESSION['cod_tipo_usr'] < 3): ?>
                      <button class="actualizar btn btn-primary btn-block disabled">Actualizar</button>
                    <?php else: ?>
                      <button class="actualizar btn btn-primary btn-block">Actualizar</button>
                    <?php endif ?>
                  </div>
                </div>
                <div class="row margen">
                  <div class="col-sm-4 col-sm-offset-4">
                    <a href="reportes/detallado.php?cedula=<?php echo $cedula ?>" class="cons-est btn btn-default btn-block">Generar Reporte</a>
                  </div>
                </div>
              </div>
              <form
                role="form"
                class="form-horizontal"
                name="form"
                id="form"
                method="POST"
                action="actualizar_U.php">
                <fieldset>
                  <legend class="text-center text-uppercase"><h1>Consulta de Personal Interno</h1></legend>
                  <div class="container">
                    <!-- cedula y nacionalidad -->
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="row">
                          <div class="col-xs-11">
                            <div class="form-group">
                              <label for="nacionalidad" class="control-label">Nacionalidad</label>
                              <select
                                name="nacionalidad"
                                id="nacionalidad"
                                required
                                disabled
                                class="form-control">
                                <?php if ($datos['nacionalidad'] == 'v'): ?>
                                  <option selected="selected" value="v">Venezolano</option>
                                  <option value="e">Extranjero</option>
                                <?php else: ?>
                                  <option value="v">Venezolano</option>
                                  <option selected="selected" value="e">Extranjero</option>
                                <?php endif ?>
                              </select>
                                <p class="help-block" id="nacionalidad_chequeo">
                                </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="row">
                          <div class="col-sm-9">
                            <div class="form-group">
                              <label for="cedula" class="control-label">Cédula</label>
                              <input
                                type="text"
                                maxlength="8"
                                name="cedula"
                                id="cedula"
                                disabled
                                class="form-control"
                                autofocus="autofocus"
                                autocomplete="off"
                                placeholder="Introduzca cedula ej: 12345678"
                                value="<?php echo $datos['cedula'] ?>"
                                required>
                              <p class="help-block" id="cedula_chequeo">
                              </p>
                              <p class="help-block" id="cedula_chequeo_adicional">
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- inicio de nombres -->
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-xs-11">
                            <div class="form-group">
                              <label for="p_nombre" class="control-label">Primer Nombre</label>
                              <input
                                class="form-control"
                                type="text"
                                name="p_nombre"
                                id="p_nombre"
                                required
                                disabled
                                value="<?php echo $datos['p_nombre'] ?>"
                                placeholder"campo obligatorio"
                                maxlength="20">
                              <p class="help-block" id="p_nombre_chequeo">
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-xs-12">
                            <div class="form-group">
                              <label for="s_nombre" class="control-label">Segundo Nombre</label>
                              <input
                                class="form-control"
                                type="text"
                                name="s_nombre"
                                id="s_nombre"
                                disabled
                                placeholder="Sin registros, favor actualizar"
                                value="<?php echo $datos['s_nombre'] === (null) ? 'Sin Registros':$datos['s_nombre'] ?>"
                                maxlength="20">
                              <p class="help-block" id="s_nombre_chequeo">
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- inicio de apellidos -->
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-xs-11">
                            <div class="form-group">
                              <label for="p_apellido" class="control-label">Primer apellido</label>
                              <input
                                class="form-control"
                                type="text"
                                name="p_apellido"
                                id="p_apellido"
                                required
                                disabled
                                placeholder="campo obligatorio"
                                value="<?php echo $datos['p_apellido'] ?>"
                                maxlength="20">
                              <p class="help-block" id="p_apellido_chequeo">
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-xs-12">
                            <div class="form-group">
                              <label for="s_apellido" class="control-label">Segundo apellido</label>
                              <input
                                class="form-control"
                                type="text"
                                name="s_apellido"
                                id="s_apellido"
                                disabled
                                placeholder="Sin registros, favor actualizar"
                                value="<?php echo $datos['s_apellido'] === (null) ? 'Sin Registros':$datos['s_apellido'] ?>"
                                maxlength="20">
                              <p class="help-block" id="s_apellido_chequeo">
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- inicio de fecha de nac, sexo y nivel edc -->
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="fec_nac" class="control-label">Fecha de nacimiento</label>
                          <!-- readonly para que no puedan cambiar manualmente la fecha -->
                          <!-- style cursor pointer etc... para que no parezca desabilitado -->
                          <div class="input-group">
                            <input
                              class="form-control"
                              type="text"
                              name="fec_nac"
                              id="fec_nac"
                              placeholder="click para mostrar calendario"
                              readonly="readonly"
                              style="cursor:pointer; background-color: #FFF"
                              value="<?php echo $datos['fec_nac'] ?>"
                              required>
                            <span class="glyphicon glyphicon-calendar input-group-addon"></span>
                          </div>
                          <p class="help-block" id="fec_nac_chequeo">
                          </p>
                        </div>
                      </div>
                      <div class="col-sm-3 col-sm-offset-1">
                        <div class="form-group">
                          <label for="sexo" class="control-label">Sexo</label>
                          <?php $query = "SELECT codigo, descripcion
                            from sexo where status = 1;";
                            $registros = conexion($query);?>
                          <select disabled class="form-control" name="sexo" id="sexo" required>
                            <?php while($fila = mysqli_fetch_array($registros)) : ?>
                              <?php if ($datos['sexo'] == $fila['codigo']): ?>
                                <option selected="selected" value="<?php echo $fila['codigo']; ?>">
                                  <?php echo $fila['descripcion']; ?>
                                </option>
                              <?php else: ?>
                                <option value="<?php echo $fila['codigo']; ?>">
                                  <?php echo $fila['descripcion']; ?>
                                </option>
                              <?php endif ?>
                            <?php endwhile; ?>
                           </select>
                          <p class="help-block" id="sexo_chequeo">
                          </p>
                        </div>
                      </div>
                      <div class="col-sm-4 col-sm-offset-1">
                        <div class="form-group">
                          <label for="nivel_instruccion" class="control-label">Nivel Educativo</label>
                          <?php $sql="SELECT codigo, descripcion from nivel_instruccion where status = 1;";
                            $registros = conexion($sql);?>
                          <select disabled class="form-control" name="nivel_instruccion" required id="nivel_instruccion">
                          <?php while($fila = mysqli_fetch_array($registros)) : ?>
                            <?php if ($datos['nivel_instruccion'] == $fila['codigo']): ?>
                              <option selected="selected" value="<?php echo $fila['codigo']?>">
                              <?php echo $fila['descripcion']?></option>
                            <?php else: ?>
                              <option value="<?php echo $fila['codigo']?>">
                              <?php echo $fila['descripcion']?></option>
                            <?php endif ?>
                          <?php endwhile; ?>
                          </select>
                          <p class="help-block" id="nivel_instruccion_chequeo">
                          </p>
                        </div>
                      </div>
                    </div>
                    <!-- titulos y/o certificados -->
                    <fieldset>
                      <legend class="text-center">Títulos y/o Certificados</legend>
                      <div class="row">
                        <div class="col-sm-3">
                          <div class="row">
                            <div class="col-sm-11">
                              <div class="form-group">
                                <label for="certificado_1" class="control-label">Tipo</label>
                                <?php $sql="SELECT codigo, descripcion from certificado where status = 1;";
                                  $registros = conexion($sql);?>
                                <select
                                  class="form-control"
                                  name="certificado_1"
                                  required
                                  disabled
                                  id="certificado_1">
                                  <?php while($fila = mysqli_fetch_array($registros)) : ?>
                                    <?php if ($fila['codigo'] === $datos['certificado_1']): ?>
                                      <option
                                        selected="selected"
                                        value="<?php echo $fila['codigo']?>">
                                        <?php echo $fila['descripcion']?>
                                      </option>
                                    <?php else: ?>
                                      <option value="<?php echo $fila['codigo']?>">
                                        <?php echo $fila['descripcion']?>
                                      </option>
                                    <?php endif ?>
                                  <?php endwhile; ?>
                                </select>
                                <p class="help-block" id="certificado_1_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-9">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="descripcion_1" class="control-label">Descripción</label>
                                <input
                                  disabled
                                  class="form-control"
                                  type="text"
                                  name="descripcion_1"
                                  id="descripcion_1"
                                  value="<?php echo $datos['descripcion_1'] ?>"
                                  maxlength="80">
                                <p class="help-block" id="descripcion_1_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <div class="row">
                            <div class="col-sm-11">
                              <div class="form-group">
                                <label for="certificado_2" class="control-label">Tipo</label>
                                <?php $sql="SELECT codigo, descripcion from certificado where status = 1;";
                                  $registros = conexion($sql);?>
                                <select
                                  class="form-control"
                                  name="certificado_2"
                                  required
                                  disabled
                                  id="certificado_2">
                                  <?php while($fila = mysqli_fetch_array($registros)) : ?>
                                    <?php if ($fila['codigo'] === $datos['certificado_2']): ?>
                                      <option
                                        selected="selected"
                                        value="<?php echo $fila['codigo']?>">
                                        <?php echo $fila['descripcion']?>
                                      </option>
                                    <?php else: ?>
                                      <option value="<?php echo $fila['codigo']?>">
                                        <?php echo $fila['descripcion']?>
                                      </option>
                                    <?php endif ?>
                                  <?php endwhile; ?>
                                </select>
                                <p class="help-block" id="certificado_2_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-9">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="descripcion_2" class="control-label">Descripción</label>
                                <input
                                  disabled
                                  class="form-control"
                                  type="text"
                                  name="descripcion_2"
                                  id="descripcion_2"
                                  value="<?php echo $datos['descripcion_2'] ?>"
                                  maxlength="80">
                                <p class="help-block" id="descripcion_2_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <div class="row">
                            <div class="col-sm-11">
                              <div class="form-group">
                                <label for="certificado_3" class="control-label">Tipo</label>
                                <?php $sql="SELECT codigo, descripcion from certificado where status = 1;";
                                  $registros = conexion($sql);?>
                                <select
                                  class="form-control"
                                  name="certificado_3"
                                  required
                                  disabled
                                  id="certificado_3">
                                  <?php while($fila = mysqli_fetch_array($registros)) : ?>
                                    <?php if ($fila['codigo'] === $datos['certificado_3']): ?>
                                      <option
                                        selected="selected"
                                        value="<?php echo $fila['codigo']?>">
                                        <?php echo $fila['descripcion']?>
                                      </option>
                                    <?php else: ?>
                                      <option value="<?php echo $fila['codigo']?>">
                                        <?php echo $fila['descripcion']?>
                                      </option>
                                    <?php endif ?>
                                  <?php endwhile; ?>
                                </select>
                                <p class="help-block" id="certificado_3_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-9">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="descripcion_3" class="control-label">Descripción</label>
                                <input
                                  disabled
                                  class="form-control"
                                  type="text"
                                  name="descripcion_3"
                                  id="descripcion_3"
                                  value="<?php echo $datos['descripcion_3'] ?>"
                                  maxlength="80">
                                <p class="help-block" id="descripcion_3_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <div class="row">
                            <div class="col-sm-11">
                              <div class="form-group">
                                <label for="certificado_4" class="control-label">Tipo</label>
                                <?php $sql="SELECT codigo, descripcion from certificado where status = 1;";
                                  $registros = conexion($sql);?>
                                <select
                                  class="form-control"
                                  name="certificado_4"
                                  required
                                  disabled
                                  id="certificado_4">
                                  <?php while($fila = mysqli_fetch_array($registros)) : ?>
                                    <?php if ($fila['codigo'] === $datos['certificado_4']): ?>
                                      <option
                                        selected="selected"
                                        value="<?php echo $fila['codigo']?>">
                                        <?php echo $fila['descripcion']?>
                                      </option>
                                    <?php else: ?>
                                      <option value="<?php echo $fila['codigo']?>">
                                        <?php echo $fila['descripcion']?>
                                      </option>
                                    <?php endif ?>
                                  <?php endwhile; ?>
                                </select>
                                <p class="help-block" id="certificado_4_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-9">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="descripcion_4" class="control-label">Descripción</label>
                                <input
                                  disabled
                                  class="form-control"
                                  type="text"
                                  name="descripcion_4"
                                  id="descripcion_4"
                                  value="<?php echo $datos['descripcion_4'] ?>"
                                  maxlength="80">
                                <p class="help-block" id="descripcion_4_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <!-- inicio de telefonos y email -->
                    <fieldset>
                      <legend class="text-center">Información de contacto</legend>
                      <div class="row">
                        <div class="col-sm-3">
                          <div class="row">
                            <div class="col-xs-11">
                              <div class="form-group">
                                <label class="control-label" for="telefono">Teléfono</label>
                                <input
                                  class="form-control"
                                  type="text"
                                  maxlength="11"
                                  name="telefono"
                                  disabled
                                  placeholder="Sin registros, favor actualizar"
                                  value="<?php echo $datos['telefono'] ?>"
                                  id="telefono">
                                <p class="help-block" id="telefono_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="row">
                            <div class="col-xs-11">
                              <div class="form-group">
                                <label class="control-label" for="telefono_otro">Teléfono Adicional</label>
                                <input
                                  class="form-control"
                                  type="text"
                                  maxlength="11"
                                  name="telefono_otro"
                                  disabled
                                  placeholder="Sin registros, favor actualizar"
                                  value="<?php echo $datos['telefono_otro'] ?>"
                                  id="telefono_otro">
                                <p class="help-block" id="telefono_otro_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="row">
                            <div class="col-xs-11">
                              <div class="form-group">
                                <label class="control-label" for="celular">Teléfono Celular</label>
                                <input
                                  class="form-control"
                                  type="text"
                                  maxlength="11"
                                  name="celular"
                                  disabled
                                  placeholder="Sin registros, favor actualizar"
                                  value="<?php echo $datos['celular'] ?>"
                                  id="celular">
                                <p class="help-block" id="celular_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="row">
                            <div class="col-xs-12">
                              <div class="form-group">
                                <label class="control-label" for="email">Correo Electrónico</label>
                                <div class="input-group">
                                  <div class="input-group-addon">@</div>
                                  <input
                                  type="email"
                                  class="form-control"
                                  id="email"
                                  name="email"
                                  maxlength="40"
                                  disabled
                                  placeholder="Sin registros, favor actualizar"
                                  value="<?php echo $datos['email'] ?>"
                                  required>
                                </div>
                                <p class="help-block" id="email_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <!-- inicio de cargo, perfil -->
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="row">
                          <div class="col-xs-11">
                            <div class="form-group">
                              <label for="cargo" class="control-label">Cargo</label>
                              <?php $sql="SELECT codigo, descripcion from cargo where status = 1;";
                                $registros = conexion($sql);?>
                              <select disabled class="form-control" name="cod_cargo" required id="cargo">
                                <?php while($fila = mysqli_fetch_array($registros)) : ?>
                                  <?php if ($datos['cod_cargo'] == $fila['codigo']): ?>
                                    <option selected="selected" value="<?php echo $fila['codigo']?>">
                                    <?php echo $fila['descripcion']?></option>
                                  <?php else: ?>
                                    <option value="<?php echo $fila['codigo']?>">
                                    <?php echo $fila['descripcion']?></option>
                                  <?php endif ?>
                                <?php endwhile; ?>
                              </select>
                              <p class="help-block" id="cargo_chequeo">
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="row">
                          <div class="col-xs-11">
                            <div class="form-group">
                              <label for="tipo_personal" class="control-label">Perfil de usuario</label>
                              <?php $sql="SELECT codigo, descripcion from tipo_personal where status = 1;";
                                $registros = conexion($sql);?>
                              <select disabled class="form-control" name="tipo_personal" required id="tipo_personal">
                                <?php while($fila = mysqli_fetch_array($registros)) : ?>
                                  <?php if ($datos['tipo_personal'] == $fila['codigo']): ?>
                                    <option selected="selected" value="<?php echo $fila['codigo']?>">
                                    <?php echo $fila['descripcion']?></option>
                                  <?php else: ?>
                                    <option value="<?php echo $fila['codigo']?>">
                                    <?php echo $fila['descripcion']?></option>
                                  <?php endif ?>
                                <?php endwhile; ?>
                              </select>
                              <p class="help-block" id="tipo_personal_chequeo">
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- inicio de estado, municio, parroquia y direccion exacta -->
                    <fieldset>
                      <legend class="text-center">Dirección de Habitación </legend>
                      <!-- est/mun/par -->
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="row">
                            <div class="col-xs-11">
                              <div class="form-group">
                                <label class="control-label" for="cod_est">Estado</label>
                                <select disabled class="form-control" name="cod_est" id="cod_est"></select>
                                <p class="help-block" id="cod_est_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="row">
                            <div class="col-xs-11">
                              <div class="form-group">
                                <label class="control-label" for="cod_mun">Municipio</label>
                                <select disabled class="form-control" name="cod_mun" id="cod_mun" >
                                  <option value="">--Seleccionar--</option>
                                </select>
                                <p class="help-block" id="cod_mun_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="row">
                            <div class="col-xs-12">
                              <div class="form-group">
                                <label class="control-label" for="cod_parro">Parroquia</label>
                                <select disabled class="form-control" name="cod_parro" id="cod_parro">
                                  <option value="">--Seleccionar--</option>
                                </select>
                                <p class="help-block" id="cod_parro_chequeo">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- dir -->
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="form-group">
                            <label for="direcc" class="control-label">Dirección (Av/Calle/Edf.)</label>
                            <textarea
                            class="form-control"
                            maxlenght="150"
                            rows="2"
                            disabled
                            name="direcc"
                            placeholder="Sin registros, favor actualizar"
                            id="direcc"><?php echo $datos['direcc'] ?></textarea>
                            <p class="help-block" id="direcc_chequeo">
                            </p>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <!-- Seudonimo y tipo de usuario -->
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="row">
                          <div class="col-xs-11">
                            <div class="form-group">
                              <label for="seudonimo" class="control-label">Seudónimo</label>
                              <input
                                class="form-control"
                                type="text"
                                name="seudonimo"
                                id="seudonimo"
                                disabled
                                placeholder="No esta registrada"
                                value="<?php echo $datos['seudonimo'] ?>"
                                maxlength="20">
                              <p class="help-block" id="seudonimo_chequeo">
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="row">
                          <div class="col-xs-11">
                            <div class="form-group">
                              <label for="cod_tipo_usr" class="control-label">Tipo de usuario en sistema</label>
                              <?php $query = "SELECT codigo, descripcion
                              from tipo_usuario where status = 1 and codigo != 255;";
                                $resultado = conexion($query);?>
                              <select disabled class="form-control" name="cod_tipo_usr" id="cod_tipo_usr" required>
                                <?php while ( $tipoUsr = mysqli_fetch_array($resultado) ) : ?>
                                  <?php if ($datos['cod_tipo_usr'] === $tipoUsr['codigo']): ?>
                                    <option selected="selected"
                                    value="<?php echo $tipoUsr['codigo'] ?>">
                                      <?php echo $tipoUsr['descripcion'] ?>
                                    </option>
                                  <?php endif ?>
                                  <option value="<?php echo $tipoUsr['codigo'] ?>">
                                    <?php echo $tipoUsr['descripcion'] ?>
                                  </option>
                                <?php endwhile; ?>
                              </select>
                              <p class="help-block" id="cod_tipo_usr_chequeo">
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- info adicional -->
                  <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 bg-primary redondeado">
                      <div class="row">
                        <div class="col-xs-12">
                          <h4>
                            Por favor, asegúrese que los datos son correctos antes de
                            continuar con el proceso de actualización.
                          </h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- boton -->
                  <div class="row margenArriba">
                    <div class="col-sm-2 col-sm-offset-5">
                      <input
                      role="button"
                      id="submit"
                      class="btn btn-info btn-block"
                      type="submit"
                      disabled
                      name="registrar"
                      value="Continuar">
                    </div>
                  </div>
                </fieldset>
              </form>
              <!-- botones de control -->
              <div class="margen">
                <div class="row margen">
                  <div class="col-sm-4 col-sm-offset-4">
                    <?php if ($_SESSION['cod_tipo_usr'] < 3): ?>
                      <button class="actualizar btn btn-primary btn-block disabled">Actualizar</button>
                    <?php else: ?>
                      <button class="actualizar btn btn-primary btn-block">Actualizar</button>
                    <?php endif ?>
                  </div>
                </div>
                <div class="row margen">
                  <div class="col-sm-4 col-sm-offset-4">
                    <a href="reportes/detallado.php?cedula=<?php echo $cedula ?>" class="cons-est btn btn-default btn-block">Generar Reporte</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- calendario -->
        <?php $cssDatepick = enlaceDinamico("java/jqDatePicker/smoothness.datepick.css"); ?>
        <link href="<?php echo $cssDatepick ?>" rel="stylesheet">
        <?php $plugin = enlaceDinamico("java/jqDatePicker/jquery.plugin.js"); ?>
        <?php $datepick = enlaceDinamico("java/jqDatePicker/jquery.datepick.js"); ?>
        <script type="text/javascript" src="<?php echo $plugin ?>"></script>
        <script type="text/javascript" src="<?php echo $datepick ?>"></script>
        <!-- validacion -->
        <?php $validacion = enlaceDinamico("java/validacionPI.js"); ?>
        <script type="text/javascript" src="<?php echo $validacion ?>"></script>
        <?php $validacion = enlaceDinamico("java/validacionUsuario.js"); ?>
        <script type="text/javascript" src="<?php echo $validacion ?>"></script>
        <script type="text/javascript">
          $(function(){
            $('#form').on('submit', function (evento){
              // DESHABILITADO POR FALTA DE TIEMPO
              // evento.preventDefault();
              // if ( validacionPI() && validacionUsuario() ) {
              //   var nacionalidad = $('#nacionalidad').val();
              //   var cedula = $('#cedula').val();
              //   var p_nombre = $('#p_nombre').val();
              //   var s_nombre = $('#s_nombre').val();
              //   var p_apellido = $('#p_apellido').val();
              //   var s_apellido = $('#s_apellido').val();
              //   var fec_nac = $('#fec_nac').val();
              //   var sexo = $('#sexo').val();
              //   var email = $('#email').val();
              //   var nivel_instruccion = $('#nivel_instruccion').val();
              //   var titulo = $('#titulo').val();
              //   var telefono = $('#telefono').val();
              //   var telefono_otro = $('#telefono_otro').val();
              //   var celular = $('#celular').val();
              //   var cargo = $('#cargo').val();
              //   var tipo_personal = $('#tipo_personal').val();
              //   var direcc = $('#direcc').val();
              //   var cod_parroquia = $('#cod_parro').val();
              //   var cod_usr = <?php echo $datos['cod_usr'] ?>;
              //   var seudonimo = $('#seudonimo').val();
              //   var cod_tipo_usr = $('#cod_tipo_usr').val();
              //   console.log("exitos totales");
              //   $.ajax({
              //     url: 'actualizar_U.php',
              //     type: 'POST',
              //     dataType: 'html',
              //     data: {
              //       nacionalidad:nacionalidad,
              //       cedula:cedula,
              //       p_nombre:p_nombre,
              //       s_nombre:s_nombre,
              //       p_apellido:p_apellido,
              //       s_apellido:s_apellido,
              //       fec_nac:fec_nac,
              //       sexo:sexo,
              //       email:email,
              //       nivel_instruccion:nivel_instruccion,
              //       titulo:titulo,
              //       telefono:telefono,
              //       telefono_otro:telefono_otro,
              //       celular:celular,
              //       cod_cargo:cargo,
              //       tipo_personal:tipo_personal,
              //       direccion:direcc,
              //       cod_parroquia:cod_parroquia,
              //       seudonimo:seudonimo,
              //       cod_tipo_usr:cod_tipo_usr
              //     },
              //     success: function (datos){
              //       $("#contenido_form_act_PI").empty().append($(datos).find('#blancoAjax').html());
              //     },
              //   });
              // };
              if ( validacionPI() && validacionUsuario() ) {
                return true;
              }else{
                return false;
              }
            });
            $('#form').on('change', function(){
              validacionPI();
              validacionUsuario();
            });
          });
        </script>
        <!-- ajax de estado/mun/parr -->
        <?php $estadoEnlace = "java/edo.php?cod_est=".$datos['cod_est']; ?>
        <?php $estado = enlaceDinamico($estadoEnlace); ?>
        <?php $municipio = enlaceDinamico("java/mun.php"); ?>
        <?php $parroquia = enlaceDinamico("java/parro.php"); ?>
        <script type="text/javascript">
          $("document").ready(function(){
            $("#cod_est").load("<?php echo $estado ?>");
            $("#cod_est").change(function(){
              var id = $("#cod_est").val();
              $.get("<?php echo $municipio ?>",{param_id:id})
              .done(function(data){
                $("#cod_mun").html(data);
                $("#cod_mun").change(function(){
                  var id2 = $("#cod_mun").val();
                  $.get("<?php echo $parroquia ?>",{param_id2:id2})
                  .done(function(data){

                    $("#cod_parro").html(data);
                  });
                });
              });
            });

            $("#cod_est").ready(function(){
              var id = "<?php echo $datos['cod_est'] ?>";
              var cod_mun = "<?php echo $datos['cod_mun'] ?>";
              var id2 = "<?php echo $datos['cod_parro'] ?>";
              $.ajax({

                url:'../java/mun.php',
                data: {
                  'param_id': id,
                  'cod_mun': cod_mun
                },
                success: function(datos){
                  $("#cod_mun").html(datos);
                }
              });
              $.ajax({

                url:'../java/parro.php',
                data: {
                  'param_id2': cod_mun,
                  'cod_parro': id2
                },
                success: function(datos){
                  $("#cod_parro").html(datos);
                }
              });
            });
          });
        </script>
        <!-- validacion de est, mun, parro -->
        <script type="text/javascript">
          $(function(){
            $.ajax({
              url: '../java/validacionDireccion.js',
              type: 'POST',
              dataType: 'script'
            });
          });
        </script>
        <!-- cedula -->
        <script type="text/javascript">
          $(function(){
            $.ajax({
              url: '../java/ajax/cedula.js',
              type: 'POST',
              dataType: 'script'
            });
          });
        </script>
        <!-- email -->
        <script type="text/javascript">
          $(function(){
            $.ajax({
              url: '../java/ajax/ClaseChequearEmail.js',
              type: 'POST',
              dataType: 'script',
              success:function(){
                email = new ChequearEmail($('#email'), 'personal');
                email.original();
                $('#email').on('change', function () {
                  email.cambiar();
                  email.chequear();
                });
              },
            });
          });
        </script>
        <!-- calendario -->
        <script type="text/javascript">
          $(function(){
            $('#fec_nac').datepick({
              maxDate:'-12Y',
              minDate:'-100Y',
              dateFormat: "yyyy-mm-dd"
            });
          });
        </script>
        <!-- para cambiar de solo lectura a normal -->
        <script type="text/javascript" src="../java/otros/cambiarSoloLectura.js"></script>
        <script type="text/javascript">
          $(function() {
            $('.actualizar').on('click', function(evento) {
              cambiarSoloLectura($('#form'), 'Personal Interno');
            });
          });
        </script>
        <!-- CONTENIDO TERMINA ARRIBA DE ESTO: -->
      </div>
    </div>
  <?php else:
    empezarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr'], 'sistemaJAG | Actualizacion de usuario'); ?>
    <div id="blancoAjax">
      <div id="blancoAjax">
        <div class="container">
          <div class="row">
            <div class="jumbotron">
              <h1>Ups!</h1>
              <h3>
                La cedula: <strong><?php echo $cedula ?></strong>
                <small>No existe como usuario interno</small>
              </h3>
              <!-- !importante -->
              <?php $enlace = encuentraCedula($_REQUEST['cedula']) ?>
              <?php if ( $enlace ): ?>
                <div class="bg-info">
                  <h2>
                    Sin embargo:
                  </h2>
                  <p>
                    Esta cedula
                    <a href="<?php echo $enlace ?> ">existe en el sistema</a>
                  </p>
                </div>
                <!-- google hire me: slayerfat@gmail.com -->
              <?php endif ?>
              <p>
                 Error en el proceso de actualización!
              </p>
              <p>
                ¿O entró en esta pagina erróneamente?
              </p>
              <p class="bg-warning">
                Si este es un problema recurrente, contacte a un administrador del sistema.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
<?php else:
  empezarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr'], 'sistemaJAG | Actualizacion de usuario'); ?>
  <div id="blancoAjax">
    <div class="container">
      <div class="row">
        <div class="jumbotron">
          <h1>Ups!</h1>
          <p>
            Error en el proceso de actualización!
          </p>
          <p>
            ¿O entró en esta pagina erróneamente?
          </p>
          <p class="bg-warning">
            Si este es un problema recurrente, contacte a un administrador del sistema.
          </p>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php
//FINALIZAMOS LA PAGINA:
//trae footer.php y cola.php
finalizarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr']);?>
