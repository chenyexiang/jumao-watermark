<?php

namespace app\store\controller;

use app\store\model\UserUrls;
use app\store\model\Wxapp as WxappModel;
use app\store\model\WxappNavbar as WxappNavbarModel;
use think\Db;

/**
 * 小程序管理
 * Class Wxapp
 * @package app\store\controller
 */
class Wxapp extends Controller
{
    /**
     * 小程序设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function setting()
    {
        $wxapp = WxappModel::detail();
        if ($this->request->isAjax()) {
            $data = $this->postData('wxapp');
            if ($wxapp->edit($data)) return $this->renderSuccess('更新成功');
            return $this->renderError('更新失败');
        }
        return $this->fetch('setting', compact('wxapp'));
    }


    public function urls()
    {
        $model = new UserUrls;
        $list = $model->getList();
        return $this->fetch('urls', compact('list'));
    }


    public function copy()
    {
        $model = new UserUrls;
        #文件内容
        $content = "以下域名按照出现次数从大到小排序" . "\r\n" .
            "直接将以下域名复制到微信公众平台中的downloadFile合法域名即可" . "\r\n\r\n";
        $contentList = $model->getCopyList();
        foreach ($contentList as $value) {
            $content = $content . $this->iconv2($value['url']) . ";" . "\r\n";
        }
        #文件名
        $fileName = "downloadFile合法域名.txt";
        #导出保存成txt
        header("Content-type: application/octet-stream;charset=utf-8");
        header("Accept-Ranges: bytes");
        header("Content-Disposition: attachment; filename =" . $fileName);
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: public");
        echo $content;
    }

    public function urlDelete($id)
    {
        (new UserUrls())->where('id', $id)->delete();
        return $this->renderSuccess('更新成功');
    }

    public function urlDeleteAll()
    {
        Db::query('truncate table yoshop_user_urls');
        $model = new UserUrls;
        $list = $model->getList();
        return $this->fetch('urls', compact('list'));
    }


    /**
     * 流量主设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function ad()
    {
        $wxapp = WxappModel::detail();
        if ($this->request->isAjax()) {
            $data = $this->postData('wxapp');
            if ($wxapp->edit($data)) return $this->renderSuccess('更新成功');
            return $this->renderError('更新失败');
        }
        return $this->fetch('ad', compact('wxapp'));
    }

    /**
     * 导航栏设置
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function tabbar()
    {
        $model = WxappNavbarModel::detail();
        if (!$this->request->isAjax()) {
            return $this->fetch('tabbar', compact('model'));
        }
        $data = $this->postData('tabbar');
        if (!$model->edit($data)) {
            return $this->renderError('更新失败');
        }
        return $this->renderSuccess('更新成功');
    }

    /**
     * 防止中文乱码
     * @param $content
     * @return string
     */
    function iconv2($content)
    {
        return iconv("UTF-8", "GB2312//IGNORE", $content);
    }


}
