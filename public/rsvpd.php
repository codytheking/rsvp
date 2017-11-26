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

    $sql = "SELECT * FROM rsvpd";

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

    <h2>Database of RSVP'd Guests</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Guest #1</th>
                <th>Food</th>
                <th>Age</th>
                <th>Guest #2</th>
                <th>Food</th>
                <th>Age</th>
                <th>Guest #3</th>
                <th>Food</th>
                <th>Age</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
<?php 
    foreach ($result as $row) 
    { ?>
        <tr>
            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["name"]); ?></td>
            <td><?php echo escape($row["guest1"]); ?></td>
            <td><?php echo escape($row["guest1Food"]); ?></td>
            <td><?php echo escape($row["guest1Age"]); ?></td>
            <td><?php echo escape($row["guest2"]); ?></td>
            <td><?php echo escape($row["guest2Food"]); ?></td>
            <td><?php echo escape($row["guest2Age"]); ?></td>
            <td><?php echo escape($row["guest3"]); ?></td>
            <td><?php echo escape($row["guest3Food"]); ?></td>
            <td><?php echo escape($row["guest3Age"]); ?></td>
            <td><?php echo escape($row["comments"]); ?></td>
        </tr>
    <?php 
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