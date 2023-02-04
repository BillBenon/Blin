<?php
    require_once "create_file.php";

   if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $status = $_POST['status'];
        $file = fopen("status.txt", "w");
        fwrite($file, $status);
        fclose($file);
   }
   // get current status
    $file = fopen("status.txt", "r");
    $status = fread($file, filesize("status.txt"));
    fclose($file);
    echo $status;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-lights</title>
    <style type="text/css">
        * {
            box-sizing: border-box;
            padding: 0em;
            margin: 0;
        }
        :root {
            --dark-background: #121a35;
            --secondary-bg: #030814;
            --orange: orange;
        }
        body {
            background-color: var(--dark-background);
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: "montserrat", sans-serif;
        }
        h4 {
            color: white;
            text-transform: uppercase;
        }

        h4 > span {
            color: dodgerblue;
            font-size: 1.5em;
        }

        p {
            color: rgba(255, 255, 255, 0.726);
            font-size: 0.9em;
            margin-top: 50px;
        }

        input {
            color: white;
            text-transform: uppercase;
            font-size: 1em;
            padding: 30px 50px;
            font-weight: 600;
            font-size:10px;
            display: inline-block;
            background-color: var(--secondary-bg);
            margin: 10px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.192);
            transition: all .2s;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.1);
        }

        input:hover {
            transform: scale(1.02);
        }

        div {
            margin: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 380px;
            width: 70%;
            text-align: center;
            margin: 20px auto;
        }

        div:first-of-type input {
            background-color: green;
            border: 1px solid rgba(255, 255, 255, 0.37);
            color: rgba(255, 255, 255, 0.);
            font-weight: 700;
        }

        .active {
            border: 2px solid dodgerblue;
        }

        div:first-of-type input:last-of-type {
            background-color: rgb(168, 0, 0);
        }
        @media screen and (max-width: 500px) {
            body {
                height: auto;
                padding: 20px 10px;
                margin-top:20px;
                display: block;
            }
            div {
                width: 100%;
            }
            a {
                width: 44%;
            }
            h4 {
                text-align: left;
                font-size: 1.2em;
                margin-left: 20px;
            }

            p {
                margin-top:10px;
                margin-left: 20px;
                font-weight: 500;
            }
        }  
    </style>
</head>
<body>
    <h4>Welcome at <span>xLights</span></h4>
    <p>Play around with these buttons😁</p>
    <div>
        <form action="index.php" method="POST">
            <input type="submit" value="ON" name="status" id="1" class="<?= $status=="ON"?"active":"" ?>">
            <input type="submit" value="OFF" name="status" id="0" class="<?= $status=="OFF"?"active":"" ?>">
        </form>          
    </div>
</body>
</html>