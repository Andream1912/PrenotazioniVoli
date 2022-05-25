DROP TABLE IF EXISTS personaldata CASCADE;

CREATE TABLE IF NOT EXISTS personaldata (
    username varchar(20) PRIMARY KEY,
    nome varchar(50),
    cognome varchar(50),
    indirizzo varchar(100),
    cap int,
    sesso char(1),
    nazionalita varchar(30),
    luogo_nascita varchar(30),
    data_nascita date,
    numerotel varchar(11),
    FOREIGN KEY (username) REFERENCES utenti (username) ON DELETE CASCADE ON UPDATE CASCADE
);

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;

GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

