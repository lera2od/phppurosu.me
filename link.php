<?php
$links = json_decode(file_get_contents("private/links.json"), true);
$uri = $_SERVER["REQUEST_URI"];
if ($uri == "/") {
    header("Location: /index.html");
    die();
}
$uri = explode("/", $uri);
$uri = $uri[1];
$link = null;

foreach ($links as $linkk) {
    if ($linkk["from"] == $uri) {
        $link = $linkk;
        break;
    }
    if (isset($linkk["aliases"])) {
        foreach ($linkk["aliases"] as $alias) {
            if ($alias == $uri) {
                $link = $linkk;
                break;
            }
        }
    }
}

if (!isset($link)) {
    echo "404 Not Found";
    http_response_code(404);
    header("Refresh: 3; url=/");
    die();
}

header("Location: " . $link["to"]);

?>