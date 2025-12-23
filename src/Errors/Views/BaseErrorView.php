<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color: rgba(29, 27, 27, 1); color: white; ">
    <?php 
        if(!isset($data))
            die("Unknown error.");
    ?>

    <div style="max-width: 1200px; margin: 100px auto;">
        <h1 style="font-size: 3rem; ">[STATUS_CODE: <?php echo $data->statusCode ?> ] - <?php echo $data->title ?></h1>
        <h4 style="font-size: 1.5rem; color: rgba(136, 125, 125, 1);"><?php echo $data->description ?></h4>
    </div>
    
</body>
</html>