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
        $id = $this->game?->getId();
        $name = $this->game?->getName();
        $releaseYear = $this->game?->getReleaseYear();
        $shortDescription = $this->game?->getShortDescription();
        $price = $this->game?->getPrice();
        $windows = $this->game?->getWindows();
        $linux = $this->game?->getLinux();
        $mac = $this->game?->getMac();
        $metacritic = $this->game?->getMetacritic();
        $developerId = $this->game?->getDeveloperId();
        $html = <<<HTML
<!doctype html>
<html lang="fr">
<head>
<title>Modification de Jeu</title>
<meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                         <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="header">
        <h1>Modification de Jeu</h1>
    </div>
<div class="menu">
    <a href="admin/game-form.php">Ajouter un jeu</a>
</div>
<div class="formulaire">
<form action="game-save.php" method="post">
  <div><input type="hidden" id="id" name="id" value="$id"></div>
  <div>
    <label for="name">Nom du jeu : </label>
    <input type="text" id="name" name="name" value="{$this->stripTagsAndTrim($name)}" required>
  </div>
  <div>
    <label for="releaseYear">Année de sortie : </label>
    <input type="number" min="1970" max="2025" id="releaseYear" name="releaseYear" value="$releaseYear" required>
  </div>
  <div>
    <label for="shortDescription">Description</label>
    <input type="text" id="shortDescription" name="shortDescription" value="{$this->stripTagsAndTrim($shortDescription)}">
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
  <div>
    <label for="developerId">ID du développeur</label>
    <input type="number" min="0" max="99999999999" name="developerId" id="developerId" value="$developerId">
  </div>
  <div>
    <input type="submit" value="Enregistrer">
  </div>
</form>
</div>
</body>
HTML;
        return $html;
    }

    /**
     * @throws ParameterException
     */
    public function setEntityFromQueryString():void{
        if(isset($_POST['id']) && is_numeric($_POST["id"])){
            $id = intval($_POST['id']);
        } else{
            $id=null;
        }
        if(!(empty($_POST['name']))){
            $name = $this->stripTagsAndTrim($_POST['name']);
        } else{
            throw new ParameterException("le nom du jeu est manquant.");
        }
        if(isset($_POST['releaseYear']) && is_numeric($_POST["releaseYear"])){
            $releaseYear = intval($_POST['releaseYear']);
        } else{
            throw new ParameterException("l'année du jeu est manquante.");
        }
        if(!(empty($_POST["shortDescription"]))){
            $shortDescription = $this->stripTagsAndTrim($_POST['shortDescription']);
        } else{
            throw new ParameterException("la description du jeu est manquante.");
        }
        if(isset($_POST['price']) && is_numeric($_POST["price"])){
            $price = intval($_POST['price']);
        } else{
            $price=null;
        }
        if(isset($_POST['windows']) && is_numeric($_POST["windows"])){
            $windows = intval($_POST['windows']);
        } else{
            $windows = 0;
        }
        if(isset($_POST['linux']) && is_numeric($_POST["linux"])){
            $linux = intval($_POST['linux']);
        } else{
            $linux=0;
        }
        if(isset($_POST['mac']) && is_numeric($_POST["mac"])){
            $mac = intval($_POST['mac']);
        } else{
            $mac=0;
        }
        if(isset($_POST['metacritic']) && is_numeric($_POST["metacritic"])){
            $metacritic = intval($_POST['metacritic']);
        } else{
            $metacritic=null;
        }
        if(isset($_POST['developerId']) && is_numeric($_POST["developerId"])){
            $developerId = intval($_POST['developerId']);
        } else{
            $developerId=null;
        }
        $this->game=Game::create($name,$releaseYear,$shortDescription,$id,$price,$windows,$linux,$mac,$metacritic,$developerId);
    }

}