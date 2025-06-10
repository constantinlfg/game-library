<?php

namespace Entity\Collection;
use Database\MyPdo;
use Entity\genre;
class genreCollection
{
    /**
     * Créer une instance de la clase Category pour chaque categorie de la bd
     * @return genre[]
     */
    public static function findAll(): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, description
FROM genre
ORDER BY description
SQL);
        $stmt->execute();
        $stmt->setFetchMode(MyPDO::FETCH_CLASS, genre::class);
        return $stmt->fetchAll();
    }
}