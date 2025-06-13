<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\genre;


class Game
{
    private ?int $id;
    private string $name;
    private int $releaseYear;
    private string $shortDescription;
    private ?int $price;
    private ?int $windows;
    private ?int $linux;
    private ?int $mac;
    private ?int $metacritic;
    private ?int $developerId;
    private ?int $posterId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Game
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Game
    {
        $this->name = $name;
        return $this;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): Game
    {
        $this->releaseYear = $releaseYear;
        return $this;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): Game
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): Game
    {
        $this->price = $price;
        return $this;
    }

    public function getWindows(): ?int
    {
        return $this->windows;
    }

    public function setWindows(?int $windows): Game
    {
        $this->windows = $windows;
        return $this;
    }

    public function getLinux(): ?int
    {
        return $this->linux;
    }

    public function setLinux(?int $linux): Game
    {
        $this->linux = $linux;
        return $this;
    }

    public function getMac(): ?int
    {
        return $this->mac;
    }

    public function setMac(?int $mac): Game
    {
        $this->mac = $mac;
        return $this;
    }

    public function getMetacritic(): ?int
    {
        return $this->metacritic;
    }

    public function setMetacritic(?int $metacritic): Game
    {
        $this->metacritic = $metacritic;
        return $this;
    }

    public function getDeveloperId(): ?int
    {
        return $this->developerId;
    }

    public function setDeveloperId(?int $developerId): Game
    {
        $this->developerId = $developerId;
        return $this;
    }

    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    public function setPosterId(?int $posterId): Game
    {
        $this->posterId = $posterId;
        return $this;
    }



    public static function findById(int $id):Game{
        $stmt=MyPdo::getInstance()->prepare(<<<'SQL'
SELECT *
FROM game
WHERE id = :id
SQL);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $game = $stmt->fetchObject(Game::class);
        if ($game === false){
            throw new EntityNotFoundException("ID du jeu non trouvé");
        }
        return $game;
    }

    public function findGenres(): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, description
FROM game_genre, genre
WHERE gameId = :gameId
AND genreId = id
SQL);
        $gameId = $this->getId();
        $stmt->bindParam(':gameId', $gameId);
        $stmt->execute();
        $stmt->setFetchMode(MyPdo::FETCH_CLASS, genre::class);
        return $stmt->fetchAll();
    }

    public function findCategory(): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, description
FROM game_category, category
WHERE gameId = :gameId
AND categoryId = id
SQL);
        $gameId = $this->getId();
        $stmt->bindParam(':gameId', $gameId);
        $stmt->execute();
        $stmt->setFetchMode(MyPdo::FETCH_CLASS, Category::class);
        return $stmt->fetchAll();
    }

    public function delete():Game{
        $stmt = MyPDO::getInstance()->prepare(<<<'SQL'
DELETE FROM game
WHERE id = :id
SQL);
        $id=$this->getId();
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $this->setId(null);
        return $this;
    }

    public function update():Game{
        $stmt = MyPDO::getInstance()->prepare(<<<'SQL'
UPDATE game
SET name = :name
WHERE id = :id
SQL);
        $id = $this->getId();
        $name = $this->getName();
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name',$name);
        $stmt->execute();
        return $this;
    }




}
