<?php

class Cart extends Base
{
    /**
     * Метод заполнения корзины товарами и отправки заказа в БД
     */
    public function cart()
    {
        $this->title .= 'Корзина';
        $this->content = '/pages/cart.html';

        if (isset($_GET['id'])) {
            if ($_GET['value'] == 'id') {
                $id = (int)$_GET['id'];

                $cart = new Basket;
                $cart->addCart($id);

                header("Location: /");
            } elseif ($_GET['value'] == 'add') {
                $id = (int)$_GET['id'];

                $cart = new Basket;
                $cart->addCart($id);
                
                header("Location: ?path=good/id/$id");
            }
        } else {
            //заполняем массив корзины при помощи вызова ф-ии getCart
            $cart = new Basket;
            $this->data = $cart->getCart();
        }
    }
}
