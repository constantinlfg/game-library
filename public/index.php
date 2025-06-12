<?php

use Html\AppWebPage;
use Entity\Collection\genreCollection;
use Entity\Collection\CategoryCollection;

$html = new AppWebPage('Jeux Vidéo');

$html->appendContent("<div class='genres'><h2>Genres</h2>");
foreach (genreCollection::findAll() as $i) {
    $body = <<<HTML
<div class='a'><a style="text-decoration:none" href='genre.php?genreId={$i->getId()}'>{$html->escapeString("{$i->getDescription()}")}</a></div>
HTML;
    $html->appendContent($body);
}
$html->appendContent("</div>");

$html->appendContent("<div class='categories'><h2>Catégories</h2>");
foreach (CategoryCollection::findAll() as $y) {
    $body = <<<HTML
<div class='a'>
  <a style="text-decoration:none" href='./category.php?categoryId={$y->getId()}'>{$html->escapeString("{$y->getDescription()}")}</a>
</div>
HTML;
    $html->appendContent($body);
}
$html->appendContent("</div>");

echo $html->toHTML();
