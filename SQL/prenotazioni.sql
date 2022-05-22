DROP TABLE IF  EXISTS prenotazioni cascade;

create table if not exists prenotazioni(
    username varchar(20),
    id_volo integer,
	FOREIGN KEY(username) REFERENCES utenti(username),
	FOREIGN KEY(id_volo)REFERENCES volo(id_volo),
    primary key (username,id_volo)
);
