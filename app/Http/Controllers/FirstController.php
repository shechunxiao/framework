<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FirstController extends Controller
{
    /**
     * 模拟上传图片的页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload()
    {
        return view('upload');
    }

    /******************************************导入*****************************************/

    /**
     * 导入
     * @param Request $request
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function import(Request $request)
    {
        //上传zip文件
        $uploadFile = $this->uploadFile($request);
        if ($uploadFile['status'] == 0) return $uploadFile;
        //解压zip文件
        $filename = public_path() . '/file/110/upload.zip';
        $extract = $this->extractZipToFile($filename, public_path() . '/file/110/');
        if (!$extract) {
            return ['status' => 0, 'msg' => '解压失败'];
        }
        //验证解压后的文件的正确性
        $path = public_path() . '/file/110/extract';
        $verifyFile = $this->verifyFile($path);
        if ($verifyFile['status'] == 0) {
            return $verifyFile;
        };
        //导入数据
        $importData = $this->importDataToDatabase();
        if ($importData['status'] == 0) {
            return $importData;
        }
        //清理上传文件和解压文件
        $this->clearDirAndFiles(public_path() . '/file/110');
        return ['status' => 1, 'msg' => '导入成功'];
    }

    /**
     * 上传文件
     * @param Request $request
     * @return array
     */
    public function uploadFile($request)
    {
//        $savePath = $request->input('path'); //暂时不用，最后再用
        if (!$request->hasFile('file')) {
            return ['status' => 0, 'msg' => '缺少文件'];
        }
        $file = $request->file('file');
        if (!$file->isValid()) {
            return ['status' => 0, 'msg' => '上传出错'];
        }
        $extension = $file->getClientOriginalExtension();
        if ($extension != 'zip') {
            return ['status' => 0, 'msg' => '上传格式错误'];
        }
        $saveName = 'upload.' . $extension;
        $savePath = public_path() . '/file/110/';
        $target = $file->move($savePath, $saveName);
        if ($target) {
            return ['status' => 1, 'msg' => '上传成功'];
        } else {
            return ['status' => 0, 'msg' => '上传失败'];
        }
    }

    /**
     *  验证文件的正确性
     * @param $path
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function verifyFile($path)
    {
        //验证图片
        $verifyPic = $this->verifyPic($path);
        if ($verifyPic['status'] == 0) {
            return $verifyPic;
        }
        $data['picArray'] = $verifyPic['data']['picArray'];
        //验证商品列表的数据
        $verifyExcel = $this->verifyExcel($path);
        if ($verifyExcel['status'] == 0) {
            return $verifyExcel;
        }
        $data['data'] = $verifyExcel['data']['lists'];
        return ['status' => 1, 'msg' => '验证通过', 'data' => $data];
    }

    /**
     * 验证图片
     * @param $path
     * @return array
     */
    public function verifyPic($path)
    {
        $picPath = $path . '/' . $this->transcoding('图片');
        $barCodeArr = []; //条形码数组
        $picArray = []; //图片数组
        //判断图片文件夹是否为空
        if ($handle = @opendir($picPath)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $pathInfo = pathinfo($picPath . '/' . $entry);
                    $barCode = explode('-', $pathInfo['filename'])[0];
                    if (!in_array($barCode, $barCodeArr)) {
                        $barCodeArr[] = $barCode;
                    }
                    $picArray[$barCode][] = $pathInfo['basename'];
                }
            }
            closedir($handle);
        }
        /*****查询数据库，验证******/


        /*****查询数据库，验证*******/
        //假设验证成功
        return ['status' => 1, 'msg' => '验证成功', 'data' => ['picArray' => $picArray]];
    }

    /**
     *  验证excel文件
     * @param $path
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function verifyExcel($path)
    {
        $excelName = ''; //文件名
        $ext = 'xlsx'; //扩展名
        if ($handle = @opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (substr_count($entry, $this->transcoding('商品列表')) > 0) {
                        $pathInfo = pathinfo($path . '/' . $entry);
                        $excelName = $entry;
                        $ext = strtolower($pathInfo['extension']);
                    }
                }
            }
            closedir($handle);
        }
        if (empty($excelName) || ($ext != 'xlsx' && $ext != 'xls')) {
            return ['status' => 0, 'msg' => 'Excel文件不存在'];
        }
        @rename($path . '/' . $excelName, $path . '/Excel.' . $ext); //重新命名，方法取数据
        $file_path = $path . '/Excel.' . $ext;
        //读取数据信息，验证是否正确
        if ($ext == 'xlsx') {
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($file_path, 'utf-8');
        } elseif ($ext == 'xls') {
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($file_path, 'utf-8');
        }
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();//取得总行数
//        $highestColumn = $sheet->getHighestColumn(); //取得总列数,这个有时候是空，所以不对，暂不使用,下面直接用I
        $data = [];
        for ($i = 1; $i <= $highestRow; $i++) {
            $rowData = [];
            for ($k = 'A'; $k <= 'I'; $k++) {
                $rowData[] = $objPHPExcel->getActiveSheet()->getCell("$k$i")->getValue();
            }
            array_push($data, $rowData);
        }
        $title = array_filter($data[0]);
        if (count($title) < 9) {
            return ['status' => 0, 'msg' => 'Excel表头不正确'];
        }
        unset($data[0]);
        $data = array_values($data);
        return ['status' => 1, 'msg' => '验证通过', 'data' => ['lists' => $data]];

    }


    /**
     *  将数据导入到数据库
     */
    public function importDataToDatabase()
    {
        return ['status' => 1, 'msg' => '导入成功'];
    }

    /**
     * 解压
     * @param $zipName
     * @param $dir
     * @return bool
     */
    function extractZipToFile($zipName, $dir)
    {
        $zip = new \ZipArchive;
        if ($zip->open($zipName) === TRUE) {
            if (!is_dir($dir)) mkdir($dir, 0775, true);
            $num = $zip->numFiles;
            for ($i = 0; $i < $num; $i++) {
                $statInfo = $zip->statIndex($i);
                $filename = $this->transcoding($statInfo['name']);
                if ($statInfo['crc'] == 0) {
                    //新建目录
                    if (!is_dir($dir . '/' . substr($filename, 0, -1))) mkdir($dir . '/' . substr($filename, 0, -1), 0775, true);
                } else {
                    //拷贝文件
                    copy('zip://' . $zipName . '#' . $zip->getNameIndex($i), $dir . '/' . $filename);
                }
            }
            $name = $zip->getNameIndex(0);
            $name = substr($name, 0, -1);
            $name = $this->transcoding($name);
            $zip->close();
            @rename($dir . $name, $dir . 'extract'); //重新命名，方便取数据
            return true;
        } else {
            return false;
        }
    }

    /**
     * 转换字符编码
     * @param $fileName
     * @return false|string
     */
    function transcoding($fileName)
    {
        $encoding = mb_detect_encoding($fileName, ['UTF-8', 'GBK', 'BIG5', 'CP936']);
        if (DIRECTORY_SEPARATOR == '/') {    //linux
            $filename = iconv($encoding, 'UTF-8', $fileName);
        } else {  //win
            $filename = iconv($encoding, 'GBK', $fileName);
        }
        return $filename;
    }

    /******************************************导入*****************************************/


    /******************************************导出*****************************************/
    /**
     * 导出商品
     * @param Request $request
     * @return void
     */
    public function export(Request $request)
    {
        $this->clearDirAndFiles(public_path().'/file/110/export'); //清除上一次导出的数据文件
//        $type = $request->input('type'); //all,select
        //查询数据库获取数据
//        $data = $this->getGoods();
//        //创建excel表和图片文件夹
//        $buildFiles = $this->buildFiles();
//        //生成压缩文件
        $path = public_path() . '/file/110/export/';
        $zip = $this->zipFiles($path);
        //输出压缩包
//        ob_end_clean();
//        $filename = '基础商品库压缩包.zip';
//        $file = public_path().'/file/110/export/goods.zip';
//        if (file_exists($file)) {
//            header('Content-Description: File download');
//            header('Content-Type: application/x-zip');
//            header('Content-Disposition: attachment; filename=' . $filename);
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate');
//            header('Pragma: public');
//            header('Content-Length: ' . filesize($file));
//            readfile($file);
//            exit;
//        }
    }

    /**
     *  获取商品数据
     */
    public function getGoods()
    {
        
    }

    /**
     * 生成文件
     */
    public function buildFiles()
    {


        if (!is_file(public_path() . '/file/110/export/build/goods.xlsx')){
            return ['status'=>0,'msg'=>'导出到Excel失败'];
        }
    }

    /**
     * 压缩文件
     * @param $path
     */
    public function zipFiles($path)
    {
        $zip = new \ZipArchive();
        @unlink($path . 'goods.zip'); //删除原来的
        if ($zip->open($path . 'goods.zip', \ZIPARCHIVE::CREATE) === true) {
            $zip->addEmptyDir('goods/图片');
            $filename = $path . 'build/goods.xlsx';
            $content = file_get_contents($filename);
            $zip->addFromString('goods/商品列表.xlsx', $content);
            //添加图片
            if ($handle = opendir($path . 'build/pic')) {
                // 添加目录中的所有文件
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != ".." && !is_dir($entry)) {
                        $zip->addFile($path . 'build/pic/' . $entry, 'goods/图片/' . $entry);
                    }
                }
                closedir($handle);
            }
            $zip->close();
        }
    }


    /******************************************导出*****************************************/

    /**
     * 删除目录下的文件
     * @param $path
     * @return void
     */
    public function clearDirAndFiles($path)
    {
        if ($handle = @opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry == "." || $entry == "..") {
                    continue;
                }
                if (is_dir($path_child = $path . '/' . $entry)) {
                    $this->clearDirAndFiles($path_child);
                    @rmdir($path_child);
                } else {
                    @unlink($path_child);
                }
            }
            closedir($handle);
        }
        @rmdir($path);
    }


}