<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> メンバー登録チェック</title>
</head>
<body>

<?php

$member_name=$_POST['name'];
$member_pass=$_POST['pass'];
$member_pass2=$_POST['pass2'];

$member_name=htmlspecialchars($member_name,ENT_QUOTES,'UTF-8'); 
$member_pass=htmlspecialchars($member_pass,ENT_QUOTES,'UTF-8');
$member_pass2=htmlspecialchars($member_pass2,ENT_QUOTES,'UTF-8');

//入力チェック
if($member_name=='')
{
	print '名前が入力されていません。<br />';
}
else
{
	print '名前';
	print $member_name;
	print '<br />';
}

if($member_pass=='')
{
	print 'パスワードが入力されていません。<br />';
}

if($member_pass!=$member_pass2)
{
	print 'パスワードが一致しません。<br />';
}

//いずれかの項目に不備がある場合に戻るボタンを表示する。
if($member_name=='' || $member_pass=='' || $member_pass!=$member_pass2) 
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
else
{   
	//パスワードのハッシュ化
	$member_pass=md5($member_pass); 
	   
	print '<form method="post" action="register_done.php">';
	print '<input type="hidden" name="name" value="'.$member_name.'">';
	print '<input type="hidden" name="pass" value="'.$member_pass.'">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="登録">';
	print '</form>';
}

?>

</body>
</html>