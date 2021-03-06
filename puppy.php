<?php
//ログインチェック
if(!isset($_COOKIE['login']))
{
    header("Location: login.php");
}
else
{
	foreach ($_COOKIE['login'] as $key => $value) 
	{
		switch ($key) {
			case 'user_seq':
				$login_user_seq = $value;
				break;
			case 'name':
				$login_user_name = $value;
				break;
			case 'auth':
				$login_user_auth = $value;
				break;
			case 'team':
				$login_user_team = $value;
				break;
			case 'auth_name':
				$login_user_auth_name = $value;
				break;
			case 'team_name':
				$login_user_team_name = $value;
				break;
		}
	}

}
    //DB接続
    require("lib/dbconect.php");
    $dbcn = DbConnect();
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>PCP用プロジェクト管理ツール</title>
<meta name="copyright" content="Nikukyu-Punch" />
<meta name="description" content="ここにサイト説明を入れます" />
<meta name="keywords" content="キーワード１,キーワード２,キーワード３,キーワード４,キーワード５" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script.js"></script>
</head>


<body>


<div id="header">
<div>
<img src="images/pcpmain.png" width="930" height="180" />
</div>
</div>
<!--/header-->


<div id="container">
<?php 
if($login_user_auth == '1')
{ ?>
	<ul class="menber" id="menu">
	<li><a href="index.php"><img src="images/menu_0.jpg" alt="HOME" width="310" height="60" id="Image1" onmouseover="MM_swapImage('Image1','','images/menu_over1.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="about.php"><img src="images/menu_1.jpg" alt="ABOUT" width="310" height="60" id="Image2" onmouseover="MM_swapImage('Image2','','images/menu_over2.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="puppy.php"><img src="images/menu_2.jpg" alt="PUPPY" width="310" height="60" id="Image3" onmouseover="MM_swapImage('Image3','','images/menu_over3.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	</ul>
<?php
}else
{ ?>
	<ul class="manager" id="menu">
	<li><a href="index.php"><img src="images/menu_0.jpg" alt="HOME" width="186" height="40" id="Image1" onmouseover="MM_swapImage('Image1','','images/menu_over1.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="about.php"><img src="images/menu_1.jpg" alt="ABOUT" width="184" height="40" id="Image2" onmouseover="MM_swapImage('Image2','','images/menu_over2.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="puppy.php"><img src="images/menu_2.jpg" alt="PUPPY" width="184" height="40" id="Image3" onmouseover="MM_swapImage('Image3','','images/menu_over3.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="photo.php"><img src="images/menu_3.jpg" alt="PHOTO" width="184" height="40" id="Image4" onmouseover="MM_swapImage('Image4','','images/menu_over4.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="contact.php"><img src="images/menu_4.jpg" alt="CONTACT" width="186" height="40" id="Image5" onmouseover="MM_swapImage('Image5','','images/menu_over5.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	</ul>
<?php
}
?>
<table class="login_info">
	<tr>
		<th>チーム名:</th>
		<td><?php echo $login_user_team_name ?></td>
	</tr>
	<tr>
		<th>ユーザ名:</th>
		<td><?php echo $login_user_name ?></td>
	</tr>
</table>
<br>
<br>
<br>
<div id="main">

<h2>アイテム一覧</h2>
<table id="item_list" class="item_list" >
	<tr>
		<th class="tamidashi">種別</th>
		<th class="tamidashi">アイテム名</th>
		<th class="tamidashi">担当チーム</th>
		<th class="tamidashi">進捗状況</th>
		<th class="tamidashi">予定開始日</th>
		<th class="tamidashi">予定終了日</th>
		<th class="tamidashi">開始日</th>
		<th class="tamidashi">終了日</th>
	</tr>
	<?php
		$sql = "SELECT 
				parent_item_seq, 
				parent_item_name, 
				m_team.team_name,
				m_item_type.item_type_name,
				DATE_FORMAT(schedule_start_date,'%Y年%m月%d日'),
				DATE_FORMAT(schedule_end_date,'%Y年%m月%d日'),
				DATE_FORMAT(start_date,'%Y年%m月%d日'),
				DATE_FORMAT(end_date,'%Y年%m月%d日'),
				progress 
				FROM parent_item 
				JOIN m_team ON m_team.team_seq = parent_item.team_seq 
				JOIN m_item_type ON m_item_type.item_type_seq = parent_item.item_type_seq 
				WHERE parent_item.team_seq = 2";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result))
		{?>
			<tr>
				<td><?php echo $row[3] ?></td>
				<td><a href="puppy2.php?id=<?php echo $row[0] ?>"><?php echo $row[1] ?></a></td>
				<td><?php echo $row[2] ?></td>
				<td class="progress"><?php echo $row[8] ?>%</td>
				<td><?php echo $row[4] ?></td>
				<td><?php echo $row[5] ?></td>
				<td><?php echo $row[6] ?></td>
				<td><?php echo $row[7] ?></td>
			</tr>		 
	<?php
		}
		mysql_free_result($result);	
		?>
</table>

</div>
<!--/main-->


<div id="footer">
Copyright&copy; 2011 サンプルブリーダーショップ All Rights Reserved.<br />
<a href="http://nikukyu-punch.com/" target="_blank">Template design by Nikukyu-Punch</a>
</div>
<!--/footer-->


</div>
<!--/container-->


</body>
</html>
