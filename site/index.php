<html>
    <head>
        <title> My Page

        </title>
    </head>
    <body>
        <h1>Apparel Prices</h1>

    <ul>
        
    <?php
        $json = file_get_contents('http://prices');
        $price_items = json_decode($json);
        foreach($price_items as $price_item){
            echo "<li> $price_item->price </li>";
        }
    ?>
    </ul>
    </body>
</html>