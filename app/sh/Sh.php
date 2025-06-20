<?php 

namespace App\Sh;

defined('CPATH') or exit('No direct script access allowed');

require_once __DIR__ . "/../core/config.php";
use PDO;
use PDOException;

class Sh
{

    private $version = '1.0.0';


    private function singularize($word)
    {
        $irregular = [
            'people' => 'person',
            'men' => 'man',
            'women' => 'woman',
            'children' => 'child',
            'teeth' => 'tooth',
            'feet' => 'foot',
            'mice' => 'mouse',
            'geese' => 'goose',
            'databases' => 'database'
        ];

        // Check for irregular words
        if (isset($irregular[strtolower($word)])) {
            return ucfirst($irregular[strtolower($word)]);
        }

        // Common plural rules
        if (preg_match('/(oes|ses|xes|ches|shes|zes)$/i', $word)) {
            return substr($word, 0, -2);
        }
        if (preg_match('/(ies)$/i', $word)) {
            return substr($word, 0, -3) . 'y';
        }
        if (preg_match('/(s)$/i', $word) && !preg_match('/(ss)$/i', $word)) {
            return substr($word, 0, -1);
        }

        return ucfirst($word);
    }

    private function pluralize($word)
    {
        $irregular = [
            'person' => 'people',
            'man' => 'men',
            'woman' => 'women',
            'child' => 'children',
            'tooth' => 'teeth',
            'foot' => 'feet',
            'mouse' => 'mice',
            'goose' => 'geese',
            'database' => 'databases'
        ];

        if (isset($irregular[strtolower($word)])) {
            return $irregular[strtolower($word)];
        }

        // Common plural rules
        if (preg_match('/(ch|sh|x|s|z)$/i', $word)) {
            return $word . 'es';
        }
        if (preg_match('/(y)$/i', $word) && !preg_match('/(ay|ey|iy|oy|uy)$/i', $word)) {
            return substr($word, 0, -1) . 'ies';
        }

        return $word . 's';
    }


    public function colorText($text, $colorCode)
    {
        return "\033[" . $colorCode . "m" . $text . "\033[0m";

        /** USAGE:
         * echo colorText("Success! Controller created.", "32") . "\n";
        *  echo colorText("Error! Something went wrong.", "31") . "\n";
        *  echo colorText("Warning! Check your input.", "33") . "\n";
         */
    }


    private function controller($name = null)
    {
        if(!$name) {
            echo $this->colorText("\nWarning: Please provide a Controller name", "33") . "\n";
            die();
        }

        $className = ucfirst($name);

        $controllerPath = CPATH . "app" . DS . "controllers" . DS . "{$className}.php";

        if (file_exists($controllerPath)) {
            echo $this->colorText("\nWarning: Controller '{$className}.php' already exists!", "33") . "\n";
            die();
        }


        $controllerTemplate = <<<PHP
        <?php 
        
        namespace Controller;
        
        defined('ROOTPATH') OR exit('Access Denied!');
        
        /**
         * {$className} class
         */
        class {$className} extends Controller
        {
        
            public function index()
            {
                \$this->view('{$name}');
            }
        
        }
        PHP;

        // Attempt to create the file
        if (file_put_contents($controllerPath, $controllerTemplate) !== false) {
            echo $this->colorText("\nSuccess: Controller '{$className}.php' has been created successfully!", "32") . "\n";
        } else {
            echo $this->colorText("\nError: Failed to create controller file!", "31") . "\n";
            die();
        }


    }

    private function model($name = null)
    {
        
        if(!$name) {
            echo $this->colorText("\nWarning: Please provide a Model name", "33") . "\n";
            die();
        }

        // Ensure class name starts with a letter
        if (!ctype_alpha($name[0])) {
            echo $this->colorText("\nWarning: Model name must start with a letter.", "31") . "\n";
            die();
        }

        // Convert name to singular PascalCase
        $className = ucfirst(rtrim($name, 's')); // Removes trailing 's' if present

        // Define the file path
        $modelPath = CPATH . "app" . DS . "models" . DS . "{$className}.php";

        // Check if the file already exists
        if (file_exists($modelPath)) {
            echo $this->colorText("\nWarning: Model '{$className}' already exists!", "33") . "\n";
            die();
        }

        $tableName = strtolower($className) . 's';

        $modelTemplate = <<<PHP
        <?php
        
        namespace App\Models;
        
        defined('ROOTPATH') OR exit('Access Denied!');
        
        /**
         * {$className} Model
         */
        class {$className}
        {
            use Model;
            use Database;
        
            protected \$table = '{$tableName}';
            protected \$allowedColumns = [];
        
            /**
             * Find a record by ID
             */
            public function findById(\$id)
            {
                \$sql = "SELECT * FROM \$this->table WHERE id = :id LIMIT 1";
                \$result = \$this->read(\$sql, ['id' => \$id]);
                return \$result ? \$result[0] : false;
            }
        
            /**
             * Find records by a condition
             */
            public function findWhere(\$column, \$value)
            {
                \$sql = "SELECT * FROM \$this->table WHERE \$column = :value";
                return \$this->read(\$sql, ['value' => \$value]);
            }
        
            /**
             * Insert a new record
             */
            public function insert(\$data)
            {
                \$keys = array_keys(\$data);
                \$columns = implode(", ", \$keys);
                \$placeholders = ":" . implode(", :", \$keys);
        
                \$sql = "INSERT INTO \$this->table (\$columns) VALUES (\$placeholders)";
                return \$this->write(\$sql, \$data);
            }
        
            /**
             * Update a record by ID
             */
            public function update(\$id, \$data)
            {
                \$setPart = "";
                foreach (\$data as \$key => \$value) {
                    \$setPart .= "\$key = :\$key, ";
                }
                \$setPart = rtrim(\$setPart, ", ");
                
                \$sql = "UPDATE \$this->table SET \$setPart WHERE id = :id";
                \$data['id'] = \$id;
        
                return \$this->write(\$sql, \$data);
            }
        
            /**
             * Delete a record by ID
             */
            public function deleteOne(\$id)
            {
                \$sql = "DELETE FROM \$this->table WHERE id = :id";
                return \$this->write(\$sql, ['id' => \$id]);
            }
        
            /**
             * Delete all records
             */
            public function deleteAll()
            {
                \$sql = "DELETE FROM \$this->table";
                return \$this->write(\$sql);
            }
        
            /**
             * Count total records
             */
            public function count()
            {
                \$sql = "SELECT COUNT(*) AS total FROM \$this->table";
                \$result = \$this->read(\$sql);
                return \$result ? \$result[0]->total : 0;
            }
        
            /**
             * Get the first record
             */
            public function first()
            {
                \$sql = "SELECT * FROM \$this->table ORDER BY id ASC LIMIT 1";
                \$result = \$this->read(\$sql);
                return \$result ? \$result[0] : false;
            }
        
            /**
             * Get the last record
             */
            public function last()
            {
                \$sql = "SELECT * FROM \$this->table ORDER BY id DESC LIMIT 1";
                \$result = \$this->read(\$sql);
                return \$result ? \$result[0] : false;
            }
        
            /**
             * Check if a record exists
             */
            public function exists(\$column, \$value)
            {
                \$sql = "SELECT COUNT(*) AS count FROM \$this->table WHERE \$column = :value";
                \$result = \$this->read(\$sql, ['value' => \$value]);
                
                return \$result && \$result[0]->count > 0;
            }
        }
        PHP;

        // Attempt to create the file
        if (file_put_contents($modelPath, $modelTemplate) !== false) {
            echo $this->colorText("\nSuccess: Model '{$className}' has been created successfully!", "32") . "\n";
        } else {
            echo $this->colorText("\nError: Failed to create Model!", "31") . "\n";
            die();
        }


    }

    private function migration($args = [])
    {
        // Check if at least the table name is provided.
        if (!isset($args[2])) {
            echo $this->colorText("\nWarning: Please provide a table name", "33") . "\n";
            die();
        }

          // Ensure database exists before proceeding
        if (!$this->databaseExists(DBNAME)) {
            echo $this->colorText("\nWarning: Database '" . DBNAME . "' does not exist!", "33") . "\n";
            echo "Would you like to create it now? (yes/no): ";

            $handle = fopen("php://stdin", "r");
            $response = trim(fgets($handle));

            if (strtolower($response) === 'yes') {
                $this->createDatabase();
            } else {
                echo $this->colorText("\nError: Migration aborted. Database must be created first!", "31") . "\n";
                die();
            }
        }


        // Determine the operation (create or alter) and get the actual table name.
        $operation = "create"; // default is create
        $tableArg = $args[2];
        if (stripos($tableArg, "alter:") === 0) {
            $operation = "alter";
            // Remove "alter:" prefix to get the table name.
            $tableArg = substr($tableArg, strlen("alter:"));
        }
        $tableName = strtolower($tableArg);

        $className = "Create".$this->singularize($tableArg)."Table";

        $operation === "alter" ? $className = "Alter".$this->singularize($tableArg)."Table" : $className;

        // Set the migrations folder path.
        $migrationPath = CPATH . "app" . DS . "migrations";

        // If operation is "create", check for duplicate creation migrations.
        if ($operation === "create") {
            $existing = glob($migrationPath . DS . "*_create_{$tableName}_table.php");
            if (count($existing) > 0) {
                echo $this->colorText("\nError: Migration for table '{$tableName}' already exists.", "31") . "\n";
                echo "'make:migration alter:{$tableName} ...' to modify the table.\n";
                die();
            }
        }

        // Generate filename based on operation.
        if ($operation === "create") {
            $filename = date('Ymd_His') . "_create_{$tableName}_table.php";
        } else {
            $filename = date('Ymd_His') . "_alter_{$tableName}_table.php";
        }
        $filepath = $migrationPath . DS . $filename;

        // Default columns for creation migration.
        $defaultColumns = [
            "id INT AUTO_INCREMENT PRIMARY KEY",
            "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
            "updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
            "deleted_at TIMESTAMP NULL DEFAULT NULL"
        ];

        // Initialize an array to hold column definitions.
        $columns = [];

        // Parse additional columns if provided (starting from index 3).
        if (count($args) > 3) {
            for ($i = 3; $i < count($args); $i++) {
                $columnParts = explode(":", $args[$i]);
                if (count($columnParts) >= 2) {
                    [$columnName, $columnType] = $columnParts;
                    $foreignTable = $columnParts[2] ?? null;

                    // Prevent self-referencing foreign keys.
                    if ($foreignTable && $foreignTable === $tableName) {
                        echo $this->colorText("\nError: '$columnName' cannot reference the same table '$tableName'!", "31") . "\n";
                        die();
                    }

                    switch (strtolower($columnType)) {
                        case "string":
                            $columns[] = "$columnName VARCHAR(255) NOT NULL";
                            break;
                        case "text":
                            $columns[] = "$columnName TEXT NOT NULL";
                            break;
                        case "integer":
                            $columns[] = "$columnName INT NOT NULL";
                            if ($foreignTable) {
                                $columns[] = "FOREIGN KEY ($columnName) REFERENCES $foreignTable(id) ON DELETE CASCADE";
                            }
                            break;
                        case "boolean":
                            $columns[] = "$columnName TINYINT(1) NOT NULL DEFAULT 0";
                            break;
                        case "datetime":
                            $columns[] = "$columnName DATETIME NOT NULL";
                            break;
                        case "float":
                            $columns[] = "$columnName FLOAT NOT NULL";
                            break;
                        case "double":
                            $columns[] = "$columnName DOUBLE NOT NULL";
                            break;
                        case "enum":
                            // If a foreign table is given here, ignore it for enums.
                            $enumSeparator = ",";
                            
                            // Ensure each enum value is wrapped in single quotes
                            $enumValuesArray = explode($enumSeparator, $columnParts[2]);
                            $enumValues = "'" . implode("', '", $enumValuesArray) . "'";

                            $columns[] = "$columnName ENUM($enumValues) NOT NULL";
                            break;
                        default:
                            echo $this->colorText("\nWarning: Unknown column type '{$columnType}'", "33") . "\n";
                            die();
                    }

                    // Check for unique or index constraints.
                    if (in_array("unique", $columnParts)) {
                        $columns[] = "UNIQUE ($columnName)";
                    }
                    if (in_array("index", $columnParts)) {
                        $columns[] = "INDEX ($columnName)";
                    }
                } else {
                    echo $this->colorText("\nWarning: Invalid column format for '{$args[$i]}'", "33") . "\n";
                    die();
                }
            }
        }

        // For creation migrations, add default columns.
        if ($operation === "create") {
            $columns = array_merge($columns, $defaultColumns);
            $sql = "CREATE TABLE {$tableName} (\n    " . implode(",\n    ", $columns) . "\n);";
        } else {
            $alterQueries = [];
            foreach ($columns as $column) {
                $alterQueries[] = "ADD " . $column;
            }
            $sql = "ALTER TABLE {$tableName} \n    " . implode(",\n    ", array_merge($alterQueries, $foreignKeys)) . ";";
        }


        // Create migration file content.
        $migrationTemplate = <<<PHP
        <?php

        namespace App\Migrations;

        defined('ROOTPATH') OR exit('Access Denied!');

        class {$className}
        {
            public function up()
            {
                return "{$sql}";
            }

            public function down()
            {
                return "DROP TABLE IF EXISTS {$tableName};";
            }
        }
        PHP;


        try {
            $pdo = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Check if migration already exists in the database
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
            $stmt->execute([$filename]);
            $exists = $stmt->fetchColumn();
    
            if (!$exists) {
                // Insert the migration into the migrations table
                $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
                $stmt->execute([$filename]);
                echo $this->colorText("\nSuccess: Migration '{$filename}' recorded in database!", "32") . "\n";
            }
    
    
        } catch (PDOException $e) {
            echo $this->colorText("\nError: " . $e->getMessage(), "31") . "\n";
            die();
        }


        // Create the migration file.
        if (file_put_contents($filepath, $migrationTemplate) !== false) {
            echo $this->colorText("\nSuccess: Migration '{$filename}' has been created successfully!", "32") . "\n";
        } else {
            echo $this->colorText("\nError: Failed to create migration file!", "31") . "\n";
            die();
        }
    }

    public function createDatabase(){

        $configFile = CPATH. "app" . DS . "core" . DS . "config.php";
        $currentDbName = DBNAME;
        echo $this->colorText("\nCurrent database name: '$currentDbName'", "33") . "\n";
        echo "Do you want to use this database? (yes/no): ";
        
        $handle = fopen("php://stdin", "r");
        $response = trim(fgets($handle));
    
        if (strtolower($response) === 'no') {
            echo "Enter new database name: ";
            $newDbName = trim(fgets($handle));
    
            if (!$newDbName) {
                echo $this->colorText("\nError: Database name cannot be empty!", "31") . "\n";
                die();
            }
    
            // Update DBNAME in the config file
            $configContents = file_get_contents($configFile);
            $configContents = preg_replace(
                "/define\('DBNAME', '.*?'\);/",
                "define('DBNAME', '$newDbName');",
                $configContents
            );
    
            file_put_contents($configFile, $configContents);
            echo $this->colorText("\nSuccess: Database name updated in config file!", "32") . "\n";
    
            $currentDbName = $newDbName;

            try {
                $pdo = new PDO("mysql:host=" . DBHOST, DBUSER, DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "CREATE DATABASE IF NOT EXISTS `$currentDbName`";
                $pdo->exec($sql);
    
                $pdo = new PDO("mysql:host=" . DBHOST . ";dbname=" . $currentDbName, DBUSER, DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                // Ensure the migrations table exists
                $sql = "CREATE TABLE IF NOT EXISTS migrations (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    migration VARCHAR(255) NOT NULL,
                    executed BOOLEAN NOT NULL DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                $pdo->exec($sql);

                $migrationPath = CPATH . "app" . DS . "migrations" . DS;
                $files = array_diff(scandir($migrationPath), ['.', '..']);
                if(is_dir($migrationPath) && !empty($files)){
                    natsort($files);
                    foreach ($files as $file) {
                        $sql = "INSERT INTO migrations (migration) VALUES ('$file')";
                        $pdo->exec($sql);
                    }
                }
                
                echo $this->colorText("\nSuccess: Database '$currentDbName' created successfully!", "32") . "\n";
                return;
            } catch (PDOException $e) {
                echo $this->colorText("\nError: " . $e->getMessage(), "31") . "\n";
                die();
            }

        }elseif (strtolower($response) === 'yes'){

            try {
                $pdo = new PDO("mysql:host=" . DBHOST, DBUSER, DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "CREATE DATABASE IF NOT EXISTS `$currentDbName`";
                $pdo->exec($sql);
    
                $pdo = new PDO("mysql:host=" . DBHOST . ";dbname=" . $currentDbName, DBUSER, DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                // Ensure the migrations table exists
                $sql = "CREATE TABLE IF NOT EXISTS migrations (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    migration VARCHAR(255) NOT NULL,
                    executed BOOLEAN NOT NULL DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                $pdo->exec($sql);

                $migrationPath = CPATH . "app" . DS . "migrations" . DS;
                $files = array_diff(scandir($migrationPath), ['.', '..']);
                if(is_dir($migrationPath) && !empty($files)){
                    natsort($files);
                    foreach ($files as $file) {
                        $sql = "INSERT INTO migrations (migration) VALUES ('$file')";
                        $pdo->exec($sql);
                    }
                }
                
                echo $this->colorText("\nSuccess: Database '$currentDbName' created successfully!", "32") . "\n";
                return;
            } catch (PDOException $e) {
                echo $this->colorText("\nError: " . $e->getMessage(), "31") . "\n";
                die();
            }
        }else {
            echo $this->colorText("\nError: Invalid response. Aborting...", "31") . "\n";
            die();
        }
        


    }

    public function make($command)
    {
        if (!isset($command[2])) {
            echo $this->colorText("\nError: Missing argument. Usage: make:tool {name}", "31") . "\n";
            die();
        }

        // Ensure the first character is a valid letter
        if (!ctype_alpha($command[2][0])) {
            echo $this->colorText("\nWarning: Tool name must start with a letter.", "33") . "\n";
            return;
        }

        switch ($command[1]) {
            case 'make:migration':
                $this->migration($command);
                break;
            case 'make:model':
                $this->model($command[2]);
                break;
            case 'make:controller':
                $this->controller($command[2]);
                break;
            default:
                die("Unknown command: $command[1]");
                break;
        }
    }

    public function db($command){

        switch ($command[1]) {
            case 'db:create':
                $this->createDatabase();
                break;
            case 'db:drop':
                $this->dbDrop();
                break;
            case 'db:migrate':
                $this->dbMigrate();
                break;
            case 'db:seed':
                $this->dbSeed();
                break;
            default:
                die("Unknown command: $command[1]");
                break;
        }
    }

    public function help() {

echo "
Sh v$this->version Command Line Interface (CLI) Php MVC Tool

Database:
    db:create               Creates a new database          =>   db:create
    db:drop                 Drops a database                =>   db:drop
    db:migrate              Run all pending migrations      =>   db:migrate
    db:seed                 Seed the database with records


Make:
    make:migration             Create a new migration file   =>   make:migration fileName
    make:model                 Create a new model file       =>   make:model modelName
    make:controller            Create a new controller file  =>   make:controller controllerName

Migration:
    migrate:status              Show the status of each migration
    migrate:refresh             Reset and re-run all migrations
    migrate:rollback            Rollback the last database migration
    migrate:reset               Rollback all database migrations
";
    }


    private function dbSeed(){
        $migrationPath = CPATH . "app" . DS . "migrations" . DS;
        $files = scandir($migrationPath);

        // Filter only .php files and ignore "." and ".."
        $migrationFiles = array_filter($files, function ($file) {
            return $file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });

        // Sort files in ascending order (oldest migrations first)
        natsort($migrationFiles);

        foreach ($migrationFiles as $file) {
            echo "Migration File: " . $file . "\n";
        }

    }





    public function dbMigrate()
    {
        $pdo = $this->connectDatabase();

        // Get all pending migrations
        $pendingMigrations = $this->getPendingMigrations($pdo);

        if (empty($pendingMigrations)) {
            echo $this->colorText("\nAll migrations are up to date!", "32") . "\n";
            return;
        }

        foreach ($pendingMigrations as $migration) {
            $migrationFile = $migration['migration'];
            $migrationPath = CPATH . "app" . DS . "migrations" . DS . $migrationFile;

            if (!file_exists($migrationPath)) {
                echo $this->colorText("\nError: Migration file not found: $migrationFile", "31") . "\n";
                continue;
            }

            require_once $migrationPath;

            // Extract class name from file
            $className = $this->getClassNameFromFile($migrationPath);

            if (!$className) {
                echo $this->colorText("\nError: Could not determine class name in $migrationFile", "31") . "\n";
                continue;
            }

            echo $this->colorText("\nMigrating: $migrationFile...", "34");

            $migrationClass = new $className();
            $sql = $migrationClass->up();

            $pdo = $this->connectDatabase();
            if($pdo->query($sql)){

                $this->markMigrationAsExecuted($pdo, $migrationFile);
                echo $this->colorText(" ✓ Done", "32") . "\n";
            }else {
                echo $this->colorText(" ✗ Failed", "31") . "\n";
                die;
            }
        }
        
        echo $this->colorText("\nMigration completed successfully!", "32") . "\n";
        die();
    }


    
    private function getPendingMigrations($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM migrations WHERE executed = 0 ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function markMigrationAsExecuted($pdo, $migrationName)
    {
        $stmt = $pdo->prepare("UPDATE migrations SET executed = 1 WHERE migration = :migration");
        $stmt->execute(['migration' => $migrationName]);
    }
    



    private function connectDatabase()
    {
        try {
            return new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die($this->colorText("\nDatabase Connection Error: " . $e->getMessage(), "31"));
        }
    }


    private function databaseExists($dbname)
    {
        try {
            $pdo = new PDO("mysql:host=" . DBHOST, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo $this->colorText("\nError: " . $e->getMessage(), "31") . "\n";
            die();
        }
    }
    
    private function dbDrop()
    {
        $dbName = DBNAME;

        echo $this->colorText("\nWarning: You are about to drop the database '$dbName'.", "33") . "\n";
        echo "Are you sure? This action is irreversible! (yes/no): ";

        $handle = fopen("php://stdin", "r");
        $response = trim(fgets($handle));

        if (strtolower($response) === 'no') {
            echo $this->colorText("\nOperation canceled. Database '$dbName' was not dropped.", "32") . "\n";
            return;
        }elseif (strtolower($response) === 'yes'){

            try {
                $pdo = new PDO("mysql:host=" . DBHOST, DBUSER, DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                // Check if the database exists
                $stmt = $pdo->query("SHOW DATABASES LIKE '$dbName'");
                $dbExists = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if (!$dbExists) {
                    echo $this->colorText("\nError: Database '$dbName' does not exist!", "31") . "\n";
                    return;
                }
    
                // Drop the database
                $pdo->exec("DROP DATABASE `$dbName`");
    
                echo $this->colorText("\nSuccess: Database '$dbName' has been dropped!", "32") . "\n";
            } catch (PDOException $e) {
                echo $this->colorText("\nError: " . $e->getMessage(), "31") . "\n";
            }

        }else {
            echo $this->colorText("\nError: Invalid response. Aborting...", "31") . "\n";
            die();
        }
    }


    private function getClassNameFromFile($filePath)
    {
        $contents = file_get_contents($filePath);
        
        // Match namespace
        $namespace = null;
        if (preg_match('/namespace\s+([^;]+);/', $contents, $matches)) {
            $namespace = trim($matches[1]);
        }

        // Match class name
        if (preg_match('/class\s+([a-zA-Z0-9_]+)/', $contents, $matches)) {
            $className = trim($matches[1]);

            // If there's a namespace, append it to the class name
            return $namespace ? $namespace . "\\" . $className : $className;
        }

        return null;
    }



}