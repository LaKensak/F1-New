Select nom, prenom, ifnull(sum(point), 0) as point
from pilote
         left join resultat on resultat.idPilote = id
group by nom, prenom;

Select nom, prenom, (select sum(point) from resultat where idPilote = id) as point
from pilote
order by point desc;

select *
from pilote;



SELECT id,
       nom,
       prenom,
       (SELECT SUM(point) FROM resultat WHERE idPilote = pilote.id) AS point,
       @rownum := @rownum + 1                                       AS place
FROM pilote
         JOIN
         (SELECT @rownum := 0) r
ORDER BY point DESC;

drop view if exists classementPilote;

create view classementPilote as
SELECT id,
       (SELECT SUM(point) FROM resultat WHERE idPilote = pilote.id) AS point,
       (SELECT COUNT(*) + 1
        FROM (SELECT SUM(point) AS total_points
              FROM resultat
              GROUP BY idPilote) AS place
        WHERE total_points > point)                                 AS place
FROM pilote
ORDER BY point DESC;

select *
from classementPilote;

Select pilote.id, nom, prenom, point, place, idPays
from pilote
         join classementPilote on pilote.id = classementPilote.id;


SELECT nom,
       prenom,
       (SELECT SUM(point) FROM resultat WHERE idPilote = pilote.id) AS point,
       ROW_NUMBER() OVER (ORDER BY SUM(point) DESC)                 AS place
FROM pilote
GROUP BY nom, prenom
ORDER BY point DESC;


SELECT nom,
       prenom,
       (SELECT SUM(point) FROM resultat WHERE idPilote = pilote.id) AS point,
       rank() OVER (ORDER BY SUM(point) DESC)                       AS place
FROM pilote
GROUP BY nom, prenom
ORDER BY point DESC


SELECT id,
       nom,
       idPays,
       idEcurie,
       (SELECT SUM(point)
        FROM resultat
        WHERE idPilote = pilote.id) AS point,
       (SELECT COUNT(*) + 1
        FROM (SELECT SUM(point) AS total_points
              FROM resultat
              GROUP BY idPilote) as p
        WHERE total_points > point) AS place
FROM pilote
ORDER BY point DESC;


-- date et nom des grands prix, point de l'écrurie pour l'écurie n° 1

Select date, grandprix.nom, sum(point) as point
from grandPrix
  join resultat on grandPrix.id = resultat.idGrandPrix
 join  pilote on pilote.id = resultat.idPilote
Where idEcurie = :id
group by idGrandPrix

# $data = json_encode($select->getRows($sql, ['id' => $_GET['id']]));

4ème colonne  <a href='resultatecurie'> <i class="bi bi-search"></i></a>
