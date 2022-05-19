DROP TABLE IF  EXISTS volo cascade;

create table if not exists volo(
    id_volo SERIAL primary key,
    data_volo DATE not null,
    città_partenza varchar(255) not null,
    ora_partenza TIME not null,
    città_arrivo varchar(255) not null,
    ora_arrivo TIME not null,
    prezzo decimal(10,2) not null,
    categoria varchar(255)
);
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

insert into volo(data_volo,città_partenza,ora_partenza,città_arrivo,ora_arrivo,prezzo,categoria) values
 ('2022-06-01','Napoli','07:00:00','Milano','08:30:00',32,'città'),
 ('2022-06-01','Napoli','09:00:00','Milano','11:30:00',19,'città'),
 ('2022-06-01','Napoli','11:00:00','Milano','12:30:00',40,'città'),
 ('2022-06-01','Napoli','18:00:00','Milano','19:30:00',9.99,'città'),
 ('2022-06-01','Roma','07:00:00','Milano','08:00:00',9.99,'città'),
 ('2022-06-01','Roma','10:00:00','Milano','11:00:00',29.99,'città'),
 ('2022-06-01','Napoli','15:30:00','Parigi','17:30:00',20.99,'città'),
 ('2022-06-01','Napoli','07:00:00','Sardegna','08:00:00',30,'mare'),
 ('2022-06-01','Napoli','11:00:00','Budapest','12:30:00',60,'città'),
 ('2022-06-01','Napoli','10:30:00','Barcellona','12:00:00',33.99,'città'),
 ('2022-06-01','Napoli','22:00:00','Barcellona','00:00:00',29.99,'città'),
 ('2022-06-01','Napoli','16:00:00','Madrid','17:30:00',52.11,'città'),
 ('2022-06-01','Napoli','07:00:00','Madrid','08:30:00',9.99,'città'),
 ('2022-06-01','Napoli','21:00:00','Madrid','22:30:00',19.99,'città'),
 ('2022-06-01','Napoli','05:40:00','Valencia','07:25:00',12.99,'città'),
 ('2022-06-01','Napoli','07:00:00','Valencia','09:00:00',30,'città'),
 ('2022-06-01','Napoli','10:00:00','Amsterdam','11:30:00',23.50,'città'),
 ('2022-06-01','Napoli','07:00:00','Amsterdam','09:00:00',19.99,'città'),
 ('2022-06-01','Napoli','07:00:00','Londra','09:40:00',19.99,'città'),
 ('2022-06-01','Napoli','12:00:00','Londra','14:20:00',39.99,'città'),
 ('2022-06-01','Napoli','18:00:00','Londra','20:25:00',89.99,'città'),
 ('2022-06-01','Roma','07:00:00','New York','18:30:00',329.99,'città'),
 ('2022-06-01','Napoli','09:30:00','Pag','11:00:00',32,'città'),
 ('2022-10-01','Milano','11:00:00','Napoli','12:00:00',18,'città'),
 ('2022-10-01','Milano','14:00:00','Napoli','15:00:00',20.99,'città'),
('2022-06-02','Barcellona','09:00:00','Milano','11:30:00',32,'città'),
