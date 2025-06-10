<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Game;

class GameCollection
{
    public function findByCategoryId(int $categoryId): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT *
FROM category
WHERE category = :categoryId
ORDER BY name
SQL);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();
        $stmt->setFetchMode(MyPDO::FETCH_CLASS, Game::class);
        return $stmt->fetchALl();
    }
}
