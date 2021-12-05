<?php

class Basket
{
    /**
     * Метод получения товара из корзины
     */
    public function getCart()
    {
        if (!empty($_COOKIE['cart'])) {
            foreach ($_COOKIE['cart'] as $value) {
                $good = new Product;
                $getGood = $good->getGood($value['id']);
                $value['title'] = $getGood['title'];
                $value['id'] = $getGood['id'];
                $value['price'] = $getGood['price'];
                $cart[] = $value;
            }
            return $cart;
        }
    }

    /**
     * Метод добавления товара в корзину
     */
    public function addCart($id)
    {
        if (!$_COOKIE['cart']) {
            setcookie("cart[$id][id]", $id, time() + 3600, '/');
            setcookie("cart[$id][count]", 1, time() + 3600, '/');
        } else {
            setcookie("cart[$id][id]", $id, time() + 3600, '/');
            setcookie("cart[$id][count]", ++$_COOKIE['cart'][$id]['count'], time() + 3600, '/');
        }
    }

    /**
     * Метод меняет количество товара в корзине
    */
    public function changeCountGoodCart($sign, $idCart)
    {
        if ($sign == 'plus') {
            setcookie("cart[$idCart][id]", $idCart, time() + 3600, '/');
            setcookie("cart[$idCart][count]", ++$_COOKIE['cart'][$idCart]['count'], time() + 3600, '/');
        } elseif ($sign == 'minus') {
            if (isset($_COOKIE['cart'][$idCart]) && $_COOKIE['cart'][$idCart]['count'] == 1) {
                setcookie("cart[$idCart][id]", '', time() - 1, '/');
                setcookie("cart[$idCart][count]", '', time() - 1, '/');
            } else {
                setcookie("cart[$idCart][id]", $idCart, time() + 3600, '/');
                setcookie("cart[$idCart][count]", --$_COOKIE['cart'][$idCart]['count'], time() + 3600, '/');
            }
        } else {
            die ('Ошибка в перерасчете карзины!');
        }
    }
}
