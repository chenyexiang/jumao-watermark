<?php

namespace app\admin\controller\setting;

use app\admin\controller\Controller;
use app\admin\model\Update as UpdateModel;

/**
 * 在线更新模型
 * Class User
 * @package app\store\controller
 */
class Update extends Controller
{


    public function index()
    {
        $model = new UpdateModel;
        $list = $model->whether();
//        pre($list);
        return $this->fetch('index', [
            'list' => $list
        ]);
    }


    public function upDate()
    {
        $model = new UpdateModel;
        $list = $model->update();
        if ($list['code'] == 200) {
            return $this->renderSuccess($list['msg']);
        }
        return $this->renderError($list['msg']);
    }






}
