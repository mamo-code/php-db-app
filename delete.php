<?php
$dsn = 'mysql:dbname=php_db_app;host=localhost;charset=utf8mb4;port=3309';
$user = 'root';
$password = '';

if (isset($_GET['id'])) {
  try {
    $pdo = new PDO($dsn, $user, $password);

    // idカラムの値をプレースホルダ（:id）に置き換えたSQL文をあらかじめ用意する
    $sql_delete_product = 'DELETE FROM products WHERE id = :id';
    $stmt_delete_product = $pdo->prepare($sql_delete_product);
    $stmt_delete_product->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt_delete_product->execute();

    $count = $stmt_delete_product->rowCount();
    $message = "商品を{$count}件削除しました";

    $product = $stmt_delete_product->fetch(PDO::FETCH_ASSOC);

    header("Location: read.php?message={$message}");

    if ($product === FALSE) {
      echo 'idパラメータの値が不正です';
    }

  } catch (PDOException $e) {
    exit($e->getmessage());
  }

} else {
  // idパラメータの値が存在しない場合はエラーメッセージを表示して処理を停止する
  exit('idパラメータの値が存在しません。');
}

?>