<?php

class Profile
{
    public function getUser($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE `id`=:id";
            $markers = [
                ':id' => $id
            ];
            return DB::selectRow($sql, $markers);
        } catch (PDOException $e) {
            die ('Ошибка при получении пользователя: ' . $e->getMessage());
        }
    }

    public function editUser($id, $name, $email, $password, $salt)
    {
        $pass = $salt . md5($password) . $salt;
        try {
            $sql = "UPDATE users SET `name`=:name, `email`=:email, `password`=:pass WHERE `id`=:id";
            $markers = [
                ':name' => $name,
                ':email' => $email,
                ':pass' => $pass,
                ':id' => $id
            ];
            DB::insert($sql, $markers);
        } catch (PDOException $e) {
            die ('Ошибка в отправки товара: ' . $e->getMessage());
        }
    }

   /**
     * Метод получения заказов из БД
     */
    public function getOrders($email)
    {
        try {
            $orders = [];
            $sql = "SELECT o.id, o.count, o.name, o.address, o.phone, o.email, o.date, o.id_user, o.completed, g.title, g.price FROM orders o LEFT OUTER JOIN goods g ON (o.id_good = g.id) WHERE o.email='$email' ORDER BY o.date DESC";
            $result = DB::selectAll($sql);

            //перебираем таблицу заказов
            foreach ($result as $value) {
                //создаём ключ по номеру id_use
                $key = $value['id_user'];
                //создаём массив с товарами и количеством, где ключ - это наименование товара, а значение - количество товара
                $orders[$key]['goods'][$value['title']]['count'] = $value['count'];
                $orders[$key]['goods'][$value['title']]['price'] = $value['price'];
                //заполняем массив остальными данными по клиенту (адрес, телефон, почта итд)
                $orders[$key]['user'] = $value;
            }
            return $orders;
        } catch (PDOException $e) {
            die ('Ошибка в отправки заказов: ' . $e->getMessage());
        }
    }
}
