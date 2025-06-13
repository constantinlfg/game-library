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

    public function getHtmlForm(string $url):string
    {
        $id = $this->game->getId();
        $name = $this->game->getName();
        $releaseYear = $this->game->getReleaseYear();
        $shortDescription = $this->game->getShortDescription();
        $price = $this->game->getPrice();
        $windows = $this->game->getWindows();
        $linux = $this->game->getLinux();
        $mac = $this->game->getMac();
        $metacritic = $this->game->getMetacritic();
        $html = <<<HTML
<form action="$url" method="post">
  <div><input type="hidden" id="id" name="id" value="$id"></div>
  <div>
    <label for="name">Nom du jeu : </label>
    <input type="text" id="name" name="name" value="{$this->stringEscaper($name)}" required>
  </div>
  <div>
    <label for="releaseYear">Année de sortie : </label>
    <input type="number" min="1970" max="2025" id="releaseYear" name="releaseYear" value="$releaseYear" required>
  </div>
  <div>
    <label for="shortDescription">Description</label>
    <input type="text" id="shortDescription" name="shortDescription" value="{$this->stringEscaper($shortDescription)}">
  </div>
  <div>
    <label for="price">Prix du jeu (en centime)</label>
    <input type="number" min="0" max="10000" id="price" name="price" value="$price">
  </div>
  <div>
    <fieldset>
      <legend>OS disponible(s) :</legend>
HTML;
        if ($windows === 1) {
            $html .= <<<HTML
<div>
  <input type="checkbox" id="windows" name="windows" value="1" checked>
  <label for="windows">Windows</label>
</div>
HTML;
        } else{
            $html .= <<<HTML
<div>
  <input type="checkbox" id="windows" name="windows" value="1">
  <label for="windows">Windows</label>
</div>
HTML;
        }
        if ($linux === 1) {
            $html .= <<<HTML
      <div>
        <input type="checkbox" id="linux" name="linux" value="1" checked>
        <label for="linux">Linux</label>
      </div>
HTML;
        } else {
            $html .= <<<HTML
      <div>
        <input type="checkbox" id="linux" name="linux" value="1">
        <label for="linux">Linux</label>
      </div>
HTML;
        }
        if ($mac === 1) {
            $html .= <<<HTML
      <div>
        <input type="checkbox" id="mac" name="mac" value="1" checked>
        <label for="mac">Mac</label>
      </div>
    </fieldset>
  </div>
HTML;
        } else {
            $html .= <<<HTML
      <div>
        <input type="checkbox" id="mac" name="mac" value="1">
        <label for="mac">Mac</label>
      </div>
    </fieldset>
  </div>
HTML;
        }
        $html .= <<<HTML
  <div>
    <label for="metacritic">Note Metacritic</label>
    <input type="number" min="0" max="100" id="metacritic" name="metacritic" value="$metacritic">
  </div>
</form>
HTML;
        return $html;
    }



}