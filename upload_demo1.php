<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>upload demo</title>
</head>
<?php
if ($_FILES) {
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    if ($_FILES['file1']) {
        $file1 = $_FILES['file1'];
        if ($file1['error'] == 0) {
            //保持上传文件名不变
            //$_FILES内容按utf-8编码，所以在写入时中文文件名要转为gb2312编码
            $fname = iconv("UTF-8", "gb2312", $file1['name']);
            //按固定规则重新设置文件名
            $ext         = strrchr($file1['name'], '.'); //后缀
            $fname       = date("YmdHis") . '_' . rand(11111, 99999) . $ext;
            $target_file = "./upload_files/" . $fname;
            move_uploaded_file($file1['tmp_name'], $target_file);
        }

    }
}
?>
<body>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="file1"><br><br>
		<input type="file" name="file3[]"><br><br>
		<input type="submit" value="提交">
	</form>
</body>
</html>
