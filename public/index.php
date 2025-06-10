<?php

use Html\AppWebPage;
use Entity\Collection\genreCollection;
use Entity\Collection\CategoryCollection;

$html = new AppWebPage('Jeux Vidéo');

$html->appendContent("<div class='genres'><h2>Genres</h2>");
foreach (genreCollection::findAll() as $i) {
    $body = "<div class='a'><a href='./genre.php?genreId={$i->getId()}'>".$html->escapeString("{$i->getDescription()}")."</a></div>\n";
    $html->appendContent($body);
}
$html->appendContent("</div>");



echo $html->toHTML();
