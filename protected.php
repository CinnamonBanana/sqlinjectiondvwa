<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form method="GET">
    USER ID <input name="user_id" type="text" required><br>
    <input name="Login" type="submit" value="Войти">
    </form>
    
    <?php
    function dbcon()
    {
        try {
            $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=lab2;";
            $pdo = new PDO($dsn, 'postgres', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            return $pdo;
        } catch (PDOException $e) {
            die($e->getMessage());
        } 
    }

    $pattern='/^[A-Za-z0-9@.]+$/';
    if(isset($_GET['Login']) && preg_match($pattern, $_GET[ 'user_id' ]))
    {
        $pdo = dbcon();
        $userid = stripslashes($_GET[ 'user_id' ]);
        $sql = "SELECT first_name, last_name FROM public.users WHERE user_id = :userid";
        echo "<p>".$userid."</p>";
        $sth = $pdo->prepare($sql);
        $sth->bindParam(':userid', $userid, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetchAll();
        
        if (count($result) == 1)
        {
            echo '<pre>User ID exists in the database.</pre>';
        }
        else
        {
            echo '<pre>User ID is MISSING from the database.</pre>';
        }
    }
    else
    {
        echo "<p>INVALID INPUT!</p>";
    }
    ?>
</body>
</html>
