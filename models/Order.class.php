<?php

class Order
{
    /**
     * Метод записи заказа из корзины в БД
     */
    public function addOrder($idGood, $count, $name, $address, $phone, $email)
    {
        try {
            $idUser = 'user' . time() . rand(0, 1000);
            //записываем данные в таблицу заказов
            for ($i=0; $i<count($idGood); $i++) {
                $sql = "INSERT INTO `orders`(`id_good`, `count`, `name`, `address`, `phone`, `email`, `id_user`) VALUES (:id_good, :count, :name, :address, :phone, :email, :id_user)";
                $markers = [
                    ':id_good' => $idGood[$i],
                    ':count' => $count[$i],
                    ':name' => $name,
                    ':address' => $address,
                    ':phone' => $phone,
                    ':email' => $email,
                    ':id_user' => $idUser
                ];
    
                DB::insert($sql, $markers);
            }
    
            //очищаем корзину после оформления заказа
            if (isset($_COOKIE['cart'])) {
                foreach ($_COOKIE['cart'] as $key => $value) {
                    setcookie("cart[$key][id]", '', time() - 1, '/');
                    setcookie("cart[$key][count]", '', time() - 1, '/');
                }
            }
    
            $message = 'success';
            return $message;

        } catch (PDOException $e) {
            die ('Ошибка в отправки заказа: ' . $e->getMessage());
        }
    }

    /**
     * Метод получения заказов из БД
     */
    public function getOrders()
    {
        try {
            $orders = [];
            $sql = "SELECT o.id, o.count, o.name, o.address, o.phone, o.email, o.date, o.id_user, o.completed, g.title, g.price FROM orders o LEFT OUTER JOIN goods g ON (o.id_good = g.id) ORDER BY o.date DESC";
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

    public function completed($user)
    {
        $sql = "UPDATE orders SET completed='1' WHERE id_user=:id_user";
        $markers = [
            ':id_user' => $user
        ];

        return DB::update($sql, $markers);
    }
}
