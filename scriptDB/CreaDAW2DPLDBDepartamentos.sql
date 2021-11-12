--Creacion de base de datos DB205DWESProyectoTema4
create database if not exists DB205DWESProyectoTema4;

--Creacion de la tabla Departamento en la base de datos DB205DWESProyectoTema4
create table DB205DWESProyectoTema4.Departamento(
    CodDepartamento varchar(3),
    DescDepartamento varchar(255) NOT NULL,
    FechaBaja date NULL,
    VolumenNegocio float NULL,
    primary key(CodDepartamento)
)ENGINE=INNODB;

--Creacion de usuario
create user 'user205DWESProyectoTema4'@'%' identified by 'P@ssw0rd';
grant all privileges on DB205DWESProyectoTema4.* to 'user205DWESProyectoTema4'@'%' with grant option;
