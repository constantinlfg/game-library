<?php

declare(strict_types=1);

use Entity\poster;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

$id = $_GET['id'];
try {
    if (!(isset($id)) && !(is_numeric($id))) {
        throw new ParameterException('Erreur de paramètre');
    }
    $poster = poster::findById($id);
    header("Content-Type: image/jpeg");
    echo $poster->getJpeg();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
