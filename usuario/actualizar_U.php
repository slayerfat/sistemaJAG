<?php
if(!isset($_SESSION)){
  session_start();
}
$enlace = $_SERVER['DOCUMENT_ROOT']."/github/sistemaJAG/php/master.php";
require_once($enlace);
// invocamos validarUsuario.php desde master.php
validarUsuario();

//ESTA FUNCION TRAE EL HEAD Y NAVBAR:
//DESDE empezarPagina.php
empezarPagina();

if (isset($_POST['tipo'])	and isset($_POST['cedula']) ) :
	if ($_POST['tabla'] == '1') :
		$tabla = 'docente';
	elseif ($_POST['tabla'] == '2'):
		$tabla = 'administrativo';
	elseif ($_POST['tabla'] == '3'):
		$tabla = 'directivo';
	endif;
<?php
//FINALIZAMOS LA PAGINA:
//trae footer.php y cola.php
finalizarPagina();?>
<?php else: ?>
	<?php header('Location: consultar_U.php?error=vacio'); ?>
<?php endif; ?>
