<?php
class Model

{
public $login=false;
public $email=false;
public $password=false;
public $repassword=false;
public $conn;

    function __construct()
    {
         $this->conn=new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    }


    function connectDB()
    {
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    function array_to_string($data)
    {
        $field_list = '';  //field list string
        $value_list = '';  //value list string
        foreach ($data as $k => $v) {
                $field_list .= $k . ',';
                $value_list .= $v . ',';
        }
        $field_list=rtrim($field_list,',');
        $value_list=rtrim($value_list,',');
        $array=array($field_list,$value_list);
        return $array;
    }

    function createDB($table_name,$rows)
    {
        $this->connectDB();
        try {
            $sql = "CREATE TABLE {$table_name} (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, {$rows})";
            $this->conn->exec($sql);
        }
        catch(PDOException $e)
        {
            /*echo "Creation failed: " . $e->getMessage().'<br>';*/
            return false;
        }
    }
    /**
     * @select $table_name
     * @select $data ---> array kind of [column_name => $info]
     * data insert into DB
     */
    function insertDB($table_name, $data)
    {
        $this->connectDB();
        $array=$this->array_to_string($data);
        $field_list=$array[0];
        $value_list='';
        foreach ($data as $k => $v) {

                $value_list .= ":".$k.",";
        }
        // Trim the comma on the right
        $value_list = rtrim($value_list,',');
        $sql="INSERT INTO {$table_name} ({$field_list}) VALUES ($value_list)";
        $ins=$this->conn->prepare($sql);
        $ins->execute($data);
        return $ins;
    }

    function fetch_to_array($fetch_result)
    {
        if (!is_array($fetch_result))
        {
            /*echo "fetch_to_array ALERT";*/
            return false;
        }
        foreach ($fetch_result as $k => $v)
        {
            foreach ($v as $x => $y) {
                $c[$k]=$y;//array "select_from_where" from 0 to ... of selected rows
            }
        }
        return $c;
    }
    function fetch_to_string($fetch_result)
    {
        $fetch_result=$this->fetch_to_array($fetch_result);
        if (!is_array($fetch_result))
        {
            /*echo "fetch_to_array ALERT";*/
            return false;
        }
        $fetch_result=$fetch_result[0];
        return $fetch_result;
    }

    function get_column_names($table_name,$except=null)
    {
        $this->connectDB();
        $except_list='';
        foreach ($except as $v) {
            $except_list .= "and column_name !='".$v."'";
        }
        $query = "SELECT column_name from information_schema.columns where table_schema ='".DB_NAME."' and table_name = '{$table_name}' {$except_list}";
        $query=$this->conn->prepare($query);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function select_from_whereDB($select,$table_name,$condition=null,$limit=null,$offset=null)
    {
        $this->connectDB();
        $query="SELECT {$select} FROM {$table_name}";
        if ($condition || $limit || $offset)
        {
            if (is_array($condition))
            {
                $array = $this->array_to_string($condition);
                $field_list = $array[0];
                $value_list = $array[1];
                $query .= " WHERE {$field_list}='{$value_list}'";
            }
            if ($limit !== null && $offset !== null)
            {
                $query .= " LIMIT {$limit} OFFSET {$offset}";
            }
        }
        $query=$this->conn->prepare($query);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result)
        {
            return false;
        }
        else{
            return $result;
        }
    }

    function updateDB($table_name,$updated,$condition)
    {
        $this->connectDB();
        $condition_set=$this->array_to_string($updated);
        $condition_where=$this->array_to_string($condition);
        $query="UPDATE {$table_name} SET {$condition_set[0]}='{$condition_set[1]}' where {$condition_where[0]}='{$condition_where[1]}'";
        $this->conn->exec($query);
    }

    function deleteDB($table_name,$condition)
    {
        $this->connectDB();
        $array=$this->array_to_string($condition);
        $field_list=$array[0];
        $value_list=$array[1];
        $query="DELETE FROM {$table_name} WHERE {$field_list}='{$value_list}'";
        $this->conn->exec($query);
    }
}