<?php 
    include('../config/helpers.php');
    isAuthenticated();
    $userData = unserialize($_COOKIE['user']);
    $restaurant = $_GET['restaurant'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post New Review</title>
</head>
<body>
    <form action="/slurp/restaurant/process.php" method="post">
        Rating
        <span class="star-rating">
            <input type="radio" name="rating" value=1><i>1</i>
            <input type="radio" name="rating" value=2><i>2</i>
            <input type="radio" name="rating" value=3><i>3</i>
            <input type="radio" name="rating" value=4><i>4</i>
            <input type="radio" name="rating" value=5><i>5</i>
        </span><br/>
        Comment <br/><textarea name="comment" id="comment" cols="30" rows="10"></textarea><br/>
        <input type="hidden" name="restaurant" value="<?php echo $restaurant; ?>">
        <input type="submit" value="Post" name="new_review"><br/>
    </form>
</body>
</html>