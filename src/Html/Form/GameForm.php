<?php

namespace Html\Form;
use Entity\Game;
use StringEscaper;
use Entity\Exception\ParameterException;

class GameForm
{
    use StringEscaper;
    private ?Game $game;
    public function __construct(?Game $game=null){
        $this->game = $game;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }


}