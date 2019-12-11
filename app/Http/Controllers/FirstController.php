<?php

namespace App\Http\Controllers;


use PhpZip\ZipFile;

class FirstController extends Controller
{

    /**
     * 实现了压缩
     */
    public function testYaSuo()
    {
        $zip = new \ZipArchive();
        @unlink(public_path() . '/me.zip'); //上来就删除它
        if ($zip->open('me.zip', \ZIPARCHIVE::CREATE) === true) {
            $zip->addEmptyDir('图片');
//            var_dump(public_path('zip').'/lingshou.xlsx');die();
//            //通过内容生成
            $filename = public_path('zip') . '/汉字.xlsx';
            $filename = iconv('utf-8', 'gbk', $filename);
//            $content = file_get_contents($filename);
//            $zip->addFromString('商品列表.xlsx',$content);
            $zip->addFile($filename, '商品列表.xlsx');
            //打开图片
            if ($handle = opendir(public_path('zip/pic'))) {
                // 添加目录中的所有文件
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != ".." && !is_dir($entry)) {
                        $zip->addFile(public_path('zip/pic') . '/' . $entry, '图片/' . rand(0, 10000) . '.jpg');
                    }
                }
                closedir($handle);
            }
            $zip->close();
        }
    }


    /**
     * 实现解压
     */
    public function test()
    {
//        $zip = new \ZipArchive();
//        if ($zip->open(public_path() . '/upload.zip')){
//            for ($i=0;$i<$zip->numFiles;$i++){
////                var_dump(iconv('utf-8','gbk',$zip->getNameIndex($i)));
//                $entry = $zip->getNameIndex($i);
//                $statInfo = $zip->statIndex($i);
//                var_dump($statInfo);
////                var_dump($entry);
//            }
////            var_dump($zip->getNameIndex(0));
////            var_dump($zip->getNameIndex(1));
////            var_dump($zip->getNameIndex(2));
////            var_dump($zip->getNameIndex(3));
////            var_dump($zip->getNameIndex(4));
////            var_dump($zip->getNameIndex(5));
////            var_dump($zip->numFiles);
//            $zip->extractTo(public_path('jieya'));
//            $zip->close();
//        }
//        rmdir(public_path().'/myfd');
//        $result = scandir(public_path().'/upload');
//        var_dump($result);
//        foreach ($result as &$v){
//            $v = iconv('gbk','utf-8',$v);
//            var_dump($v);
//        }
//        rmdir(public_path().'/my');
        $filename = public_path().'/test.zip';
        $this->extractZipToFile($filename,public_path().'/file/');
    }

    /**
     * @param string $zipName 需要解压的文件路径加文件名
     * @param string $dir  解压后的文件夹路径
     * @return bool
     */
    function extractZipToFile($zipName,$dir){
        $zip = new \ZipArchive;
        if ($zip->open($zipName) === TRUE) {
            if(!is_dir($dir)) mkdir($dir,0775,true);
            $docnum = $zip->numFiles;
            for($i = 0; $i < $docnum; $i++) {
                $statInfo = $zip->statIndex($i);
                $filename = $this->transcoding($statInfo['name']);
                $now = $filename;
//                var_dump($now);
                $filename = substr($filename, 0,-1);
//                var_dump($filename);
//                var_dump($now);
                if($statInfo['crc'] == 0) {
                    //新建目录
                    $filename = substr($filename, 0,-1);
                    $count = substr_count($filename,'/');
                    if ($count>0){
                        if(!is_dir($dir.'110/'.substr($now, 0,-1))) mkdir($dir.'110/'.substr($now, 0,-1),0775,true);
                    }else{
                        $now = 'upload';
                        if(!is_dir($dir.'110/'.$now)){
                            mkdir($dir.'110/'.$now,0775,true);
                        }
                    }
                } else {

                    //拷贝文件
//                    copy('zip://'.$zipName.'#'.$zip->getNameIndex($i), $dir.'110/'.$filename);
                    copy('zip://'.$zipName.'#'.$zip->getNameIndex($i), $dir.'110/'.$now.'/');
                }
            }
            $zip->close();
            return true;
        }else{
            return false;
        }
    }

    function transcoding($fileName){
        $encoding = mb_detect_encoding($fileName,['UTF-8','GBK','BIG5','CP936']);
        if (DIRECTORY_SEPARATOR == '/'){    //linux
            $filename = iconv($encoding,'UTF-8',$fileName);
        }else{  //win
            $filename = iconv($encoding,'GBK',$fileName);
        }
        return $filename;
    }


    public function test2()
    {

        $zip = new \ZipArchive;

        if ($zip->open('test.zip', \ZipArchive::OVERWRITE) === true) {
            // 将指定文件添加到zip中
            $zip->addFile('test.txt');

            // test.txt文件添加到zip并将其重命名为newfile.txt
            $zip->addFile('test.txt', 'newfile.txt');

            // 将test.txt文件添加到zip文件中的test文件夹内
            $zip->addFile('mtest.txt', 'test/newfile.txt');

            //将一个空的目录添加到zip中
            $zip->addEmptyDir('测试');

            // 将有指定内容的new.txt文件添加到zip文件中
            $zip->addFromString('new.txt', '要添加到new.txt文件中的文本');

            // 将有指定内容的new.txt添加到zip文件中的test文件夹
            $zip->addFromString('la/new.txt', '要添加到new.txt文件中的文本');

//            //将images目录下所有文件添加到zip中
//            if ($handle = opendir('images')){
//                // 添加目录中的所有文件
//                while (false !== ($entry = readdir($handle))){
//                    if ($entry != "." && $entry != ".." && !is_dir('images/' . $entry)){
//                        $zip->addFile('images/' . $entry);
//                    }
//                }
//                closedir($handle);
//            }

            // 关闭zip文件
            $zip->close();
        }


        //压缩
//        $zip = new \ZipArchive;
//        if ($zip->open('图片.zip', \ZipArchive::CREATE) === true)
//        {
//            // 将指定文件添加到zip中
//            $zip->addFile('test.txt');
//
//            // test.txt文件添加到zip并将其重命名为newfile.txt
//            $zip->addFile('test.txt', 'newfile.txt');
//
//            // 将test.txt文件添加到zip文件中的test文件夹内
//            $zip->addFile('test.txt', 'test/newfile.txt');
//
//            //将一个空的目录添加到zip中
//            $zip->addEmptyDir ('test');
//
//            // 将有指定内容的new.txt文件添加到zip文件中
//            $zip->addFromString('new.txt', '要添加到new.txt文件中的文本');
//
//            // 将有指定内容的new.txt添加到zip文件中的test文件夹
//            $zip->addFromString('test/new.txt', '要添加到new.txt文件中的文本');
//
////            //将images目录下所有文件添加到zip中
////            if ($handle = opendir('images')){
////                // 添加目录中的所有文件
////                while (false !== ($entry = readdir($handle))){
////                    if ($entry != "." && $entry != ".." && !is_dir('images/' . $entry)){
////                        $zip->addFile('images/' . $entry);
////                    }
////                }
////                closedir($handle);
////            }
//
//            // 关闭zip文件
//            $zip->close();
//        }


    }


    /**
     * 上传文件
     */
    public function uploadFile(){

    }
}
