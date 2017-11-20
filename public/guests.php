<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

if (isset($_POST['submit'])) 
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
}
?>
<?php require "templates/header.php"; ?>
		
<?php  
if (isset($_POST['submit'])) 
{
	if ($result && $statement->rowCount() > 0) 
	{ ?>
		<h2>Enter your choices:</h2>

        <?php 
                
        foreach ($result as $row) 
        { ?>
            <form method="post">
                <label for="name">First Name</label>
                <input type="text" name="name" id="name">
            </form>

        <?php 
        } 
    }
	       
    else 
    { ?>
        <blockquote>No results found for <?php echo escape($_POST['name']); ?>.</blockquote>
    <?php
    } 
}?>

<a href="/">Back to home</a>

<?php require "templates/footer.php"; ?>