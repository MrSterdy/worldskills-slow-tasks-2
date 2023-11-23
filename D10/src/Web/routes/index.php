<?php

require_once __DIR__ . "/../../index.php";

use WSCrop\Core\Models\Image;
use WSCrop\Core\Services\ImageService;

$images = ImageService::getInstance()->getImages();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = $_POST["data"];
    if (!$data || !is_string($data) || !str_starts_with($data, 'data:')) {
        http_response_code(400);
    } else {
        ImageService::getInstance()->createImage(new Image(data: explode(',', $data)[1]));

        $location = $_SERVER["REQUEST_URI"];
        header("Location: $location");
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WSCrop</title>

    <link rel="stylesheet" type="text/css" href="public/app.css">

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/jcrop@3.0.1/dist/jcrop.css">
    <script src="https://unpkg.com/jcrop@3.0.1/dist/jcrop.js"></script>
</head>
<body>
<main>
    <article id="recent">
        <h1>Недавние изображения</h1>

        <?php
            if (count($images)) {
                echo '<ul id="images" class="box">';
                foreach ($images as $image) {
                    $id = $image->getId();

                    echo "<li>
                        <img src='image.php?id=$id' alt=''>
                    </li>";
                }
                echo '</ul>';
            } else {
                echo '<span id="no-images">Нет загруженных изображений</span>';
            }
        ?>
    </article>

    <section id="upload">
        <h1>Загрузка изображения</h1>

        <div>
            <input type="file" accept="image/*" id="file">

            <img id="preview" src="public/field.jpg">

            <canvas id="result"></canvas>

            <form method="post">
                <input type="hidden" name="data" id="data">

                <input type="submit" value="Загрузить">
            </form>
        </div>
    </section>
</main>
<script src="public/app.js"></script>
</body>
</html>
