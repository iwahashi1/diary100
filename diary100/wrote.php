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
        <h1 class="login">日記を投稿しました</h1>
       
        
         <!-- <a href="mypage.php">マイページへ</a> -->
    </main>
         <!-- フッター -->
<footer id="footer">
  Copyright <a href="index.php">〇〇日記</a>. All Rights Reserved.
</footer>
    </body>
</html>
