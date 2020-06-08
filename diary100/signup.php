
<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

//post送信されていた場合表示するコメント一覧
if(!empty($_POST)){    
    define('MSG01','入力必須です');
  define('MSG02', 'Emailの形式で入力してください');
  define('MSG03','パスワード（再入力）が合っていません');
  define('MSG04','半角英数字のみご利用いただけます');
  define('MSG05','6文字以上で入力してください');

//配列＄err_msgを用意
  $err_msg = array();

  //フォームが入力されていない場合に出す
  if(empty($_POST['email'])){
      $err_msg['email'] = MSG01;
  }
  if(empty($_POST['pass'])){
      $err_msg['pass'] = MSG01;
  }
  if(empty($_POST['pass_retype'])){
      $err_msg['pass_retype'] = MSG01;
  }
  

  //変数にユーザー情報を代入。サニタイズ（htmlspcialchars ENT_QUOTES）入り
  if(empty($err_msg)){
      $email = htmlspecialchars($_POST['email'],ENT_QUOTES);
      $pass = htmlspecialchars($_POST['pass'],ENT_QUOTES);
      $pass_re = htmlspecialchars($_POST['pass_retype'],ENT_QUOTES);

      //emailの形式でない場合
      if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
        $err_msg['email'] = MSG02;
      }
      //パスワードとパスワード再入力が合っていない場合
      if($pass !== $pass_re){
          $err_msg['pass'] = MSG03;
      }
      if(empty($err_msg)){
          //パスワードとパスワード再入力が半角英数字でない場合 ←パスワードと再入力があっていたらチェックすると手間が省ける
          if(!preg_match("/^[a-zA-Z0-9]+$/", $pass)){
            $err_msg['pass'] = MSG04;

      }else if(mb_strlen($pass) < 6){
          //パスワードとパスワード再入力が6文字以上でない場合
          $err_msg['pass'] = MSG05;
      }

      //全てOKだったらDB接続する
      if(empty($err_msg)){

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
        $stm = $dbh->prepare('INSERT INTO users(email,pass,login_time)VALUES(:email,:pass,:login_time)');

        //プレースホルダーに値をセットし、SQL文を実行してmypageへ遷移 
        $stm->execute(array(':email' => $email, ':pass' => $pass, ':login_time' => date('Y-m-d H:i:s')));
        header("Location:mypage.php");
        
      }

      }
  }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>〇〇日記</title>
        <link rel="stylesheet" href="style.css">
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet'>
            
   
    </head>
  <body>
    <header>
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
          <!-- 入力フォーム -->
        <h1 class="sign-up">ユーザー登録</h1>
        <form action="mypage.php" method="post">
            <!-- valueの中にif文を書くことで入力ミスっても入力した内容が消えない -->
            <span class="err_msg"><?php if(!empty($err_msg['email'])) echo $err_msg['email']; ?></span>
            <input type="text" name="email" placeholder="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email'];?>">
            <span class="err_msg"><?php if(!empty($err_msg['pass'])) echo $err_msg['pass']; ?></span>
            <input type="password" name="pass" placeholder="パスワード" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass'];?>">
            <span class="err_msg"><?php if(!empty($err_msg['pass_retype'])) echo $err_msg['pass_retype'] ?></span>
            <input type="password" name="pass_retype" placeholder="パスワード（再入力）" value="<?php if(!empty($_POST['pass_retype'])) echo $_POST['pass_retype']?>">
            <input type="submit" value="送信">
         </form>
         <a href="mypage.php">マイページへ</a>
    </body>
</html>
