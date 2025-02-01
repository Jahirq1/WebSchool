<?php
session_start();
include '../backend/login/db.php'; 
include '../backend/login/User.php'; 

if (isset($_POST['username-r'])) {
    $username = $_POST['username-r'];
    $password = $_POST['password-r'];
    $passwordConfirm = $_POST['password-r1'];
    $role = $_POST['profesioni-r'];  

  
    if ($password !== $passwordConfirm) {
        echo "Fjalëkalimet nuk përputhen!";
    } else {
        $user = new User($username, $password, $role, $conn);
        $message = $user->register();
        echo $message;
    }
}

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['profesioni'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['profesioni'];  

    $user = new User($username, $password, $role, $conn);  // Dërgo 4 argumente

    $role = $user->login();
    
    if ($role) {
        if ($role == 'Arsimtar') {
            header("Location: ../Teacher/html/dashboard.php");
        } elseif ($role == 'Student') {
            header("Location: ../Studenti/html/dashboardS.php");
        } elseif ($role == 'Prind') {
            header("Location: ../Prind/html/dashboard.php");
        }
        exit;
    } else {
        $_SESSION['message'] = "Username ose fjalëkalimi janë të pasakta!";
        header("Location: login.php");
        exit;
    }
}
?>
<?php
if (isset($_SESSION['message'])) {
    echo "<script>
            alert('" . $_SESSION['message'] . "');
            </script>";
    unset($_SESSION['message']);
}
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../img/ubt-logo-img1.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>

</head>

<body>

    <div class="container">
        <div class="form-box login">
            <form action="login.php" method="POST" id="login-form">
                <h1>Login</h1>
                <select name="profesioni" id="profesioni" required>
                    <option value="">zgjedhni nje profesion</option>
                    <option value="Student">Student</option>
                    <option value="Arsimtar">Arsimtar</option>
                    <option value="Prind">Prind</option>
                </select>
                <div class="input-box">
                    <input type="text" name="username" id="username" placeholder="Shenoni emrin tuaj" required>
                    <i class="bx bxs-user"></i>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="Fjalekalimi" required>
                    <i class="bx bxs-lock-alt"></i>
                </div>


                <button type="submit" class="btn">Login</button>

            </form>

        </div>

        <div class="form-box register">
            <form action="login.php" method="POST" id="regjistrimi">
                <h1>Registration</h1>
                <select name="profesioni-r" id="profesioni-r" required>
                    <option value="">Zgjedhni nje profesion</option>
                    <option value="Student">Student</option>
                    <option value="Arsimtar">Arsimtar</option>
                    <option value="Prind">Prind</option>
                </select>
                <div class="input-box">
                    <input type="text" id="username-r" name="username-r" placeholder="Shenoni Emrin" required>
                </div>
                <div class="input-box">
                    <input type="password" id="password-r" name="password-r" placeholder="Fjalekalimi" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password-r1" id="password-r1" placeholder="Rishkruaj fjalkalimin"
                        required>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
        </div>


        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1 class="h1">Tung , Pershendetje!</h1>
                <p>Nuk keni nje llograri ?</p>
                <button class="btn register-btn">Register</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1 class="h1">Mire se vini!</h1>
                <p>keni nje llograri tashme ?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>
    </div>


    <script src="../js/login.js"></script>
</body>

</html>