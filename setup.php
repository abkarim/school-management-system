<?php
if (isset($_POST["submit"])) {
    /**
     * Update data
     */
    function update(string $constant, string $value, string $data): string {
        $appendValue = "define('$constant', '$value')";
        /**
         * Regex to search for a constant name
         * search for define('SOME_NAME', 'SOME VALUE');
         */
        return preg_replace("/define\((\s+)?\'$constant\'(\s+)?,(\s+)?\'(?'target'.+)?\'(\s+)?\)/", $appendValue, $data);
    }

    $data = [
        'DATABASE_HOSTNAME' => isset($_POST['hostname']) ? $_POST['hostname'] : exit,
        'DATABASE_NAME'     => isset($_POST['name']) ? $_POST['name'] : exit,
        'DATABASE_USERNAME' => isset($_POST['username']) ? $_POST['username'] : exit,
        'DATABASE_PASSWORD' => isset($_POST['password']) ? $_POST['password'] : exit,
        'TABLE_PREFIX'      => isset($_POST['table_prefix']) ? $_POST['table_prefix'] : '',
    ];

    define('INSTALLING_DATA', $data);

    /**
     * Update data in config.php
     */
    $fileData = file_get_contents(__DIR__ . '/config.php');

    foreach ($data as $key => $val) {
        $fileData = update($key, $val, $fileData);
    }

    if (!file_put_contents(__DIR__ . '/config.php', $fileData)) {
        echo "Something went wrong please try again later";
    } else {
        /**
         * Don't stop script if user abort
         */
        ignore_user_abort(true);

        /**
         * Create database table
         */
        require_once __DIR__ . '/install.php';

        /**
         ** Table creation done
         * Set installed = true in config.php
         */
        $fileData = update('APP_INSTALLED', 1, $fileData);
        /**
         * Add client ip
         */
        $fileData = update('APP_INSTALLER_IP', $_SERVER['REMOTE_ADDR'], $fileData);
        file_put_contents(__DIR__ . '/config.php', $fileData);

        echo "installing done. Please reload page";
        exit;
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;600&family=Poppins:wght@200;300;600;700&display=swap"
        rel="stylesheet">
    <title>Setup</title>
    <style>
        html,
        body {
            height: 100%;
            background-color: rgb(249 250 251 / 1);
        }

        * {
            box-sizing: border-box;
            font-family: 'Alexandria', sans-serif;
            margin:0;
            padding:0;
        }

        main {
            height:100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            font-family: 'Poppins', sans-serif;
        }

        p {
            margin-bottom: 1rem;
        }

        label {
            font-size: 1.2rem;
            color: rgb(36, 36, 36);
        }

        input {
            padding: 0.3rem;
            width: 100%;
            background-color: rgb(241 245 249 / 1);
            border: 1px solid rgb(51, 50, 50);
            border-radius: 0.125rem;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        form  {
            flex-grow: 1;
            padding: 1rem;
            max-width: 40rem;
            border-radius: 0.125rem;
            background-color: white;
            --shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            --shadow-colored: 0 25px 50px -12px var(--shadow-color);
            box-shadow: var(--ring-offset-shadow, 0 0 #0000), var(--ring-shadow, 0 0 #0000), var(--shadow);
        }

        button {
            display: inline-block;
            width: 100%;
            padding: 0.3rem;
            color: white;
            background-color: rgb(13 148 136 / 1);
            border: none;
            cursor: pointer;
            border-radius: 0.125rem;
            font-size: 1.1rem;
            margin-top: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        button:hover {
            background-color: rgb(14, 131, 121);
        }
    </style>
</head>

<body>
    <main>
        <form method="POST">
        <h1>Configure database info</h1>
        <p>First create a database if not exists already</p>

        <label>Database name</label>
        <input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" required>

        <label>Database hostname</label>
        <input type="text" name="hostname" value="<?php echo isset($_POST['hostname']) ? $_POST['hostname'] : '' ?>" required>

        <label>Database username</label>
        <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" required>

        <label>Database password</label>
        <input type="text" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>" required>

        <label>Database table prefix (optional)</label>
        <input type="text" name="table_prefix" value="<?php echo isset($_POST['table_prefix']) ? $_POST['table_prefix'] : '' ?>" >

        <button type="submit" name="submit">Install</button>
    </form >
    </main>

</body>

</html>
