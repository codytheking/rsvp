<?php require "templates/header.php"; 

/**
 * Function to query information based on 
 * a parameter: in this case, name.
 *
 */

 
/* Guests and food have been submitted */
if (isset($_POST['guests'])) 
{
    try 
	{	
		require "../config.php";
		require "../common.php";

		$connection = new PDO($dsn, $username, $password, $options);

        /* See if all guest names match database */
		$sql = "SELECT * 
						FROM users
						WHERE location = :location";

		$location = $_POST['guests'];

		$statement = $connection->prepare($sql);
		$statement->bindParam(':location', $location, PDO::PARAM_STR);
		$statement->execute();

		$result = $statement->fetchAll();
	}
	
	catch(PDOException $error) 
	{
		echo $sql . "<br>" . $error->getMessage();
	}
    
    if ($result && $statement->rowCount() > 0) 
	{ ?>
        <h2>RSVP Confirmed. A confirmation email has been sent to your provided address.</h2>
        <h3>We look forward to seeing you!</h3>

	<?php 
		foreach ($result as $row) 
		{ ?>
			<tr>
				<td><?php echo escape($row["id"]); ?></td>
				<td><?php echo escape($row["firstname"]); ?></td>
				<td><?php echo escape($row["lastname"]); ?></td>
				<td><?php echo escape($row["email"]); ?></td>
				<td><?php echo escape($row["age"]); ?></td>
				<td><?php echo escape($row["location"]); ?></td>
				<td><?php echo escape($row["date"]); ?> </td>
			</tr>
		<?php 
		}  
	} 
	else 
	{ ?>
		<blockquote>One or more guests were not found.</blockquote>
	<?php
	}
    
    
    
	?>
        <h2>Done.</h2>
    <?php
}

/* Initial RSVP lookup has been submitted */
else if (isset($_POST['submit'])) 
{
	try 
	{	
		require "../config.php";
		require "../common.php";

		$connection = new PDO($dsn, $username, $password, $options);

		$sql = "SELECT * 
						FROM users
						WHERE name = :name";

		$name = $_POST['name'];

		$statement = $connection->prepare($sql);
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->execute();

		$result = $statement->fetchAll();
	}
	
	catch(PDOException $error) 
	{
		echo $sql . "<br>" . $error->getMessage();
	}
 
    if (isset($_POST['submit'])) 
    {
        if ($result && $statement->rowCount() > 0) 
        { ?>
            <h2>Guests and dinner selections</h2>
            <!-- Form for each allotted guest -->
            <form action="" method="post">
                <?php 
                $c = 1;
                $guest = "guest" . $c;

                /* Display form for each guest listed in database */
                while(strcmp($result[0][$guest], "") !== 0 && $c < 4)
                {
                    $guest = "guest" . $c;
                    ?>

                    <label for="<?php echo $guest; ?>">First and Last Name</label>
                    <input type="text" id="<?php echo $guest; ?>" name="<?php echo $guest; ?>" required>
                    <select required>
                        <option value="">Select your entree</option>
                        <option value="Steak">Steak</option>
                        <option value="Chicken">Chicken</option>
                        <option value="Fish">Fish</option>
                        <option value="Vegetarian">Vegetarian</option>
                    </select>

                <?php
                    $c++; 
                }
                ?>

                <br>
                <input type="submit" name="guests" value="RSVP" style="display: block; margin-top: 10px;">
            </form>
        <?php
        }

        else 
        { ?>
            <blockquote>No results found for <?php echo escape($_POST['name']); ?>.</blockquote>
        <?php
        } 
    }
}

/* Enter name for RSVP lookup */
else
{?>		
    <h2>Enter your name to RSVP</h2>

    <form method="post">
        <label for="name">First and Last Name</label>
        <input type="text" id="name" name="name">
        <input type="submit" name="submit" value="RSVP">
    </form>
<?php
} ?>

<br>
<br>
<a href="/">Back to home</a>

<?php require "templates/footer.php"; ?>