use f1;

CREATE TABLE IF NOT EXISTS pays
(
    id  char(2)     NOT NULL primary key,
    nom varchar(70) NOT NULL
);



CREATE TABLE IF NOT EXISTS ecurie
(
    id         tinyint AUTO_INCREMENT primary key,
    nom        varchar(45) NOT NULL,
    idPays     char(2)     NOT NULL,
    logo       varchar(50) NOT NULL,
    imgVoiture varchar(50) NOT NULL,
    constraint fk_ecurie_pays foreign key (idPays) references pays (id)
);


CREATE TABLE IF NOT EXISTS pilote
(
    id        tinyint primary key,
    nom       varchar(30) NOT NULL,
    prenom    varchar(20) NOT NULL,
    photo     varchar(50) NOT NULL,
    numPilote tinyint     NOT NULL,
    idEcurie  tinyint     NOT NULL,
    idPays    char(2)     NOT NULL,
    UNIQUE KEY idEcurie (idEcurie, numPilote),
    constraint fk_pilote_pays foreign key (idPays) references pays (id),
    constraint fk_pilote_ecurie foreign key (idEcurie) references ecurie (id)
);



CREATE TABLE IF NOT EXISTS grandprix
(
    id       tinyint AUTO_INCREMENT primary key,
    date     date        NOT NULL unique,
    nom      varchar(50) NOT NULL,
    circuit  varchar(45) NOT NULL,
    idPays   char(2)     NOT NULL,
    idPilote tinyint     null,
    constraint FK_grandprix_pilote foreign key (idPilote) references pilote (id),
    constraint fk_grandprix_pays foreign key (idPays) references pays (id)
);


CREATE TABLE IF NOT EXISTS resultat
(
    idGrandPrix tinyint NOT NULL,
    idPilote    tinyint NOT NULL,
    place       tinyint NOT NULL,
    point       float   NOT NULL DEFAULT '0',
    PRIMARY KEY (idGrandPrix, idPilote),
    UNIQUE KEY idGrandPrix (idGrandPrix, place),
    CONSTRAINT resultat_GrandPrix FOREIGN KEY (idGrandPrix) REFERENCES grandprix (id),
    CONSTRAINT resultat_Pilote FOREIGN KEY (idPilote) REFERENCES pilote (id)
);

