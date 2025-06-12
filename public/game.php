<?php

use Entity\Game;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;
use Entity\Exception\ParameterException;
use Entity\genre;
use Entity\developer;

$gameId = $_GET['gameId'];
try {
    if (!(isset($gameId)) && !(is_numeric($gameId))) {
        throw new ParameterException('id du jeu invalide');
    }
    $game = Game::findById(intval($gameId));
    $nom = (new AppWebPage())->escapeString($game->getName());
    $html = new AppWebPage("Jeux Vidéo : $nom");
    $html->appendContent('<div class="main">');
    $developer = developer::findById($game->getDeveloperId());
    $price = $game->getPrice();
    $price = $price/100;
    $content = <<<HTML
<div class="detailJeu">
  <div class="details">
    <div class="posterDetails"><img src="poster.php?posterId={$game->getPosterId()}"></div>
    <div class="os&yearDetails">
      <div class="osDetails">os</div>
      <div class="yearDetails">Année de publication : {$game->getReleaseYear()}</div>
    </div>
    <div class="devDetails">
      Développeur : {$developer->getName()}
    </div>
  </div>
  <div class="descriptionDetails">
    <div class="note&prixDetails">
      <div class="noteDetails">
        Note Metacritic : {$game->getMetacritic()}
      </div>
      <div class="prixDetails">
        Prix : $price €
      </div>
    </div>
    <div class="description">
      {$game->getShortDescription()}
    </div>
  </div>
</div>
<div class="tagJeu">
  <div class="genresTag">
    Genres : 
HTML;
    $genreGame = $game->findGenres();
    $genresTag = "";
    foreach ($genreGame as $i) {
        $genresTag = $i->getDescription();
        $content .= "<a style='text-decoration:none' href='genre.php?genreId={$i->getId()}'>{$html->escapeString($genresTag)} </a>";
    }
    $content .= "</div> <div class='categoryTag'>Catégories : ";

    $categoryGame = $game->findCategory();
    $categoryTag = "";
    foreach ($categoryGame as $y){
        $categoryTag = $y->getDescription();
        $content .= "<a style='text-decoration:none' href='category.php?categoryId={$y->getId()}'>{$html->escapeString($categoryTag)} </a>";

    }

    $html->appendContent($content);
    $html->appendContent('</div></div></div>');
    echo $html->toHtml();


} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}