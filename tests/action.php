<!doctype html>

<html lang="en-us">

    <head>
        <meta charset="utf-8"/>
        <title>Test</title>
    </head>

    <body>
        <h1>Testing</h1>

        <?php
        /*echo "Hi " . htmlspecialchars($_POST['name']) . ". You are " . (int)$_POST['age'] . " years old.";*/

        $servername = "localhost";
        $username = "codyjkin_codyjk";
        $password = "y55pWWH\$C@1&";
        $dbname = "codyjkin_testing";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // sql to create table
            $sql = "CREATE TABLE MyGuests (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                firstname VARCHAR(30) NOT NULL,
                lastname VARCHAR(30) NOT NULL,
                email VARCHAR(50),
                reg_date TIMESTAMP
                )";

            // use exec() because no results are returned
            $conn->exec($sql);
            echo "Table MyGuests created successfully";
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
        ?>

    </body>
</html>
