<?php

class Orders extends Base
{
    /**
     * Метод получения заказов из БД и отправки заказа в БД
     */
    public function orders()
    {
        $this->title .= 'Заказы';
        $this->content = '/pages/orders.html';

        if (isset($_GET['value']) && $_GET['value'] == 'order') {
            if ($this->isPost()) {
                //проверяем входные данные на тэги и удаляем их если есть при помощи ф-ии strip_tags() и пробелы при помощи trim()
                $idGood = $_POST['id_good'];
                $count = $_POST['count'];
                $name = (!empty($_POST['name'])) ? trim(strip_tags($_POST['name'])) : '';
                $address = (!empty($_POST['address'])) ? trim(strip_tags($_POST['address'])) : '';
                $phone = (!empty($_POST['phone'])) ? str_replace(' ', '', trim($_POST['phone'])) : '';
                $email = (!empty($_POST['email'])) ? trim(strip_tags($_POST['email'])) : '';
    
                $order = new Order;
                $this->data = $order->addOrder($idGood, $count, $name, $address, $phone, $email);
    
                header('Location: ?path=cart');
            }
        } else {
            $orders = new Order;
            $this->data = $orders->getOrders();
        }

        if (isset($_GET['id'])) {
            $user = trim(strip_tags($_GET['id']));

            $cart = new Order;
            $cart->completed($user);

            header('Location: ?path=orders');
        }
    }
}
