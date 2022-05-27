DROP TABLE IF EXISTS utenti cascade;

Create table if not exists utenti(
    username varchar(20) primary key,
    email varchar(255) unique not null,
    password varchar(255) not null,
    livello varchar(55) DEFAULT 'visitatore' not null
);
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

insert into utenti(username, email, password, livello) values ('admin','admin@gmail.com','Ciaociao1','admin');