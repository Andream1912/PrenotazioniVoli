drop table if exists paese cascade;

create table if not exists paese(
    nome varchar(255) primary key,
    luogo varchar(255) not null,
    tipo varchar(255) not null,
    categoria varchar(255)
);
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

insert into paese(nome,luogo,tipo,categoria) values
('roma','italia','citta','cibo'),
('venezia','italia','citta','romanticismo'),
('napoli','italia','mare','cibo'),
('milano','italia','citta','famiglia'),
('firenze','italia','citta','cultura'),
('olbia','italia','mare','divertimento'),
('pisa','italia','citta','famiglia'),
('verona','italia','citta','cultura'),
('alghero','italia','mare','relax'),
('figi','figi','mare','relax'),
('parigi','francia','citta','romanticismo'),
('amsterdam','paesi bassi','citta','cultura'),
('londra','regno unito','citta','cultura'),
('pago','croazia','mare','divertimento'),
('barcellona','spagna','citta','divertimento'),
('madrid','spagna','citta','cultura'),
('valencia','spagna','mare','cultura'),
('bolzano','italia','montagna','cultura'),
('samedan','svizzera','montagna','neve'),
('innsbruck','austria','montagna','neve'),
('aosta','italia','citta','neve')




