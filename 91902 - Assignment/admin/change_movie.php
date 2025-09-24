<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

    if(isset($_REQUEST['submit']))
{

// retrieve movie and director ID from form
// check they are integers (in case someone edits the URL)
$movie_ID = filter_var($_REQUEST['ID'], FILTER_SANITIZE_NUMBER_INT);
$old_director = filter_var($_REQUEST['directorID'], FILTER_SANITIZE_NUMBER_INT);

    include("process_form.php");

    // delete director if there are no movies associated
    // with that director!
    if ($old_director != $director_ID) {
        delete_ghost($dbconnect, $old_director);
    } // end check director changed

// update movie
$stmt = $dbconnect -> prepare("UPDATE `movies` SET `Director_ID` = ?, `Movies` = ?, `Genre_ID` = ? WHERE `Movie_ID` = ?;");
$stmt -> bind_param("isii", $director_ID, $movie, $genre_ID_1, $movie_ID);
$stmt -> execute();

// Close stmt once everything has been inserted
$stmt -> close();

$heading = "";
$heading_type = "edit_success";
$sql_conditions = "WHERE Movie_ID = $movie_ID";

include("content/results.php");

} // end submit button pushed


} // end user logged on it

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=login&error=$login_error");
}



?>