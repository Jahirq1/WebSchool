<?php


require_once('../../backend/Teacher/chat/Message.php');
require_once('../../backend/Teacher/chat/User.php');
require_once('../../backend/Teacher/chat/chat.php');


include('../../backend/login/db.php');  

session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../html/login.php");  
    exit();
}

$professor_id = $_SESSION['user_id'];  
$prind_id = isset($_GET['prind_id']) ? $_GET['prind_id'] : null; 

if ($prind_id) {
    if (!User::checkUserExists($conn, $prind_id)) {
        echo "Prindi nuk ekziston.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $photo = $_FILES['photo'];  

    if ($photo['error'] == 0) {
        $photoName = time() . '_' . basename($photo['name']);
        $photoPath = '../../uploads/' . $photoName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($photo['type'], $allowedTypes)) {
            if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
                $chat = new Chat($conn, $professor_id, $prind_id);
                if ($chat->sendChatMessage($message, $photoPath)) {
                    header("Location: chatRealTime.php?prind_id=$prind_id"); 
                } else {
                    echo "Ka ndodhur një gabim gjatë dërgimit të mesazhit.";
                }
            } else {
                echo "Gabim gjatë ngarkimit të fotos.";
            }
        } else {
            echo "Lloji i file-it nuk është i lejuar.";
        }
    } else {
        if (!empty($message)) {
            $chat = new Chat($conn, $professor_id, $prind_id);
            if ($chat->sendChatMessage($message)) {
                header("Location: chatRealTime.php?prind_id=$prind_id"); 
            } else {
                echo "Ka ndodhur një gabim gjatë dërgimit të mesazhit.";
            }
        } else {
            echo "Mesazhi është bosh.";
        }
    }
}

?>


<?php
if (isset($_GET['logout'])) {

    session_unset(); 
    session_destroy(); 
    header("Location: ../../html/login.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../icon/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="stylesheet" href="../css/chat2.css">
    <title>Chat_UBT</title>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="iconn">
                            <img src="../icon/ubt.png" alt="">
                        </span>
                        <span class="title">UBT</span>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php">
                        <span class="icon">
                            <img src="../icon/home.png" alt="">
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="Smis.php">
                        <span class="icon" style="margin-top:15px;">
                            <img src="../icon/report.png" alt="">
                        </span>
                        <span class="title">Smis</span>
                    </a>
                </li>

                <li>
                    <a href="Lendet.php">
                        <span class="icon" style="margin-top:15px;">
                         <img src="../icon/book.png" alt="">
                        </span>
                        <span class="title">Lendet</span>
                    </a>
                </li>
                <li>
                    <a href="chat.php">
                        <span class="icon">
                            <img src="../icon/chat.png" alt="">
                        </span>
                        <span class="title">Info</span>
                    </a>
                </li>
                <li>
                    <a href="?logout=true">
                        <span class="icon">
                            <img src="../icon/log-out.png" alt="">
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <img src="../icon/menu.png" alt="">
                </div>

                <div class="user">
                    <a href="profile.php">
                        <img src="../icon/user.png">
                    </a>
                </div>
            </div>

            <section class="chat-area">
                <div class="chat-box">
                <?php
$sqlMessages = "SELECT * FROM mesazhet WHERE (sender_id = '$professor_id' AND receiver_id = '$prind_id') 
                OR (sender_id = '$prind_id' AND receiver_id = '$professor_id') 
                ORDER BY timestamp ASC";
$query = mysqli_query($conn, $sqlMessages);

if (!$query) {
    echo "Gabim në ekzekutimin e query-t: " . mysqli_error($conn);
    exit();
}

while ($row = mysqli_fetch_assoc($query)) {
    $sender_id = $row['sender_id'];

    $sqlSender = "SELECT username FROM users WHERE id = '$sender_id'";
    $senderQuery = mysqli_query($conn, $sqlSender);
    $sender = mysqli_fetch_assoc($senderQuery);
    $sender_username = $sender ? $sender['username'] : "Përdoruesi i panjohur";  

    if ($row['sender_id'] === $prind_id) {
        echo '<div class="chat outgoing">
                <div class="details">
                    <p><strong>' . htmlspecialchars($sender_username) . ':</strong> ' . htmlspecialchars($row['message']) . '</p>';
        if (isset($row['message_image']) && !empty($row['message_image'])) {
            echo '<img src="' . $row['message_image'] . '" alt="Image" class="chat-photo">';
        }
        echo '</div></div>';
    } else {
        echo '<div class="chat incoming">
                <div class="details">
                    <p><strong>' . htmlspecialchars($sender_username) . ':</strong> ' . htmlspecialchars($row['message']) . '</p>';
        if (isset($row['message_image']) && !empty($row['message_image'])) {
            echo '<img src="' . $row['message_image'] . '" alt="Image" class="chat-photo">';
        }
        echo '</div></div>';
    }
}
?>

                </div>
                
            </section>
            <form class="typing-area" method="POST" enctype="multipart/form-data">
                <label for="photoid" style="margin-bottom:10px; width:60px; height:30px; border-radius:4px; padding-top:5px; text-align:center; background-color:green; color:white;">Photo<input type="file" id="photoid" name="photo" class="photo-input" accept="image/*" style="width:20px; display:none;"></label>
                <input type="text" name="message" class="input-field" placeholder="Type a message here....">
                <button class="send_btn" type="submit"><img src="../icon/send.svg" alt=""></button>
            </form>

        </div>
    </div>

    <script>
   
    function scrollToBottom() {
        var chatBox = document.querySelector('.chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    window.onload = function() {
        scrollToBottom();
    };

    document.querySelector('.typing-area').addEventListener('submit', function() {
        setTimeout(scrollToBottom, 100); 
    });
</script>

<script src="../script/dashboard.js"></script>
</body>
</html>
