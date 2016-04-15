<?php namespace core\database;

use core\contracts\ICrud;

class Crud extends Db implements ICrud
{
    private $sql;
    private $table;
    private $primaryKey;

    use \core\traits\ClassMethods;

    public function __construct()
    {
        $this->sql = '';
        $this->table = '';
        $this->primaryKey = 'id';
    }

    protected final function setTable($table)
    {
        if (is_string($table) and strlen($table) > 0) {
            $this->table = $table;
        }
    }

    public final function getTable()
    {
        return $this->table;
    }

    protected final function setPrimaryKey($column)
    {
        if (is_string($column) and strlen($column) > 0) {
            $this->primaryKey = $column;
        }
    }

    public final function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    private function setDebugBacktrace($file, $line)
    {
        $_SESSION['debug_backtrace_file'] = $file;
        $_SESSION['debug_backtrace_line'] = $line;
    }

    private function orderBy($column, $direction)
    {
        if (!is_null($column) and is_string($column))
        {
            $this->sql .= " ORDER BY " . $column;

            if (!is_null($direction) and is_string($direction))
            {
                $this->sql .= " " . strtoupper($direction);
            }
        }

        if (!is_null($column) and is_array($column))
        {
            if (!is_null($direction) and is_array($direction))
            {
                if (count($column) === count($direction))
                {
                    foreach ($column as $i => $field)
                    {
                        if ($i < 1) {
                            $this->sql .= " ORDER BY " . $field . " " . strtoupper($direction[$i]);
                        } else {
                            $this->sql .= ", " . $field . " " . strtoupper($direction[$i]);
                        }
                    }
                }
            }
        }
    }

    public final function insert($data)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $data, 1, ['array']);

        $continue = false;

        // Validation
        if (is_array($data) and count($data) > 0) {

            if (!isset($data['fields']) and !isset($data['values'])) {
                $aux['fields'] = array_keys($data);
                $aux['values'] = array_values($data);
                $data = $aux;
            }

            if (isset($data['fields']) and isset($data['values'])) {
                if (count($data['fields']) === count($data['values'])) {
                    $continue = true;
                } else {
                    // Exception
                    $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
                    throw new \Exception('The number of columns don\'t match the number of values.');
                }
            }
        }

        if (!$continue) { return false; } // Return: False

        // Get Fields
        $fields = implode(',', $data['fields']);
        $total  = count($data['fields']);

        // String SQL
        $this->sql = "INSERT INTO " . $this->table . " (" . $fields . ") VALUES (";

        foreach ($data['fields'] as $i => $field)
        {
            $this->sql .= "?";
            if ((++$i) != $total) {
                $this->sql .= ", ";
            } else {
                $this->sql .= ")";
            }
        }

        // Try Insert
        try {
            $stmt = parent::prepare($this->sql);
            // Return: True or False
            return $stmt->execute($data['values']);
        } catch (\Exception $e) {
            // Exception
            $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
            throw new \Exception($e->getMessage());
        }
    }

    public final function update($id, $data)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 2, 2);
        self::validateArgType(__FUNCTION__, $id, 1, ['string', 'integer']);
        self::validateArgType(__FUNCTION__, $data, 2, ['array']);

        $continue = false;

        // Validation
        if (is_array($data) and count($data) > 0) {

            if (!isset($data['fields']) and !isset($data['values'])) {
                $aux['fields'] = array_keys($data);
                $aux['values'] = array_values($data);
                $data = $aux;
            }

            if (isset($data['fields']) and isset($data['values'])) {
                if (count($data['fields']) === count($data['values'])) {
                    if (is_string($id) or is_integer($id)) {
                        $continue = true;
                    }
                } else {
                    // Exception
                    $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
                    throw new \Exception('The number of columns don\'t match the number of values.');
                }
            }
        }

        if (!$continue) { return false; } // Return: False

        // Total Fields
        $total = count($data['fields']);

        // String SQL
        $this->sql = "UPDATE " . $this->table . " SET ";

        foreach ($data['fields'] as $i => $field)
        {
            $this->sql .= $field . " = ?";
            if ((++$i) != $total) {
                $this->sql .= ", ";
            }
        }
        $this->sql .= " WHERE ";
        $this->sql .= $this->primaryKey . " = ?";

        // Try Update
        try {
            $stmt = parent::prepare($this->sql);
            array_push($data['values'], $id);
            // Return: True or False
            return $stmt->execute($data['values']);
        } catch (\Exception $e) {
            // Exception
            $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
            throw new \Exception($e->getMessage());
        }
    }

    public final function delete($id)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $id, 1, ['string', 'integer']);

        // Validation
        if (!$id or (!is_string($id) and !is_integer($id))) {
            return false; // Return: False
        }

        // String SQL
        $this->sql = "DELETE FROM " . $this->table . " WHERE " . $this->primaryKey . " = :id";

        // Try Delete
        try {
            $stmt = parent::prepare($this->sql);
            $stmt->bindParam(':id', $id, parent::paramType($id));
            // Return: True or False
            return $stmt->execute();
        } catch (\Exception $e) {
            // Exception
            $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
            throw new \Exception($e->getMessage());
        }
    }

    public final function deleteAll()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        // String SQL
        $this->sql = "DELETE FROM " . $this->table;

        // Try Delete All
        try {
            $stmt = parent::prepare($this->sql);
            // Return: True or False
            return $stmt->execute();
        } catch (\Exception $e) {
            // Exception
            $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
            throw new \Exception($e->getMessage());
        }
    }

    public final function find($id)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $id, 1, ['string', 'integer']);

        // Validation
        if (!$id or (!is_string($id) and !is_integer($id))) {
            return false; // Return: False
        }

        // String SQL
        $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $this->primaryKey . " = :id";

        // Try Find
        try {
            $stmt = parent::prepare($this->sql);
            $stmt->bindParam(':id', $id, parent::paramType($id));
            $result = $stmt->execute();
            if ($result) {
                // Return: Object
                return $stmt->fetch();
            } else {
                // Return: False
                return $result;
            }
        } catch (\Exception $e) {
            // Exception
            $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
            throw new \Exception($e->getMessage());
        }
    }

    public final function where($args, $column = null, $direction = null)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 3);
        self::validateArgType(__FUNCTION__, $args, 1, ['array']);
        self::validateArgType(__FUNCTION__, $column, 2, ['string', 'null']);
        self::validateArgType(__FUNCTION__, $direction, 3, ['string', 'null']);

        $continue = false;

        // Validation
        if (is_array($args) and count($args) > 0) {

            if (!isset($args['fields']) and !isset($args['values'])) {
                $aux['fields'] = array_keys($args);
                $aux['values'] = array_values($args);
                $args = $aux;
            }

            if (isset($args['fields']) and isset($args['values'])) {
                if (count($args['fields']) === count($args['values'])) {
                    $continue = true;
                } else {
                    // Exception
                    $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
                    throw new \Exception('The number of columns don\'t match the number of values.');
                }
            }
        }

        if (!$continue) { return false; } // Return: False

        // String SQL
        $this->sql = "SELECT * FROM " . $this->table . " WHERE 1 = 1";

        foreach ($args['fields'] as $field) {
            $this->sql .= " AND " . $field . " LIKE ?";
        }

        $this->orderBy($column, $direction);

        // Try Where
        try {
            $stmt = parent::prepare($this->sql);
            $result = $stmt->execute($args['values']);
            if ($result) {
                // Return: Array of Objects or Empty Array
                return $stmt->fetchAll();
            } else {
                // Return: False
                return $result;
            }
        } catch (\Exception $e) {
            // Exception
            $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
            throw new \Exception($e->getMessage());
        }
    }

    public final function all($column = null, $direction = null)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 0, 2);
        self::validateArgType(__FUNCTION__, $column, 1, ['string', 'null']);
        self::validateArgType(__FUNCTION__, $direction, 2, ['string', 'null']);

        // String SQL
        $this->sql = "SELECT * FROM " . $this->table;

        $this->orderBy($column, $direction);

        // Try Get All
        try {
            $stmt = parent::prepare($this->sql);
            $result = $stmt->execute();
            if ($result) {
                // Return: Array of Objects or Empty Array
                return $stmt->fetchAll();
            } else {
                // Return: False
                return $result;
            }
        } catch (\Exception $e) {
            // Exception
            $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
            throw new \Exception($e->getMessage());
        }
    }

    public final function query($sql, $values = array())
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 2);
        self::validateArgType(__FUNCTION__, $sql, 1, ['string']);
        self::validateArgType(__FUNCTION__, $values, 2, ['array']);

        // Validation
        if (!is_string($sql)) { return false; } // Return: False

        // String SQL
        $this->sql = $sql;

        // Try Query
        try {
            $stmt = parent::prepare($this->sql);
            if (count($values) > 0) {
                $result = $stmt->execute($values);
            } else {
                $result = $stmt->execute();
            }
            if ($result) {
                // Return: Array of Objects or Empty Array
                $records = $stmt->fetchAll();
                return $records;
            } else {
                // Return: False
                return $result;
            }
        } catch (\Exception $e) {
            // Exception
            $this->setDebugBacktrace(debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
            throw new \Exception($e->getMessage());
        }
    }
}
