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

    <h1>Apparel Styles</h1>
    <ul> 
       <?php
       $json2 = file_get_contents('http://apparel');
       $apparel_items = json_decode($json2);
       foreach($apparel_items as $apparel_item){
           echo "<li> $apparel_item->name</li>";
       }
       ?>
    </ul>
    </body>
</html>