<?php

declare(strict_types=1);

use Entity\Game;
use Html\Form\GameForm;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try{
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $form=new GameForm(Game::findById(intval($_GET['gameId'])));
    }else{
        $form=new GameForm();
    }
    echo $form->getHtmlForm('game-save.php');

} catch (EntityNotFoundException) {
http_response_code(404);
} catch (Exception) {
http_response_code(500);
}
