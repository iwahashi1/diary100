
<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

//post送信されていた場合
if(!empty($_POST)){

    

    //変数にユーザー情報を代入
    $email = $_POST['email'];
    $pass = $_POST['pass'];

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
    $stmt = $dbh->prepare('SELECT * FROM users WHERE email = :email AND pass = :pass');

    //プレースホルダーに値をセットし、SQL文を実行
    $stmt->execute(array(':email' => $email, ':pass' => $pass));


    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //結果が０でない場合
    if(!empty($result)){
        
        //SESSIONを使うのにsession_start()を呼び出す
        session_start();

        //SESSION['login]に値を代入
        $_SESSION['login'] = true;

        //マイページへ遷移
        header("Location:mypage.php");
    }
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
            <li><a href="signup.php">ユーザー登録</a></li>
            <li><a href="login.php">ログイン</a></li>
        <?php
          }else{
        ?>
            <li><a href="mypage.php">マイページ</a></li>
            <li><a href="logout.php">ログアウト</a></li>
        <?php
          }
        ?>
      </ul>
    </nav>
  </div>
</header>
   
        <h1 class="login">ログイン</h1>
        <form action="login.php" method="post">
          <input type="text" name="email" placeholder="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email'] ?>">

          <input type="password" name="pass" placeholder="パスワード" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass'] ?>">

            <input type="submit" value="送信">
         </form>
         <!-- <a href="mypage.php">マイページへ</a> -->
         <!-- フッター -->
<footer id="footer">
  Copyright <a href="index.php">〇〇日記</a>. All Rights Reserved.
</footer>
    </body>
</html>
