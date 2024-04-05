drop view if exists classementPilote;

create view classementPilote as
SELECT id,
       nom,
       idPays,
       idEcurie,
       (SELECT ifnull(SUM(point), 0)
        FROM resultat
        WHERE idPilote = pilote.id) AS point,
       (SELECT COUNT(*) + 1
        FROM (SELECT ifnull(SUM(point), 0) AS total_points
              FROM resultat
              GROUP BY idPilote) as p
        WHERE total_points > point) AS place
FROM pilote
ORDER BY point DESC;

select *
from classementPilote;

drop view if exists classementEcurie;

create view classementEcurie as
Select id,
       nom,
       idPays,
       (select sum(point)
        from classementPilote
        where idEcurie = ecurie.id
        group by idEcurie)          as point,
       (SELECT COUNT(*) + 1
        FROM (SELECT SUM(point) AS total_points
              FROM classementPilote
              GROUP BY idEcurie) as p
        WHERE total_points > point) AS place
from ecurie
ORDER BY point DESC;



select *
from classementPilote;
select *
from classementEcurie;

