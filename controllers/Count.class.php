<?php

class Count extends Base
{
    /**
     * Метод подсчёта товаров в корзине
     */
    public function count()
    {
        if (isset($_GET['value'])) {
            $idCart = $_GET['id'];
            $sign = $_GET['value'];
            $cart = new Basket;
            $cart->changeCountGoodCart($sign, $idCart);
            header("Location: ?path=cart");
        }
    }
}
