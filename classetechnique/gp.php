<?php

class gp
{

    public static function getNomEcurie($id)
    {
        $sql = "SELECT nom FROM ecurie WHERE id = :id";
        $select = new Select();
        $ligne = $select->getRow($sql, ['id' => $id]);
        return $ligne ? $ligne['nom'] : null;
    }

    public static function getClassement($id)
    {
        $sql = "SELECT DATE_FORMAT(date,'%d/%m/%Y') as dateFr, grandprix.nom,  SUM(resultat.point) as point, grandprix.idPays
                FROM resultat
                JOIN grandprix ON resultat.idGrandprix = grandprix.id
                JOIN pilote ON resultat.idPilote = pilote.id
                WHERE idEcurie = :id
                GROUP BY grandprix.date, grandprix.nom";
        $select = new Select();
        return json_encode($select->getRows($sql, ['id' => $id]));
    }
    public static function getClassementGP() {
        $sql = <<<EOD
            SELECT ecurie.id,
                   ecurie.nom,
                   idPays,
                   pays.nom as nomPays,
                   (SELECT SUM(point)
                    FROM classementpilote
                    WHERE idEcurie = ecurie.id
                    GROUP BY idEcurie) AS point,
                   (SELECT COUNT(*) + 1
                    FROM (SELECT SUM(point) AS total_points
                          FROM classementpilote
                          GROUP BY idEcurie) AS p
                    WHERE total_points > point) AS place
            FROM ecurie
            JOIN pays ON ecurie.idPays = pays.id
            ORDER BY point DESC;
EOD;
        $select = new Select();
        return $select->getRows($sql);
    }

}


$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if ($id === false) {
    Erreur::envoyerReponse("La valeur transmise n'est pas de type attendu", 'system');
}

$nomEcurie = gp::getNomEcurie($id);
if (!$nomEcurie) {
    Erreur::envoyerReponse("Ecurie non trouvée", 'system');
}

$data = gp::getClassement($id);
