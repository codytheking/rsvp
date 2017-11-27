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
    
    
    /* Check that guests match */
    try 
	{	
		$connection = new PDO($dsn, $username, $password, $options);

		$sql = "SELECT * 
						FROM inglisttable
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
    
    /* See if name was found */
    if ($result && $statement->rowCount() > 0 
            && strcmp($result[0]["guest1"], $_POST["guest1"]) === 0 
            && strcmp($result[0]["guest2"], $_POST["guest2"]) === 0 
            && strcmp($result[0]["guest3"], $_POST["guest3"]) === 0) 
	{
        try 
        {	
            $connection = new PDO($dsn, $username, $password, $options);

            /*echo "food: " . $_POST['food'] . "<br><br>";*/

            $new_user = array(
                "name"       => $_POST['name'],
                "food"       => $_POST['food'],
                "age"        => $_POST['age'],
                "guest1"     => $_POST['guest1'],
                "guest1food" => $_POST['guest1food'],
                "guest1age"  => $_POST['guest1age'],
                "guest2"     => $_POST['guest2'],
                "guest2food" => $_POST['guest2food'],
                "guest2age"  => $_POST['guest2age'],
                "guest3"     => $_POST['guest3'],
                "guest3food" => $_POST['guest3food'],
                "guest3age"  => $_POST['guest3age'],
                "comments"  => $_POST['comments']
            );

            $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "rsvpd",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
            );

            $statement = $connection->prepare($sql);
            $statement->execute($new_user);
        }

        catch(PDOException $error) 
        {
            echo $sql . "<br>" . $error->getMessage();
        }
        
        ?>
        <h4>Thank you for your RSVP. We look forward to seeing you!</h4>
        <?php
    }
    
    else
    { ?>
        <blockquote>An error occurred when adding guests to the rsvp list. Please try again.</blockquote>
    <?php
    }
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
		$sql = "SELECT * FROM inglisttable WHERE name = :name";
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
        if ($statement->rowCount() > 0)  /* Check if name was found in inglisttable */
        { 
            try 
            {	
                /* Search for invite */
                $sql = "SELECT * FROM rsvpd WHERE name = :name";
                $name = $_POST['name'];
                $checkstmt = $connection->prepare($sql);
                $checkstmt->bindParam(':name', $name, PDO::PARAM_STR);
                $checkstmt->execute();

                $check = $checkstmt->fetchAll();
            }

            catch(PDOException $error) 
            {
                echo $sql . "<br>" . $error->getMessage();
            }

            if (isset($_POST['submit'])) 
            {
                if ($checkstmt->rowCount() <= 0)  /* Check if name was found in rsvpd */
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
                                    <input type="hidden" id="name" name="name" value="<?php echo $result[0]["name"]; ?>">

                                </div>
                                <div class="col-xs-4">
                                    <label for="food">Entree</label>
                                    <select name="food" required>
                                        <option value="None">Not Coming</option>
                                        <option value="Steak">Steak</option>
                                        <option value="Chicken">Chicken</option>
                                        <option value="Fish">Fish</option>
                                        <option value="Vegetarian">Vegetarian</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label for="age">Age</label>
                                    <select name="age" required>
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

                                    <!-- Guest Names -->
                                    <div class="col-xs-4">
                                        <label for="<?php echo "guest" . $c; ?>">Guest</label>
                                        <?php echo "<h6>" . $result[0]["guest" . $c] . "</h6>"; ?>
                                        <input type="hidden" id="<?php echo "guest" . $c; ?>" name="<?php echo "guest" . $c; ?>" value="<?php echo $result[0]["guest" . $c]; ?>">
                                    </div>

                                    <!-- Guest Food Choice -->
                                    <div class="col-xs-4">
                                        <label for="<?php echo "guest" . $c . "food"; ?>">Entree</label>
                                        <select name="<?php echo "guest" . $c . "food"; ?>" required>
                                            <option value="None">Not Coming</option>
                                            <option value="Steak">Steak</option>
                                            <option value="Chicken">Chicken</option>
                                            <option value="Fish">Fish</option>
                                            <option value="Vegetarian">Vegetarian</option>
                                        </select>
                                    </div>

                                    <!-- Guest Age -->
                                    <div class="col-xs-4">
                                        <label for="<?php echo "guest" . $c . "age"; ?>">Age</label>
                                        <select name="<?php echo "guest" . $c . "age"; ?>" required>
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
                                    <label for="comments">Food Allergies or Song Suggestions?</label>
                                    <textarea rows="4" cols="50" name="comments">Enter up to 200 characters...</textarea>   
                                </div>
                                <div class="col-xs-4">

                                </div>
                                <div class="col-xs-4">

                                </div>
                            </div>
                        </div>

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
                    <blockquote><?php echo escape($_POST['name']); ?> already has an RSVP recorded. Contact us if you feel this is an error.</blockquote>
                <?php
                } 
            }
        }
        
        else 
        { ?>
            <blockquote><?php echo escape($_POST['name']); ?> was not found on the guest list. Please make sure you are using the first name on the invitation.</blockquote>
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
<a href="http://www.jcwedding.codyjking.com">Back to home</a>

<?php require "templates/footer.php"; ?>