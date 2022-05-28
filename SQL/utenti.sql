DROP TABLE IF EXISTS utenti CASCADE;

CREATE TABLE IF NOT EXISTS utenti (
    username varchar(20) PRIMARY KEY,
    email varchar(255) UNIQUE NOT NULL,
    password varchar(255) NOT NULL,
    livello varchar(55) DEFAULT 'visitatore' NOT NULL
);

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;

GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

INSERT INTO utenti (username, email, password, livello) VALUES 
    ('a.marino120', 'a.marino120@studenti.unisa.it', '$2y$10$jqgPWKvXGr9negb0dKlvm.50JrVtozUlTKUZpKGiqncbeez50XexS', 'visitatore'),
    ('m.ripesi1', 'm.ripesi1@studenti.unisa.it', '$2y$10$0CzGUf.CMIkJc953J4LO6eLIv0UUlX6W9GAoJkfiZp5ThcXOWAKcO', 'visitatore'),
    ('s.prugnosiniscalc', 's.prugnosiniscalc@studenti.unisa.it', '$2y$10$hfhIrlVgbeE5t6iVEZBjpu0NAXseUunz/tWiDua0uyt4gd7XC9rva', 'visitatore'),
    ('m.monastero', 'm.monastero@studenti.unisa.it', '$2y$10$KbMzYrUAJgwuk42t4kj9y.n9QCs3FgEWa0CyU2sak.2wzwNwvULoi', 'visitatore'),
    ('admin', 'admin@gmail.com', '$2y$10$ojf4O2kppkXNuFwY1AKVwOJXYVGuZQoPh8NXF6u2qQOU6/itd62XC', 'admin');

