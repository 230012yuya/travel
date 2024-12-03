<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// データベース接続設定
$host = 'localhost';
$db_username = "root";
$db_password = "";
$dbname = "travel";

$plan = $_SESSION['ai_plan']['plan'];
$plan['user_id'] = $_SESSION['user_id'];
$plan_schedule = $_SESSION['ai_plan']['plan_schedule'];

$info = "mysql:host=$host;dbname=$dbname;charset=utf8";

try {
    // PDOを使用してデータベースに接続
    $pdo = new PDO($info, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    var_dump($plan);
    // トランザクションを開始
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO plans (user_id, departure_point, destination, start_date, end_date, details, budget, number_of_people)
        VALUES (:user_id, :departure_point, :destination, :start_date, :end_date, :details, :budget, :number_of_people)");
    $stmt->execute($plan);

    // 新しく作成されたplanのIDを取得
    $planId = $pdo->lastInsertId();

    // plan_itemsテーブルにデータをINSERT
    $stmt = $pdo->prepare("
        INSERT INTO plan_schedule (plan_id, day, time, activity)
        VALUES (:plan_id, :day, :time, :activity)
    ");

    foreach ($plan_schedule as $item) {
        $item['plan_id'] = $planId;
        $stmt->execute($item);
    }

    // トランザクションをコミット
    $pdo->commit();

    // 成功メッセージを返却
    echo json_encode(['message' => 'Plan and items saved successfully', 'planId' => $planId]);
} catch (PDOException $e) {
    // エラーが発生した場合はロールバック
    $pdo->rollBack();
    http_response_code(500); // 内部サーバーエラー
    echo json_encode(['message' => 'Failed to save plan', 'error' => $e->getMessage()]);
}
?>
