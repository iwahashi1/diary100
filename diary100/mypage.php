
<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

session_start();
//ログインしてなければ、login画面へ戻す
 if(empty($_SESSION['login'])) header("Location:login.php");

 ?>
 <?php if(!empty($_SESSION['login'])){?>
            
            <h1><a href="mypage.php">マイページ</a></h1>
             <section>
                    <ul>
                     <li><a href="write.php">日記を書く</a></li>
                     <li><a href="read.php">日記を見る</a></li>
                     <li><a href="logout.php">ログアウト</a></li>
                     <li>退会</li>
                 </ul>
                 <!-- <a href="index.php">HOMEへ戻る</a> -->
     </section>
         <?php }else{ ?>
         <p>ログインしていないと見れません</p>

     <?php } ?>
