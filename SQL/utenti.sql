Create table if not exists utenti(
    username varchar(20) primary key,
    email varchar(255) unique not null,
    password varchar(255) not null,
    ruolo varchar(55) DEFAULT 'visitatore' not null
)