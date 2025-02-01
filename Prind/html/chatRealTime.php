<?php

include('../../backend/login/db.php');


session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../html/login.php");
    exit();
}

$prindId = $_SESSION['user_id'];
$professorId = isset($_GET['professor_id']) ? $_GET['professor_id'] : null;

function sendMessage($senderId, $receiverId, $messageContent, $photo = null) {
    global $conn;

  
    if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
    
        $photoName = time() . '_' . basename($photo['name']);
        $photoPath = '../../uploads/' . $photoName;
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($photo['type'], $allowedTypes)) {
        

            if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
               
                $query = "INSERT INTO mesazhet (sender_id, receiver_id, message, message_image) 
                          VALUES ('$senderId', '$receiverId', '$messageContent', '$photoPath')";
                if (!mysqli_query($conn, $query)) {
                    echo "Ka ndodhur një gabim gjatë dërgimit të mesazhit.";
                }
            } else {
                echo "Gabim gjatë ngarkimit të fotos.";
            }
        } else {
            echo "Lloji i file-it nuk është i lejuar. Ju lutemi ngarkoni një imazh JPEG, PNG ose GIF.";
        }
    } else {
       
        if (!empty($messageContent)) {
            $query = "INSERT INTO mesazhet (sender_id, receiver_id, message) 
                      VALUES ('$senderId', '$receiverId', '$messageContent')";
            if (!mysqli_query($conn, $query)) {
                echo "Ka ndodhur një gabim gjatë dërgimit të mesazhit.";
            }
        } else {
            echo "Mesazhi është bosh.";
        }
    }
}


function getMessages($professorId, $prindId) {
    global $conn;
    
    $sql = "SELECT mesazhet.*, sender.username AS sender_username, receiver.username AS receiver_username
            FROM mesazhet
            LEFT JOIN users AS sender ON mesazhet.sender_id = sender.id
            LEFT JOIN users AS receiver ON mesazhet.receiver_id = receiver.id
            WHERE (sender_id = '$professorId' AND receiver_id = '$prindId') 
            OR (sender_id = '$prindId' AND receiver_id = '$professorId') 
            ORDER BY timestamp ASC";
    $query = mysqli_query($conn, $sql);
    
    if (!$query) {
        echo "Gabim në ekzekutimin e query-t: " . mysqli_error($conn);
        exit();
    }

    $messages = ['incoming' => [], 'outgoing' => []];
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['sender_id'] === $prindId) {
            $messages['outgoing'][] = $row;
        } else {
            $messages['incoming'][] = $row;
        }
    }

    return $messages;
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $messageContent = mysqli_real_escape_string($conn, $_POST['message']);
    $photo = $_FILES['photo'];
    sendMessage($prindId, $professorId, $messageContent, $photo);
}


$messages = getMessages($professorId, $prindId);
?>
<?php if (isset($_GET['logout'])) {
   
    session_unset();  
    session_destroy(); 
    header("Location: ../../html/login.php"); 
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../icon/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="stylesheet" href="../css/biseda.css">
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
                            <img src="../icon/home.png" style="margin-top:15px;">
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="chat.php">
                        <span class="icon">
                            <img src="../icon/chat.png" style="margin-top:15px;">
                        </span>
                        <span class="title">Info</span>
                    </a>
                </li>
                <li>
                    <a href="?logout=true">
                        <span class="icon">
                            <img src="../icon/log-out.png" style="margin-top:15px;">
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

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
                    <?php foreach ($messages['incoming'] as $message): ?>
                        <div class="chat incoming">
                            <div class="details">
                                <p><strong><?php echo htmlspecialchars($message['sender_username']); ?>:</strong> <?php echo htmlspecialchars($message['message']); ?></p>
                                <?php if (isset($message['message_image']) && !empty($message['message_image'])): ?>
                                    <img src="<?php echo $message['message_image']; ?>" alt="Image" class="chat-photo">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php foreach ($messages['outgoing'] as $message): ?>
                        <div class="chat outgoing">
                            <div class="details">
                                <p><strong><?php echo htmlspecialchars($message['receiver_username']); ?>:</strong> <?php echo htmlspecialchars($message['message']); ?></p>
                                <?php if (isset($message['message_image']) && !empty($message['message_image'])): ?>
                                    <img src="<?php echo $message['message_image']; ?>" alt="Image" class="chat-photo">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <form class="typing-area" method="POST" enctype="multipart/form-data">
                    <label for="photoid" style=" margin-bottom:10px; width:60px; height:30px; border-radius:4px; padding-top:5px; text-align:center; background-color:green; color:white;">Photo
                        <input type="file" id="photoid" name="photo" class="photo-input" accept="image/*" style="width:20px; display:none;">
                    </label>
                    <input type="text" name="message" class="input-field" placeholder="Type a message here....">
                    <button class="send_btn" type="submit"><img src="../icon/send.svg" alt=""></button>
                </form>
            </section>
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
        document.getElementById("photoid").addEventListener("change", function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.createElement("img");
                    preview.src = e.target.result;
                    preview.classList.add("chat-photo");
                    document.querySelector(".typing-area").appendChild(preview);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script src="../script/dashboard.js"></script>
</body>
</html>
