<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class poster
{
    private int $id;
    private string $jpeg;

    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public static function findById(int $id): poster
    {
        $stmt = MyPDO::getInstance()->prepare(<<<'SQL'
                                                SELECT id, jpeg
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
