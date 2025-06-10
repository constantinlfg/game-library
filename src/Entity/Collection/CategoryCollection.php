<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Category;

class CategoryCollection
{
    /**
     * Créer une instance de la clase Category pour chaque categorie de la bd
     * @return Category[]
     */
    public static function findAll(): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, description
FROM category
ORDER BY description
SQL);
        $stmt->execute();
        $stmt->setFetchMode(MyPDO::FETCH_CLASS, Category::class);
        return $stmt->fetchAll();
    }
}
