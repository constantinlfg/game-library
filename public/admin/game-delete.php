<?php

use Entity\Game;
use Html\Form\GameForm;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Database\MyPdo;

$id = $_GET['id'];

try{
    if (!isset($id) || !is_numeric($id)) {
        throw new ParameterException("L'ID du jeu est manquant ou invalide.");
    }

    $game = Game::findById($id);
    $game->delete();
    header("Location: index.php");
    exit();
} catch (ParameterException) {
http_response_code(400);
} catch (Exception) {
http_response_code(404);
}
