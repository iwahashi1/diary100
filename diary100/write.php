
<?php

error_reporting(E_ALL);
ini_set('display_errors','On');


//post送信されていた場合
if(!empty($_POST)){

    

    //変数に日記情報を代入
    $title = $_POST['title'];
    $text = $_POST['text'];

    //DBへの接続準備
    $dsn = 'mysql:dbname=diary;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $options = array(
        //SQL実行失敗時に例外をスロー
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //デフォルトフェッチモードを連想配列形式に設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        //バッファードクエリを使う（一度に結果セットを全て取得し、サーバー負荷を軽減）
        //SELECTで得た結果に対してもrowCountメソッドを使えるようにする
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );

    //PDOオブジェクト生成(DBへ接続)
    $dbh = new PDO($dsn, $user, $password, $options);

    //SQL文（クエリー作成）
    $stm = $dbh->prepare('INSERT INTO article(title,text,login_time)VALUES(:title,:text,:login_time');
    

    //プレースホルダーに値をセットし、SQL文を実行
    $stm->bindValue(':title',$title,PDO::PARAM_STR);
    $stm->bindValue(':text',$text,PDO::PARAM_STR);

    //投稿しましたページへ遷移
    $stm->execute(array(':title' => $title, ':text' => $text,':login_time' => date('Y-m-d H:i:s')));
    header("Location:wrote.php");

     

    //結果が０でない場合
    //  if(!empty($result)){
        
    //     //SESSIONを使うのにsession_start()を呼び出す
    //      session_start();

    //     //SESSION['login]に値を代入
    //      $_SESSION['login'] = true;

    //     //マイページへ遷移
    //      header("Location:mypage.php");
    // }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ホームページのタイトル</title>
        <link rel="stylesheet" href="style.css">
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet'>
     
    </head>
<body>
    <h1><a href="index.php">〇〇日記</a></h1>
    <nav id="top-nav">
      <ul>
        <?php
          if(empty($_SESSION['user_id'])){
        ?>
            <li><a href="mypage.php">マイページ</a></li>
            <li><a href="logout.php">ログアウト</a></li>
        <?php
          }else{
        ?>
            <!-- <li><a href="mypage.php">マイページ</a></li> -->
            <!-- <li><a href="logout.php">ログアウト</a></li> -->
        <?php
          }
        ?>
      </ul>
    </nav>
  </div>
</header>
   <main>
        <h1 class="login">日記を書く</h1>
        <form action="write.php" method="post">
          <input type="text" class="write-text" name="title" placeholder="タイトル" value="">
          <textarea rows="50" cols="50" name="text" value="" placeholder="本文"></textarea>

        <input type="submit" value="送信">
         </form>
         <!-- <a href="mypage.php">マイページへ</a> -->
    </main>
         <!-- フッター -->
<footer id="footer">
  Copyright <a href="index.php">〇〇日記</a>. All Rights Reserved.
</footer>
    </body>
</html>
