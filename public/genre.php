<?php

use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;
use Entity\Collection\GameCollection;
use Entity\Exception\ParameterException;
use Entity\genre;

$genreId = $_GET['genreId'];
try {
    if (!(isset($genreId)) && !(is_numeric($genreId))) {
        throw new ParameterException('id du genre invalide');
    }
    $genre = genre::findById($genreId);
    $nom = (new AppWebPage())->escapeString($genre->getDescription());
    $html = new AppWebPage("Jeux Vidéo : $nom");
    $jeux = GameCollection::findByGenreId(intval($genreId));
    foreach ($jeux as $i) {
        $content = <<<HTML
<div class="gameBox">
  <a href="game.php/?gameId={$i->getId()}" class="game" style="text-decoration:none">
    <img src="poster.php?posterId={$i->getPosterId()}">
    <div class="nomDesc">
      {$i->getName()} {$i->getReleaseYear()} <p></p>
      {$i->getShortDescription()}
    </div>
  </a>
</div>
HTML;
        $html->appendContent($content);
    }
    echo $html->toHtml();


} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
