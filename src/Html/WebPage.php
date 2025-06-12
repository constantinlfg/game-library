<?php

declare(strict_types=1);

namespace Html;

use StringEscaper;

class WebPage
{
    use StringEscaper;
    private string $head = "";
    private string $title = "";
    private string $body = "";

    public function __construct(string $title = '')
    {
        $this->title = $title;
    }

    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    public function appendCss(string $css)
    {
        $html = <<<HTML
<style>$css</style>
HTML;
        $this->appendToHead($html);

    }

    public function appendToHead(string $content)
    {
        $this->head .= $content;
    }

    public function appendCssUrl(string $url)
    {
        $html = <<<HTML
<link rel="stylesheet" href="$url">
HTML;
        $this->appendToHead($html);
    }

    public function appendJs(string $js)
    {
        $html = <<<HTML
<script >$js</script>
HTML;
        $this->appendToHead($html);
    }

    public function appendJsUrl(string $url)
    {
        $html = <<<HTML
<script src="$url"></script>
HTML;
        $this->appendToHead($html);
    }

    public function escapeString(string $string): string
    {
        /** @noinspection PhpStrictTypeCheckingInspection */
        return $this->stringEscaper($string);
    }

    /**
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * @param string $head
     */
    public function setHead(string $head): void
    {
        $this->head = $head;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function toHTML()
    {
        $html = <<<HTML
<!doctype html>
<html lang="fr">
<head>
<title>$this->title</title>
<meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                         <meta http-equiv="X-UA-Compatible" content="ie=edge">
$this->head
</head>
<body>
$this->body  
</body>
</html>
HTML;
        return $html;
    }

    public function getLastModification()
    {
        return getlastmod();
    }

}
