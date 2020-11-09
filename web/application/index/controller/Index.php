<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Request;
use Db;
class Index extends Controller{
    //查看
    public function index(){
        $info=Db::name('stu')->select();
    $list = Db::name('stu')->where('id',1)->paginate(3,true);

        //var_dump($info);
        $this -> assign("info",$info);
        $this -> assign("list",$list);
    return $this -> fetch("Index/index");
    }
    //添加页面
    public function add(){
        return $this->fetch("Index/add");
    }
    public function  tianjia(){
        $name=$_POST['name'];
        $age=$_POST['age'];
        $sex=$_POST['sex'];
        $pic=$this->shang();
        $arr=array(
            'name'=>$name,
            'age'=>$age,
            'sex'=>$sex,
            "pic"=>$pic,
        );
    // $arr=Request::param();
        if ($arr['name']!="" && $arr['age']!="" && $arr['sex']!="" && $arr['pic']!=""){
            $info1=Db::name("stu")->insert($arr);
            if ($info1){
                $this->success("成功","index/index");
            }else{
                $this->error("失败");
            }
        }else{
            $this->error("请输入内容");
        }


    }

////删除
  public function shanchu(){
        //接受id
      $id=Request::param('id');
      $info=Db::name("stu")->find($id);
      $pic=$info['pic'];
      echo $pic;
      unlink('uploads/'.$pic);
       $re=Db::name("stu")->delete($id);
       if ($re){
           $this->success("删除成功","index/index");
       }

   }

   ////修改
    public  function xiugai(){
        $id=Request::param("id");
        $ree=Db::name('stu')->find($id);
        $this->assign("ree",$ree);
       return $this->fetch("index/xiu");
    }
    public function xiugai1(){
        $arr=Request::param();
        if (!empty($_FILES['pic']['name'])){
            $file = request()->file('pic');
            unlink('uploads/'.$arr['image']);
           // 移动到框架应用根目录/uploads/ 目录下
            $info=$file->move('../public/uploads');
            if ($info){
                $img =$info->getSavaName();
            }else{
                $img=$arr['image'];
            }


        }
        if($arr['name']!=""  && $arr['age']!="" && $arr['sex']!="" ){
            $re=Db::name('stu')->update(['name'=>"{$arr['name']}",'pic'=>"{$arr['pic']}",'age'=>"{$arr['age']}",'sex'=>$arr['sex'],"id"=>$arr['id']]);
            if ($re){
                $this->success("修改成功","index/index");
            }else{
                $this->error("修改失败");
            }
        }else{
            $this->error("请输入内容");
        }

    }

/////图片上传
    public function upload(){
        return $this->fetch("Index/upload");
    }
   public function shang(){
       // 获取表单上传文件 例如上传了001.jpg
       $file = request()->file('image');
       // 移动到框架应用根目录/uploads/ 目录下
       $info = $file->move( "../public/uploads");
       if($info){
           // 成功上传后 获取上传信息
           // 输出 jpg
           //echo $info->getExtension();
           // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
           return $info->getSaveName();
           // 输出 42a79759f284b767dfcb2a0197904287.jpg
           // $info->getFilename();

       }else{
           // 上传失败获取错误信息
           return $file->getError();
       }
   }




