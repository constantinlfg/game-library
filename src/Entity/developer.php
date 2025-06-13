<?php
declare(strict_types=1);
namespace Entity;
use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class developer
{
    private int $id;
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Permet de trouver un developpeur avec son id.
     * @param int $id id du dev
     * @return developer
     */
    public static function findById(int $id): developer
    {
        $stmt = MyPDO::getInstance()->prepare(<<<'SQL'
                                                SELECT id, name
                                                FROM   developer
                                                WHERE id = :developerId
                                                SQL);
        $stmt->execute([':developerId' => $id]);
        $developer = $stmt->fetchObject(developer::class);
        if ($developer === false){
            throw new EntityNotFoundException("ID du dev non trouvé");
        }
        else {
            return $developer;
        }

    }

}