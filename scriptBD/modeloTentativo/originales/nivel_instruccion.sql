CREATE TABLE nivel_instruccion (
  codigo tinyint(1) unsigned primary key,
  descripcion varchar(20) not null,
  status tinyint(1) unsigned not null default 1,
  cod_usr_reg int unsigned not null,
  fec_reg timestamp not null default current_timestamp,
  cod_usr_mod int unsigned not null,
  fec_mod timestamp not null DEFAULT 0,
  foreign key (cod_usr_reg)
    references usuario(codigo)
    on update cascade
    on delete restrict,
  foreign key (cod_usr_mod)
    references usuario(codigo)
    on update cascade
    on delete restrict
)
CHARACTER SET utf8
COLLATE utf8_general_ci;

INSERT INTO `nivel_instruccion`
(codigo, descripcion, status, cod_usr_reg, cod_usr_mod, fec_mod )
VALUES
(0, 'N/S', 1, 1, 1, current_timestamp),
(1, 'Inicial', 1, 1, 1, current_timestamp),
(2, 'Primaria', 1, 1, 1, current_timestamp),
(3, 'Diversificada', 1, 1, 1, current_timestamp),
(4, 'Tecnico Medio', 1, 1, 1, current_timestamp),
(5, 'Tecnico Superior', 1, 1, 1, current_timestamp),
(6, 'Universitario', 1, 1, 1, current_timestamp),
(7, 'Post-grado', 1, 1, 1, current_timestamp),
(8, 'Doctorado', 1, 1, 1, current_timestamp)
;
