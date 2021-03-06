<?php
/**
 * @author Alejnadro Granadillo. <[slayerfat@gmail.com]>
 *
 * @internal genera un pdf con los datos del query expresado, requiere
 * al menos la cédula del alumno para generar el reporte o da mensaje de error.
 *
 * @see insertar_A.php
 *
 * @version 1.0
 */
$enlace = $_SERVER['DOCUMENT_ROOT']."/github/sistemaJAG/php/master.php";
require_once($enlace);
$enlace = enlaceDinamico('php/tcpdf/tcpdf.php');
require_once($enlace);
$enlace = enlaceDinamico('php/clases/claseTCPDFEnvenenado.php');
require_once($enlace);

if(!isset($_SESSION)){
session_start();
}
validarUsuario(1, 1, $_SESSION['cod_tipo_usr']);
if (!( isset($_GET['cedula']) and preg_match( "/[0-9]{6,8}/", $_GET['cedula']) )) :
  empezarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr']);?>
  <div id="contenido_actualizar_A">
    <div id="blancoAjax">
      <div class="container">
        <div class="row">
          <div class="jumbotron">
            <h1>Ups!</h1>
            <p>
              Error en el proceso de reporte!
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
<?php finalizarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr']);
else :
  $conexion = conexion();
  $cedula = mysqli_escape_string($conexion, $_GET['cedula']);
  $query = "SELECT
  persona.codigo, cedula, cedula_escolar, nacionalidad,
  p_nombre, s_nombre, p_apellido, s_apellido,
  sexo, fec_nac, lugar_nac, telefono, telefono_otro,
  alumno.comentarios,
  curso.descripcion as curso,
  parroquia.descripcion as parroquia,
  municipio.descripcion as municipio,
  estado.descripcion as estado,
  direccion_exacta as direccion,
  acta_num_part_nac, acta_folio_num_part_nac,
  plantel_procedencia, repitiente,
  altura, peso,
  camisa.descripcion as camisa,
  pantalon.descripcion as pantalon,
  zapato, certificado_vacuna,
  discapacidad.descripcion as discapacidad
  FROM persona
  inner join alumno
  on persona.codigo = alumno.cod_persona
  inner join talla as camisa
  on alumno.camisa = camisa.codigo
  inner join talla as pantalon
  on alumno.pantalon = pantalon.codigo
  inner join discapacidad
  on alumno.cod_discapacidad = discapacidad.codigo
  inner join asume
  on alumno.cod_curso = asume.codigo
  inner join curso
  on asume.cod_curso = curso.codigo
  inner join direccion
  on persona.codigo = direccion.cod_persona
  inner join parroquia
  on direccion.cod_parroquia = parroquia.codigo
  inner join municipio
  on parroquia.cod_mun = municipio.codigo
  inner join estado
  on municipio.cod_edo = estado.codigo
  where cedula = '$cedula';";
  $resultado = conexion($query);
  if ($resultado->num_rows === 1) :
    $datos = mysqli_fetch_assoc($resultado);
    // crea un nuevo documento pdf por medio de la clase TCDPF
    $pdf = new TCPDFEnvenenado(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Informacion inicial del documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('EBNB Jose Antonio Gonzalez');
    $pdf->SetTitle('Constancia de inscripción');

    // crea data del header y footer:
    // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    $pdf->setPrintHeader(true);

    // fuentes de header y footer
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // crea margenes
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(500);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // crea nuevas paginas automaticamente.
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor (escala imagenes)
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // crea una pagina
    $pdf->AddPage();

    // variables de fecha:
    $meses = array(
      '01' => 'ENERO',
      '02' => 'FEBRERO',
      '03' => 'MARZO',
      '04' => 'ABRIL',
      '05' => 'MAYO',
      '06' => 'JUNIO',
      '07' => 'JULIO',
      '08' => 'AGOSTO',
      '09' => 'SEPTIEMBRE',
      '10' => 'OCTUBRE',
      '11' => 'NOVIEMBRE',
      '12' => 'DICIEMBRE',
      '1' => 'ENERO',
      '2' => 'FEBRERO',
      '3' => 'MARZO',
      '4' => 'ABRIL',
      '5' => 'MAYO',
      '6' => 'JUNIO',
      '7' => 'JULIO',
      '8' => 'AGOSTO',
      '9' => 'SEPTIEMBRE'
    );
    $n = date('m');
    $mes = $meses[$n];
    $x = date('d');
    $y = $n;
    $z = date('Y');
    $n = intval(date('Y'));
    $n1 = $n+1;
    // variables de persona:
    // $p_nombre_r = htmlentities($datos['p_nombre_r'], ENT_QUOTES);
    // $p_apellido_r = htmlentities($datos['p_apellido_r'], ENT_QUOTES);
    $cedula = $datos['cedula'];
    $cedula_escolar = $datos['cedula_escolar'];
    $nacionalidad = $datos['nacionalidad'] === ('v') ? 'Venezolano':'Extrangero';
    $p_nombre = htmlentities($datos['p_nombre'], ENT_QUOTES);
    $s_nombre = htmlentities($datos['s_nombre'], ENT_QUOTES);
    if ($datos['s_nombre'] != '' && $datos['s_nombre'] != null) :
      $s_nombre = $datos['s_nombre'];
    else :
      $s_nombre = '-';
    endif;
    $p_apellido = htmlentities($datos['p_apellido'], ENT_QUOTES);
    $s_apellido = htmlentities($datos['s_apellido'], ENT_QUOTES);
    if ($datos['s_apellido'] != '' && $datos['s_apellido'] != null) :
      $s_apellido = $datos['s_apellido'];
    else :
      $s_apellido = '-';
    endif;
    $sexo = $datos['sexo'] === ('0') ? 'Masculino':'Femenino';
    $fec_nac = $datos['fec_nac'];
    if ($datos['lugar_nac'] != '' && $datos['lugar_nac'] != null) :
      $lugar_nac = htmlentities($datos['lugar_nac'], ENT_QUOTES);
    else :
      $lugar_nac = 'SIN INFORMACIÓN, FAVOR ACTUALIZAR';
    endif;
    $telefono = $datos['telefono'] === (null) ? '-':$datos['telefono'];
    $telefono_otro = $datos['telefono_otro'] === (null) ? '-':$datos['telefono_otro'];
    $curso = htmlentities($datos['curso'], ENT_QUOTES);
    $parroquia = htmlentities($datos['parroquia'], ENT_QUOTES);
    $municipio = htmlentities($datos['municipio'], ENT_QUOTES);
    $estado = htmlentities($datos['estado'], ENT_QUOTES);
    if ($datos['direccion'] != '' && $datos['direccion'] != null) :
      $direccion_exacta = $datos['direccion'];
    else :
      $direccion_exacta = 'SIN INFORMACIÓN, FAVOR ACTUALIZAR';
    endif;
    $acta_num_part_nac = htmlentities($datos['acta_num_part_nac'], ENT_QUOTES);
    $acta_folio_num_part_nac = htmlentities($datos['acta_folio_num_part_nac'], ENT_QUOTES);
    if ($datos['plantel_procedencia'] != '' && $datos['plantel_procedencia'] != null) :
      $plantel_procedencia = htmlentities($datos['plantel_procedencia'], ENT_QUOTES);
    else :
      $plantel_procedencia = 'SIN INFORMACIÓN, FAVOR ACTUALIZAR';
    endif;
    $repitiente = $datos['repitiente'] === ('s') ? 'SI':'NO';
    $altura = $datos['altura'] === (null) ? '-':$datos['altura'];
    $peso = $datos['peso'] === (null) ? '-':$datos['peso'];
    $camisa = $datos['camisa'] === (null) ? '-':$datos['camisa'];
    $pantalon = $datos['pantalon'] === (null) ? '-':$datos['pantalon'];
    $zapato = $datos['zapato'] === (null) ? '-':$datos['zapato'];
    $certificado_vacuna = $datos['certificado_vacuna'] === ('s') ? 'SI':'NO';
    $discapacidad = htmlentities($datos['discapacidad'], ENT_QUOTES);
    $comentarios = htmlentities($datos['comentarios'], ENT_QUOTES);
    // $dia_alumno = $datos['dia'];
    // $mes_alumno = $meses[$datos['mes']];
    // $anio_alumno = $datos['anio'];
    // $articulo = $datos['sexo'] === ('0') ? 'el':'la';
    // $sustantivoAlumno = $datos['sexo'] === ('0') ? 'alumno':'alumna';
    // $nacidoa = $datos['sexo'] === ('0') ? 'nacido':'nacida';
    // $inscritoa = $datos['sexo'] === ('0') ? 'inscrito':'inscrita';
// contenido a ejectuar para pdf:
$html = <<<HTML
<style>
  table{
    border-collapse: collapse;
    text-align: left;
  }
  table th{
    width:16%;
    padding: 15px 0;
    margin: 10px 0;
  }
  table td{
    width: 33%;
  }

</style>
<p></p>
<p></p>
<div>
<h1 align="center"><strong>REPORTE DE ALUMNO</strong></h1>
  <div>
    <table cellspacing="0" style="border-collapse:collapse;text-align: left;">
      <tbody>
        <tr>
          <th>Nac.:</th>
          <td><strong>{$nacionalidad}</strong></td>
        </tr>
        <tr>
          <th width="48%">Numero de acta partida nacimiento:</th>
          <td><strong>{$acta_num_part_nac}</strong></td>
        </tr>
        <tr>
          <th width="48%">Numero de folio partida nacimiento:</th>
          <td><strong>{$acta_folio_num_part_nac}</strong></td>
        </tr>
        <tr>
          <th>Cédula:</th>
          <td><strong>{$cedula}</strong></td>
          <th>Ced. Escolar:</th>
          <td><strong>{$cedula_escolar}</strong></td>
        </tr>
        <tr>
          <th>P. Apellido:</th>
          <td><strong>{$p_apellido}</strong></td>
          <th>S. Apellido:</th>
          <td><strong>{$s_apellido}</strong></td>
        </tr>
        <tr>
          <th>P. Nombre:</th>
          <td><strong>{$p_nombre}</strong></td>
          <th>S. Nombre:</th>
          <td><strong>{$s_nombre}</strong></td>
        </tr>
        <tr>
          <th>Sexo:</th>
          <td><strong>{$sexo}</strong></td>
          <th>Fec. Nac.:</th>
          <td><strong>{$fec_nac}</strong></td>
        </tr>
        <tr>
          <th colspan="2" width="100%">Lugar de nacimiento:</th>
          <td></td>
        </tr>
        <tr>
          <td rowspan="1" colspan="3" width="100%"><strong>{$lugar_nac}</strong></td>
        </tr>
        <tr>
          <th>Teléfono:</th>
          <td><strong>{$telefono}</strong></td>
          <th>Telf. adc.:</th>
          <td><strong>{$telefono_otro}</strong></td>
        </tr>
        <tr>
          <th>Estado:</th>
          <td><strong>{$estado}</strong></td>
          <th>Municipio:</th>
          <td><strong>{$municipio}</strong></td>
        </tr>
        <tr>
          <th>Parroquia:</th>
          <td><strong>{$parroquia}</strong></td>
        </tr>
        <tr>
          <th colspan="2" width="100%">Dirección detallada:</th>
          <td></td>
        </tr>
        <tr>
          <td rowspan="1" colspan="3" width="100%"><strong>{$direccion_exacta}</strong></td>
        </tr>
        <tr>
          <th width="10%">Curso:</th>
          <td><strong>{$curso}</strong></td>
        </tr>
        <tr>
          <th colspan="2" width="100%">Plantel de procedencia:</th>
          <td></td>
        </tr>
        <tr>
          <td rowspan="1" colspan="3" width="100%"><strong>{$plantel_procedencia}</strong></td>
        </tr>
        <tr>
          <th>Repitiente:</th>
          <td><strong>{$repitiente}</strong></td>
          <th>Altura(cm):</th>
          <td><strong>{$altura}</strong></td>
        </tr>
        <tr>
          <th>Peso(kg):</th>
          <td><strong>{$peso}</strong></td>
          <th>camisa:</th>
          <td><strong>{$camisa}</strong></td>
        </tr>
        <tr>
          <th>Pantalon:</th>
          <td><strong>{$pantalon}</strong></td>
          <th>Zapato:</th>
          <td><strong>{$zapato}</strong></td>
        </tr>
        <tr>
          <th width="30%">Certificado de vacunación:</th>
          <td width="19%"><strong>{$certificado_vacuna}</strong></td>
          <th width="18%">Discapacidad:</th>
          <td><strong>{$discapacidad}</strong></td>
        </tr>
        <tr>
          <th colspan="2" width="100%">Comentarios:</th>
          <td></td>
        </tr>
        <tr>
          <td rowspan="1" colspan="3" width="100%"><strong>{$comentarios}</strong></td>
        </tr>
      </tbody>
    </table>
  </div>
  <p style="padding:150px;">&nbsp;</p>
  <p><em>Reporte generado el: {$x}-{$y}-{$z}</em></p>
</div>
HTML;
    // magia:
    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    // ---------------------------------------------------------

    // termina el proceso y crea el archivo:
    $y = date('m');
    $nombre = "reporte-alumno-$cedula-$x-$y-$z.pdf";
    $pdf->Output($nombre, 'I');
  else:
    empezarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr']);?>
    <div id="contenido_actualizar_A">
      <div id="blancoAjax">
        <div class="container">
          <div class="row">
            <div class="jumbotron">
              <h1>Ups!</h1>
              <p>
                Error en el proceso de reporte!
              </p>
              <p class="bg-danger">
                La cedula: <strong><?php echo $_GET['cedula'] ?></strong>,
                no esta registrada como alumno.
              </p>
              <!-- !importante -->
              <?php $enlace = encuentraCedula($_REQUEST['cedula']) ?>
              <?php if ( $enlace ): ?>
                <!-- se quedaron locos verdad? -->
                <div class="bg-info">
                  <h2>
                    Sin embargo:
                  </h2>
                  <p>
                    Esta cedula
                    <a href="<?php echo $enlace ?> ">existe en el sistema</a>
                  </p>
                </div>
              <?php else: ?>
                <?php
                $enlace = "personalAutorizado/form_reg_P.php";
                $inscripcion = enlaceDinamico("$enlace"); ?>
                <p>
                  La cedula <?php echo $_GET['cedula'] ?>, no esta registrada en el sistema.
                  <em>Para registrar a un alumno, es necesario registrar primero al representante.</em>
                  para ir al proceso de inscripción <a href="<?php echo $inscripcion ?>">
                  puede seguir este enlace.
                  </a>
                </p>
                <!-- google hire me: slayerfat@gmail.com -->
              <?php endif ?>
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
    <?php finalizarPagina($_SESSION['cod_tipo_usr'], $_SESSION['cod_tipo_usr']);
  endif;
endif;
?>
