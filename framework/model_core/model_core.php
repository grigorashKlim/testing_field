<?php

class Model

{
    public $login = false;
    public $email = false;
    public $password = false;
    public $repassword = false;
    public $conn;

    function __construct()
    {
        $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    }


    function connectDB()
    {
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * transforms array's indexes into list $field_list and values - into $value_list and puts both lists into another array.
     * needed for setting sql queries params
     * @param $data
     * @return array
     */
    function array_to_string($data)
    {
        $field_list = '';  //field list string
        $value_list = '';  //value list string
        foreach ($data as $k => $v) {
            $field_list .= $k . ',';
            $value_list .= $v . ',';
        }
        $field_list = rtrim($field_list, ',');
        $value_list = rtrim($value_list, ',');
        $array = array($field_list, $value_list);
        return $array;
    }

    function createDB($table_name, $rows)
    {
        $this->connectDB();
        try {
            $sql = "CREATE TABLE {$table_name} (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, {$rows})";
            $this->conn->exec($sql);
        } catch (PDOException $e) {
            /*echo "Creation failed: " . $e->getMessage().'<br>';*/
            return false;
        }
    }

    /**
     * @param $table_name
     * @param $data
     * @return bool|PDOStatement
     *
     * same as sql query "INSERT INTO"
     */
    function insertDB($table_name, $data)
    {
        $this->connectDB();
        $array = $this->array_to_string($data);
        $field_list = $array[0];
        $value_list = '';
        foreach ($data as $k => $v) {

            $value_list .= ":" . $k . ",";
        }
        // Trim the comma on the right
        $value_list = rtrim($value_list, ',');
        $sql = "INSERT INTO {$table_name} ({$field_list}) VALUES ($value_list)";
        $ins = $this->conn->prepare($sql);
        $ins->execute($data);
        return $ins;
    }

    /**
     * @param $fetch_result
     * @return bool
     * transform sql resulting array into associative array (remove nesting level)
     */
    function fetch_to_array($fetch_result)
    {
        if (!is_array($fetch_result)) {
            /*echo "fetch_to_array ALERT";*/
            return false;
        }
        foreach ($fetch_result as $k => $v) {
            foreach ($v as $x => $y) {
                $c[$k] = $y;//array "select_from_where" from 0 to ... of selected rows
            }
        }
        return $c;
    }

    /**
     * @param $fetch_result
     * @return bool|mixed
     * transform fetch result into one first string of a query
     */
    function fetch_to_string($fetch_result)
    {
        $fetch_result = $this->fetch_to_array($fetch_result);
        if (!is_array($fetch_result)) {
            /*echo "fetch_to_array ALERT";*/
            return false;
        }
        $fetch_result = $fetch_result[0];
        return $fetch_result;
    }

    /**
     * @param $table_name
     * @param null $except
     * @return array
     * by table name gives name of all columns contained
     */
    function get_column_names($table_name, $except = null)
    {
        $this->connectDB();
        $except_list = '';
        foreach ($except as $v) {
            $except_list .= "and column_name !='" . $v . "'";
        }
        $query = "SELECT column_name from information_schema.columns where table_schema ='" . DB_NAME . "' and table_name = '{$table_name}' {$except_list}";
        $query = $this->conn->prepare($query);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param $select
     * @param $table_name
     * @param null $condition
     * @param null $limit
     * @param null $offset
     * @return array|bool
     * same as "SELECT FROM" sql query"  + supports extra condition and limit/offset for output
     */
    function select_from_whereDB($select, $table_name, $condition = null, $limit = null, $offset = null)
    {
        $this->connectDB();
        $query = "SELECT {$select} FROM {$table_name}";
        if ($condition || $limit || $offset) {
            if (is_array($condition)) {
                $array = $this->array_to_string($condition);
                $field_list = $array[0];
                $value_list = $array[1];
                $query .= " WHERE {$field_list}='{$value_list}'";
            }
            if ($limit !== null && $offset !== null) {
                $query .= " LIMIT {$limit} OFFSET {$offset}";
            }
        }
        $query = $this->conn->prepare($query);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    /**
     * @param $table_name
     * @param $condition
     * @return bool|mixed
     * returns number of table rows
     */
    function arrayCount($table_name, $condition)
    {
        $this->connectDB();
        $query = "SELECT count(*)FROM {$table_name} ";
        if (is_array($condition)) {
            $array = $this->array_to_string($condition);
            $field_list = $array[0];
            $value_list = $array[1];
            $query .= " WHERE {$field_list}='{$value_list}'";
        }
        $query = $this->conn->prepare($query);
        $query->execute();
        $result = $query->fetchColumn();

        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    /**
     * @param $table_name
     * @param $updated
     * @param $condition
     * same as "UPDATE" sql query
     */
    function updateDB($table_name, $updated, $condition)
    {
        $this->connectDB();
        $condition_set = $this->array_to_string($updated);
        $condition_where = $this->array_to_string($condition);
        $query = "UPDATE {$table_name} SET {$condition_set[0]}='{$condition_set[1]}' where {$condition_where[0]}='{$condition_where[1]}'";
        $this->conn->exec($query);
    }

    /**
     * @param $table_name
     * @param $condition
     * same as "DELETE" sql query
     */
    function deleteDB($table_name, $condition)
    {
        $this->connectDB();
        $array = $this->array_to_string($condition);
        $field_list = $array[0];
        $value_list = $array[1];
        $query = "DELETE FROM {$table_name} WHERE {$field_list}='{$value_list}'";
        $this->conn->exec($query);
    }
}