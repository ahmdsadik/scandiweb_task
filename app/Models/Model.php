<?php

namespace App\Models;

use App\Lib\Database\DatabaseHandler;

abstract class Model
{
    protected string $sql;

    public function fill(array $values): void
    {
        foreach (static::$tableSchema as $column => $type) {
            $this->{$column} = $values[$column] ?? '';
        }
    }

    private function prepareValues(\PDOStatement &$stmt): void
    {
        foreach (static::$tableSchema as $columnName) {
            $stmt->bindValue(":$columnName", $this->$columnName);
        }
    }

    private function buildNameParametersSQL(): string
    {
        $namedParams = '';
        foreach (static::$tableSchema as $columnName) {
            $namedParams .= $columnName . ' = :' . $columnName . ', ';
        }
        return trim($namedParams, ', ');
    }

    protected function create(): bool
    {
        $sql = 'INSERT INTO ' . static::$tableName . ' SET ' . $this->buildNameParametersSQL();

        $stmt = DatabaseHandler::factory()->prepare($sql);

        $this->prepareValues($stmt);
        if ($stmt->execute()) {
            if (property_exists($this, static::$primaryKey ?? ''))
                $this->{static::$primaryKey} = DatabaseHandler::factory()->lastInsertId();
            return true;
        }
        return false;
    }

    public static function getAll()
    {
        $sql = 'SELECT * FROM ' . static::$tableName;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();

        if (method_exists(get_called_class(), '__construct')) {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        } else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }

        return $results;
    }

    public static function deleteIn($colName, $items = [])
    {
        $placeholders = rtrim(str_repeat('?,', count($items)), ',');
        $sql = 'DELETE FROM ' . static::$tableName . '  WHERE ' . $colName . ' IN ' . "($placeholders)";

        $stmt = DatabaseHandler::factory()->prepare($sql);

        return $stmt->execute($items);
    }
}