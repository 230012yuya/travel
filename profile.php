<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE user SET name='$name', email='$email' WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "プロフィールが更新されました";
    } else {
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT name, email FROM user WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ホーム</title>
<link rel="stylesheet" href="styles.css">
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .navbar {
        overflow: hidden;
        background-color: #333;
    }
    .navbar a {
        float: left;
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }
    .navbar .icon {
        display: none;
    }
    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }
    @media screen and (max-width: 600px) {
        .navbar a:not(:first-child) {display: none;}
        .navbar a.icon {
            float: right;
            display: block;
        }
    }
    @media screen and (max-width: 600px) {
        .navbar.responsive {position: relative;}
        .navbar.responsive .icon {
            position: absolute;
            right: 0;
            top: 0;
        }
        .navbar.responsive a {
            float: none;
            display: block;
            text-align: left;
        }
    }

    /* フォームのスタイル */
    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }
    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }

    /* プロフィール画像のスタイル */
    .profile-image {
        width: 120px; /* 大きさを調整 */
        height: 120px; /* 大きさを調整 */
        border-radius: 50%;
        border: 2px solid #ddd;
        object-fit: cover; /* 画像が切り取られるのを防ぐ */
        margin-bottom: 15px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    /* ユーザー名を中央に配置 */
    .profile-header {
        text-align: center;
    }
</style>
</head>
<body>
    <div class="navbar" id="myNavbar">
        <a href="home.php">ホーム</a>
        <a href="create_plan.php">旅行プラン作成</a>
        <a href="view_plans.php">旅行プラン表示</a>
        <a href="profile.php">プロフィール</a>
        <a href="view_plans.php">過去の旅行プラン</a>
        <!-- ログアウトボタン -->
        <a href="javascript:void(0);" onclick="confirmLogout()">ログアウト</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            &#9776;
        </a>
    </div>
    <main>
        <h1>プロフィール</h1>
        
        <!-- ユーザーアイコンと名前の表示 -->
        <div class="profile-header">
            <img src="uploads/default.png" alt="" class="profile-image">
            <h2><?php echo $user['name']; ?></h2>
        </div>

        <form action="profile.php" method="post">
            <label for="name">ユーザー名:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            
            <label for="email">自己紹介文:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            
            <button type="submit">更新</button>
        </form>
    </main>
    <script>
        function myFunction() {
            var x = document.getElementById("myNavbar");
            if (x.className === "navbar") {
                x.className += " responsive";
            } else {
                x.className = "navbar";
            }
        }

        // ログアウト確認ダイアログ
        function confirmLogout() {
            var confirmation = confirm("本当にログアウトしますか？");
            if (confirmation) {
                window.location.href = "logout.php"; // OKが押された場合はログアウト
            }
        }
    </script>
</body>
</html>
<?php
$conn->close();
?>
