<?php 

// function to 'clean' data
function clean_input($dbconnect, $data) {
	$data = trim($data);	
	$data = htmlspecialchars($data); //  needed for correct special character rendering
    // remove dodgy characters to prevent SQL injectiobns
    $data = mysqli_real_escape_string($dbconnect, $data);
    return $data;
}

function get_data($dbconnect, $more_condition=null) {  
    $find_sql = "SELECT
        m.Movie_ID AS ID,
        m.Movies AS Movies,
        m.Description,
        m.Director_ID,
        d.Director AS Director_Name,
        g.Genre AS Genre
    FROM
        movies m
    JOIN director d ON m.Director_ID = d.Director_ID
    JOIN genre g ON m.Genre_ID = g.Genre_ID
    ";
    if($more_condition != null) {
        $find_sql .= " " . $more_condition;
    }
    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_count = mysqli_num_rows($find_query);
    return array($find_query, $find_count);
}

function get_item_name($dbconnect, $table, $column, $ID)
{
    if (empty($ID)) {
        return null; // Prevents invalid SQL
    }
    $find_sql ="SELECT * FROM $table WHERE $column = $ID";
    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);

    return $find_rs;
}

// entity is genre, country, occupation etc
function autocomplete_list($dbconnect, $item_sql, $entity)    
{
// Get entity / topic list from database
$all_items_query = mysqli_query($dbconnect, $item_sql);
    
// Make item arrays for autocomplete functionality...
while($row=mysqli_fetch_array($all_items_query))
{
  $item=$row[$entity];
  $items[] = $item;
}

$all_items=json_encode($items);
return $all_items;
    
}

// Delete Ghost Directors
function delete_ghost($dbconnect, $directorID)
{
    // see if there are other movies by that director
    $check_director_sql = "SELECT * FROM `movies` WHERE `Director_ID` = $directorID ";
    $check_director_query = mysqli_query($dbconnect, $check_director_sql);

    $count_director = mysqli_num_rows($check_director_query);

        // if there are not movies associateed with the old director,
        // we can delete the old director.
    if ($count_director <= 1) {
        $delete_ghost = "DELETE FROM `director` WHERE `director`. `Director_ID` = $directorID ";
        $delete_ghost_query = mysqli_query($dbconnect, $delete_ghost);
    }
}

// get search ID
function get_search_ID($dbconnect, $search_term)
{
    $find_sql = "SELECT * FROM genre WHERE Genre LIKE '$search_term'";
    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);

    // count results
    $find_count = mysqli_num_rows($find_query);

    if($find_count == 1) {
        return $find_rs['Genre_ID'];
    }
    else {
        return "no results";
    }
}



// function to get genre, country & career ID's
function get_ID($dbconnect, $table_name, $column_ID, $column_name, $entity)
{
    
    if($entity=="")
    {
        return 0;
    }
    
    
    // get entity ID if it exists
    $findid_sql = "SELECT * FROM $table_name WHERE $column_name LIKE '$entity'";
    $findid_query = mysqli_query($dbconnect, $findid_sql);
    $findid_rs = mysqli_fetch_assoc($findid_query);
    $findid_count=mysqli_num_rows($findid_query);
    
    // If genre ID does exists, return it...
    if($findid_count > 0) {
        $find_ID = $findid_rs[$column_ID];
        return $find_ID;
    }   // end if (entity existed, ID returned)
    

    else {
        $add_entity_sql = "INSERT INTO $table_name ($column_ID, $column_name) VALUES (NULL, '$entity');";
        $add_entity_query = mysqli_query($dbconnect, $add_entity_sql);
        
    $new_id_sql = "SELECT * FROM $table_name WHERE $column_name LIKE '$entity'";
    $new_id_query = mysqli_query($dbconnect, $new_id_sql);
    $new_id_rs = mysqli_fetch_assoc($new_id_query);
        
    $new_id = $new_id_rs[$column_ID];
    
    return $new_id;
        
    }   // end else (entity added to table and ID returned)
    
} // end get ID function


function get_rs($dbconnect, $sql)
{
    $find_sql = $sql;
    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);
    
    return $find_rs;
}


function country_job($dbconnect, $entity_1, $entity_2, $label_sg, $label_pl, $table, $entity_ID, $entity_name)
{
    
    $all_entities = array($entity_1, $entity_2);
    // loop through items and look up their values...
    
    // Counts # of countries that without ID zero...
    $num_entities = count(array_filter($all_entities));
    
        
    if ($num_entities == 1)
    {
    echo "<b>".$label_sg."</b>: ";
    }
    
    else { echo "<b>".$label_pl."</b>: ";}
    
    foreach ($all_entities as $entity) {
    
    $entity_sql = "SELECT * FROM $table WHERE $entity_ID = $entity";
    $entity_query = mysqli_query($dbconnect, $entity_sql);
    $entity_rs = mysqli_fetch_assoc($entity_query);
    
    if ($entity != 0) {
        
    ?>
    
        
    <span class="director_entity tag"><?php echo htmlspecialchars($entity_rs[$entity_name]); ?> </span> &nbsp;
      
    <?php
        
    } // end entity if
  
    // break reference with the last element as per the manual
    unset($entity);
        
    }
     
}

// Before using $director_ID
if (!isset($director_ID) || empty($director_ID)) {
    // Handle the error, e.g. show a message or set a default value
    $director_ID = 0; // or return/exit if this is required
}

// Only fetch director if $director_ID is valid
if (isset($director_ID) && !empty($director_ID)) {
    $director_rs = get_item_name($dbconnect, 'director', 'Director_ID', $director_ID);
    $director_name = $director_rs ? $director_rs['Director'] : '';
    $heading = "<h2>$director_name Movies ($find_count $result_s)</h2>";
}

$sql_conditions = "ORDER BY m.Movie_ID DESC LIMIT 10";