<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
$enlace = $_SERVER['DOCUMENT_ROOT']."/github/sistemaJAG/php/master.php";
require_once($enlace);
// invocamos validarUsuario.php desde master.php
validarUsuario();
empezarPagina();

//if ( isset($_POST['seudonimo']) && isset($_POST['clave']) ): 
if ( true ): 
	// $seudonimo = $_POST['seudonimo'];
	// $clave = $_POST['clave'];
	$seudonimo = "hola";
	$clave = "matrix1";
	$hash = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 12]);
	$validarForma = new ChequearUsuario($seudonimo,	$hash);
	//CONTENIDO:?>
	<div id="contenido">
		<div id="blancoAjax">
			<!-- CONTENIDO EMPIEZA DEBAJO DE ESTO: -->
			<!-- DETALLESE QUE NO ES UN ID SINO UNA CLASE. -->
			<div class="contenido">
				<form method="POST" action="">
					<table>
						<thead>
							<th>Nacionalidad</th>
							<th>C&eacute;dula</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<select 
										name="nacionalidad"
										id="nacionalidad"
										required>
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
										required>
								</td>
							</tr>
							<tr>
								<td>
									
								</td>
								<td id="cedula_chequeo">
									
								</td>
							</tr>
						</tbody>
						<thead>
							<th>Primer Nombre</th>
							<th>Segundo Nombre</th>
							<th>Primer Apellido</th>
							<th>Segundo Apellido</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<input 
										type="text"
										name="p_nombre"
										id="p_nombre"
										required
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
										required
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
								<td id="p_nombre_chequeo"></td>
								<td id="s_nombre_chequeo"></td>
								<td id="p_apellido_chequeo"></td>
								<td id="s_apellido_chequeo"></td>
							</tr>
						</tbody>
						<thead>
							<th>Fecha de nacimiento</th>
							<th>Sexo</th>
							<th>Email</th>
							<th>Titulos y/o Certificados</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<input 
										type="date"
										name="fec_nac"
										id="fec_nac"
										required>
								</td>
								<td>
									<?php
										$query = "SELECT codigo, descripcion from sexo where status = 1;";
										$registros = conexion($query);
									?>
									<select name="sexo" id="sexo" required>
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
								<td id="email_chequeo">
									
								</td>
								<td id="titulo_chequeo">
									
								</td>
							</tr>
						</tbody>
						<thead>
							<th>Nivel Educativo</th>
							<th>Telefono</th>
							<th>Telefono Adicional</th>
							<th>Telefono Celular</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<?php $sql="SELECT codigo, descripcion from nivel_instruccion where status = 1;";
										$registros = conexion($sql);?>
									<select name="nivel_instruccion" required id="nivel_instruccion">
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
								<td id="telefono_chequeo">
									
								</td>
								<td id="telefono_otro_chequeo">
									
								</td>
								<td id="celular_chequeo">
									
								</td>
							</tr>
						</tbody>
						<thead>
							<th>Cargo</th>
							<th>Direccion (Av/Calle/Edf.)</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<?php $sql="SELECT codigo, descripcion from cargo where status = 1;";
										$registros = conexion($sql);?>
									<select name="cargo" required id="cargo">
									<?php while($fila = mysqli_fetch_array($registros)) :	?>
										<option value="<?php echo $fila['codigo']?>">
										<?php echo $fila['descripcion']?></option>
									<?php endwhile; ?>
									</select>
								</td>
								<td colspan="3">
									<textarea
											maxlenght="150"
											cols="100"
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
							<th>Estado</th>
							<th>Municipio</th>
							<th>Parroquia</th>
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
									<input type="button" name="registrar" value="Insertar">
								</td>
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
			<?php $validacion = enlaceDinamico("java/validacionUsuario.js"); ?>
			<script type="text/javascript" src="<?php echo $validacion ?>"></script>
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
<?php
//FINALIZAMOS LA PAGINA:
//trae footer.php y cola.php
finalizarPagina();?>