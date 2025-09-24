<?php

// retrieve search type...
$search_type = $_POST['search_type'];
$search_term = $_POST['quick_search'];

// set up searches...
$quote_search = "q.Quote LIKE '%$search_term%'";


if ($search_type == "quote") {
    $sql_conditions = "WHERE $quote_search";
}

elseif ($search_type == "author") {
    $sql_conditions = "";
}

elseif ($search_type == "subject") {
    $sql_conditions = "";
}

else {
    $sql_conditions = "";
}

$heading = "'$search_term' Quotes";

include ("results.php");

?>