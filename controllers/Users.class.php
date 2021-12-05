<?php

class Users extends Base
{
    /**
     * Метод вывода пользователей из БД на страницу
     */
    public function users()
    {
        $this->title .= 'Пользователи';
        $this->content = '/pages/users.html';

        $users = new Profiles;
        $this->data = $users->getUsers();

        $id = (!empty($_GET['id'])) ? (int)$_GET['id'] : '';
        $role = (!empty($_GET['value'])) ? (int)$_GET['value'] : '';

        if (isset($_GET['value']) && (int)$_GET['value']) {
            if ($this->isPost()) {
                if (isset($_POST['edit'])) {
                    $user = new Profiles;
                    $user->editUser($role, $id);
                    header('Location: ?path=users');
                } elseif (isset($_POST['delete'])) {
                    $user = new Profiles;
                    $user->deleteUser($id);
                    header('Location: ?path=users');
                }
            }
        }
    }
}
