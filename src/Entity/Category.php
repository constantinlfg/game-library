<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Category
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

    public static function findById(int $id): Category
    {
        $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
SELECT id, description
FROM category
WHERE id = :id
SQL);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $category = $stmt->fetchObject(Category::class);
        if($category === false) {
            throw new EntityNotFoundException("ID de la catégorie non trouvé");
        }
        return $category;
    }



}
