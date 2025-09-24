<?php
// check user is logged on
if (isset($_SESSION['admin'])) {

// retrieve genres and directors to populate combo box
include("sub_director.php");

// Retrieve current values for movie...
$ID = $_REQUEST['ID'];

// get values from DB
$edit_query = get_data($dbconnect, "WHERE m.Movie_ID = $ID");

$edit_results_query = $edit_query[0];
$edit_results_rs = mysqli_fetch_assoc($edit_results_query);

// Use correct column names/aliases
$director_ID = $edit_results_rs['Director_ID'];
$director_full_name = $edit_results_rs['Director_Name']; // Use 'Director_Name' not 'Full_Name'
$movie = $edit_results_rs['Movies']; // Use 'Movies' not 'Movie'
$genre_1 = $edit_results_rs['Genre'];

?>


<div class="admin-form">
    <h1>Edit a Movie</h1>
    <form action="index.php?page=change_movie&ID=<?php echo $ID ?>&directorID=<?php echo $director_ID; ?>" method="post">
        <p>
            <textarea name="movie" placeholder="Movie (Required)" required><?php echo $movie; ?></textarea>
        </p>
        <div class="important">
            If you edit a director, it will change the director name for the movie being edited. It does not edit the director name on all movies attributed to that director.
        </div>
        <div class="autocomplete">
            <input name="director_full" id="director_full" value = "<?php echo htmlspecialchars($director_full_name); ?>">
        </div>
        <div class="light_blue">
            Blank genres appear as n/a. You can either edit these / add a genre or leave them as n/a.
        </div>
    <br>
        <div class="autocomplete">
            <input name="genre" id="genre" value = "<?php echo htmlspecialchars($genre_1); ?>" required>
        </div>
    <p><input class="form-submit" type="submit" name="submit" value="Edit Movie"></p>
    </form>
</div>

<?php
    } // end user logged on if

    else {
        $login_error = 'Please login to acces this page';
        header("Location: index.php?page=../content/login&error=$login_error");
    }
?>

