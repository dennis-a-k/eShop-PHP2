<?php

class Goods
{
    public function getGoods()
    {
        try {
            $sql = "SELECT * FROM goods ORDER BY `id` DESC";
            return DB::selectAll($sql);
        } catch (PDOException $e) {
            die ('Ошибка в отправки товаров: ' . $e->getMessage());
        }
    }

    public function getProducts()
    {
        try {
            $sql = "SELECT * FROM goods ORDER BY `title`";
            return DB::selectAll($sql);
        } catch (PDOException $e) {
            die ('Ошибка в отправки товаров: ' . $e->getMessage());
        }
    }
}
