<?php

namespace app\store\controller\setting;

use app\store\controller\Controller;
use think\Cache as Driver;

/**
 * 清理缓存
 * Class Index
 * @package app\store\controller
 */
class Cache extends Controller
{
    /**
     * 清理缓存
     * @param bool $isForce
     * @return mixed
     */
    public function clear($isForce = false)
    {
        if ($this->request->isAjax()) {
            $data = $this->postData('cache');
            $this->rmCache($data['keys'], isset($data['isForce']) ? !!$data['isForce'] : false);
            return $this->renderSuccess('操作成功');
        }
        return $this->fetch('clear', [
            'cacheList' => $this->getItems(),
            'isForce' => !!$isForce ?: config('app_debug'),
        ]);
    }

    /**
     * 数据缓存项目
     * @return array
     */
    private function getItems()
    {
        $wxapp_id = $this->store['wxapp']['wxapp_id'];
        return [
//            'category' => [
//                'type' => 'cache',
//                'key' => 'category_' . $wxapp_id,
//                'name' => '商品分类'
//            ],
            'setting' => [
                'type' => 'cache',
                'key' => 'setting_' . $wxapp_id,
                'name' => '系统设置'
            ],
            'wxapp' => [
                'type' => 'cache',
                'key' => 'wxapp_' . $wxapp_id,
                'name' => '小程序设置'
            ],
//            'dealer' => [
//                'type' => 'cache',
//                'key' => 'dealer_setting_' . $wxapp_id,
//                'name' => '分销设置'
//            ],
//            'temp' => [
//                'type' => 'file',
//                'name' => '临时图片',
//                'dirPath' => [
//                    'web' => WEB_PATH . 'temp' . DS . $wxapp_id . DS,
//                    'runtime' => RUNTIME_PATH . DS . 'image' . DS . $wxapp_id . DS
//                ]
//            ],
        ];
    }

    /**
     * 删除缓存
     * @param $keys
     * @param bool $isForce
     */
    private function rmCache($keys, $isForce = false)
    {
        if ($isForce === true) {
            Driver::clear();
        } else {
            $cacheList = $this->getItems();
            $keys = array_intersect(array_keys($cacheList), $keys);
            foreach ($keys as $key) {
                $item = $cacheList[$key];
                if ($item['type'] === 'cache') {
                    Driver::has($item['key']) && Driver::rm($item['key']);
                } elseif ($item['type'] === 'file') {
                    $this->deltree($item['dirPath']);
                }
            }
        }
    }

    /**
     * 删除目录下所有文件
     * @param $dirPath
     * @return bool
     */
    private function deltree($dirPath)
    {
        if (is_array($dirPath)) {
            foreach ($dirPath as $path)
                $this->deleteFolder($path);
        } else {
            return $this->deleteFolder($dirPath);
        }
        return true;
    }

    /**
     * 递归删除指定目录下所有文件
     * @param $path
     * @return bool
     */
    private function deleteFolder($path)
    {
        if (!is_dir($path))
            return false;
        // 扫描一个文件夹内的所有文件夹和文件
        foreach (scandir($path) as $val) {
            // 排除目录中的.和..
            if (!in_array($val, ['.', '..'])) {
                // 如果是目录则递归子目录，继续操作
                if (is_dir($path . $val)) {
                    // 子目录中操作删除文件夹和文件
                    $this->deleteFolder($path . $val . DS);
                    // 目录清空后删除空文件夹
                    rmdir($path . $val . DS);
                } else {
                    // 如果是文件直接删除
                    unlink($path . $val);
                }
            }
        }
        return true;
    }

}
