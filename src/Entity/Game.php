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
    private int $windows=0;
    private int $linux=0;
    private int $mac=0;
    private ?int $metacritic;
    private ?int $developerId;
    private ?int $posterId=null;

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


    /**
     * Permet de trouver un jeu à partir de son id.
     * @param int $id id du jeu
     * @return Game
     */
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

    /**
     * Permet de trouver les genres d'un jeu.
     * @return genre[]
     */
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

    /**
     * Permet de trouver les catégories d'un jeu.
     * @return Category[]
     */
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

    /**
     * Permet de suprimer un jeu dans la bd et rend l'id de l'instance null.
     * @return $this
     */
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

    /**
     * Permet de modifier un jeu dans la bd.
     * @return $this
     */
    public function update():Game{
        $stmt = MyPDO::getInstance()->prepare(<<<'SQL'
UPDATE game
SET name = :name, releaseYear=:releaseYear, shortDescription=:shortDescription, 
    price=:price, windows=:windows, linux=:linux, mac=:mac, metacritic=:metacritic,
    developerId=:developerId
WHERE id = :id
SQL);
        $id = $this->getId();
        $name = $this->getName();
        $releaseYear = $this->getReleaseYear();
        $shortDescription = $this->getShortDescription();
        $price = $this->getPrice();
        $windows = (int) $this->getWindows();
        $linux = (int) $this->getLinux();
        $mac = (int) $this->getMac();
        $metacritic = $this->getMetacritic();
        $developerId = $this->getDeveloperId();
        //var_dump($windows); // debug
        //var_dump($linux); // debug
        //var_dump($mac); // debug
        //exit;
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':releaseYear',$releaseYear);
        $stmt->bindParam(':shortDescription',$shortDescription);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':windows',$windows);
        $stmt->bindParam(':linux',$linux);
        $stmt->bindParam(':mac',$mac);
        $stmt->bindParam(':metacritic',$metacritic);
        $stmt->bindParam(':developerId',$developerId);
        $stmt->execute();
        return $this;
    }

    /**
     * Permet de créer une instance Game.
     * @param string $name
     * @param int $releaseYear
     * @param string $shortDescription
     * @param int|null $id
     * @param int|null $price
     * @param int $windows
     * @param int $linux
     * @param int $mac
     * @param int|null $metacritic
     * @param int|null $developerId
     * @param int|null $posterId
     * @return Game
     */
    public static function create(string $name, int $releaseYear, string $shortDescription,
                                    int $id=null, int $price=null, int $windows=0,
                                    int $linux=0, int $mac=0, int $metacritic=null,
                                    int $developerId=null, int $posterId=null){
        $game= new Game();
        $game->setName($name);
        $game->setReleaseYear($releaseYear);
        $game->setShortDescription($shortDescription);
        $game->setId($id);
        $game->setPrice($price);
        $game->setWindows($windows);
        $game->setLinux($linux);
        $game->setMac($mac);
        $game->setMetacritic($metacritic);
        $game->setDeveloperId($developerId);
        $game->setPosterId($posterId);
        return $game;
    }

    /**
     * Rend le contructeur privé.
     */
    private function __construct()
    {
    }

    /**
     * Permet d'insérer un jeu dans la bd.
     * @return $this
     */
    public function insert():Game{
        $stmt=MyPdo::getInstance()->prepare(<<<'SQL'
INSERT INTO game(id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic,
        developerId)
VALUES(:id, :name, :releaseYear, :shortDescription, :price, :windows, :linux, :mac, :metacritic,
        :developerId)
SQL);
        $this->setId((int)MyPdo::getInstance()->lastInsertId());
        $id = $this->getId();
        $name = $this->getName();
        $releaseYear = $this->getReleaseYear();
        $shortDescription = $this->getShortDescription();
        $price = $this->getPrice();
        $windows = $this->getWindows();
        $linux = $this->getLinux();
        $mac = $this->getMac();
        //var_dump($windows); // debug
        //var_dump($linux); // debug
        //var_dump($mac); // debug
        //exit;
        $metacritic = $this->getMetacritic();
        $developerId = $this->getDeveloperId();
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':releaseYear',$releaseYear);
        $stmt->bindParam(':shortDescription',$shortDescription);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':windows',$windows);
        $stmt->bindParam(':linux',$linux);
        $stmt->bindParam(':mac',$mac);
        $stmt->bindParam(':metacritic',$metacritic);
        $stmt->bindParam(':developerId',$developerId);
        $stmt->execute();
        return $this;
    }

    /**
     * Insère ou Modifie un jeu selon si son id est null ou non null.
     * @return $this
     */
    public function save():Game{
        if($this->getId()===null){
            $this->insert();
        }
        else{
            $this->update();
        }
        return $this;
    }
}
