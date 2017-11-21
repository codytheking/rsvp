<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit']))
{

    require "../config.php";
    require "../common.php";

    try 
    {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "name" => $_POST['name'],
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
    }

}
?>

<?php require "templates/header.php"; ?>

<?php 
if (isset($_POST['submit']) && $statement) 
{ ?>
<blockquote>RSVP for <?php echo $_POST['name']; ?> successfully added.</blockquote>
<?php 
} ?>

<h2>Add a user</h2>

<form method="post">
    <label for="name">First and Last Name</label>
    <input type="text" name="name" id="name">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="guest1">Guest #1</label>
    <input type="text" name="guest1" id="guest1">
    <label for="guest2">Guest #2</label>
    <input type="text" name="guest2" id="guest2">
    <label for="guest3">Guest #3</label>
    <input type="text" name="guest3" id="guest3">
    <input type="submit" name="submit" value="Submit">
</form>

<br><br>

<a href="/">Back to home</a>

<?php require "templates/footer.php"; ?>