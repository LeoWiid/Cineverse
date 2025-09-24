
<div class="box banner">
    <h1>CineVerse</h1>
</div>    <!-- / banner -->

<div class="box nav">
    <div class="linkwrapper">
        <div class="commonsearches">
            <a href="index.php?page=all_results&search=all">All Movies</a> | 
            <a href="index.php?page=all_results&search=recent">Recent</a> | 
            <a href="index.php?page=all_results&search=random">Random</a> 
        </div>  <!-- / common searches -->
        <div class="topsearch">
            <!-- Quick Search -->           
            <form method="post" action="index.php?page=quick_search" enctype="multipart/form-data">
                <input class="search quicksearch" type="text" name="quick_search" size="40" value="" required placeholder="Quick Search...">
                <select class="quick-choose" name="search_type">
                    <option value="all" selected>All</option>
                    <option value="movie">Movie</option>
                    <option value="director">Director</option>
                    <option value="genre">Genre</option>
                </select>
                <!-- Use a magnifying glass emoji or text instead of Unicode Private Use Area -->
                        <button class="submit search-btn" type="submit" name="find_quick" aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;">
                                <circle cx="11" cy="11" r="7"/>
                                <line x1="18" y1="18" x2="15.5" y2="15.5"/>
                            </svg>
                        </button>
            </form>     <!-- / quick search -->
        </div>  <!-- / top search -->
        <div class="topadmin">
            <?php
                if(isset($_SESSION['admin'])) {
            ?>
                <a href="index.php?page=add_movie">
                <i class="fa fa-plus fa-2x"></i></a>
                &nbsp; &nbsp;
                <a href="index.php?page=logout">
                <i class="fa fa-sign-out fa-2x"></i></a>
            <?php
                } else {
            ?>
                <a href="index.php?page=login">Log In</a>
            <?php
                }
            ?>
        </div>  <!-- / top admin -->
    </div>  <!--- / link wrapper -->
</div>    <!-- / nav -->

