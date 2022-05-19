DROP TABLE IF  EXISTS personaldata cascade;
create table if not exists personaldata(
    username varchar(20),
    nome varchar(50),
	cognome varchar(50),
	indirizzo varchar(100),
	cap int,
	sesso char(1),
	nazionalita varchar(30),
	ldinascita varchar(30),
	ddinascita date,
	numerotel varchar(11),
    primary key (username)
	FOREIGN KEY(username) REFERENCES utenti(username),
);
