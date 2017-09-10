<?php
class Upload
{
    //允许的后缀名
    private $allow_ext = array(".jpg", ".jpeg", ".gif", ".png");
    //允许的文件类型
    private $allow_type     = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    private $allow_max_size = 2097152; //最大2M
    private $err_arr        = array(); //用于存放错误信息内容
    public function getError()
    {
        if (!empty($this->err_arr)) {
            return $this->err_arr; //返回错误信息
        } else {
            return false; //没有错误
        }
    }
    public function uploadAllFile()
    {
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
                    $this->uploadOneFile($fileTmp);
                }
            } else {
                $this->uploadOneFile($file); //处理单个表单变量的提交
            }
        }
    }

    public function uploadOneFile($file)
    {
        //$fname = iconv("UTF-8", "gb2312", $file['name']); //win系统保持上传文件名不变,需转码

        if ($file['error'] == 0) {

            //检测后缀
            $ext = strrchr($file['name'], '.'); //后缀
            if (!in_array($ext, $this->allow_ext)) {
                $this->err_arr[] = "文件[{$file['name']}]后缀错误!";
                return;
            }
            //检测类型
            if (!in_array($file['type'], $this->allow_type)) {
                $this->err_arr[] = "文件[{$file['name']}]类型错误!";
                return;
            }
            //检测大小
            if ($file['size'] > $this->allow_max_size) {
                $this->err_arr[] = "文件[{$file['name']}]大小超出允许范围!";
                return;
            }
            $new_fname   = date("YmdHis") . '_' . rand(11111, 99999) . $ext; //按固定规则重新设置文件名
            $target_file = "./upload_files/" . $new_fname;
            if (move_uploaded_file($file['tmp_name'], $target_file)) {

            } else {
                $this->err_arr[] = "<br>移动文件[{$file['name']}]发生错误!";
            }
        } else {
            $this->err_arr[] = "<br>上传文件[{$file['name']}]发生错误!";
        }
    }
}
