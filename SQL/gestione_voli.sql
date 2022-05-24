DROP TABLE IF  EXISTS volo cascade;

create table if not exists volo(
    id_volo SERIAL primary key,
    data_volo DATE not null,
    citta_partenza varchar(255) not null,
    ora_partenza TIME not null,
    citta_arrivo varchar(255) not null,
    ora_arrivo TIME not null,
    prezzo decimal(10,2) not null,
    posti_disponibili integer not null check(posti_disponibili >= 0),
    foreign key(citta_partenza) references paese(nome) on delete restrict on update cascade,
    foreign key(citta_arrivo) references paese(nome) on delete restrict on update cascade
);
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

insert into volo(data_volo,citta_partenza,ora_partenza,citta_arrivo,ora_arrivo,prezzo,posti_disponibili) values
 ('2022-06-01','napoli','07:00:00','milano','08:30:00',32,35),
 ('2022-06-01','napoli','09:00:00','milano','11:30:00',19,50),
 ('2022-06-01','napoli','11:00:00','milano','12:30:00',40,10),
 ('2022-06-01','napoli','18:00:00','milano','19:30:00',9.99,20),
 ('2022-06-01','roma','07:00:00','milano','08:00:00',9.99,13),
 ('2022-06-01','roma','10:00:00','milano','11:00:00',29.99,100),
 ('2022-06-01','napoli','15:30:00','parigi','17:30:00',20.99,100),
 ('2022-06-01','napoli','07:00:00','olbia','08:00:00',30,45),
 ('2022-06-01','napoli','11:00:00','pago','12:30:00',60,100),
 ('2022-06-01','napoli','10:30:00','barcellona','12:00:00',33.99,20),
 ('2022-06-01','napoli','22:00:00','barcellona','00:00:00',29.99,100),
 ('2022-06-01','napoli','16:00:00','madrid','17:30:00',52.11,100),
 ('2022-06-01','napoli','07:00:00','madrid','08:30:00',9.99,100),
 ('2022-06-01','napoli','21:00:00','madrid','22:30:00',19.99,100),
 ('2022-06-01','napoli','05:40:00','valencia','07:25:00',12.99,100),
 ('2022-06-01','napoli','07:00:00','valencia','09:00:00',30,100),
 ('2022-06-01','napoli','10:00:00','amsterdam','11:30:00',23.50,100),
 ('2022-06-01','napoli','07:00:00','amsterdam','09:00:00',19.99,200),
 ('2022-06-01','napoli','07:00:00','londra','09:40:00',19.99,10),
 ('2022-06-01','napoli','12:00:00','londra','14:20:00',39.99,70),
 ('2022-06-01','napoli','18:00:00','londra','20:25:00',89.99,15),
 ('2022-06-01','roma','07:00:00','pago','18:30:00',329.99,100),
 ('2022-06-01','napoli','09:30:00','pago','11:00:00',32,100),
 ('2022-06-01','milano','11:00:00','napoli','12:00:00',18,40),
 ('2022-06-10','milano','14:00:00','napoli','15:00:00',20.99,60),
 ('2022-06-02','barcellona','09:00:00','milano','11:30:00',32,100),
 ('2022-05-24','barcellona','09:00:00','milano','11:30:000',32,100),
 ('2022-05-23','napoli','12:00:00','parigi','17:30:000',20.99,100),
 ('2022-05-23','napoli','07:00:00','olbia','08:00:000',30,100),
 ('2022-05-24','napoli','11:00:00','pago','12:30:000',60,97),
 ('2022-05-24','napoli','18:00:00','milano','19:30:000',9.99,20),
 ('2022-05-25','napoli','00:00:00','olbia','01:30:000',19.99,20)

 
