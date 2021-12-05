<?php

class Products extends Base
{
    /**
     * Метод вывода товара из БД на страницу
     */
    public function products()
    {
        $this->title .= 'Каталог товаров';
        $this->content = '/pages/goods.html';

        $goods = new Goods;
        $this->data = $goods->getProducts();

        $textError = '';
        //проверяем входные данные на тэги и удаляем их если есть при помощи ф-ии strip_tags() и пробелы при помощи trim()
        $id = (!empty($_GET['value'])) ? (int)$_GET['value'] : ''; 
        $title = (!empty($_POST['title'])) ? trim(strip_tags($_POST['title'])) : '';
        $price = (!empty($_POST['price'])) ? (float)trim(strip_tags($_POST['price'])) : '';
        $description = (!empty($_POST['description'])) ? trim(strip_tags($_POST['description'])) : '';

        //указываем путь к папке для загрузки
        $bigImg = $_SERVER['DOCUMENT_ROOT'] . '/src/img/big/';
        $smallImg = $_SERVER['DOCUMENT_ROOT'] . '/src/img/small/';

        if (isset($_GET['value']) && $_GET['value'] == 'upload') {
            if ($this->isPost()) {
                //определяем если в массиве $_FILES с ключом img что-то есть и исключим ошибку error, то переносим файл из временной директории tmp_name в нашу папки с картинками
                if (!empty($_FILES['img']['error'])) {
                    $textError = 'Произошла ошибка';
                } else {
                    //проверяем на формат
                    if ($_FILES['img']['type'] === 'image/jpeg' ||
                        $_FILES['img']['type'] === 'image/jpg' ||
                        $_FILES['img']['type'] === 'image/png') {
                            $product = new Product;
                            $product->uploadGood($_FILES['img'], $bigImg, $smallImg, $title, $price, $description, $textError);
                            header('Location: ?path=products');
                    } else {
                        $textError = 'Неверный формат файла';
                    }
                }
            }
        } elseif (isset($_GET['value']) && (int)$_GET['value']) {
            if ($this->isPost()) {
                if (isset($_POST['edit'])) {
                    //определяем если в массиве $_FILES с ключом img что-то есть и исключим ошибку error, то переносим файл из временной директории tmp_name в нашу папки с картинками
                    if (!empty($_FILES['img']['error'])) {
                        $textError = 'Произошла ошибка';
                    } else {
                        //проверяем на формат
                        if ($_FILES['img']['type'] === 'image/jpeg' ||
                            $_FILES['img']['type'] === 'image/jpg' ||
                            $_FILES['img']['type'] === 'image/png') {
                                $product = new Product;
                                $product->editImg($_FILES['img'], $bigImg, $smallImg, $id, $textError);
                        } else {
                            $textError = 'Неверный формат файла';
                        }
                    }
                    $product = new Product;
                    $product->editGood($title, $price, $description, $id);
                    
                    header('Location: ?path=products');
                } elseif (isset($_POST['delete'])) {
                    $product = new Product;
                    $product->deleteGood($id);
                    header('Location: ?path=products');
                }
            }
        }
    }
}
