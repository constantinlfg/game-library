<?php


use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;
use Entity\Collection\GameCollection;
use Entity\Exception\ParameterException;
use Entity\Category;

$categoryId = $_GET['categoryId'];
try {
    if (!(isset($categoryId)) && !(is_numeric($categoryId))) {
        throw new ParameterException('id du genre invalide');
    }
    $category = Category::findById($categoryId);
    $nom = (new AppWebPage())->escapeString($category->getDescription());
    $html = new AppWebPage("Jeux Vidéo : $nom");
    $jeux = GameCollection::findByCategoryId(intval($categoryId));
    $html->appendContent('<div class="main">');
    foreach ($jeux as $i) {
        $content = <<<HTML
<div class="gameBox">
  <a href="game.php?gameId={$i->getId()}" class="game" style="text-decoration:none">
    <img src="poster.php?posterId={$i->getPosterId()}">
    <div class="nomDesc">
      {$i->getName()} ({$i->getReleaseYear()})<p></p>
      {$i->getShortDescription()}
    </div>
  </a>
</div>
HTML;
        $html->appendContent($content);
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
