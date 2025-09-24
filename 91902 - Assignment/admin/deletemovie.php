<?php


// check user is logged on
if (isset($_SESSION['admin'])) {

    // Always get IDs first
    $movie_ID = isset($_REQUEST['ID']) ? intval($_REQUEST['ID']) : 0;
    $director_ID = isset($_REQUEST['director']) ? intval($_REQUEST['director']) : 0;

    if (isset($_POST['confirm'])) {
        // Delete the movie
        $stmt = $dbconnect->prepare("DELETE FROM `movies` WHERE `Movie_ID` = ?");
        $stmt->bind_param("i", $movie_ID);
        $stmt->execute();
        $stmt->close();

        // Optionally, delete the director if needed (ghost director logic)
        // delete_ghost($dbconnect, $director_ID);

        echo "<h2>Delete Success</h2>";
        echo "<p>The requested movie has been deleted.</p>";

        
        include("content/results.php");

    } elseif (isset($_POST['cancel'])) {
        // Redirect if cancelled
        header("Location: index.php?page=home");
        exit;
    } else {
        // Only fetch the movie record if showing the confirmation form
        $movie_sql = "SELECT * FROM `movies` WHERE `Movie_ID` = $movie_ID";
        $movie_query = mysqli_query($dbconnect, $movie_sql);
        $find_rs = mysqli_fetch_assoc($movie_query);

        if ($find_rs && isset($find_rs['Director_ID'])) {
            $director_ID = $find_rs['Director_ID'];
        } else {
            $director_ID = 0;
        }

        include("deleteconfirm.php");
    }

} else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=login&error=$login_error");
    exit;
}
?>