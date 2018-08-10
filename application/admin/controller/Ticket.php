<?php
/**
 * Created by PhpStorm.
 * User: 57839
 * Date: 2018/8/8
 * Time: 14:34
 */

namespace app\admin\controller;
use think\Db;

/**
 * 在线报修模块
 */
class Ticket extends Admin
{
    /**
     * 报修管理列表
     */
    public function index()
    {

        $list  =Db::name('Ticket')->paginate(1);
        $page=$list->render();
        $this->assign('list',$list);
        $this->assign('meta_title' , '报修管理');
        $this->assign('page', $page);
        return $this->fetch();
    }
    
    /**
     * 添加报修
     */
    public function add()
    {
        if (request()->isPost()){
            $Ticket = model('Ticket');
            $post_data=\think\Request::instance()->post();
            //自动验证
            $validate = validate('Ticket');
            if(!$validate->check($post_data)){
               return $this->error($validate->getError());
            }
//            var_dump($post_data);
//            die();
            $date=$Ticket->create($post_data);
            if ($date){
                $this->success('新增成功', url('index'));
                //记录行为
            }else{
                $this->error($Ticket->getError());
            }
        }else{
//            $pid = input('pid', 0);
//            //获取父导航
//            if(!empty($pid)){
//                $parent = \think\Db::name('Channel')->where(array('id'=>$pid))->field('title')->find();
//                $this->assign('parent', $parent);
//            }

//            $this->assign('pid', $pid);
            $this->assign('info',null);
            $this->assign('meta_title', '新增报修');
            return $this->fetch('edit');
        }

    }

    /**
     * 编辑报修
     */
    public function edit($id =0)
    {
        if (request()->isPost()){
            //实例化模型
            $Ticket = model('Ticket');
            //接收数据
            $post_data=\think\Request::instance()->post();
            //自动验证
            $validate = validate('Ticket');
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
            $data = $Ticket->update($post_data);
            if($data !== false){
                $this->success('编辑成功', url('index'));
            } else {
                $this->error('编辑失败');
            }
        }else{
            $info = array();
            /* 获取数据 */
            $info = \think\Db::name('Ticket')->find($id);
            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->assign('meta_title', '编辑报修');
            return $this->fetch();
        }

    }

    /**
     * 删除
     */
    public function del($id =0)
    {
        $id = array_unique((array)input('id/a',0));
//        var_dump($id);
//        die();
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id) );
        if(\think\Db::name('ticket')->where($map)->delete()){
            //记录行为
            action_log('update_channel', 'channel', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
}