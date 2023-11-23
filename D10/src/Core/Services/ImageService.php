<?php

namespace WSCrop\Core\Services;

use WSCrop\Core\Database\Database;
use WSCrop\Core\Models\Image;
use WSCrop\Core\Utils\Singleton;

class ImageService
{
    use Singleton;

    private const TABLE = "images";

    private readonly Database $database;

    public function __construct()
    {
        $this->database = Database::getInstance();

        $this->init();
    }

    private function init(): void
    {
        $table = self::TABLE;

        Database::getInstance()->getConnection()->query("CREATE TABLE IF NOT EXISTS $table (id INT PRIMARY KEY AUTO_INCREMENT, data LONGTEXT NOT NULL)");
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        $table = self::TABLE;

        $result = $this->database->getConnection()->query("SELECT * FROM $table")->fetch_all();

        return array_map(fn(array $obj) => new Image($obj[1], intval($obj[0])), $result);
    }

    public function getImageById(int $id): ?Image
    {
        $table = self::TABLE;

        $result = $this->database->getConnection()->query("SELECT * FROM $table WHERE id = $id")->fetch_array();

        return $result ? new Image($result['data'], intval($result['id'])) : null;
    }

    public function createImage(Image $image): void
    {
        $table = self::TABLE;

        $data = $image->getData();

        $statement = $this->database->getConnection()->prepare("INSERT INTO $table (data) VALUES (?)");
        $statement->bind_param("s", $data);
        $statement->execute();
    }
}