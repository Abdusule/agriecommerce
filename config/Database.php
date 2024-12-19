<?php
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "ecommerce";
    private $conn;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $this->conn = new PDO($dsn, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function escapeString($string)
    {
        return $string;
    }

    public function create($table, $data)
    {
        try {
            $keys = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO $table ($keys) VALUES ($values)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function read($table, $condition = "")
    {
        try {
            $sql = "SELECT * FROM $table $condition";
            $stmt = $this->conn->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

  public function readAll($table, $condition = "")
{
    try {
        // Ensure proper formatting of condition
        $condition = trim($condition);

        // Build the query
        $sql = "SELECT * FROM $table";
        if (!empty($condition)) {
            $sql .= " $condition";
        }

        // Execute the query
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

public function fetchOrderDetails($columns = "*", $condition = "")
{
    try {
        // Ensure proper formatting of columns
        $columns = !empty($columns) ? $columns : "*";

        // Build the SQL query
        $sql = "
            SELECT $columns
            FROM orders o
            INNER JOIN users u ON o.user_id = u.id
            INNER JOIN products p ON o.product_id = p.id
        ";

        // Add conditions if provided
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }

        // Execute the query
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}


    public function readAllCondition($table, $condition = "")
    {
        try {
            $sql = "$condition";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function readWithJoin($table1, $table2, $joinCondition, $condition = "")
    {
        try {
            // Dynamically prefix column names with table names
            $columns1 = $this->getColumns($table1, $table1 . ".");
            $columns2 = $this->getColumns($table2, $table2 . ".");
            $columns = implode(", ", array_merge($columns1, $columns2));
    
            $sql = "SELECT $columns FROM $table1 
                    INNER JOIN $table2 
                    ON $joinCondition $condition";
    
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    
    private function getColumns($table, $prefix = "")
    {
        try {
            $sql = "DESCRIBE $table";
            $stmt = $this->conn->query($sql);
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            return array_map(fn($column) => $prefix . $column, $columns);
        } catch (PDOException $e) {
            die("Error fetching columns for $table: " . $e->getMessage());
        }
    }
    

    public function update($table, $data, $condition)
    {
        try {
            $set = [];
            foreach ($data as $key => $value) {
                $set[] = "$key = :$key";
            }
            $set = implode(", ", $set);
            $sql = "UPDATE $table SET $set WHERE $condition";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function delete($table, $condition)
    {
        try {
            $sql = "DELETE FROM $table WHERE $condition";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function readF($table1, $table2,  $key1, $fields = "*", $key2 = "id")
    {
        try {
            $query = "SELECT $fields FROM $table1 INNER JOIN $table2 ON $table1.$key1 = $table2.$key2";
            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function readInnerJoin($table1, $table2, $key1, $fields = "*", $key2 = "id", $where = "", $params = [])
{
    try {
        // Build the base query
        $query = "SELECT $fields FROM $table1 INNER JOIN $table2 ON $table1.$key1 = $table2.$key2";
        
        // Append WHERE clause if provided
        if (!empty($where)) {
            $query .= " WHERE $where";
        }

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}


    public function query($sql, $params = [])
{
    try {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}


public function readAllNew($table, $condition, $params = [])
{
    try {
        // Ensure the condition is prefixed with "WHERE" if not already
        $condition = trim($condition);
        if (stripos($condition, 'WHERE') !== 0) {
            $condition = "WHERE " . $condition;
        }

        $query = "SELECT * FROM $table $condition";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function sendEmail($senderEmail, $senderName, $receiverEmail, $receiverName, $message, $subject) {

    $site_setting = $this->read("settings", "WHERE id=1");

    // Include PHPMailer library
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require 'PHPMailer/Exception.php';


    require 'PHPMailer/autoload.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Server settings
        $mail->isSMTP();
        $mail->Host = $site_setting['smtp_host'];  // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = $site_setting['smtp_user'];  // Replace with your SMTP username
        $mail->Password = $site_setting['smtp_password']; // Replace with your SMTP password
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 465;

        // Sender and recipient settings
        $mail->setFrom($senderEmail, $senderName);
        $mail->addAddress($receiverEmail, $receiverName);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return "Email has been sent successfully.";
    } catch (Exception $e) {
        return "Failed to send email. Error: " . $mail->ErrorInfo;
    }
}

}
