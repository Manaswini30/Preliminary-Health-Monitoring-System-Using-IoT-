<?php
// Database connection
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'major_project';
$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    die('Error connecting to the database');
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password match
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $query);

if ($result) {
    // Check the number of rows only if the query was successful
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userID = $row['id'];

        // Redirect logic remains the same
    } else {
        echo 'Invalid username or password';
    }
} else {
    echo 'Error: ' . mysqli_error($conn);
}

        // Redirect to a specific page based on the user's ID
        if ($userID == 1) {
            header("Location: page2.php");
            exit();
        } else if ($userID == 2) {
            header("Location: page3.php");
            exit();
        } else {
            // Redirect to a default page for other users
            header("Location: user_not_registered.php");
            exit();
        }
    } else {
        echo 'Invalid username or password';
    }

mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>MediMonitor</title>
   <link rel="stylesheet" href="Signup.css">
   <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Catamaran:wght@200&family=Courgette&family=Dancing+Script:wght@700&family=Edu+TAS+Beginner:wght@700&family=Lato:wght@300;900&family=Mukta:wght@700&family=Mulish:wght@300&family=Open+Sans&family=PT+Sans:ital,wght@1,700&family=Poppins:wght@300&family=Raleway:wght@100&family=Roboto&family=Roboto+Condensed:wght@700&family=Roboto+Slab&display=swap" rel="stylesheet">
   <script src="https://kit.fontawesome.com/f30fac2c61.js" crossorigin="anonymous"></script>
  </head>
  <body>
  <div class="container">
            <nav>
                <div class="logo">
                    <h1>MediMonitor</h1>
                </div>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="Signup.php">Sign Up</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="home.php">About Us</a></li>
                </ul>
            </nav>
                <div class="main">
                    <!-- <div class="col"> -->
                          <!-- <div class="card mb-4 rounded-3 "> -->
                              <div class="card-header py-3  ">
                                  <h2 style="text-align: center;">Login</h2>                    
                              </div>
                              <div class="card-body">
                                        <form action="login.php" method="POST">
                                            <label><H4>Username:</H4></label>
                                            <input type="text" name="username" required><br><br>
                                            <label><H4>Password:</H4></label>
                                            <input type="password" name="password" required><br><br>
                                            <input type="submit" value="Login" >
                                            <a class="MuiTypography-root MuiTypography-inherit MuiLink-root MuiLink-underlineAlways css-1kd30p4" href = 'signup.php'><H4>Signup<H4></a>
                                        </form>
                              </div>
                    </div>            
                </div>
      </div>
      <script src="index.js"></script>
</body>
</html>