

delete from pilote;
delete from ecurie;

INSERT INTO ecurie (id, nom, idPays, logo, imgVoiture)
VALUES (1, 'Mercedes', 'de', 'mercedes-f1-logo-1.webp', '1.png'),
       (2, 'Ferrari', 'it', 'scuderia-ferrari-logo-1.webp', '2.png'),
       (3, 'Red Bull', 'au', 'red-bull-racing-logo-1.webp', '3.png'),
       (4, 'McLaren', 'gb', 'mclaren-f1-team-logo-1.webp', '4.png'),
       (5, 'Alpine', 'fr', 'alpine-f1-team-logo-1.webp', '5.png'),
       (6, 'Alpha Tauri', 'it', 'scuderia-alphatauri-f1-logo-1.webp', '6.png'),
       (7, 'Aston Martin', 'gb', 'aston-martin-cognizant-f1-team-1.webp', '7.png'),
       (8, 'Alfa Romeo', 'ch', 'alfa-romeo-f1-team-logo-1.webp', '8.png'),
       (9, 'Haas', 'us', 'haas-logo-1.webp', '9.png'),
       (10, 'Williams', 'gb', 'williams-racing-logo-1.webp', '10.png');

INSERT INTO pilote (id, nom, prenom, idPays, photo, idEcurie, numPilote)
VALUES (1, 'Verstappen', 'Max', 'nl', 'max-verstappen-red-bull-racing-1.webp', 3, 1),
       (2, 'Logan', 'Sargeant', 'us', 'logan-sargeant-williams-1.webp', 10, 1),
       (3, 'Ricciardo', 'Daniel', 'au', 'daniel-ricciardo-alphatauri-1.webp', 6, 1),
       (4, 'Norris', 'Lando', 'gb', 'lando-norris-mclaren-1.webp', 4, 1),
       (81, 'Pistri', 'Oscar', 'au', 'oscar-piastri-mclaren-1.webp', 4, 2),
       (10, 'Gasly', 'Pierre', 'fr', 'pierre-gasly-alpine-1.webp', 5, 2),
       (11, 'Pérez', 'Sergio', 'mx', 'sergio-perez-red-bull-racing-1.webp', 3, 2),
       (14, 'Alonzo', 'Fernando', 'es', 'fernando-alonso-aston-martin-r-1.webp', 7, 1),
       (16, 'Leclerc', 'Charles', 'mc', 'charles-leclerc-ferrari-1.webp', 2, 1),
       (18, 'Stroll', 'Lance', 'ca', 'lance-stroll-aston-martin-raci-1.webp', 7, 2),
       (20, 'Magnussen', 'Kevin', 'dk', 'kevin-magnussen-haas-1.webp', 9, 1),
       (22, 'Tsunoda', 'Yuki', 'jp', 'yuki-tsunoda-alphatauri-1.webp', 6, 2),
       (23, 'Albon', 'Alexander', 'th', 'alex-albon-williams-1.webp', 10, 2),
       (24, 'Zhou', 'Guanyu', 'cn', 'zhou-guanyu-alfa-romeo-1.webp', 8, 2),
       (27, 'Hülkenberg', 'Nico', 'de', 'nico-hulkenberg-haas-1.webp', 9, 2),
       (31, 'Ocon', 'Esteban', 'fr', 'esteban-ocon-alpine-1.webp', 5, 1),
       (44, 'Hamilton', 'Lewis', 'gb', 'lewis-hamilton-mercedes-1.webp', 1, 1),
       (55, 'Sainz Jr.', 'Carlos', 'es', 'carlos-sainz-ferrari-1.webp', 2, 2),
       (63, 'Russell', 'George', 'gb', 'george-russell-mercedes-1.webp', 1, 2),
       (77, 'Bottas', 'Valtteri', 'fi', 'valtteri-bottas-alfa-romeo-1.webp', 8, 1),


       (21, 'de Vries', 'Nyck', 'nl', 'de vries nyck.jpg', 6, 3),
       (40, 'Lawson', 'Liam', 'nz', 'lialawson.png', 6, 4);





