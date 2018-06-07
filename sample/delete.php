<?php

require_once dirname(__FILE__).'/../autoload.php';

require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/helper.php';

//require_once '/func.php';
//var_dump($_POST);
$id = "";
if(isset($_POST)==true)
{
	//どのボタンを押したかチェック
	for($i=0;$i<100;$i++)
		{
			if(isset($_POST['btn_'.$i])==true)
			{
				$id = $i;
/*					  	print '<br>';
        print '$botan:'.$botan;
        print '<br>';
*/
				break;
			}		
		}
}

//var_dump($botan);
//$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
//$ac_code = isset($_POST['ac_code']) ? $_POST['ac_code'] : 1;


?>




<?php 

//*************************************
//お気に入り
//2. DB接続します

//var_dump($id);
require_once __DIR__ . '../../../conf/database_conf.php';
					
					  
					# MySQLデータベースに接続します。
					  $db = new PDO($dsn, $dbUser, $dbPass);
					  
$stmt = $db->prepare("DELETE FROM gs_bm_table WHERE id=:id");
$stmt->bindValue(':id', $id);
$status = $stmt->execute();
			  


$sql='SELECT * FROM gs_bm_table';
	$prepare = $db->prepare($sql);
	$result = $prepare->execute();					  
					  
					  
					  

	
	//$prepare = null;


//３．データ表示
$view="";
if($result==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $prepare->errorInfo();
  exit("ErrorQuery:".$error[2]); //配列index[2]にエラーコメントあり 

}else{
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Rakuten Web Service SDK - Sample</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<header>
<h1><a href="index.php">Rakuten Web Service SDK お気に入り一覧</a></h1>
</header>

<div id="itemarea">
<form action="delete.php" method="post">
<ul id="itemlist">
<?php	
	
	
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $re = $prepare->fetch(PDO::FETCH_ASSOC)){ 
    //$view  .= '<p>';           
	//$view  .= $result["indate"] ."：". $result["name"] ;           
	//$view .= '</p>'; 
	//var_dump($result);
?>	
	<li class="item">

<a href="<?php echo h($re['affiliateurl']) ?>" class="itemname" title="<?php echo h($re['book_name']) ?>">
<?php echo h(mb_strimwidth($re['book_name'], 0, 80, '...', 'UTF-8')) ?></a>

<ul>
<?php if (!empty($re['imageurl'])): ?>
<li class="image"><img src="<?php echo h($re['imageurl']) ?>"></li>
<?php endif; ?>

<li class="price"><?php echo h(number_format($re['itemprice'])) ?>円</li>
<li class="description"><?php echo h($re['book_coment']) ?></li>
<li class="">

<input type="submit" name="btn_<?=$re["id"]?>" value="お気に入り削除"></li>
</ul>
</form>

<?php
  }




}			

 ?>













</body>
</html>
