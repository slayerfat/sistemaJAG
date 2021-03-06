CREATE TABLE sexo (
	codigo tinyint(1) unsigned primary key,
	descripcion varchar(10) not null,
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

INSERT INTO sexo
values
(0,'Masculino', 1, 1, null, 1, current_timestamp),
(1,'Femenino', 1, 1, null, 1, current_timestamp)
;
