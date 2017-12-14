<?php

namespace Admin\Controller;

use Admin\Common\AdminController;
use Think\Exception;

class MemberController extends AdminController
{
    public function showlist()
    {
        $user = D('user')->getAllData();
        $this->assign('user', $user['list']);
//       var_dump($user['list']);
        $this->assign('page', $user['page']);
        $this->display();
    }

    public function blocked()
    {
        $userBlockState = D('user')->userBlocked(I('post.'));
        exit($userBlockState);
    }
    public function unblocked(){
        $id = I('post.user_id');
        $user = D('User')->unblocked($id);
        if($user){
            echo json_encode(array('state'=>'200','message'=>'解冻成功！'));
        }else{
            echo json_encode(array('state'=>'202','message'=>'解冻失败！'));
        }
    }

    //导出PHPExcel
    public function exportUser()
    {
        $userData = D('User')->select();
        $this->export_execl($userData);
    }

    public function export_execl($data)
    {
        try {
            //设置php运行时间
            set_time_limit(0);//设置为0表示没有限制
            /**
             * 大数据导出①
             * 设置php可使用内存
             * ini_set("memory_limit", "1024M");
             */
            //引入Vendor\PHPExcel\PHPExcel.php类
            Vendor('PHPExcel.PHPExcel');
            //引入PHPExcel/PHPExcel/Writer/Excel2007类
            Vendor('PHPExcel.PHPExcel.Writer.Excel2007');
            $objExcel = new \PHPExcel();
            $objWriter = new \PHPExcel_Writer_Excel2007($objExcel);
            // 设置文档属性特性：包括作者、最后一次修改者、标题、主题、备注、标记、类别等文档信息
            $objProps = $objExcel->getProperties();
            $objProps->setCreator("tpshop")->setLastModifiedBy("John shuxian")->setTitle("tpshop用户表")->setSubject("John shuxian")->setDescription("John shuxian")->setKeywords("John shuxian")->setCategory("John shuxian");
            $objExcel->setActiveSheetIndex(0);//设置excel表格起始位置
            //这是设置栏目标题和栏目宽度和数量(A-F)6列
            $objActSheet = $objExcel->getActiveSheet();
            $objActSheet->getColumnDimension('A')->setWidth(20);
            $objActSheet->getColumnDimension('B')->setWidth(20);
            $objActSheet->getColumnDimension('C')->setWidth(20);
            $objActSheet->getColumnDimension('D')->setWidth(20);
            $objActSheet->getColumnDimension('E')->setWidth(20);
            $objActSheet->getColumnDimension('F')->setWidth(20);
            $objActSheet->setCellValue('A1', '用户ID');
            $objActSheet->setCellValue('B1', '用户名');
            $objActSheet->setCellValue('C1', '邮箱');
            $objActSheet->setCellValue('D1', '性别');
            $objActSheet->setCellValue('E1', 'qq');
            $objActSheet->setCellValue('F1', '手机');
            //遍历组装excel数据
            foreach ($data as $key => $v) {
                $i = $key+2;
                /*因为excel栏是从第一栏开始的，并且第一栏已经被字段标题占据了，所以下面的数据是从第2栏开始的，
                因此我们使用A.$i的方法动态生成字段位置*/
                $objActSheet->setCellValue('A'.$i,$v['user_id']);
                $objActSheet->setCellValue('B'.$i,$v['username']);
                $objActSheet->setCellValue('C'.$i,$v['user_email']);
                $objActSheet->setCellValue('D'.$i,$v['user_sex']!='1'?$v['user_sex']!='2'?'保密':'女':'男');
                $objActSheet->setCellValue('E'.$i,$v['user_qq']);
                $objActSheet->setCellValue('F'.$i,$v['user_tel']);
            }
            $dir = "./Public/uploads/excel/";
            if(!is_dir($dir)){
                //在Linux系统中，完整的文件的权限信息分为：文档类型/owner/group/others,其下分别有r(写)/w(读)/x(执行)权限
                //其中文档类型：d 目录、l为链接文档、b为可随机存储装置、c为一次性读取装置、-为文件
                //r:4 w:2 x:1;
                //所以0777=>0(4+2+1)(4+2+1)(4+2+1); 对应的0765=>0(4+2+1)(4+2+0)(4+0+1)=>drwxrw-r-x(没有的权限用-代替);
                //0777意为：drwxrwxrwx;既是用户主、用户组以及其他用户拥有对该目录的所有的读取、写入以及执行权限
                mkdir($dir,0777,true);
            }
            $fileName = $dir.date('Y-m',time()).'_tpshop用户表.xlsx';
            //保存输出excel文件到指定目录地址
            $objWriter->save($fileName);
            die(json_encode(['state'=>200,'message'=>'导出成功！']));

        } catch (Exception $e) {
            //异常抛出
            die(json_encode(['state' => 200, 'message' => $e->getMessage()]));
        }
    }
}