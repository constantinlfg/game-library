<?php

namespace Html;

use Html\WebPage;

class AppWebPage extends WebPage
{
    public function __construct(string $title = "")
    {
        parent::__construct($title);
        $this->appendCssUrl('/css/style.css');
    }

    public function toHtml()
    {
        $last = date('d/m/Y-H:i:s', filemtime(substr($_SERVER['PHP_SELF'], 1)));
        $html = <<<HTML
<!doctype html>
<html lang="fr">
<head>
<title>{$this->getTitle()}</title>
<meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                         <meta http-equiv="X-UA-Compatible" content="ie=edge">
{$this->getHead()}
</head>
<body>
    <div class="header">
        <h1>{$this->getTitle()}</h1>
    </div>
    {$this->getBody()}
    <div class="footer">
        Denière modification : $last
    </div>
</body>
</html>
HTML;
        return $html;
    }

}
