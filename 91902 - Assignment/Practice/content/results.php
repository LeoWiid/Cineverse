<?php

$all_results = get_data($dbconnect, $sql_conditions);

$find_query = $all_results[0];
$find_count = $all_results[1];

if($find_count == 1) {
    $result_s = "Result";
}
else {
    $result_s = "Results";
}

// check that we have results
if($find_count > 0) {

// Customise headings!

if($heading != "") {
    $heading = "<h2>$heading ($find_count $result_s)</h2>";
}

elseif ($heading_type=="author") {
    // retrieve author name
    $author_rs = get_item_name($dbconnect, 'author', 'Author_ID',
    $author_ID);

    $author_name = $author_rs['First']." ".$author_rs['Middle']." ".
    $author_rs['Last'];

    $heading = "<h2>$author_name Quotes ($find_count $result_s)</h2>";
}

elseif ($heading_type=="subject") {
    $subject_name = ucwords($subject_name);
    $heading = "<h2>$subject_name Quotes ($find_count $result_s)</
    h2>";
}

echo $heading;

while($find_rs = mysqli_fetch_assoc($find_query)) {
    $quote = $find_rs['Quote'];

    $author_first = $find_rs['First'];
    $author_middle = $find_rs['Middle'];
    $author_last = $find_rs['Last'];

    // Create full name of author
    $author_full = $author_first." ".$author_middle. " ".$author_last;

    // get author ID for clickable author link
    $author_ID = $find_rs['Author_ID'];

    // set up subjects
    $subject_1 = $find_rs['Subject1'];
    $subject_2 = $find_rs['Subject2'];
    $subject_3 = $find_rs['Subject3'];

    // put subjects in list so that we can iterate through it
    $all_subjects = array($subject_1, $subject_2, $subject_3);

    ?>

    <div class="results">
        <?php echo $quote; ?>

        <p><i>
            <a href="index.php?page=all_results&search=author&
            Author_ID=<?php echo $author_ID; ?>">
            <?php echo $author_full; ?>
            </a>
        </i></p>

        <p>
        <?php

        // iterate through all_subjects list and output subject if it is not blank.

        foreach ($all_subjects as $subject) {
            // check the subject is not "n/a"
            if ($subject != "n/a") {
                
                ?>
                <span class="tag">
                    <a href="index.php?page=all_results&search=subject&
                    subject_name=<?php echo $subject; ?>">
                        <?php echo $subject;?>
                    </a>
                </span>
                &nbsp;&nbsp;

                <?php
            }
            

        }

        ?>
        </p>
    </div>

    <br />

    <?php

} // end of while loop

} // end of 'have results'

// if there are no results, show an error message
else {

    ?>

    <h2>Sorry!</h2>

    <div class="no-results">
        Unfortunately - there were no results for your search. Please try again.
    </div>
    <br />

    <?php

} // end of 'no results' else


?>