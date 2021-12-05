<?php

class Reviews
{
    public function getReviews($id)
    {
        try {
            $sql = "SELECT * FROM reviews WHERE id_good=:id ORDER BY `date` DESC";
            $markers = [
                ':id' => $id
            ];

            return DB::selectAll($sql, $markers);
        } catch (PDOException $e) {
            die ('Ошибка в отправки отзыва: ' . $e->getMessage());
        }
    }

    public function sendComment($name, $review, $id)
    {
        try {
            $sql = "INSERT INTO reviews(`id_good`, `name`, `review`) VALUES (:id_good, :name, :review)";
            $markers = [
                ':id_good' => $id,
                ':name' => $name,
                ':review' => $review
            ];

            DB::insert($sql, $markers);
                     
        } catch (PDOException $e) {
            die ('Ошибка в отправки отзыва: ' . $e->getMessage());
        }
    }
}
