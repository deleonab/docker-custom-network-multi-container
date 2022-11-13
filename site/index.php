<html>
    <head>
        <title> My Page

        </title>
    </head>
    <body>
        <h1>Apparel Prices</h1>

    <ul>
        
    <?php
        $json = file_get_contents('http://prices')
        $price_items = json_decode($json)

    ?>
    </ul>
    </body>
</html>