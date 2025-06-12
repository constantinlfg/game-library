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
ORDER BY name, releaseYear
SQL);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();
        $stmt->setFetchMode(MyPDO::FETCH_CLASS, Game::class);
        return $stmt->fetchALl();
    }

    /**
     * @param int $genreId
     * @return Game[]
     */
    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT g.id, g.name, g.releaseYear, g.shortDescription, g.price, g.windows, g.linux, g.mac, g.metacritic, g.developerId, g.posterId
FROM game_genre gg, game g
WHERE  gg.genreId = :genreId
AND gg.gameId = g.id
ORDER BY name, releaseYear
SQL);
        $stmt->bindParam(':genreId', $genreId);
        $stmt->execute();
        $stmt->setFetchMode(MyPDO::FETCH_CLASS, Game::class);
        return $stmt->fetchALl();
    }

}
