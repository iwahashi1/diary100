
<!DOCTYPE html>
  <html lang="ja">

  <head>
  <meta charset="utf-8">
  <title>〇〇日記</title>
  <link rel="stylesheet" href="style.css">
  <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet'>
  </head>
<body>
    <!-- ヘッダー -->
  <header>
  <div class="site-width">
    <h1><a href="index.php">〇〇日記</a></h1>
    <nav id="top-nav">
      <ul>
        <?php
          if(empty($_SESSION['user_id'])){
        ?>
            <li><a href="signup.php" >ユーザー登録</a></li>
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
<!-- メイン -->

<!-- フッター -->
<footer id="footer">
  Copyright <a href="index.php">〇〇日記</a>. All Rights Reserved.
</footer>

</body>
</html>