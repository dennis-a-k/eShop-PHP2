<?php

class Index extends Base
{
    /**
     * Метод вывода товара из БД на страницу
     */
    public function index()
    {
        $this->title .= 'Интернет-магазин';
        $this->content = '/pages/index.html';

        $goods = new Goods;
        $this->data = $goods->getGoods();
    }
}
