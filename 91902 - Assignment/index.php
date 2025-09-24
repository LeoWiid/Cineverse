
<!DOCTYPE HTML>
<?php 
    session_start();
    include("config.php");
    include("functions.php");
    // Connect to database...
    $dbconnect = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if(mysqli_connect_errno()) {
        echo "Connections failed:" . mysqli_connect_error();
        exit;
    }
    $director_name = '';
    // Only fetch director if $director_ID is set and not empty
    if (isset($director_ID) && !empty($director_ID)) {
        $director_rs = get_item_name($dbconnect, 'director', 'Director_ID', $director_ID);
        if ($director_rs) {
            $director_name = $director_rs['Director'];
        }
    }
?>
<html lang="en">
<?php include("content/head.php"); ?>
<body>
    <div class="wrapper">
        <?php include("content/banner_navigation.php"); ?>
        <div class="box main">
            <?php
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
            echo "<!-- Requested page: $page -->"; // Debug: see what value is being passed
            if(!isset($_REQUEST['page'])) {
                include("content/home.php");
            } else {
                $page = preg_replace('/[^0-9a-zA-Z_]/', '', $_REQUEST['page']); // allow underscores for admin pages
                // List of admin pages
                $admin_pages = [
                    "editmovie",
                    "deleteconfirm",
                    "deletemovie",
                    "change_movie",
                    "add_movie",
                    "sub_director",
                    "process_form",
                    "insert_movie",
                    "adminlogin"
                    // add more admin page names as needed
                ];
                echo "<!-- Requested page: $page -->";
                // Routing
                if (in_array($page, $admin_pages)) {
                    $filepath = "admin/$page.php";
                } else {
                    $filepath = "content/$page.php";
                }
                if (file_exists($filepath)) {
                    include($filepath);
                } else {
                    echo "<h2>Page not found.</h2>";
                }
            }
            ?>
        </div>    <!-- / main -->
        <?php include("content/footer.php"); ?>
    </div> <!-- / wrapper -->
</body>
</html>