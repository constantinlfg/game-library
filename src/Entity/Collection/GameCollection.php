<?php

namespace Entity\Collection;
use Database\MyPdo;
use Entity\Game;

class GameCollection
{
    public function findByCategoryId(int $categoryId): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic, developerId, posterId
FROM game_category gc, game g
WHERE  categoryId = :categoryId
AND gameId = g.id
ORDER BY name
SQL);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();
        $stmt->setFetchMode(MyPDO::FETCH_CLASS, Game::class);
        return $stmt->fetchALl();
    }


}
