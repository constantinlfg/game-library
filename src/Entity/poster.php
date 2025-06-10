<?php
declare(strict_types=1);

namespace Entity;
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

}