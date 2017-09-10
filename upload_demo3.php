<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>upload demo</title>
</head>
<?php
require_once "./upload.class.php";
if ($_FILES) {
    $up = new Upload();
    $up->uploadAllFile();
    $err = $up->getError();
    if ($err === false) {
        echo "文件上传成功";
    } else {
        echo "<p>发生如下错误：";
        foreach ($err as $v) {
            echo "<br>$v";
        }
    }
}
?>
<body>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="file1"><br><br>
		<input type="file" name="file2"><br><br>
		<input type="file" name="file3[]"><br><br>
		<input type="file" name="file3[]"><br><br>
		<input type="submit" value="提交">
	</form>
</body>
</html>
