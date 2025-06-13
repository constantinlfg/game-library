<?php

use Entity\Game;
use Html\Form\GameForm;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Database\MyPdo;

$name = $_POST["name"];
$releaseYear = $_POST["releaseYear"];
$shortDescription = $_POST["shortDescription"];
try{
    if (!empty($name)){
        throw new ParameterException("le nom n'est pas valide");
    }if (!empty($shortDescription)){
        throw new ParameterException("la description n'est pas valide");
    }if (!isset($releaseYear) && is_numeric($releaseYear)){
        throw new ParameterException("l'année n'est pas valide");
    }
    $form = new GameForm();
    $form->setEntityFromQueryString();
    $form->getGame()->save();
    header("Location: index.php");
    exit;

} catch (ParameterException) {
http_response_code(400);
} catch (Exception) {
http_response_code(500);
}

