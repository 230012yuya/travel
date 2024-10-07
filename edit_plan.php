<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

if (isset($_GET['plan_id'])) {
    $plan_id = $_GET['plan_id'];

    // プランの詳細を取得
    $sql = "SELECT * FROM plans WHERE id='$plan_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $plan = $result->fetch_assoc();
    } else {
        echo "指定されたプランは存在しません。";
        exit;
    }
} else {
    echo "プランが指定されていません。";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // フォームからのデータを受け取って更新する
    $departure_point = $_POST['departure_point'];
    $destination = $_POST['destination'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $number_of_people = $_POST['number_of_people'];
    $budget = $_POST['budget'];
    $details = $_POST['details'];

    $update_sql = "UPDATE plans SET departure_point=?, destination=?, start_date=?, end_date=?, number_of_people=?, budget=?, details=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssiisi", $departure_point, $destination, $start_date, $end_date, $number_of_people, $budget, $details, $plan_id);

    if ($stmt->execute() === TRUE) {
        header("Location: view_plans.php"); // 更新が成功したらプラン表示ページにリダイレクト
        exit;
    } else {
        echo "エラー: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>プラン編集</title>
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

        .plan-detail {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px; /* パディングを増やして余白を調整 */
            background-color: rgba(255, 255, 255, 0.9); /* 半透明の白 */
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* シャドウを少し強く */
            transition: box-shadow 0.3s; /* ホバー時のエフェクト */
        }

        .plan-detail:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3); /* ホバー時のシャドウ */
        }

        h1 {
            text-align: center;
            color: #ff6b6b; /* カラフルな赤 */
            font-size: 30px; /* タイトルサイズ */
            margin-bottom: 30px;
        }

        label {
            font-weight: bold; /* ラベルを太字に */
            margin-bottom: 5px; /* ラベルと入力フィールドの間に余白 */
            display: block; /* ラベルをブロック要素にして、各フィールドの上に配置 */
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%; /* 幅を100%にして全体を占める */
            padding: 10px; /* パディングを追加 */
            margin-bottom: 20px; /* フィールド間に余白 */
            border: 1px solid #ccc; /* ボーダーを追加 */
            border-radius: 5px; /* 角を丸く */
            font-size: 16px; /* フォントサイズを調整 */
            transition: border-color 0.3s; /* ボーダーの色変更を滑らかに */
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            border-color: #ff6b6b; /* フォーカス時のボーダーカラー */
            outline: none; /* デフォルトのアウトラインを消す */
        }

        input[type="submit"] {
            background-color: #ff6b6b; /* ボタンの背景色 */
            color: white; /* ボタンの文字色 */
            padding: 10px 15px; /* ボタンのパディング */
            border: none; /* ボーダーをなしに */
            border-radius: 5px; /* 角を丸く */
            cursor: pointer; /* ポインターをカーソルに */
            font-size: 16px; /* フォントサイズを調整 */
            transition: background-color 0.3s; /* ホバー時のエフェクト */
        }

        input[type="submit"]:hover {
            background-color: #ffd93d; /* ホバー時のボタン色 */
        }

        a {
            display: inline-block; /* リンクをインラインブロックに */
            margin-top: 20px; /* リンクの上に余白 */
            color: #007bff; /* リンクの色 */
            text-decoration: none; /* 下線を消す */
            font-weight: bold; /* 太字 */
        }

        a:hover {
            text-decoration: underline; /* ホバー時に下線を表示 */
        }
    </style>
</head>
<body>
    <div class="plan-detail">
        <h1>プラン編集</h1>
        <form method="POST" action="">
            <label for="departure_point">出発地点:</label>
            <input type="text" name="departure_point" value="<?php echo isset($plan['departure_point']) ? $plan['departure_point'] : ''; ?>" required>

            <label for="destination">目的地:</label>
            <input type="text" name="destination" value="<?php echo isset($plan['destination']) ? $plan['destination'] : ''; ?>" required>

            <label for="start_date">出発日:</label>
            <input type="date" name="start_date" value="<?php echo isset($plan['start_date']) ? $plan['start_date'] : ''; ?>" required>

            <label for="end_date">帰着日:</label>
            <input type="date" name="end_date" value="<?php echo isset($plan['end_date']) ? $plan['end_date'] : ''; ?>" required>

            <label for="number_of_people">人数:</label>
            <input type="number" name="number_of_people" value="<?php echo isset($plan['number_of_people']) ? $plan['number_of_people'] : ''; ?>" required>

            <label for="budget">予算:</label>
            <input type="number" name="budget" value="<?php echo isset($plan['budget']) ? $plan['budget'] : ''; ?>" required>

            <label for="details">詳細:</label>
            <textarea name="details" required><?php echo isset($plan['details']) ? $plan['details'] : ''; ?></textarea>

            <input type="submit" value="更新する">
        </form>
        <a href="view_plans.php">戻る</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>
