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
    <title>Messenger</title>
    <style>
        *{
            font-size: 15px;
            margin: 0; padding: 0;
            scroll-behavior: smooth;
            outline: none !important;
            box-sizing: border-box;
        }
        body{
            margin: 0; padding: 0;
            padding: 10px;
            background-color: #f5f5f5;
        }
        input{
            margin-right: 7px;
            padding: 10px;
            border: 1px solid blueviolet;
            border-radius: 4px;
            transition: all .3s;
        }
        input:focus{
            box-shadow: 0 0 0 3px rgb(190, 103, 255);
        }
        form{
            position: relative;
            width: 100%;
            height: 65,6px;
            padding: 10px;
            border: 3px solid black;
            border-radius: 4px;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, .15);
        }
        #submit{
            cursor: pointer;
            color: white;
            background-color: blueviolet;
        }
        .msg-box{
            position: relative;
            width: 100%;
            height: calc(100vh - 95.6px);
            margin: 0; padding: 0;
            margin-bottom: 10px;
            border: 3px solid black;
            border-radius: 4px;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, .15);
            display: flex;
            flex-direction: column-reverse;
            overflow-y: auto;
        }
        .msg-item{
            position: relative;
            width: 100%;
            height: max-content;
            padding: 10px;
        }
        .msg-item>.username{
            margin-bottom: 5px;
            font-weight: 600;
        }
        .msg-item>.username>span{
            font-weight: 400;
            font-size: 13px;
            color: gray;
        }
    </style>
</head>
<body>

    <div class="ui-controller">
        <div class="msg-box">
            <!-- <div class="msg-item">
                <p class="username">Tom_W</p>
                <p class="content">Hey! What's the name of youre cat?</p>
            </div> -->
        </div>
        <form action="./index.php">
            <input type="text" name="username" id="username" placeholder="Votre pseudo">
            <input type="text" name="content" id="content" placeholder="Votre message">
            <input id="submit" type="submit" value="Envoyer">
        </form>
    </div>

    <script>
        const msgBox = document.querySelector('msg-box');
        const msgUrl = './data.json';
        let jsonData = null;

        function findProp(obj, prop, defval){
            if (typeof defval == 'undefined') defval = null;
            prop = prop.split('.');
            for (var i = 0; i < prop.length; i++) {
                if(typeof obj[prop[i]] == 'undefined')
                    return defval;
                obj = obj[prop[i]];
            }
            return obj;
        }

        function sendRequest() {
            let request = new XMLHttpRequest();
            request.open('GET', msgUrl);
            request.responseType = 'json';
            request.send();

            request.onload = function () {
                jsonData = request.response;

                for (let i = jsonData.length - 1; i >= 0; i--) {
                    console.log(jsonData[i].content);
                    let msgItem = document.createElement('div');
                    msgItem.classList.add('msg-item');
                    msgItem.innerHTML = `
                        <p class="username">${jsonData[i].username} <span>${jsonData[i].time}</span></p>
                        <p class="content">${jsonData[i].content}</p>
                    `;
                    document.querySelector('.msg-box').appendChild(msgItem);
                    if (i%2 == 0) {
                        msgItem.style.backgroundColor = 'white';
                    }
                }

            }
        }

        sendRequest();
    </script>
</body>
</html>