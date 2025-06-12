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
    $html->appendContent('<div class="main">');
    $jeux = GameCollection::findByGenreId(intval($genreId));

    $reverse = -1;
    foreach ($jeux as $i) {
        $reverse += 1;

        if ($reverse % 2 == 0){
            $content = <<<HTML
        <div class="gameBox">
          <div class="image"><a href="game.php/?gameId={$i->getId()}" class="game" style="text-decoration:none">
            <img src="poster.php?posterId={$i->getPosterId()}"></a></div>
          <div class="nomDesc">
             <p>{$i->getName()} ({$i->getReleaseYear()})</p>
             <p>{$i->getShortDescription()}</p>
          </div>
        
        </div>
        HTML;
            $html->appendContent($content);
        }

        if ($reverse % 2 == 1){
            $content = <<<HTML
        <div class="gameBox_rev">
          <div class="image"><a href="game.php/?gameId={$i->getId()}" class="game" style="text-decoration:none">
            <img src="poster.php?posterId={$i->getPosterId()}"></a></div>
          <div class="nomDesc">
             <p>{$i->getName()} ({$i->getReleaseYear()})</p>
             <p>{$i->getShortDescription()}</p>
          </div>
        
        </div>
        HTML;
            $html->appendContent($content);
        }
    }
    $html->appendContent('</div>');
    echo $html->toHtml();


} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
