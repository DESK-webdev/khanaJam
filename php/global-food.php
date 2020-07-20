<?php
include 'components/main.php';
    if($_GET){
        $food=new putdata;
        $food->globalfood(json_encode($_GET));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/add-food.css">
    <title>Add Food</title>
</head>
<body>
    <div class="add-food-container">
        <div class="text-section">
            <h1>Add New global Food</h1>
        </div>
        <div class="form-section">
            <form action="" method="GET">
                <input type="text" name="name" placeholder="Name of Food" id="">
                <span>
                    <label for="GlobalFood">Food Category</label>
                    <input type="text" name="category">
                </span>
                <span>
                    <label for="ImageofFood">Image of Food:</label>
                    <input type="image" id="image" src="/assets/file-image-regular.svg" alt="">
                </span>
                <textarea name="description" placeholder="Enter Description" id="" cols="30" rows="10"></textarea>
                <button type="submit" class="button">Sumbit</button>
            </form>
        </div>
    </div>
</body>
</html>