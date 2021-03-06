DROP TABLE IF EXISTS discussioni cascade;

create table if not exists discussioni(
    creatore varchar(20) not null,
    id integer primary key,
    titolo varchar(60),
    descrizione varchar(600),
    data_creazione timestamp not null,
    data_modifica timestamp,
    foreign key(creatore) references utenti(username) on delete cascade on update cascade
);
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;