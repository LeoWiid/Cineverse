         <div class="box banner">
            <h1>Quick Quotes</h1>
        </div>    <!-- / banner -->

        <!-- Navigation goes here.  Edit BOTH the file name and the link name -->
        <div class="box nav">
            
            <div class="linkwrapper">
                <div class="commonsearches">
                    <a href="index.php?page=all_results&search=all">All Quotes</a> | 
                    <a href="index.php?page=all_results&search=recent">Recent</a> | 
                    <a href="index.php?page=all_results&search=random">Random</a> 
                </div>  <!-- / common searches -->
            
                <div class="topsearch">
                    
                    <!-- Quick Search -->           
                    <form method="post" action="index.php?page=quick_search" enctype="multipart/form-data">

                        <input class="search quicksearch" type="text" name="quick_search" size="40" value="" required placeholder="Quick Search..." />

                        <select class="quick-choose" name="search_type">
                            <option value="all" selected>All</option>
                            <option value="quote">Quote</option>
                            <option value="author">Author</option>
                            <option value="subject">Subject</option>
                        </select>

                        <input class="submit" type="submit" name="find_quick" value="&#xf002;" />

                    </form>     <!-- / quick search -->
                    
                </div>  <!-- / top search -->
                
                <div class="topadmin">
                    <a href="#">Log In</a>
                    
                </div>  <!-- / top admin -->
                
            </div>  <!--- / link wrapper -->
            
        </div>    <!-- / nav -->        
        
