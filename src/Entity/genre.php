<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class genre
{
    private int $id;
    private string $description;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Permet de trouver un genre avec son id.
     * @param int $id id du genre
     * @return genre
     */
    public static function findById(int $id): genre
    {
        $stmt = MyPDO::getInstance()->prepare(<<<'SQL'
                                                SELECT id, description
                                                FROM   genre
                                                WHERE id = :genreId
                                                SQL);
        $stmt->execute([':genreId' => $id]);
        $genre = $stmt->fetchObject(genre::class);
        if ($genre === false) {
            throw new EntityNotFoundException("ID du genre non trouvé");
        } else {
            return $genre;
        }
    }
}
