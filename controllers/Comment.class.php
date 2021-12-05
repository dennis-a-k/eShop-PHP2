<?php

class Comment extends Base
{
    /**
     * Метод записи нового отзыва
     */
    public function comment()
    {
        if ($this->isPost()) {
            //проверяем входные данные на тэги и удаляем их если есть при помощи ф-ии strip_tags()
            $name = (!empty($_POST['name'])) ? trim(strip_tags($_POST['name'])) : '';
            $review = (!empty($_POST['review'])) ? trim(strip_tags($_POST['review'])) : '';
            $id = (int)$_GET['id'];
            //записываем данные в таблицу
            $comment = new Reviews;
            $comment->sendComment($name, $review, $id);
            
            header('Location: ?path=good/id/' . $id);
        }
    }
}
