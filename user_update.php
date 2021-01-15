<?php

session_start();
include("funcs.php");
// loginCheck();

//1.POSTでid,name,email,naiyouを取得

$bookName = $_POST["bookName"];
$bookUrl = $_POST["bookUrl"];
$bookComment = $_POST["bookComment"];
$id = $_POST["id"];


//2.DB接続
$pdo = db_connect();


//3.UPDATE gs_an_table SET ....; で更新(bindValue)
$sql = 'UPDATE gs_bm_table SET bookName=:bookName,bookUrl=:bookUrl,bookComment=:bookComment WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':bookName',   $bookName,   PDO::PARAM_STR);
$stmt->bindValue(':bookUrl',  $bookUrl,  PDO::PARAM_STR);
$stmt->bindValue(':bookComment', $bookComment, PDO::PARAM_STR);
$stmt->bindValue(':id',     $id,     PDO::PARAM_INT);    //更新したいidを渡す
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  //select.phpへリダイレクト
  header("Location: select.php");
  exit;

}



?>
