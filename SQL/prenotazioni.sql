DROP TABLE IF  EXISTS prenotazioni cascade;

create table if not exists prenotazioni(
    username varchar(20),
    id_volo integer,
    numero_bagagli numeric,
    prezzo numeric check(prezzo >= 0),
	FOREIGN KEY(username) REFERENCES utenti(username) on delete cascade on update cascade,
	FOREIGN KEY(id_volo)REFERENCES volo(id_volo),
    primary key (username,id_volo)
);

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;
