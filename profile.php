<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel_plan_db";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; // これを取得するために、ログイン時にユーザーIDもセッションに保存する必要があります
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "UPDATE users SET username='$name', email='$email' WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "プロフィールが更新されました";
    } else {
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT username, email FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home.php">ホーム</a></li>
                <li><a href="create_plan.php">旅行プラン作成</a></li>
                <li><a href="view_plans.php">旅行プラン表示</a></li>
                <li><a href="profile.php">プロフィール</a></li>
                <li><a href="past_plans.php">過去の旅行プラン</a></li>
                <li><a href="logout.php">ログアウト</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>プロフィール</h1>
        <form action="profile.php" method="post">
            <label for="name">ユーザー名:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['username']; ?>" required>
            
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            
            <button type="submit">更新</button>
        </form>
    </main>
</body>
</html>
<?php
$conn->close();
?>
