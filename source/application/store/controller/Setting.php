<?php

namespace app\store\controller;

use app\common\library\sms\Driver as SmsDriver;
use app\store\model\Setting as SettingModel;
use app\store\model\Update as UpdateModel;

/**
 * 系统设置
 * Class Setting
 * @package app\store\controller
 */
class Setting extends Controller
{
    /**
     * 商城设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function store()
    {
        return $this->updateEvent('store');
    }
    /**
     * 商城设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function analysis()
    {
        return $this->updateEvent('store');
    }


    /**
     * 上传设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function storage()
    {
        return $this->updateEvent('storage');
    }

    /**
     * 更新商城设置事件
     * @param $key
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    private function updateEvent($key)
    {
        if (!$this->request->isAjax()) {
            $values = SettingModel::getItem($key);
            return $this->fetch($key, compact('values'));
        }
        $model = new SettingModel;
        if ($model->edit($key, $this->postData($key))) {
            return $this->renderSuccess('更新成功');
        }
        return $this->renderError('更新失败');
    }



    public function updates()
    {
        $model = new UpdateModel;
        $list = $model->whether();
        return $this->fetch('setting.update', compact('list'));
    }


}
