<?php

namespace Entity\Collection;
use Database\MyPdo;
use Entity\Game;

class GameCollection
{
    public static function findByCategoryId(int $categoryId): array
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

    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic, developerId, posterId
FROM game_genre gc, game g
WHERE  genreId = :genreId
AND gameId = g.id
ORDER BY name
SQL);
        $stmt->bindParam(':genreId', $genreId);
        $stmt->execute();
        $stmt->setFetchMode(MyPDO::FETCH_CLASS, Game::class);
        return $stmt->fetchALl();
    }

}
