<?php

session_start();
include("funcs.php");
// loginCheck();

$id = $_GET["id"];

//1. DB接続します
$pdo = db_connect();

$sql = "SELECT * FROM gs_user_table WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

$view = "";
if($status==false){
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
} else {
  $row = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/main.css">
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style> -->
</head>
<body>

<main class="main">
  <div class="container">
    <!-- Head[Start] -->
    <header>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="user_select.php">データ一覧</a>
            <!-- <a class="navbar-brand" href="index.php">データ登録</a> -->
            <!-- <a class="navbar-brand" href="index.html">ログアウト</a> -->
          </div>
        </div>
      </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div class="form-wrapper2">
      <h1 class="form_title">ユーザー登録</h1>
      <form method="post" action="insert.php">
        <dl class="form-inner">
          <dt class="form-title_reg">名前：</dt>
          <dd class="form-item_reg"><input class="input_reg" type="text" name="name" value="<?=$row['name']?>" required></dd>
          <dt class="form-title_reg">ID：</dt>
          <dd class="form-item_reg"><input class="input_reg" type="text" name="lid" value="<?=$row['lid']?>" required></dd>
          <dt class="form-title_reg">PASSWORD：</dt>
          <dd class="form-item_reg"><input class="input_reg" type="text" name="lpw" value="<?=$row['lpw']?>" required></dd>
          <div style="display:block;">
            <div style="display: flex; margin: 0 0 10px 0">
              <dd><input type="radio" name="kanri_flg" value="0" checked>管理者：</dd>
              <dd><input type="radio" name="kanri_flg" value="1">スーパー管理者：</dd>
            </div>
            <div style="display: flex;">
              <dd><input type="radio" name="life_flg" value="0" checked>退社：</dd>
              <dd><input type="radio" name="life_flg" value="1">出社：</dd>
            </div>
          </div>
        </dl>
        <input class="sub_btn" type="submit" value="登録"><input class="sub_btn" type="reset" value="リセット">
      </form>
    </div>
  </div>
  <input type="radio">
</main>
<!-- Main[End] -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
