<?php

// retrieve search type...
$search_type = clean_input($dbconnect, $_POST['search_type']);
$search_term = clean_input($dbconnect, $_POST['quick_search']);

$search = mysqli_real_escape_string($dbconnect, $search_term);

if ($search_type == "movie") {
    $sql_conditions = "WHERE m.Movies LIKE '%$search%'";
} elseif ($search_type == "director") {
    $sql_conditions = "WHERE d.Director LIKE '%$search%'";
} elseif ($search_type == "genre") {
    $sql_conditions = "WHERE g.Genre LIKE '%$search%'";
} else {
    // General search: search all fields
    $sql_conditions = "WHERE m.Movies LIKE '%$search%' OR g.Genre LIKE '%$search%' OR d.Director LIKE '%$search%'";
}

$heading = "'$search_term' Movies";

include ("results.php");

?>