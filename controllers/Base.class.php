<?php

abstract class Base extends Controller
{
	protected $title;
    protected $layouts;
	protected $content;
    protected $data;
    protected $date;
    protected $reviews;
    protected $cart;
    protected $user;

    protected function before()
    {
		$this->title = 'eShop | ';
        $this->layouts = 'shop.html';
        $this->date = date('Y');
        $this->cart = 0;
        
        //Вывод количества товаров в корзине
        if (isset($_COOKIE['cart'])) {
            foreach ($_COOKIE['cart'] as $key => $value) {
                $this->cart += $value['count'];
            }
        }
        if (isset($_COOKIE['user'])) {
            $this->user['email'] = $_COOKIE['user']['email'];
            $this->user['password'] = $_COOKIE['user']['password'];
        }
	}
	
	public function render()
	{
		$vars = [
            'title' => $this->title,
            'content' => $this->content,
            'data' => $this->data,
            'date' => $this->date,
            'reviews' => $this->reviews,
            'cart' => $this->cart,
            'user' => $this->user
        ];
        
		$page = $this->template($this->layouts, $vars);				
		echo $page;
	}	
}
