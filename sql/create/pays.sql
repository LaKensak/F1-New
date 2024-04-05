use f1;

create table if not exists pays (
    id char(2) primary key,
    nom  varchar(70) not null
) engine = InnoDB;


delete from pays;

INSERT INTO f1.pays (id, nom) VALUES ('ad', 'Andorre');
INSERT INTO f1.pays (id, nom) VALUES ('ae', 'Émirats Arabes Unis');
INSERT INTO f1.pays (id, nom) VALUES ('al', 'Albanie');
INSERT INTO f1.pays (id, nom) VALUES ('ar', 'Argentine');
INSERT INTO f1.pays (id, nom) VALUES ('at', 'Autriche');
INSERT INTO f1.pays (id, nom) VALUES ('au', 'Australie');
INSERT INTO f1.pays (id, nom) VALUES ('az', 'Azerbaïdjan');
INSERT INTO f1.pays (id, nom) VALUES ('ba', 'Bosnie-Herzégovine');
INSERT INTO f1.pays (id, nom) VALUES ('be', 'Belgique');
INSERT INTO f1.pays (id, nom) VALUES ('bg', 'Bulgarie');
INSERT INTO f1.pays (id, nom) VALUES ('bh', 'Bahreïn');
INSERT INTO f1.pays (id, nom) VALUES ('br', 'Brésil');
INSERT INTO f1.pays (id, nom) VALUES ('ca', 'Canada');
INSERT INTO f1.pays (id, nom) VALUES ('ch', 'Suisse');
INSERT INTO f1.pays (id, nom) VALUES ('cl', 'Chili');
INSERT INTO f1.pays (id, nom) VALUES ('cn', 'Chine');
INSERT INTO f1.pays (id, nom) VALUES ('co', 'Colombie');
INSERT INTO f1.pays (id, nom) VALUES ('cr', 'Costa Rica');
INSERT INTO f1.pays (id, nom) VALUES ('cu', 'Cuba');
INSERT INTO f1.pays (id, nom) VALUES ('cy', 'Chypre');
INSERT INTO f1.pays (id, nom) VALUES ('cz', 'République Tchèque');
INSERT INTO f1.pays (id, nom) VALUES ('de', 'Allemagne');
INSERT INTO f1.pays (id, nom) VALUES ('dk', 'Danemark');
INSERT INTO f1.pays (id, nom) VALUES ('es', 'Espagne');
INSERT INTO f1.pays (id, nom) VALUES ('fi', 'Finlande');
INSERT INTO f1.pays (id, nom) VALUES ('fr', 'France');
INSERT INTO f1.pays (id, nom) VALUES ('gb', 'Royaume-Uni');
INSERT INTO f1.pays (id, nom) VALUES ('gr', 'Grèce');
INSERT INTO f1.pays (id, nom) VALUES ('hk', 'Hong Kong');
INSERT INTO f1.pays (id, nom) VALUES ('hr', 'Croatie');
INSERT INTO f1.pays (id, nom) VALUES ('hu', 'Hongrie');
INSERT INTO f1.pays (id, nom) VALUES ('ie', 'Irlande');
INSERT INTO f1.pays (id, nom) VALUES ('il', 'Israël');
INSERT INTO f1.pays (id, nom) VALUES ('in', 'Inde');
INSERT INTO f1.pays (id, nom) VALUES ('is', 'Islande');
INSERT INTO f1.pays (id, nom) VALUES ('it', 'Italie');
INSERT INTO f1.pays (id, nom) VALUES ('jm', 'Jamaïque');
INSERT INTO f1.pays (id, nom) VALUES ('jp', 'Japon');
INSERT INTO f1.pays (id, nom) VALUES ('kr', 'Corée du Sud');
INSERT INTO f1.pays (id, nom) VALUES ('lt', 'Lituanie');
INSERT INTO f1.pays (id, nom) VALUES ('lu', 'Luxembourg');
INSERT INTO f1.pays (id, nom) VALUES ('mc', 'Monaco');
INSERT INTO f1.pays (id, nom) VALUES ('mx', 'Mexique');
INSERT INTO f1.pays (id, nom) VALUES ('my', 'Malaysie');
INSERT INTO f1.pays (id, nom) VALUES ('nl', 'Pays-Bas');
INSERT INTO f1.pays (id, nom) VALUES ('no', 'Norvège');
INSERT INTO f1.pays (id, nom) VALUES ('nz', 'Nouvelle Zélande');
INSERT INTO f1.pays (id, nom) VALUES ('pl', 'Pologne');
INSERT INTO f1.pays (id, nom) VALUES ('pt', 'Portugal');
INSERT INTO f1.pays (id, nom) VALUES ('qa', 'qatar');
INSERT INTO f1.pays (id, nom) VALUES ('ru', 'Russie');
INSERT INTO f1.pays (id, nom) VALUES ('sa', 'Arabie Saoudite');
INSERT INTO f1.pays (id, nom) VALUES ('se', 'Suède');
INSERT INTO f1.pays (id, nom) VALUES ('sg', 'Singapour');
INSERT INTO f1.pays (id, nom) VALUES ('th', 'Thaïlande');
INSERT INTO f1.pays (id, nom) VALUES ('us', 'États-Unis (USA)');
INSERT INTO f1.pays (id, nom) VALUES ('za', 'Afrique du Sud');
