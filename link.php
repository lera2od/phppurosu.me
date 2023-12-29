<?php 
$links = json_decode(file_get_contents("private/links.json"), true);
$uri = $_SERVER["REQUEST_URI"];
if($uri == "/"){
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
    if(isset($linkk["aliases"])){
        foreach ($linkk["aliases"] as $alias) {
            if ($alias == $uri) {
                $link = $linkk;
                break;
            }
        }
    }
}

if(!isset($link)){
    echo "404 Not Found";
    http_response_code(404);
    header("Refresh: 3; url=/");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhpPurosu.me</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <hr>
    <h1>PHPPUROSU</h1>
    <hr>
    <h2 style="text-align: center;">REDIRECTING TO</h2>
    <h3 style="text-align: center;"><?= $link["to"]?></h3>
    <script>
        setTimeout(() => {
            window.location.href = "<?= $link["to"]?>";
        }, 1500);

        let span = document.querySelector("span");
        let i = 0;
        setInterval(() => {
            if (i == 0) {
                span.innerHTML = ".";
                i++;
            } else if (i == 1) {
                span.innerHTML = "..";
                i++;
            } else if (i == 2) {
                span.innerHTML = "...";
                i = 0;
            }
        }, 500);
    </script>
</body>

</html>