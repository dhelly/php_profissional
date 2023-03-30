<?php

function all($table, $fields = '*')
{
    try {

        $connect = connect();

        $query = $connect->query("SELECT {$fields} FROM {$table}");

        return $query->fetchAll();


    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}

function findBy($table, $field, $value, $fields = "*")
{
    try {

        $connect = connect();

        $prepare = $connect->prepare("SELECT {$fields} FROM {$table} where {$field} = :{$field}");

        $prepare->execute([
            $field => $value
        ]);

        return $prepare->fetch();


    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}
