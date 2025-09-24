<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

// retrieve movie ID and santise it case someone edits the URL
$movie_ID = filter_var($_REQUEST['ID'], FILTER_SANITIZE_NUMBER_INT);

// adjust heading and find movie
$heading_type = "deletemovie";
$heading = "";
$sql_conditions = "WHERE Movie_ID = $movie_ID";

include("content/results.php");

// Fetch the movie record directly for director_ID
$movie_sql = "SELECT * FROM `movies` WHERE `Movie_ID` = $movie_ID";
$movie_query = mysqli_query($dbconnect, $movie_sql);
$find_rs = mysqli_fetch_assoc($movie_query);

if ($find_rs && isset($find_rs['Director_ID'])) {
    $director_ID = $find_rs['Director_ID'];
} else {
    $director_ID = 0;
}

?> 

    <form method="post" action="index.php?page=deletemovie&ID=<?php echo $movie_ID; ?>&director=<?php echo $director_ID; ?>">
        <div class="delete-confirm-buttons">
            <input type="submit" class="delete-confirm" name="confirm" value="Yes, Delete it!">
            <input type="submit" class="delete-confirm" name="cancel" value="NO, take me back">
        </div>
    </form>
<?php

} // end user logged on it

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=login&error=$login_error");
}



?>