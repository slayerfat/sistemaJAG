<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
$enlace = $_SERVER['DOCUMENT_ROOT']."/github/sistemaJAG/php/master.php";
require_once($enlace);

if ( isset($_POST['seudonimo']) && isset($_POST['clave']) ):
	$seudonimo = $_POST['seudonimo'];
	$clave = $_POST['clave'];
	$hash = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 12]);
	//$validarForma = new ChequearUsuario($seudonimo,	$hash);
	//CONTENIDO:?>
	<div id="contenido">
		<div id="blancoAjax">
			<!-- CONTENIDO EMPIEZA DEBAJO DE ESTO: -->
			<!-- DETALLESE QUE NO ES UN ID SINO UNA CLASE. -->
			<div class="contenido">
				<form method="POST" name="form_PI" id="form_PI" action="insertar_U.php">
					<table>
						<thead>
							<th id="nacionalidad_titulo">Nacionalidad</th>
							<th id="cedula_titulo">C&eacute;dula</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<select 
										name="nacionalidad"
										id="nacionalidad"
										1required>
										<option selected="selected" value="v">V</option>
										<option value="e">E</option>
									</select>
								</td>
								<td>
									<input 
										type="text"  
										maxlength="8" 
										name="cedula" 
										id="cedula" 
										1required>
								</td>
							</tr>
							<tr>
								<td class="chequeo" id="nacionalidad_chequeo">
									
								</td>
								<td class="chequeo" id="cedula_chequeo">
									
								</td>
							</tr>
						</tbody>
						<thead>
							<th id="p_nombre_titulo">Primer Nombre</th>
							<th id="s_nombre_titulo">Segundo Nombre</th>
							<th id="p_apellido_titulo">Primer Apellido</th>
							<th id="s_apellido_titulo">Segundo Apellido</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<input 
										type="text"
										name="p_nombre"
										id="p_nombre"
										1required
										maxlength="20">
								</td>
								<td>
									<input 
										type="text"
										name="s_nombre"
										id="s_nombre"
										maxlength="20">
								</td>
								<td>
									<input 
										type="text"
										name="p_apellido"
										id="p_apellido"
										1required
										maxlength="20">
								</td>
								<td>
									<input 
										type="text"
										name="s_apellido"
										id="s_apellido"
										maxlength="20">
								</td>
							</tr>
							<tr>
								<td class="chequeo" id="p_nombre_chequeo"></td>
								<td class="chequeo" id="s_nombre_chequeo"></td>
								<td class="chequeo" id="p_apellido_chequeo"></td>
								<td class="chequeo" id="s_apellido_chequeo"></td>
							</tr>
						</tbody>
						<thead>
							<th id="fec_nac_titulo">Fecha de nacimiento</th>
							<th id="sexo_titulo">Sexo</th>
							<th id="email_titulo">Email</th>
							<th id="titulo_titulo">Titulos y/o Certificados</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<input 
										type="date"
										name="fec_nac"
										id="fec_nac"
										1required>
								</td>
								<td>
									<?php
										$query = "SELECT codigo, descripcion from sexo where status = 1;";
										$registros = conexion($query);
									?>
									<select name="sexo" id="sexo" 1required>
										<option value="">Seleccione una opci&oacute;n </option>
										<?php	while($fila = mysqli_fetch_array($registros)) : ?>
											<option value="<?php echo $fila['codigo']; ?>">
												<?php echo $fila['descripcion']; ?>
											</option>
										<?php endwhile; ?>
									</select>
								</td>
								<td>
									<input 
										type="text"
										name="email"
										id="email"
										maxlength="20">
								</td>
								<td>
									<input 
										type="text"
										name="titulo"
										id="titulo"
										maxlength="80">
								</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td class="chequeo" id="email_chequeo">
									
								</td>
								<td class="chequeo" id="titulo_chequeo">
									
								</td>
							</tr>
						</tbody>
						<thead>
							<th id="nivel_instruccion_titulo">Nivel Educativo</th>
							<th id="telefono_titulo">Telefono</th>
							<th id="telefono_otro_titulo">Telefono Adicional</th>
							<th id="celular_titulo">Telefono Celular</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<?php $sql="SELECT codigo, descripcion from nivel_instruccion where status = 1;";
										$registros = conexion($sql);?>
									<select name="nivel_instruccion" 1required id="nivel_instruccion">
									<?php while($fila = mysqli_fetch_array($registros)) :	?>
										<option value="<?php echo $fila['codigo']?>">
										<?php echo $fila['descripcion']?></option>
									<?php endwhile; ?>
									</select>
								</td>
								<td>
									<input 
										type="text" 
										maxlength="11" 
										name="telefono"
										id="telefono">
								</td>
								<td>
									<input 
										type="text" 
										maxlength="11" 
										name="telefono_otro"
										id="telefono_otro">
								</td>
								<td>
									<input 
										type="text" 
										maxlength="11" 
										name="celular"
										id="celular">
								</td>
							</tr>
							<tr>
								<td></td>
								<td class="chequeo" id="telefono_chequeo">
									
								</td>
								<td class="chequeo" id="telefono_otro_chequeo">
									
								</td>
								<td class="chequeo" id="celular_chequeo">
									
								</td>
							</tr>
						</tbody>
						<thead>
							<th id="cargo_titulo">Cargo</th>
							<th id="tipo_titulo">Perfil de Usuario</th>
							<th id="direcc_titulo">Direccion (Av/Calle/Edf.)</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<?php $sql="SELECT codigo, descripcion from cargo where status = 1;";
										$registros = conexion($sql);?>
									<select name="cargo" 1required id="cargo">
									<?php while($fila = mysqli_fetch_array($registros)) :	?>
										<option value="<?php echo $fila['codigo']?>">
										<?php echo $fila['descripcion']?></option>
									<?php endwhile; ?>
									</select>
								</td>
								<td>
									<select name="tipo" id="tipo" 1required>
										<option value="" selected="selected">
											--Seleccione--
										</option>
										<option value="1">
											Administrativo
										</option>
										<option value="2">
											Docente
										</option>
										<option value="3">
											Directivo
										</option>
									</select>
								</td>
								<td colspan="3">
									<textarea
											maxlenght="150"
											cols="70"
											rows="3"
											name="direcc"
											id="direcc"></textarea>
								</td>
							</tr>
							<tr>
								<td></td>
							</tr>
						</tbody>
						<thead>
							<th id="estado_titulo">Estado</th>
							<th id="municipio_titulo">Municipio</th>
							<th id="parroquia_titulo">Parroquia</th>
						</thead>
						<tbody>
							<tr>
								<td>									
									<select name="cod_est" id="cod_est"></select>
								</td>
								<td>
									<select name="cod_mun" id="cod_mun" >
									<option value="">--Seleccionar--</option></select>
								</td>
								<td>				
									<select name="cod_parro" id="cod_parro">
									<option value="">--Seleccionar--</option></select>
								</td>
								<td>
									<input type="submit" name="registrar" value="Insertar">
								</td>
							</tr>
							<tr>
								
							</tr>
						</tbody>
					</table>
				</form>			
			</div>
			<!-- calendario -->
			<?php $cssDatepick = enlaceDinamico("java/jqDatePicker/jquery.datepick.css"); ?>
			<link href="<?php echo $cssDatepick ?>" rel="stylesheet">
			<?php $plugin = enlaceDinamico("java/jqDatePicker/jquery.plugin.js"); ?>
			<?php $datepick = enlaceDinamico("java/jqDatePicker/jquery.datepick.js"); ?>
			<script type="text/javascript" src="<?php echo $plugin ?>"></script>
			<script type="text/javascript" src="<?php echo $datepick ?>"></script>
			<!-- validacion -->
			<?php $validacion = enlaceDinamico("java/validacionPI.js"); ?>
			<script type="text/javascript" src="<?php echo $validacion ?>"></script>
			<script type="text/javascript">
			$(function(){
				$('#form_PI').on('submit', function (evento){
					evento.preventDefault();
					if ( validacionPI() ) {
						$.ajax({
							url: 'insertar_U.php',
							type: 'POST',
							data: {
								seudonimo:seudonimo,
								clave:clave
							},
							success: function (datos){
								$('#contenido').html('');
								$("#contenido").load().html(datos);
							},
						});
					};
				});
			});
			</script>
			<!-- ajax de estado -->
			<?php $estado = enlaceDinamico("java/edo.php"); ?>
			<?php $municipio = enlaceDinamico("java/mun.php"); ?>
			<?php $parroquia = enlaceDinamico("java/parro.php"); ?>
			<!-- ajax de estado/mun/par -->
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
				});
			</script>
			<!-- calendario -->
			<script type="text/javascript">
				<?php $imagen = enlaceDinamico("java/jqDatePicker/calendar-blue.gif"); ?>
				$(function(){
					$('#fec_nac').datepick({
						maxDate:'-h',
						showOn: "button",
						buttonImage: "<?php echo $imagen ?>",
						buttonImageOnly: true,
						dateFormat: "yyyy-mm-dd"
					});
				});
			</script>
			<!-- submit -->
			<!-- CONTENIDO TERMINA ARRIBA DE ESTO: -->
		</div>
	</div>
<?php else: ?>
	<div id="blancoAjax">
		Error en el proceso de inscripcion.
		</br>
		Ups! parece ser que trato de ingresar a esta pagina incorrectamente!
	</div>
<?php endif; ?>