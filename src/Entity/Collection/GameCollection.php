<?php

namespace Entity\Collection;
use Database\MyPdo;
use Entity\Game;

class GameCollection
{
    /**
     * Permet de trouver tous les jeux d'une catégorie avec le tri intégré.
     * @param int $categoryId
     * @return array
     */
    public static function findByCategoryId(int $categoryId): array
    {
        if(isset($_GET["tri"]) && $_GET["tri"]=='year') {
            $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic, developerId, posterId
FROM game_category gc, game g
WHERE  categoryId = :categoryId
AND gameId = g.id
ORDER BY releaseYear, name
SQL);
        }
        else{
            $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic, developerId, posterId
FROM game_category gc, game g
WHERE  categoryId = :categoryId
AND gameId = g.id
ORDER BY name, releaseYear
SQL);
        }
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();
        $stmt->setFetchMode(MyPDO::FETCH_CLASS, Game::class);
        return $stmt->fetchALl();
    }

    /**
     * Permet de trouver tous les jeux d'un genre avec le tri intégré.
     * @param int $genreId
     * @return Game[]
     */
    public static function findByGenreId(int $genreId): array
    {
        if(isset($_GET["tri"]) && $_GET["tri"]=='year') {
            $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic, developerId, posterId
FROM game_genre gc, game g
WHERE  genreId = :genreId
AND gameId = g.id
ORDER BY releaseYear, name
SQL);
        }
        else{
            $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic, developerId, posterId
FROM game_genre gc, game g
WHERE  genreId = :genreId
AND gameId = g.id
ORDER BY name, releaseYear
SQL);
        }
        $stmt->bindParam(':genreId', $genreId);
        $stmt->execute();
        $stmt->setFetchMode(MyPDO::FETCH_CLASS, Game::class);
        return $stmt->fetchALl();
    }

}
