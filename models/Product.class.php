<?php

class Product
{
    public function getGood($id)
    {
        try {
            $sql = "SELECT * FROM goods WHERE id=:id";
            $markers = [
                ':id' => $id
            ];
            return DB::selectRow($sql, $markers);
        } catch (PDOException $e) {
            die ('Ошибка в отправки товара: ' . $e->getMessage());
        }
    }

    public function editImg($arrFile, $bigImg, $smallImg, $id, $textError)
    {
        try {
            //записываем расширение картинки и вызываем ф-ю changeImage() для уменьшения картинки и загрузки в папку с маленькими картинками
            if (copy($arrFile['tmp_name'], $bigImg . $this->translit($arrFile['name']))) {
                $path = $smallImg . $this->translit($arrFile['name']);
                $type = explode('/', $arrFile['type'])[1];
                $img = $this->translit($arrFile['name']);
                $this->changeImage(128, 128, $arrFile['tmp_name'], $path, $type);
                //обновляем данные в таблице
                $sql = "UPDATE goods SET img=:img WHERE `id`=:id";
                $markers = [
                    ':img' => $img,
                    ':id' => $id
                ];
                DB::insert($sql, $markers);
            } else {
                $textError = 'Ошибка загрузки файла!';
            }
        } catch (PDOException $e) {
            die ('Ошибка в отправки товара: ' . $e->getMessage());
        }
    }

    public function editGood($title, $price, $description, $id)
    {
        try {
            //обновляем данные в таблице
            $sql = "UPDATE goods SET `title`=:title, `price`=:price, `description`=:description WHERE `id`=:id";
            $markers = [
                ':title' => $title,
                ':price' => $price,
                ':description' => $description,
                ':id' => $id
            ];
            DB::insert($sql, $markers);
        } catch (PDOException $e) {
            die ('Ошибка в отправки товара: ' . $e->getMessage());
        }
    }

    public function deleteGood($id)
    {
        try {
            //удаляем данные в таблице
            $sql = "DELETE FROM goods WHERE id=:id";
            $markers = [
                ':id' => $id
            ];
            DB::delete($sql, $markers);
        } catch (PDOException $e) {
            die ('Ошибка в отправки товара: ' . $e->getMessage());
        }
    }

    public function uploadGood($arrFile, $bigImg, $smallImg, $title, $price, $description, $textError)
    {
        try {
            //записываем расширение картинки и вызываем метод changeImage() для уменьшения картинки и загрузки в папку с маленькими картинками
            if (copy($arrFile['tmp_name'], $bigImg . $this->translit($arrFile['name']))) {
                $path = $smallImg . $this->translit($arrFile['name']);
                $img = $this->translit($arrFile['name']);
                $type = explode('/', $arrFile['type'])[1];
                $sql = "INSERT INTO goods(`title`, `price`, `img`, `description`) VALUES (:title, :price, :img, :description)";
                $markers = [
                    ':title' => $title,
                    ':price' => $price,
                    ':img' => $img,
                    ':description' => $description
                ];
                DB::insert($sql, $markers);
                $this->changeImage(128, 128, $arrFile['tmp_name'], $path, $type);
            } else {
                $textError = 'Ошибка загрузки файла!';
            }
        } catch (PDOException $e) {
            die ('Ошибка записи товара: ' . $e->getMessage());
        }
    }

    /**
     * Метод преобразует текст с кириллицы на латиницу
     * @param $string - строка на кириллице
     * @return - текст на латинице
    */
    private function translit($string)
    {
        $translit = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ы' => 'y', 'ъ' => '', 'ь' => '', 'э' => 'eh', 'ю' => 'yu', 'я'=>'ya'
        ];

        return str_replace(' ', '_', strtr(mb_strtolower(trim($string)), $translit));
    }

    /**
     * Метод уменьшает размер файла
     * @param $h - необходимая высота картинки
     * @param $w - необходимая ширина картинки
     * @param $src - путь от куда получаем картинку
     * @param $newsrc - путь куда сохраняем новую картинку
     * @param $type - расширение картинки
     * @return - ничего не возвращаем
    */
    private function changeImage($h, $w, $src, $newsrc, $type)
    {
        $newimg = imagecreatetruecolor($h, $w);
        switch ($type) {
            case 'jpeg':
                $img = imagecreatefromjpeg($src);
                imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
                imagejpeg($newimg, $newsrc);
                break;
            case 'png':
                $img = imagecreatefrompng($src);
                imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
                imagepng($newimg, $newsrc);
                break;
            case 'gif':
                $img = imagecreatefromgif($src);
                imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
                imagegif($newimg, $newsrc);
                break;
        }
    }
}
