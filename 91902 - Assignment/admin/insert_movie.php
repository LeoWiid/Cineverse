<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

    if(isset($_REQUEST['submit']))
{

    // Get movie and description from form
    $movie = isset($_POST['movie']) ? trim($_POST['movie']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    include("process_form.php");

// insert movie
$stmt = $dbconnect -> prepare("INSERT INTO `Movies` (`Director_ID`, `Movies`, `Description`, `Genre_ID`) VALUES (?, ?, ?, ?); ");
$stmt -> bind_param("issi", $director_ID, $movie, $description, $genre_ID_1);
$stmt -> execute();

$movie_ID = $dbconnect -> insert_id;

// Close stmt once everything has been inserted
$stmt -> close();

$heading = "Movie Success";
$sql_conditions = "WHERE Movie_ID = $movie_ID";

include("content/results.php");

} // end submit button pushed


} // end user logged on it

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=login&error=$login_error");
}



?>