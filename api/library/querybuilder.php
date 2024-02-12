<?php

class QueryBuilder {
    public static function buildInsertParamQuery($table, $data) {
        // Membuat bagian VALUES dari pernyataan SQL
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(function($field) {
            return ':' . $field;
        }, array_keys($data)));

        // Membuat pernyataan SQL INSERT
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";

        return $sql;
    }

    public static function buildInsertQuery($table, $data) {
        // Membuat bagian VALUES dari pernyataan SQL
        $fields = implode(', ', array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";

        // Membuat pernyataan SQL INSERT
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";

        return $sql;
    }

    public static function buildBulkInsertQuery($table, $data) {
        // Membuat bagian FIELD dari pernyataan SQL
        $fields = implode(', ', array_keys($data[0]));

        // Membuat bagian VALUES dari pernyataan SQL
        $values = [];
        foreach ($data as $row) {
            $rowValues = [];
            foreach ($row as $value) {
                $rowValues[] = "'" . $value . "'";
            }
            $values[] = '(' . implode(', ', $rowValues) . ')';
        }
        $valuesString = implode(', ', $values);

        // Membuat pernyataan SQL INSERT
        $sql = "INSERT INTO $table ($fields) VALUES $valuesString";

        return $sql;
    }
}
