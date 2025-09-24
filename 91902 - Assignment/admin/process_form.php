<?php

    // retrieve data from form
    $movie = $_REQUEST['movie'];

    $director_full = $_REQUEST['director_full'];
    $genre = $_REQUEST['genre'];

    $first = "";
    $middle = "";
    $last = "";

// Initialise IDs
$genre_ID_1 = $director_ID = "";

// handle blank fields
if ($director_full == '') {
    $director_full = $first = "Anonymous";
}

// check to see if genre / director is in DB, if it isn't add it.

$genres = array($genre);
$genre_IDs = array();

// statement to insert genre/s
$stmt = $dbconnect -> prepare("INSERT INTO `Genre` (`Genre`) VALUES (?); ");

foreach ($genres as $genre) {
    $genreID = get_search_ID($dbconnect, $genre);

    if ($genreID == "no results") {

        // insert the genre
        $stmt -> bind_param("s", $genre);
        $stmt -> execute();

        // retrieve genre ID
        $genreID = $dbconnect->insert_id;
    }

    $genre_IDs[] = $genreID;
}

// retrieve genre ids
$genre_ID_1 = $genre_IDs[0];

// check to see if director exists
$find_director_sql = "SELECT * FROM director WHERE Director = '$director_full'";
$find_director_query = mysqli_query($dbconnect, $find_director_sql);
$find_director_rs = mysqli_fetch_assoc($find_director_query);
$director_count = mysqli_num_rows($find_director_query);

// retrieve director ID if director exists
if ($director_count > 0) {
    $director_ID = $find_director_rs['Director_ID'];
} else {
    // add director to DB
    $stmt = $dbconnect -> prepare("INSERT INTO `Director` (`Director`) VALUES (?); ");
    $stmt -> bind_param("s", $director_full);
    $stmt -> execute();
    $director_ID = $dbconnect -> insert_id;
}

?>