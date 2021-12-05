<?php
/* Класс Singleton (одиночка), который не позволяет наследоваться и служит лишь для одного конкретного применения */

//Подключение констант
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/index.php';

class DB
{
    //класс для запроса PDO
    protected static $pdo = null;

    // У класса Singleton конструктор должен быть закрыт (приватным) и без возможности клопировать сам класс
    private function __construct() {}
    private function __clone() {}

    /**
     * Метод подключения к БД
     * @return возвращает подключение к БД
     */
    private static function pdo() {
        try {
            if (self::$pdo === null) {
                $options = [
                    // Опция для вывода всех ошибок
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Опция для PDO чтобы сформированный массив был ассоциативный на выходе
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    //
                    PDO::ATTR_EMULATE_PREPARES => TRUE,
                ];

                $connect = DRIVER . ':host=' . SERVER . ';dbname=' . DB . ';';
                self::$pdo = new PDO($connect, LOGIN, PASSWORD, $options);
            }
            return self::$pdo;
        } catch (PDOException $e) {
            die ('Ошибка подключения к БД: ' . $e->getMessage());
        }
    }

    /**
     * Шаблон запросов sql к БД
     * @param string $sql
     * @param array $args маркеры
     * @return возвращает результат запроса к БД
     */
    private static function sql($sql, $args = []) {
        $result = self::pdo()->prepare($sql);
        $result->execute($args);
        return $result;
    }

    /**
     * Запрос sql к БД типа SELECT
     * @param string $sql
     * @param array $args маркеры
     * @return array ассоциативный со всеми строками (записями) БД - (fetchAll)
     */
    public static function selectAll($sql, $args = []) {
        return self::sql($sql, $args)->fetchAll();
    }

    /**
     * Запрос sql к БД типа SELECT
     * @param string $sql
     * @param array $args маркеры
     * @return array ассоциативный с одной конкретной строкой (записью) БД - (fetch)
     */
    public static function selectRow($sql, $args = []) {
        return self::sql($sql, $args)->fetch();
    }

    /**
     * Запрос sql к БД типа INSERT
     * @param string $sql
     * @param array $args маркеры
     * @return integer последний вставленный  ID
     */
    public static function insert($sql, $args = []) {
        self::sql($sql, $args);
        return self::pdo()->lastInsertId();
    }

    /**
     * Запрос sql к БД типа UPDATE
     * @param string $sql
     * @param array $args маркеры
     * @return integer сколько строк обновили
     */
    public static function update($sql, $args = []) {
        $result = self::sql($sql, $args);
        return $result->rowCount();
    }

    /** 
     * Запрос sql к БД типа DELETE
     * @param string $sql
     * @param array $args маркеры
     * @return integer сколько строк удалили
     */
    public static function delete($sql, $args = []) {
        $result = self::sql($sql, $args);
        return $result->rowCount();
    }
}
