<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class poster
{
    private int $id;
    private string $mediumblob;

    public function getMediumblob(): string
    {
        return $this->mediumblob;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public static function findById(int $id): genre
    {
        $stmt = MyPDO::getInstance()->prepare(<<<'SQL'
                                                SELECT id, mediumblob
                                                FROM   poster
                                                WHERE id = :posterId
                                                SQL);
        $stmt->execute([':posterId' => $id]);
        $poster = $stmt->fetchObject(poster::class);
        if ($poster === false) {
            throw new EntityNotFoundException("ID du jeu non trouvé");
        } else {
            return $poster;
        }
    }

}
