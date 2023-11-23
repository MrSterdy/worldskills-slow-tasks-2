<?php

require_once __DIR__ . "/../../index.php";

$image = \WSCrop\Core\Services\ImageService::getInstance()->getImageById(intval($_GET['id']));

if (!$image) {
    http_response_code(400);
} else {
    $result = imagecreatefromstring(base64_decode($image->getData()));
    header('Content-Type: image/png');
    imagepng($result);
    imagedestroy($result);
}
