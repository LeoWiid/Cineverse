 <?php

// get all genres from database
$all_tags_sql = "SELECT * FROM genre ORDER BY Genre ASC ";
$all_genres = autocomplete_list($dbconnect, $all_tags_sql, 'Genre');

// initialise genre variables
$tag_1 = "";
$tag_2 = "";
$tag_3 = "";

// initialise tag ID's
$tag_1_ID = $tag_2_ID = $tag_3_ID = 0;

// get director full name from database
$director_full_sql = "SELECT *, Director AS Full_Name FROM director" ;
$all_director = autocomplete_list($dbconnect, $director_full_sql,'Full_Name');

?>