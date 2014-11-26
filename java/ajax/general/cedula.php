<?php
/**
 * @author [Alejandro Granadillo]
 *
 * @internal esto es utilizado para
 * hacer los queries por medio
 * de ajax para saber si la
 * cedula esta disponible
 *
 * @see
 * usuario/menucon.php
 * @example
 * usuario/menucon.php
 */
if ( isset($_POST['cedula']) ) :
	if (strlen($_POST['cedula']) == 8):
		$enlace = $_SERVER['DOCUMENT_ROOT']."/github/sistemaJAG/php/master.php";
		require_once($enlace);
		$con = conexion();
		$cedula = mysqli_escape_string($con,$_POST['cedula']);
		$query = "SELECT codigo FROM persona
		WHERE cedula = '$cedula';";
		$consulta = conexion($query);
		if ($consulta->num_rows == 0): ?>
			<span id="disponible" data-disponible="true">
			</span>
		<?php else: ?>
			<span id="disponible" data-disponible="false">
				Esta Cedula esta ya registrada en el sistema!
				<?php
					$query = "SELECT persona.cedula
					from persona
					inner join personal_autorizado
					on personal_autorizado.cod_persona = persona.codigo
					where persona.cedula = $cedula;";
					$resultado = conexion($query);
				?>
				<?php if ($resultado->num_rows <> 0): ?>
					<a href="consultar_P.php?cedula_r=<?php echo $_POST['cedula'] ?>">
						Consultar
					</a>
				<?php endif ?>
			</span>
		<?php endif ?>
	<?php mysqli_close($con) ?>
	<?php else: ?>
		<span style="color:red;">
			cedula no puede ser </br>mayor a 20 digitos ni menor a 3.
		</span>
	<?php endif ?>
<?php else: ?>
	<?php echo 'error' ?>
<?php endif; ?>
