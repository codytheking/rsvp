<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

try 
{	
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT category, count(*) total
            FROM 
            (
              SELECT food as category
              FROM rsvpd
              UNION ALL
              SELECT guest1food
              FROM rsvpd
              UNION ALL
              SELECT guest2food
              FROM rsvpd
              UNION ALL
              SELECT guest3food
              FROM rsvpd
              UNION ALL
              SELECT age
              FROM rsvpd
              UNION ALL
              SELECT guest1age
              FROM rsvpd
              UNION ALL
              SELECT guest2age
              FROM rsvpd
              UNION ALL
              SELECT guest3age
              FROM rsvpd
            ) d
            GROUP by category
            ORDER by total desc";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
}

catch(PDOException $error) 
{
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
		
<?php  
if ($result && $statement->rowCount() > 0) 
{ ?>

    <h2>Count for Entree and Age Selections</h2>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
<?php 
    $count = 0;
    foreach ($result as $row) 
    { 
        $count++;
        if($count > 1 && strcmp($row["category"], "None") !== 0)  /* exclue overall total and "None" counts */
        {
            ?>
            
            <tr>
                <td><?php echo escape($row["category"]); ?></td>
                <td><?php echo escape($row["total"]); ?></td>
            </tr>
    <?php 
        }
    } ?>
    </tbody>
</table>
<?php 
} 
else 
{ ?>
    <blockquote>Database is empty.</blockquote>
<?php
} ?> 

<br><br>

<a href="/">Back to home</a>

<?php require "templates/footer.php"; ?>