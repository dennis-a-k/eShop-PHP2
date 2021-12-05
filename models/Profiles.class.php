<?php

class Profiles
{
    public function getUsers()
    {
        try {
            $sql = "SELECT * FROM users ORDER BY `name`";
            return DB::selectAll($sql);
        } catch (PDOException $e) {
            die ('Ошибка при получении списка пользователей: ' . $e->getMessage());
        }
    }

    public function editUser($role, $id)
    {
        try {
            //меняем роль пользователя
            $role == 1 ? $role = 2 : $role = 1;
            //обновляем данные в таблице
            $sql = "UPDATE users SET `role`=:role WHERE `id`=:id";
            $markers = [
                ':role' => $role,
                ':id' => $id
            ];
            DB::insert($sql, $markers);
        } catch (PDOException $e) {
            die ('Ошибка при изменении статуса пользователя: ' . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $sql = "DELETE FROM users WHERE id=:id";
            $markers = [
                ':id' => $id
            ];
            DB::delete($sql, $markers);
        } catch (PDOException $e) {
            die ('Ошибка при удалении пользователя: ' . $e->getMessage());
        }
    }
}
