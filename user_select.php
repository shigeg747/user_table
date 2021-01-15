<?php

session_start();
include("funcs.php");
// loginCheck();

//1. DB接続します
$pdo = db_connect();



//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("エラー:".$error[2]);

} else {


  //Selectデータの数だけ自動でループしてくれる
  $view = "";
    $query = "SELECT * FROM gs_user_table";
    $result = $pdo->query($query);
    foreach ($result as $row) {
      $kanri = $row['kanri_flg'];
      $life = $row['life_flg'];

      $view .= "<tr>";
      $view .= "<td class='list_item'>".$row['name']."</td>";
      $view .= "<td class='list_item'>".$row['lid']."</td>";
      $view .= "<td class='list_item'>".$row['lpw']."</td>";
      if($kanri == 0){
        $view .= "<td class='list_item'>管理者</td>";
      } else {
        $view .= "<td class='list_item'>スーパー管理者</td>";
      }
      if($life == 0){
        $view .= "<td class='list_item'>退社</td>";
      } else {
        $view .= "<td class='list_item'>出社</td>";
      }
      $view .= "<td class='list_item'>";
      $view .= '<a class="aaa" href="user_update_view.php?id='.$row['id'].'">';
      $view .= '修正';
      $view .= '</a>'."</td>";
      $view .= "<td class='list_item'>";
      $view .= '<a class="aaa" href="delete.php?id='.$row['id'].'">';
      $view .= '削除';
      $view .= '</a>'."</td>";
      $view .= "</tr>";
    }
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー一覧</title>
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/main.css">

</head>
<body>
<main class="main">
  <div class="container">

    <!-- Head[Start] -->
    <header>
      <nav class="navbar navbar-default">
        <div class="container-fluid" style="position:relative;">
          <div class="navbar-header">
            <!-- <a class="navbar-brand aaa" href="user_select.php"> User一覧</a> -->
            <a class="navbar-brand aaa" href="index.php">User登録</a>
            <!-- <a class="navbar-brand aaa" href="logout.php">ログアウト</a> -->
          </div>
        </div>
      </nav>
    </header>
    <!-- Head[End] -->
    <div class="space"></div>
    <!-- Main[Start] -->
    <table class="table">
      <thead>
        <tr>
          <th class="txcenter">user_name</th>
          <th class="txcenter">user_Id</th>
          <th class="txcenter">user_Password</th>
          <th class="txcenter">社員ステータス</th>
          <th class="txcenter">就業状態</th>
          <th class="txcenter">修正</th>
          <th class="txcenter">削除</th>
        </tr>
      </thead>
      <tbody>
        <?=$view?>
      </tbody>
    </table>

  </div>
</main>

<!-- Main[End] -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
