<?php

// Prevent undefined variable warnings
$heading = isset($heading) ? $heading : "";
$heading_type = isset($heading_type) ? $heading_type : "";

// Get results
$all_results = get_data($dbconnect, $sql_conditions);
$find_query = $all_results[0];
$find_count = $all_results[1];

if($find_count == 1) {
    $result_s = "Result";
} else {
    $result_s = "Results";
}

// Customise headings!
if($heading != "") {
    $heading = "<h2>$heading ($find_count $result_s)</h2>";
}
elseif ($heading_type=="director") {
    // retrieve director name
    $director_rs = get_item_name($dbconnect, 'director', 'Director_ID', $director_ID);
    $director_name = $director_rs['Director'];
    $heading = "<h2>$director_name Movies ($find_count $result_s)</h2>";
}
elseif ($heading_type=="genre") {
    $genre_name = ucwords($genre_name);
    $heading = "<h2>$genre_name Movies ($find_count $result_s)</h2>";
}
elseif ($heading_type == "movie_success") {
    $heading = "
    <h2>Insert Movie Success</h2>
    <p>You have inserted the following movie...</p>
    ";
}
elseif ($heading_type == "edit_success") {
    $heading = "
    <h2>Edit Movie Success</h2>
    <p>You have edited the movie. The entry is now...</p>
    ";
}
elseif ($heading_type == "delete_movie") {
    $heading = "
    <h2>Delete Movie - Are you Sure?</h2>
    <p>
    Do you really want to delete the movie in the box below?
    </p>
    ";
}
elseif ($heading_type == "random") {
    $heading = "<h2>Random Movies ($find_count $result_s)</h2>";
}
elseif ($heading_type == "all") {
    $heading = "<h2>All Movies ($find_count $result_s)</h2>";
}
elseif ($heading_type == "recent") {
    $heading = "<h2>Recent Movies ($find_count $result_s)</h2>";
}

echo $heading;

if ($find_count > 0) {
    while($find_rs = mysqli_fetch_assoc($find_query)) {
        $movie = $find_rs['Movies'];
        $description = $find_rs['Description'];
        $ID = $find_rs['ID'];
        $director_ID = $find_rs['Director_ID'];
        $director_name = $find_rs['Director_Name'];
        $genre = $find_rs['Genre'];
        ?>
        <div class="results">
            <strong><?php echo htmlspecialchars($movie); ?></strong>
            <p><?php echo nl2br(htmlspecialchars($description)); ?></p>
            <p><i>
                <a href="index.php?page=all_results&search=director&Director_ID=<?php echo $director_ID; ?>">
                    <?php echo htmlspecialchars($director_name); ?>
                </a>
            </i></p>
            <p>
                <?php if ($genre && strtolower($genre) != "n/a") { ?>
                    <span class="tag genre-tag">
                        <a href="index.php?page=all_results&search=genre&genre_name=<?php echo urlencode($genre); ?>">
                            <?php echo htmlspecialchars($genre); ?>
                        </a>
                    </span>
                <?php } ?>
            </p>
            <?php if (isset($_SESSION['admin'])) { ?>
                <div class="tools">
                    <a href="index.php?page=editmovie&ID=<?php echo $ID; ?>"><i class="fa fa-edit fa-2x"></i></a> &nbsp; &nbsp;
                    <a href="index.php?page=deleteconfirm&ID=<?php echo $ID; ?>"><i class="fa fa-trash fa-2x"></i></a>
                </div>
            <?php } ?>
        </div>
        <br />
        <?php
    }
} else {
    ?>
    <h2>Sorry!</h2>
    <div class="no-results">
        Unfortunately - there were no results for your search. Please try again.
    </div>
    <br />
    <?php
} // end of 'no results' else

?>
