DROP TABLE IF EXISTS risposte cascade;

create table if not exists risposte(
    codice integer not null,
    id_discussione integer not null,
    partecipante varchar(255) not null,
    testo varchar(1000),
    data_risposta timestamp not null,
    primary key (codice),
    foreign key (id_discussione) references discussioni(id) on delete cascade on update cascade,
    foreign key (partecipante) references utenti(username)  on delete cascade on update cascade
);
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;