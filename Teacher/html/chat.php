<?php
include('../../backend/login/db.php'); 

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../html/login.php");
    exit();
}

class ParentSearch {
    private $conn;
    private $searchQuery;

    public function __construct($conn, $searchQuery) {
        $this->conn = $conn;
        $this->searchQuery = $searchQuery;
    }

    public function searchParents() {
        $sql = "SELECT u.username, u.id AS prind_id
                FROM users u
                JOIN prind p ON u.id = p.user_id
                WHERE u.username LIKE ? AND u.role = 'Prind'";

        if ($stmt = $this->conn->prepare($sql)) {
            $likeQuery = "%" . $this->searchQuery . "%";  
            $stmt->bind_param("s", $likeQuery);
            $stmt->execute();
            return $stmt->get_result();
        }
        return null;
    }
}

$searchQuery = '';
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
}

$parentSearch = new ParentSearch($conn, $searchQuery);
$result = $parentSearch->searchParents();

if (isset($_GET['logout'])) {
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
    <title>Sistemi-Chat-UBT</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .kliko {
            color: orange;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="dashboard.php">
                        <span class="iconn">
                            <img src="../icon/ubt.png" alt="">
                        </span>
                        <span class="title">UBT</span>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php">
                        <span class="icon" style="margin-top:15px;">
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
                        <span class="icon" style="margin-top:15px;">
                            <img src="../icon/chat.png" alt="">
                        </span>
                        <span class="title">info</span>
                    </a>
                </li>
                <li>
                    <a href="?logout=true">
                        <span class="icon" style="margin-top:15px;">
                            <img src="../icon/log-out.png" alt="">
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!---======================== Pjesa e main ======================================== --->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <img src="../icon/menu.png" >
                </div>
                <div class="search">
                    <form method="GET" action="">
                        <label>
                            <input type="text" name="search_query" placeholder="Kerko Prindin" value="<?php echo isset($_GET['search_query']) ? $_GET['search_query'] : ''; ?>">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </form>
                </div>
                
                <div class="user">
                    <a href="profile.php">
                        <img src="../icon/user.png">
                    </a>
                </div>
            </div>
            
            <!-- Pjesa e vizitave -->
            <div class="Vizitat">
                <div class="Aktive">
                    <div class="Top">
                        <h2>Lista e Prindërve</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Emri i Prindit</td>
                                <td>Kontakto Prindin</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($result) && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                    echo "<td><a href='chatRealTime.php?prind_id=" . $row['prind_id'] . "' class='kliko'>Kontakto Prindin</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>Nuk u gjetën prindër për këtë kërkim.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   <script src="../script/dashboard.js"></script>
</body>
</html>
