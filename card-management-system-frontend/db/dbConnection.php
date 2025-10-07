<?php
class DatabaseConnection {
    private static $host = "localhost";
    private static $port = "5432";
    private static $dbname = "cms_db";
    private static $user = "postgres";
    private static $password = "password";
    private static $connection = null;

    // Function to get connection
    public static function getConnection() {
        if (self::$connection === null) {
            try {
                // Create the PDO connection
                $dsn = "pgsql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbname;
                self::$connection = new PDO($dsn, self::$user, self::$password);
                
                // Set PDO error mode to exception
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // ✅ Success message
                echo "✅ Database connection successful!";
            } catch (PDOException $e) {
                // ❌ Error message
                echo "❌ Failed to connect to DB: " . $e->getMessage();
                self::$connection = null;
            }
        }
        return self::$connection;
    }
}
?>

