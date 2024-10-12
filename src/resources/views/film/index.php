<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
    <link rel="stylesheet" href="/styles/movies.css">
</head>
<body>
This is FILM index page

<div>
    <?php var_dump($films); ?>
</div>


<div>


    <?php foreach ($films as $film) { ?>
        <div>
            1 <?php echo $film['id']; ?>
        </div>
        <div>
            2 <?php echo $film['original_language']; ?>
        </div>
        <div>
            3 <?php echo $film['title']; ?>
        </div>
        <div>
            4 <?php echo $film['overview']; ?>
        </div>
        <div>
            5 <?php echo $film['popularity']; ?>
        </div>
        <div>
            6 <?php echo $film['poster_path']; ?>
            <div>
                <a href="/films/<?php echo $film['id']; ?>">Show film</a>
            </div>
        </div>
    <?php } ?>
</div>


</body>
</html>