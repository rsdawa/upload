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
    foreach ($_FILES as $key => $file) {
        if (is_array($file['name'])) {
            //处理表单变量为:name="xxxx[]"形式的提交
            $fileTmp = array();
            foreach ($file['name'] as $_key => $_file) {
                $fileTmp['name']     = $file['name'][$_key];
                $fileTmp['type']     = $file['type'][$_key];
                $fileTmp['tmp_name'] = $file['tmp_name'][$_key];
                $fileTmp['error']    = $file['error'][$_key];
                $fileTmp['size']     = $file['size'][$_key];
                uploadOneFile($fileTmp);
            }
        } else {
            uploadOneFile($file); //处理单个表单变量的提交
        }
    }
}

function uploadOneFile($file)
{
    if ($file['error'] == 0) {
        $fname       = iconv("UTF-8", "gb2312", $file['name']); //保持上传文件名不变,需转码
        $ext         = strrchr($file['name'], '.'); //后缀
        $fname       = date("YmdHis") . '_' . rand(11111, 99999) . $ext; //按固定规则重新设置文件名
        $target_file = "./upload_files/" . $fname;
        if (move_uploaded_file($file['tmp_name'], $target_file)) {

        } else {
            echo "<br>移动文件发生错误!";
        }
    } else {
        echo "<br>上传文件发生错误!";
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
