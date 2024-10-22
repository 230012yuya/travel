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

// お気に入りの数を制限するためのクエリ
$favorites_sql = "SELECT COUNT(*) AS favorite_count FROM user_favorites WHERE user_id='$user_id'";
$favorites_result = $conn->query($favorites_sql);
$favorites_count = $favorites_result->fetch_assoc()['favorite_count'];

// お気に入りを追加する処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($favorites_count < 3) {
        $plan_id = $_POST['plan_id'];
        $insert_sql = "INSERT INTO user_favorites (user_id, plan_id) VALUES ('$user_id', '$plan_id')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('お気に入りに追加しました。');</script>";
        } else {
            echo "エラー: " . $conn->error;
        }
    } else {
        echo "<script>alert('お気に入りは最大3つまで選択できます。');</script>";
    }
}

// ユーザーのプランを取得
$sql = "SELECT id, destination, start_date, end_date, created_at FROM plans WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅行プラン表示</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen font-sans text-gray-800">
    <?php include ('components/main_menu.php') ?>

    <main class="container mx-auto p-6 bg-white rounded-lg shadow-md my-12">
        <h1 class="text-2xl font-bold text-center text-red-500 mb-6">過去の旅行プラン</h1>
        <ul class="space-y-4">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='bg-blue-100 p-4 rounded-lg relative'>";
                    echo "<p class='mb-2'>作成日: " . $row['created_at'] . "</p>";
                    echo "<p class='mb-2'>目的地: " . $row['destination'] . "</p>";
                    echo "<p class='mb-2'>旅行日程: " . $row['start_date'] . " ~ " . $row['end_date'] . "</p>";
                    
                    // プラン詳細リンク
                    echo "<a href='plan_detail.php?plan_id=" . $row['id'] . "' class='text-blue-500 hover:text-blue-700'>詳細を見る</a>";

                    // お気に入りボタンをハートアイコンに変更
                    echo "<form action='add_favorite.php' method='post' class='absolute top-2 right-2'>";
                    echo "<input type='hidden' name='plan_id' value='" . $row['id'] . "'>";
                    echo "<button class='bg-pink-500 text-white rounded-full p-2 hover:bg-pink-600 focus:outline-none'><i>❤️</i>追加</button>";
                    echo "</form>";
                    echo "</li>";
                }
            } else {
                echo "<p class='text-center text-gray-600'>作成したプランはありません。</p>";
            }
            $conn->close();
            ?>
        </ul>
    </main>

    <script>
        function confirmLogout() {
            var confirmation = confirm("本当にログアウトしますか？");
            if (confirmation) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>
</html>
