<?php

    if (!empty($_REQUEST["username"]) && !empty($_REQUEST["content"])) {
        $username = $_REQUEST["username"];
        $content = $_REQUEST["content"];

        if (file_exists("./username/{$username}.txt")) {
            $username = file_get_contents("./username/{$username}.txt");
        } else {
            exit("Aucun utilisateur trouvé.<br>Revenez à la page précédente.");
        }

        $dataUrl = './data.json';
        $dataContent = file_get_contents($dataUrl);
        $data = json_decode($dataContent, true);

        date_default_timezone_set('Europe/Paris');

        $data[] = ['username' => $username, 'content' => $content, 'time' => date("H:i d.m.Y")];
        $dataEncoded = json_encode($data);
        file_put_contents($dataUrl, $dataEncoded);

        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";

        $url .= $_SERVER['HTTP_HOST'];
        $url .= $_SERVER['REQUEST_URI'];
        $url = strtok($url, '?');

        function redirect($url, $statusCode = 303) {
            header('Location: ' . $url, true, $statusCode);
            die();
        }
        Redirect($url);
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
    <meta http-equiv="Expires" content="0" />
    <!-- meta -->
    <link rel="apple-touch-icon" sizes="180x180" href="./identity/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./identity/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./identity/favicon-16x16.png">
    <link rel="manifest" href="./identity/site.webmanifest">
    <!-- endsection meta -->
    <title>Messenger</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body{
            margin: 0; padding: 0;
            padding: 10px;
            background-color: rgb(100, 100, 255);
        }
        input{
            margin-right: 7px;
            padding: 10px;
            padding-bottom: 12px;
            border: 1px solid blueviolet;
            border-radius: 4px;
            transition: all .3s;
        }
        input:focus{
            box-shadow: 0 0 0 3px rgb(190, 103, 255);
        }
        form{
            position: fixed;
            bottom: 0; left: 0;
            width: calc(100% - 250px);
            height: 65.6px;
            padding: 10px;
        }
        #username{
            width: 150px;
        }
        #content{
            width: calc(100% - 168px);
        }
        #submit{
            cursor: pointer;
            color: white;
            background-color: blueviolet;
            display: none;
        }
        .msg-box{
            position: fixed;
            top: 0; left: 0;
            width: calc(100% - 250px);
            height: calc(100% - 65.6px);
            margin: 0; padding: 0;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column-reverse;
            overflow-y: auto;
        }
        .msg-item{
            position: relative;
            width: 100%;
            max-whidth: 100%;
            height: max-content;
            padding: 10px;
            background-color: #f5f5f5;
        }
        .msg-item>.username{
            margin-bottom: 5px;
            font-weight: 600;
            font-family: 'SF Pro Display SemiBold', sans-serif;
        }
        .msg-item>.username>img{
            pointer-events: none;
            height: 17.5px;
            margin: 0; padding: 0;
            transform: translateY(2.25px);
        }
        .msg-item>.username>span{
            font-weight: 400;
            font-size: 13px;
            color: gray;
            font-family: 'SF Pro Display Regular', sans-serif;
        }
        .msg-item>.content{
            word-wrap: break-word;
        }
    </style>
</head>
<body>

    <div class="ui-controller">
        <div class="msg-box box"></div>
        <form class="box" action="./index.php">
            <input type="text" name="username" id="username" placeholder="Votre pseudo">
            <input type="text" name="content" id="content" placeholder="Votre message">
            <input id="submit" type="submit" value="Envoyer">
        </form>
        <div class="member-box box">
            <p class="title">MEMBRES — 7</p>
            <p class="item">Clem</p>
            <p class="item">Conekt</p>
            <p class="item">Eloan</p>
            <p class="item">DaveToMax</p>
            <p class="item">Tom_W</p>
            <p class="item">TV63</p>
            </div>
        </div>
    </div>

    <script src="./script.js"></script>
</body>
</html>