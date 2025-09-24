<?php
// check user is logged on
if (isset($_SESSION['admin'])) {

// retrieve genres and directors to populate combo box
include("sub_director.php");

?>

<div class = "admin-form">
    <h1>Add a Movie</h1>

    <form action="index.php?page=insert_movie" method="post">
        <p>
            <textarea name="movie" placeholder="Movie (Required)" required></textarea>
        </p>
        <p>
            <textarea name="description" placeholder="Description (Required)" required></textarea>
        </p>
        
        <div class="autocomplete">
            <input name="director_full" id="director_full" placeholder="Director Name (Required)" required />
        </div>

        <br /><br />

        <div class="autocomplete">
            <input name="genre" id="genre" placeholder="Genre (Required)" required />
        </div>

        <p><input class="form-submit" type="submit" name="submit" value="Submit Movie" /></p>
    </form>

    <script>
        <?php include("autocomplete.php"); ?>

        /* Arrays containing lists. */
        var all_tags = <?php print("$all_genres")?>;
        autocomplete(document.getElementById("genre"), all_tags);

        var all_director = <?php print("$all_director") ?>;
        autocomplete(document.getElementById("director_full"), all_director);

    </script>
</div>

<?php
    } // end user logged on it

    else {
        $login_error = 'Please login to acces this page';
        header("Location: index.php?page=login&error=$login_error");
    }
?>

