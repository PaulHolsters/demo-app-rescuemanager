<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>
            app
        </title>
        <script src="resources/scanner/qr-scanner.umd.js"></script>
    </head>
    <style>
        body {
            margin: 0;
            overflow-x: hidden;
        }
        body > div:nth-of-type(2){
            width: 100%;
            margin: 0;
        }
    </style>
    <body>
        <?php
        include('menu/index.php');
        ?>
        <div class="home">
            <?php
            include('views/home/index.php');
            ?>
        </div>
        <template id="home">
            <?php
            include('views/home/index.php');
            ?>
        </template>
        <template id="duikoefening">
            <?php
            include('views/duikoefening/index.php');
            ?>
        </template>
        <template id="inventaris">
            <?php
            include('views/inventaris/index.php');
            ?>
        </template>
        <template id="materiaalbeheer">
            <?php
            include('views/materiaalbeheer/index.php');
            ?>
        </template>
    </body>
</html>
