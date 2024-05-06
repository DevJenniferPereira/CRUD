CREATE database prova


CREATE TABLE papelaria
(
codigo int NOT NULL auto_increment,
status int NOT NULL,
preco int NOT NULL,
PRIMARY key (codigo)
)




create database bdSisCompletao

use bdSisCompletao

create table tbStatus(
id int not null primary key auto_increment,
descricao varchar(50) not null
)

insert into tbstatus 
values(1,"Ativo"),
(2,"Suspenso"),
(3,"Aguardando ativação"),
(4,"Cancelado")



create table tbUsuarios(
id int not null primary key auto_increment,
nome varchar(200) not null,
email varchar(200) not null,
senha varchar(40) not null,
idStatus int references tbStatus(id)
)

insert into tbusuarios values 
(1, 'Ana', 'anuxa.caldas@gmail.com', '123', @idstatus),
(2, 'Lorenzo', 'lorenzo@mail.com', '1234', @idstatus),
(3, 'Thais', 'thais@mail.com', '1234', @idstatus),
(4, 'Natalia', 'nat@mail.com', '1234', @idstatus),
(5, 'Maria', 'mary@mail.com', '1234', @idstatus),
(6, 'Ricardo', 'ricardin@mail.com', '1234', @idstatus),
(7, 'Rebeca', 'rebeca@mail.com', '1234', @idstatus),
(8, 'Sabrina', 'sabrina@mail.com', '1234', @idstatus),
(9, 'Jenifer', 'jeny@mail.com', '1234', @idstatus),
(10, 'Sergio', 'serjao@mail.com', '1234', @idstatus)

 

create table tbModulos(
id int not null primary key auto_increment,
descricao varchar(100) not null,
link varchar(500) not null
)

insert into tbmodulos values 
(1, 'Home', 'home.php'),
(2, 'Perfil', 'perfil.php'),
(3, 'Cadastro', 'cadastro.php'),
(4, 'Categorias', 'categorias.php'),
(5, 'Documentos', 'documentos.php'),
(6, 'Avaliações', 'avaliacao.php'),
(7, 'Chamados', 'chamado.php'),
(8, 'Módulos', 'modulos.php'),
(9, 'Pemissões', 'permissao.php'),
(10, 'Artigos', 'artigos.php')




create table tbPermissoes(
id int not null primary key auto_increment,
idModulo int not null references tbmodulos(id),
idUsuario int not null references tbusuarios(id),
validade date null,
nivel varchar(30)
)

select * from tbpermissoes 






create table tbpessoas(
id varchar(20) not null,
idUsuario int not null references tbusuarios(id),
cpf varchar(20) null,
rg varchar(20) null,
endereco varchar(500) not null,
cep varchar(9) not null,
sexo varchar(10) not null,
dataNascimento date not null

)

create table tbresponsaveis(
idUsuarioResponsavel int not null references tbusuarios(id),
idUsuarioMenor int not null references tbusuarios(id),
parentesco int not null,
assinacontrato boolean
)

create table tbdocumentos(
iddocumento int not null primary key auto_increment,
documento blob,
datadocumento date,
tipodocumento varchar(20),
idUsuario int not null references tbusuarios(id)
)