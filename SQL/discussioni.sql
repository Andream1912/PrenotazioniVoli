DROP TABLE IF EXISTS discussioni cascade;

create table if not exists discussioni(
    creatore varchar(20) not null,
    id integer not null,
    titolo varchar(255),
    descrizione varchar(1000),
    data_creazione timestamp not null,
    data_modifica timestamp,
    foreign key(creatore) references utenti(username) on delete cascade on update cascade,
    primary key(id)
);
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;