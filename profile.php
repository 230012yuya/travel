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
    <title>プロフィール</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f9ff; /* 柔らかいパステルブルー */
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(50, 50, 70, 0.9); /* 少し濃い目の背景 */
            padding: 0 15px;
            font-size: 18px;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ffb6b9; /* 柔らかいピンク */
            color: #fff;
            transform: scale(1.05); /* ホバー時の動き */
        }

        /* Traveeelタイトル */
        .title {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 50px;
            font-weight: bold;
            background: linear-gradient(45deg, #ff6b6b, #ffd93d, #6bc9ff);
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .title:hover {
            transform: scale(1.1) rotate(5deg);
            text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.5);
        }

        main {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* 半透明の背景 */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ff6b6b; /* カラフルな赤 */
            font-size: 28px;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        input[type="text"],
        input[type="email"] {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ffb6b9; /* カラフルなピンク */
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #ff6b6b; /* カラフルな赤 */
        }

        button {
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            background-color: #ff6b6b; /* カラフルな赤 */
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: #ffd93d; /* 明るい黄色に変更 */
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:active {
            background-color: #ff6b6b;
            transform: scale(1.02);
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
        <a href="javascript:void(0);" onclick="confirmLogout()">ログアウト</a>
    </div>

    <!-- Traveeelのタイトル -->
    <div class="title">Traveeel</div>

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
