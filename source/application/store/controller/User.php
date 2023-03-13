<?php

namespace app\store\controller;

use app\store\model\UserRecord as UserRecordModel;
use app\store\model\User as UserModel;

/**
 * 用户管理
 * Class User
 * @package app\store\controller
 */
class User extends Controller
{
    /**
     * 用户列表
     * @param string $nickName
     * @param null $gender
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($nickName = '', $gender = null)
    {
        $model = new UserModel;
        $list = $model->getList($nickName, $gender);
        return $this->fetch('index', compact('list'));
    }

    /**
     * 用户解析记录
     */
    public function lists()
    {
        $model = new UserRecordModel();
        $list = $model->getList();
        return $this->fetch('record', compact('list'));
    }

    /**
     * 用户充值
     * @param $user_id
     * @param int $source 充值类型
     * @return array|bool
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function recharge($user_id, $source)
    {
        // 用户详情
        $model = UserModel::detail($user_id);
        if ($model->recharge($this->store['user']['user_name'], $source, $this->postData('recharge'))) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError($model->getError() ?: '操作失败');
    }

    /**
     * 删除用户
     * @param $user_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($user_id)
    {
        // 商品详情
        $model = UserModel::detail($user_id);
        if (!$model->setDelete()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 删除用户
     * @param $user_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function deleteRecord()
    {
        $model = new UserRecordModel();
        if (!$model->where("wxapp_id",$this->getWxappId())->delete()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}
