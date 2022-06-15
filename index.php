<?php
$insert = false;
$nameErr = $contactErr = $emailErr = $detailsErr = "";
$errorFlag = false;
$name = $contact = $email = $details = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name'])) {
        $nameErr = "Name is required";
        $errorFlag = true;
    } else
        $name = $_POST['name'];
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Only letters and spaces allowed";
        $errorFlag = true;
    }


    if (empty($_POST['contact'])) {
        $contactErr = "Contact Number is required";
        $errorFlag = true;
    } else
        $contact = $_POST['contact'];
    if (strlen($contact) != 10) {
        $contactErr = "Invalid contact number";
        $errorFlag = true;
    }


    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
        $errorFlag = true;
    } else
        $email = $_POST['email'];

    if (strlen($_POST['details']) > 250) {
        $detailsErr = "Character length is only 250";
        $errorFlag = true;
    }
    $details =  $_POST['details'];
}

if ($errorFlag == false) 
{
    $server = 'localhost';
    $username = 'root';
    $password = "";

    $connection = mysqli_connect($server, $username, $password);

    if (!$connection)
        die("Connection to database failed due to " . mysqli_connect_error());
    // else
    //     echo "Successfully connected to database";

    $sql = "INSERT INTO `Pokhara Trip`.`trip_info` (`name`, `contact`, `email`, `details`, `date`) VALUES ('$name', '$contact', '$email', '$details', current_timestamp());";
    // echo $sql;

    if ($connection->query($sql) == true) {
        // echo "Your details have been uploaded";
        $insert = true;
    }
     else {
        echo "ERROR: $connection->error";
    }
    $connection->close;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Travel Form</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <style>
        .error {
            color: red;
        }
    </style>
    <img src="samrat-khadka-2bxAoXcfwwM-unsplash.jpg" alt="Image" class="bg">
    <div class="container">

        <h1>Welcome to NCIT Pokhara Trip Form</h1>
        <p>Enter your details to confirm your participation</p>

        <span class="error">* required field</span>
        <form action="index.php" method="post">
            Name: <input type="text" name="name" id="name" value="<?php echo $name; ?>">
            <span class="error">
                * <?php echo $nameErr; ?>
            </span>
            <br>
            Contact Number: <input type="number" name="contact" id="contact" value="<?php echo $contact; ?>">
            <span class="error">
                * <?php echo $contactErr; ?>
            </span>
            <br>
            Email: <input type="email" name="email" value="<?php echo $email; ?>">
            <span class="error">*
                <?php echo $emailErr; ?>
            </span>
            <br>
            Enter details: <span class="error">
                <?php echo $detailsErr; ?>
            </span>
            <br> <textarea name="details" id="details" cols="30" rows="10"><?php echo $details; ?></textarea>

            <br>
            <button type="submit" class="btn">Submit</button>
            <button type="reset" class="btn">Reset</button>
        </form>
        <?php
        if ($insert == true) {
            echo "<p  class='submitMsg'>Thank you for submitting your form. We are happy to see you coming along!</p>";
        }
        ?>
    </div>
    <script src="index.js"></script>

</body>
</html>