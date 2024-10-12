<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
</head>
<body>
This is FILM show page
<div>
    <div>
         <?php echo $film['id']; ?>
    </div>
    <div>
         <?php echo $film['title']; ?>
    </div>
    <div>
         <?php echo $film['overview']; ?>
    </div>
    <div>
         <?php echo $film['release_date']; ?>
    </div>
</div>


</body>
</html>