<?php require "templates/header.php"; 

/**
 * Function to query information based on 
 * a parameter: in this case, name.
 *
 */

 
/* Guests and food have been submitted */
if (isset($_POST['guests'])) 
{
    require "../config.php";
    require "../common.php";
    
    
    /* See if all guest names match database */
    
    /*
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT * FROM users WHERE guest1 = 'allison covey'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$result) 
        {
            echo 'guest does not exist<br>';
        } 
        else 
        {
            echo 'guest added<br>';
        }
    */
    
    /*try 
	{	
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "name"      => $_POST['name'],
            "email"     => $_POST['email'],
            "guest1"    => $_POST['guest1'],
            "guest2"    => $_POST['guest2'],
            "guest3"    => $_POST['guest3']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    }

    catch(PDOException $error) 
    {
        echo $sql . "<br>" . $error->getMessage();
    }*/
    
    
    
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
        
        /* Search for invite */
		$sql = "SELECT * FROM `users` WHERE `name` = :name";
		$name = $_POST['name'];
		$statement = $connection->prepare($sql);
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->execute();

		$result = $statement->fetchAll();
        
        
        
        
        /* Take email if name is found */
        if ($statement->rowCount() > 0) 
        {
            $id = $result[0]["id"];
            $sql = "UPDATE `users` SET `email` = :email WHERE `id` = $id";
            $email = $_POST['email'];
            $statement = $connection->prepare($sql);
            $statement->execute(array($email));
        } 
	}
	
	catch(PDOException $error) 
	{
		echo $sql . "<br>" . $error->getMessage();
	}
 
    if (isset($_POST['submit'])) 
    {
        if ($statement->rowCount() > 0) 
        { ?>

            <h2>Guests and dinner selections</h2>
            <p style="margin-top: -15px; margin-bottom: 20px;"><em>Please, family and spouses only.</em></p>
            <!-- Form for each allotted guest -->
            <form action="" method="post">
                
                <!-- Name, food, and age -->
                <div class="rsvp-rows container">
                    <div class="row">
                        <div class="col-xs-4">
                            <label for="name">First and Last Name</label>
                            <?php echo "<h6>" . $result[0]["name"] . "</h6>"; ?>
                        </div>
                        <div class="col-xs-4">
                            <label for="entree">Entree</label>
                            <select required>
                                <option value="None">Not Coming</option>
                                <option value="Steak">Steak</option>
                                <option value="Chicken">Chicken</option>
                                <option value="Fish">Fish</option>
                                <option value="Vegetarian">Vegetarian</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <label for="age">Age</label>
                            <select required>
                                <option value="None">Not Coming</option>
                                <option value="over21">21+ years old</option>
                                <option value="under21">13 - 20</option>
                                <option value="under12">4 - 12</option>
                                <option value="under4">Under 4</option>
                            </select>
                        </div>
                    </div>
                </div>
                

                <!-- Food option and age for invitee -->
                <?php 
                $c = 1;
                $guest = "guest" . $c;

                /* Display form for each guest listed in database */
                
                while(strcmp($result[0][$guest], "") !== 0 && $c < 4)
                {
                    ?>

                    <!-- Columns for name, entree, and age -->
                    <div class="rsvp-rows container">
                    <div class="row">
                        <div class="col-xs-4">
                            <label for="<?php echo $guest; ?>">First and Last Name</label>
                            <input type="text" id="<?php echo $guest; ?>" name="<?php echo $guest;?>">
                        </div>
                            <div class="col-xs-4">
                                <label for="entree">Entree</label>
                                <select required>
                                    <option value="None">Not Coming</option>
                                    <option value="Steak">Steak</option>
                                    <option value="Chicken">Chicken</option>
                                    <option value="Fish">Fish</option>
                                    <option value="Vegetarian">Vegetarian</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label for="age">Age</label>
                                <select required>
                                    <option value="None">Not Coming</option>
                                    <option value="over21">21+ years old</option>
                                    <option value="under21">13 - 20</option>
                                    <option value="under12">4 - 12</option>
                                    <option value="under4">Under 4</option>
                                </select>
                            </div>
                        </div>
                    </div>

                <?php
                    $c++;
                    $guest = "guest" . $c;
                }
                ?>

                <br>
                
                <div class="rsvp-rows container">
                    <div class="row">
                        <div class="col-xs-4">
                            <input type="submit" name="guests" value="RSVP" style="display: block; margin-top: 10px;">
                        </div>
                        <div class="col-xs-4">
                            
                        </div>
                        <div class="col-xs-4">
                            
                        </div>
                    </div>
                </div>
        
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