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

// check that variable is defined and set to 0 if not
    if ($find_rs && isset($find_rs['Director_ID'])) {
        $director_ID = $find_rs['Director_ID'];
    }
    else {
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