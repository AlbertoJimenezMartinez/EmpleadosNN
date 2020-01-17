
create database empleados08;
use empleados08;

/*departamento*/
create table departamento (cod_dpto varchar(4), nombre varchar(40), constraint pk_departamento primary key (cod_dpto));

/*empleado*/
create table empleado (dni varchar(9), nombre varchar(40), apellidos varchar(40), fecha_nac date, salario double);
alter table empleado add constraint pk_empleado primary key (dni);

/*emple_depart*/
create table emple_depart (dni varchar(9), cod_dpto varchar(4), fecha_ini datetime, fecha_fin datetime );
alter table emple_depart add constraint pk_emple_depart primary key (dni, cod_dpto, fecha_ini);
alter table emple_depart add constraint fk_emple_depart_dni foreign key (dni) references empleado(dni);
alter table emple_depart add constraint fk_emple_depart_cd foreign key (cod_dpto) references departamento(cod_dpto);












