<?php

/**
* @author Granadillo Alejandro.
*
* @internal
*
* @todo MODIFICAR 99 al numero exacto del acta y folio
*
* @see chequearGenericoEjemplo.php
* @example chequearGenericoEjemplo.php
* @todo ampliar segun sea necesario segun
* los objetivos necesarios:
*
* @version 1.5
*
*
*/
class ChequearAlumno extends ChequearGenerico{
  function __construct(
    $codUsrMod,
    $p_apellido,
    $s_apellido = 'default',
    $p_nombre,
    $s_nombre = 'default',
    $nacionalidad,
    $cedula = 'default',
    $cedulaEscolar,
    $telefono = 'default',
    $telefonoOtro = 'default',
    $fecNac,
    $lugNac = 'default',
    $sexo,
    $actaNumero,
    $actaFolio,
    $plantelProcedencia = 'default',
    $repitiente,
    $codCurso,
    $altura = 'default',
    $peso = 'default',
    $camisa = 'default',
    $pantalon = 'default',
    $zapato = 'default',
    $discapacidad,
    $vacuna,
    $partidaNac = 'default',
    $constanciaSano = 'default',
    $canaima = 'default',
    $bicentenario = 'default',
    $boleta = 'default',
    $fotosR = 'default',
    $fotoCedulaPA = 'default',
    $fotoCedulaPR = 'default',
    $comentarios = 'default',
    $codRepresentante,
    $codPersonaRetira = 'default'
  ){
    //variables de la clase:
    $conexion = conexion();//desde master.php > conexion.php
    $this->codUsrMod = mysqli_escape_string($conexion, trim($codUsrMod));
    $this->p_apellido = mysqli_escape_string($conexion, trim($p_apellido));
    $this->s_apellido = mysqli_escape_string($conexion, trim($s_apellido));
    $this->p_nombre = mysqli_escape_string($conexion, trim($p_nombre));
    $this->s_nombre = mysqli_escape_string($conexion, trim($s_nombre));
    $this->nacionalidad = mysqli_escape_string($conexion, trim($nacionalidad));
    $this->cedula = mysqli_escape_string($conexion, trim($cedula));
    $this->cedulaEscolar = mysqli_escape_string($conexion, trim($cedulaEscolar));
    $this->telefono = mysqli_escape_string($conexion, trim($telefono));
    $this->telefonoOtro = mysqli_escape_string($conexion, trim($telefonoOtro));
    $this->fecNac = mysqli_escape_string($conexion, trim($fecNac));
    $this->lugNac = mysqli_escape_string($conexion, trim($lugNac));
    $this->sexo = mysqli_escape_string($conexion, trim($sexo));
    $this->actaNumero = mysqli_escape_string($conexion, trim($actaNumero));
    $this->actaFolio = mysqli_escape_string($conexion, trim($actaFolio));
    $this->plantelProcedencia = mysqli_escape_string($conexion, trim($plantelProcedencia));
    $this->repitiente = mysqli_escape_string($conexion, trim($repitiente));
    $this->codCurso = mysqli_escape_string($conexion, trim($codCurso));
    $this->altura = mysqli_escape_string($conexion, trim($altura));
    $this->peso = mysqli_escape_string($conexion, trim($peso));
    $this->camisa = mysqli_escape_string($conexion, trim($camisa));
    $this->pantalon = mysqli_escape_string($conexion, trim($pantalon));
    $this->zapato = mysqli_escape_string($conexion, trim($zapato));
    $this->discapacidad = mysqli_escape_string($conexion, trim($discapacidad));
    $this->vacuna = mysqli_escape_string($conexion, trim($vacuna));
    $this->codRepresentante = mysqli_escape_string($conexion, trim($codRepresentante));
    $this->codPersonaRetira = mysqli_escape_string($conexion, trim($codPersonaRetira));
    $this->recaudos = array(
      'partidaNac' => mysqli_escape_string($conexion, trim($partidaNac)),
      'constanciaSano' => mysqli_escape_string($conexion, trim($constanciaSano)),
      'canaima' => mysqli_escape_string($conexion, trim($canaima)),
      'bicentenario' => mysqli_escape_string($conexion, trim($bicentenario)),
      'boleta' => mysqli_escape_string($conexion, trim($boleta)),
      'fotosR' => mysqli_escape_string($conexion, trim($fotosR)),
      'fotoCedulaPA' => mysqli_escape_string($conexion, trim($fotoCedulaPA)),
      'fotoCedulaPR' => mysqli_escape_string($conexion, trim($fotoCedulaPR)),
      );
    $this->comentarios = mysqli_escape_string($conexion, trim($comentarios));
    //metodos internos:
    //para poner variables nulas si es necesario:
    self::setNull();
    //chequeaomos la forma (el objeto como tal):
    self::chequeaForma();
    self::chequeame(); //heredado de ChequearGenerico
  }

  /**
  *
  * @internal {chequea que los datos
  * existan antes de enviarlos a la base de datos.
  * tambien chequea la validez de cedula,
  * y valizacion de clave de usuario en base de datos
  * ej: nombre = juan1 < error}
  * @version 1.3
  *
  *
  * @return void
  *
  */

  private function chequeame(){

    if ( $this->nacionalidad <> "'v'" and $this->nacionalidad <> "'e'" ) {
      self::verificar("Error en: nacionalidad, se espera valor apropiado del formulario, datos: ".$this->nacionalidad);
    }

    if ( !preg_match( '/^[\']\d{8}[\']$/', $this->cedula) ) {
      self::verificar("Error en: cedula: solo numeros, datos: ".$this->cedula);
    }

    if ( !preg_match( '/^[\']\d{10}[\']$/', $this->cedulaEscolar) ) {
      self::verificar("Error en: cedula escolar: solo numeros, datos: ".$this->cedulaEscolar);
    }

    if ( preg_match( "/[^a-zA-Z-_áéíóúÁÉÍÓÚÑñ']/", $this->p_nombre) ) {
      self::verificar("Error en: primer nombre: solo letas, datos: ".$this->p_nombre);
    }

    if ($this->s_nombre <> 'default') {
      if ( preg_match( "/[^a-zA-Z-_áéíóúÁÉÍÓÚÑñ']/", $this->s_nombre) ) {
        self::verificar("Error en: segundo nombre: solo letas, datos: ".$this->s_nombre);
      }
    }

    if ( preg_match( "/[^a-zA-Z-_áéíóúÁÉÍÓÚÑñ']/", $this->p_apellido) ) {
      self::verificar("Error en: primer apellido: solo letas, datos: ".$this->p_apellido);
    }

    if ( $this->s_apellido <> 'default' ) {
      if ( preg_match( "/[^a-zA-Z-_áéíóúÁÉÍÓÚÑñ']/", $this->s_apellido) ) {
        self::verificar("Error en: segundo apellido: solo letas, datos: ".$this->s_apellido);
      }
    }

    if ($this->telefono <> 'default' && $this->telefono <> "'-'") {
      if ( !preg_match( '/^[\']\d{11}[\']$/', $this->telefono) ) {
        self::verificar("Error en: telefono: se espera solo numeros: 02125559911, datos: ".$this->telefono);
      }
    }

    if ($this->telefonoOtro <> 'default' && $this->telefonoOtro <> "'-'") {
      if ( !preg_match( '/^[\']\d{11}[\']$/', $this->telefonoOtro) ) {
        self::verificar("Error en: telefono: se espera solo numeros: 02125559911, datos: ".$this->telefonoOtro);
      }
    }

    if ($this->fecNac <> 'current_timestamp') {
      if ( preg_match( "/['][^0-9$^-][']/", $this->fecNac) ) {
        self::verificar("Error en: fecha de nacimiento se espera AAAA-MM-DD, datos: ".$this->fecNac);
      }
    }

    if ($this->sexo <> "'0'" and $this->sexo <> "'1'") {
      if ( !is_numeric($this->sexo) ) {
        self::verificar("Error en: sexo: se esperan un valor apropiados del formulario, datos: ".$this->sexo);
      }
    }

    if ($this->lugNac <> 'default') {
      if ( strlen($this->lugNac) > 50 ) {
       self::verificar("Error en: lugar de nacimiento: datos excede limite maximo, datos: ".$this->lugNac.", largo: ".strlen($this->lugNac));
      }
    }

    /**
    * @todo MODIFICAR 20 al numero exacto del acta y folio
    */

    if ($this->actaNumero <> 'default') {
      if ( preg_match( "/['][^0-9$^-][']/", $this->actaNumero) ) {
        self::verificar("Error en: Acta numero Part. Nac: se espera solo numeros, datos: ".$this->actaNumero);
      }
      if ( strlen($this->actaNumero) > 22 ) { // modificar al numero real
        self::verificar("Error en: Acta numero Part. Nac: tamaño excede limite maximo, datos: ".$this->actaNumero);
      }
    }

    if ($this->actaFolio <> 'default') {
      if ( preg_match( "/['][^0-9$^-][']/", $this->actaFolio) ) {
        self::verificar("Error en: Acta folio Part. Nac: se espera solo numeros, datos: ".$this->actaFolio);
      }
      if ( strlen($this->actaFolio) > 22 ) { // modificar al numero real
        self::verificar("Error en: Acta numero Part. Nac: tamaño excede limite maximo, datos: ".$this->actaFolio);
      }
    }

    if ($this->plantelProcedencia <> 'default') {
      if ( strlen($this->plantelProcedencia) > 50 ) {
        self::verificar("Error en: plantel de procedencia: datos excede limite maximo, datos: ".
          $this->plantelProcedencia.", largo: ".strlen($this->plantelProcedencia));
      }
    }

    if ( $this->repitiente <> "'s'" and $this->repitiente <> "'n'" ) {
      self::verificar("Error en: sexo: se esperan un valor apropiados del formulario, datos: ".$this->repitiente);
    }

    if ($this->altura <> 'default') {
      if ( !is_numeric($this->altura) ) {
        self::verificar("Error en: altura: se espera solo numeros, datos: ".$this->altura);
      }
      if ( strlen($this->altura) > 3 ) {
        self::verificar("Error en: altura: tamaño excede limite maximo, datos: ".$this->altura);
      }
    }

    if ($this->peso <> 'default') {
      if ( !is_numeric($this->peso) ) {
        self::verificar("Error en: peso: se espera solo numeros, datos: ".$this->peso);
      }
      if ( strlen($this->peso) > 3 ) {
        self::verificar("Error en: peso: tamaño excede limite maximo, datos: ".$this->peso);
      }
    }

    if ($this->camisa <> 'default') {
      if ( !is_numeric($this->camisa) ) {
        self::verificar("Error en: camisa: se espera solo numeros, datos: ".$this->camisa);
      }
      if ( strlen($this->camisa) > 1 ) {
        self::verificar("Error en: camisa: tamaño excede limite maximo, datos: ".$this->camisa);
      }
    }

    if ($this->pantalon <> 'default') {
      if ( !is_numeric($this->pantalon) ) {
        self::verificar("Error en: pantalon: se espera solo numeros, datos: ".$this->pantalon);
      }
      if ( strlen($this->pantalon) > 1 ) {
        self::verificar("Error en: pantalon: tamaño excede limite maximo, datos: ".$this->pantalon);
      }
    }

    if ($this->zapato <> 'default') {
      if ( !is_numeric($this->zapato) ) {
        self::verificar("Error en: zapato: se espera solo numeros, datos: ".$this->zapato);
      }
      if ( strlen($this->zapato) > 2 ) {
        self::verificar("Error en: zapato: tamaño excede limite maximo, datos: ".$this->zapato);
      }
    }

    if ( preg_match( "/[^0-9]/", $this->discapacidad) ) {
      self::verificar("Error en: tipo de discapacidad: se esperan un valor apropiados del formulario, datos: ".$this->discapacidad);
    }

    if ( $this->vacuna <> "'s'" and $this->vacuna <> "'n'" ) {
      self::verificar("Error en: cert. vacuna: se esperan un valor apropiados del formulario, datos: ".$this->vacuna);
    }

    // recaudos fisicos
    foreach ($this->recaudos as $campo => $valor) :
      if ($valor <> "'s'" and $valor <> "'n'" ) :
        self::verificar("Error en: recaudos de $campo: se esperan un valor apropiados del formulario, datos: ".$valor);
      endif;
    endforeach;

    if ($this->comentarios <> 'default') {
      if ( strlen($this->comentarios) > 500 ) {
        self::verificar("Error en: comentarios: datos excede limite maximo, datos: ".
          $this->comentarios.", largo: ".strlen($this->comentarios));
      }
    }
  }

  /**
  *
  * {@internal esto es para autogenerar el default
  * para los campos que acepten default en la base de datos.}
  *
  * @return void [solo genera las variables internas de la clase]
  */
  private function setNull(){
    $this->p_apellido = "'$this->p_apellido'";

    if ($this->s_apellido == "") {
      $this->s_apellido = "default";
    }else{
      $this->s_apellido = "'$this->s_apellido'";
    }

    $this->p_nombre = "'$this->p_nombre'";

    if ($this->s_nombre == "") {
      $this->s_nombre = "default";
    }else{
      $this->s_nombre = "'$this->s_nombre'";
    }

    $this->nacionalidad = "'$this->nacionalidad'";
    $this->cedula = "'$this->cedula'";

    if ($this->actaNumero == "") {
      $this->actaNumero = "default";
    }else{
      $this->actaNumero = "'$this->actaNumero'";
    }
    if ($this->actaFolio == "") {
      $this->actaFolio = "default";
    }else{
      $this->actaFolio = "'$this->actaFolio'";
    }

    if ($this->telefono == "") {
      $this->telefono = "default";
    }else{
      $this->telefono = "'$this->telefono'";
    }
    if ($this->telefonoOtro == "") {
      $this->telefonoOtro = "default";
    }else{
      $this->telefonoOtro = "'$this->telefonoOtro'";
    }

    $this->fecNac = "'$this->fecNac'";

    if ($this->lugNac == "") {
      $this->lugNac = "default";
    }else{
      $this->lugNac = "'$this->lugNac'";
    }

    $this->sexo = "'$this->sexo'";

    $this->fecMod = "current_timestamp";
    $this->cedulaEscolar = "'$this->cedulaEscolar'";

    if ($this->plantelProcedencia == "") {
      $this->plantelProcedencia = "default";
    }else{
      $this->plantelProcedencia = "'$this->plantelProcedencia'";
    }
    $this->repitiente = "'$this->repitiente'";

    if ($this->altura == "") {
      $this->altura = "default";
    }

    if ($this->peso == "") {
      $this->peso = "default";
    }

    if ($this->camisa == "") {
      $this->camisa = "default";
    }

    if ($this->pantalon == "") {
      $this->pantalon = "default";
    }

    if ($this->zapato == "") {
      $this->zapato = "default";
    }

    if ($this->codPersonaRetira == "") {
      $this->codPersonaRetira = "default";
    }
    $this->vacuna = "'$this->vacuna'";

    // recaudos fisicos
    foreach ($this->recaudos as $campo => $valor) :
      if ($valor === '') :
        $this->recaudos[$campo] = 'default';
      else :
        $this->recaudos[$campo] = "'$valor'";
      endif;
    endforeach;

    if ($this->comentarios == "") {
      $this->comentarios = "default";
    }else{
      $this->comentarios = "'$this->comentarios'";
    }
  }

}

?>
