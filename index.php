<?php
    $servername = "localhost";
    $username   = "root";
    $password   = "feljun";
    $dbname     = "friend_share";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ( isset( $_POST['submit'] ) ) {
        $fname    = $_POST['fname'] ?? '';
        $lname    = $_POST['lname'] ?? '';
        $age      = $_POST['age'] ?? '';
        $gender   = $_POST['gender'] ?? '';
        $fullname = $fname . ' ' . $lname;

        $sql = "INSERT INTO friends (firstname, lastname, age, gender)
        VALUES ('{$fname}', '{$lname}', {$age}, '{$gender}')";

        if ( $conn->query($sql) === TRUE ) {
            $message = "Thank you, {$fullname}!";
        } else {
            $message =  "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = 'Please fill the form below';
    }
?>
<html>
    <head>
        <title>Sample Form</title>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <form method="post">
            <h1><?php echo $message; ?></h1>
            <p>First Name: <input name="fname" type="text" /></p>
            <p>Last Name: <input name="lname" type="text" /></p>
            <p>Age: <input name="age" type="text" /></p>
            <p>Gender:
                <select name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </p>
            <p>
                <input type="submit" name="submit" value="Submit" />
            </p>
        </form>
        <?php
            $sql = "SELECT * FROM friends";
            $result = $conn->query($sql);

            $friends_array = array();
            if ( $result->num_rows > 0 ) {
                $friends_array = $result->fetch_all(MYSQLI_ASSOC);
            }
        ?>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Gender</th>
            </tr>
            <?php foreach ( $friends_array as $friend ) { ?>
                <tr>
                    <td><?php echo $friend['firstname']; ?></td>
                    <td><?php echo $friend['lastname']; ?></td>
                    <td><?php echo $friend['age']; ?></td>
                    <td><?php echo $friend['gender']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>