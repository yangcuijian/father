<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
class Giao extends Controller{
   public function index(){
       $res=User::all();
       var_dump($res);
       $this->assign("res",$res);
       return $this->fetch("index/index");
   }
}