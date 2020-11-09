<?php
namespace app\index\model;
use think\Model;
use Db;
class User extends Model{
    public function user(){
    return Db::name('stu')->select();
    }
}