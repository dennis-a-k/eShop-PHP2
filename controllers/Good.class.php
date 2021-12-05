<?php

class Good extends Base
{
    public function good()
    {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $good = new Product;
            $this->data = $good->getGood($id);
            if (empty($this->data)) header('Location: /');

            $reviews = new Reviews;
            $this->reviews = $reviews->getReviews($id);
        }

        $this->content = '/pages/good.html';
        $this->title .= $this->data['title'];
    }
}
