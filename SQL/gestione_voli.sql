create table if not exist volo(
    id_volo integer primary key auto_increment,
    città_partenza varchar(255) not null,
    ora_partenza smalldatetime(255) not null,
    città_arrivo varchar(255) not null,
    ora_arrivo smalldatetime(255) not null,
    prezzo decimal(10,2) not null,
    categoria varchar(255)
);