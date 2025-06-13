<?php


use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;
use Entity\Collection\GameCollection;
use Entity\Exception\ParameterException;
use Entity\Category;

$categoryId = $_GET['categoryId'];
try {
    if (!(isset($categoryId)) && !(is_numeric($categoryId))) {
        throw new ParameterException('id de la catégorie invalide');
    }
    $category = Category::findById($categoryId);
    $nom = (new AppWebPage())->escapeString($category->getDescription());
    $html = new AppWebPage("Jeux Vidéo : $nom");
    $html->appendContent(<<<HTML
<div class="menu">
    <div>
        <a href="index.php">Accueil</a>
    </div>
    <div>
        <a href="admin/game-form.php">Ajouter un jeu</a>
    </div>
    <div class="tri">
      <form action="category.php" method="get">
          <input type="hidden" name="categoryId" value="$categoryId">
          <legend>Trier par:</legend>
          <div>
            <input type="radio" id='triN' name="tri" value="name">
            <label for="triN">Nom</label>
          </div>
          <div>
            <input type="radio" id='triY' name="tri" value="year">
            <label for="triY">Année de sortie</label>
          </div>
          <input type="submit" value="trier">
      </form>
    </div>
</div>
HTML);
    $html->appendContent('<div class="main">');
    $jeux = GameCollection::findByCategoryId(intval($categoryId));


    $reverse = -1;
    foreach ($jeux as $i) {
        $reverse += 1;

        if ($reverse % 2 == 0) {
            $content = <<<HTML
        <div class="gameBox">
          <div class="image"><a href="game.php?gameId={$i->getId()}" class="game" style="text-decoration:none">
            <img src="poster.php?posterId={$i->getPosterId()}"></a></div>
          <div class="nomDesc">
              {$i->getName()} ({$i->getReleaseYear()})<p></p>
              {$i->getShortDescription()}
          </div>
          
        </div>
        HTML;
            $html->appendContent($content);
        }

        if ($reverse % 2 == 1) {
            $content = <<<HTML
        <div class="gameBox_rev">
          <div class="image"><a href="game.php?gameId={$i->getId()}" class="game" style="text-decoration:none">
            <img src="poster.php?posterId={$i->getPosterId()}"></a></div>
          <div class="nomDesc">
              {$i->getName()} ({$i->getReleaseYear()})<p></p>
              {$i->getShortDescription()}
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
