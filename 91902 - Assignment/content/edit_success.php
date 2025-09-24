<?php
// Show a success message after editing a movie
echo "<h2>Edit Movie Success</h2>";
echo "<p>The movie has been updated successfully.</p>";

// Optionally, show the updated movie details:
if (isset($_GET['ID'])) {
    $movie_ID = intval($_GET['ID']);
    $sql = "SELECT m.*, d.Director, g.Genre 
            FROM movies m
            LEFT JOIN director d ON m.Director_ID = d.Director_ID
            LEFT JOIN genre g ON m.Genre_ID = g.Genre_ID
            WHERE m.Movie_ID = $movie_ID";
    $query = mysqli_query($dbconnect, $sql);
    if ($row = mysqli_fetch_assoc($query)) {
        ?>
        <div class="results">
            <strong><?php echo htmlspecialchars($row['Movies']); ?></strong>
            <p><?php echo nl2br(htmlspecialchars($row['Description'])); ?></p>
            <p><i>
                <a href="index.php?page=all_results&search=director&Director_ID=<?php echo $row['Director_ID']; ?>">
                    <?php echo htmlspecialchars($row['Director']); ?>
                </a>
            </i></p>
            <p>
                <?php if ($row['Genre'] && strtolower($row['Genre']) != "n/a") { ?>
                    <span class="tag genre-tag">
                        <a href="index.php?page=all_results&search=genre&genre_name=<?php echo urlencode($row['Genre']); ?>">
                            <?php echo htmlspecialchars($row['Genre']); ?>
                        </a>
                    </span>
                <?php } ?>
            </p>
            <?php if (isset($_SESSION['admin'])) { ?>
                <div class="tools">
                    <a href="index.php?page=editmovie&ID=<?php echo $row['Movie_ID']; ?>"><i class="fa fa-edit fa-2x"></i></a> &nbsp; &nbsp;
                    <a href="index.php?page=deleteconfirm&ID=<?php echo $row['Movie_ID']; ?>"><i class="fa fa-trash fa-2x"></i></a>
                </div>
            <?php } ?>
        </div>
    <br>
        <?php
    }
}
?>