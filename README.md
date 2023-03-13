# 橘猫去水印 （微信小程序）

 有问题可以去QQ交流群：790720186

 前端基于uniapp框架开发的，引用了colorUI、uviewUI组件库，感谢作者！
 
 后端部分业务php文件加密了一下，只想保留一下作者名字。也可以自行二开不使用加密的文件。

 小白在线教程文档：https://www.kancloud.cn/xiaofanmo/jumao_free

<br>

### 更新内容

###### 2023-01-11  (v1.0.1)
1、增加批量解析页面。如不需要的在index.vue文件将跳转url改为null<br>
2、增加了一个比较垃圾的某音主页解析方法，具体代码在Apis.php文件中

###### 2023-01-12  (v1.0.2)
增加激励广告，用户需观看一次广告后可24小时内不限次数下载视频<br>

###### 2023-01-15  (v1.0.3)
根据用户需求更新，图片/视频下载接口在后台可随时更换<br>

###### 2023-03-13  (v1.0.4)
新增以直链下载视频为主，服务器中转为辅。有助于下载视频速度<br>

<br>

### 自定义接口配置

 自定义解析接口配置的文件路径是 
 source/application/api/controller/Apis.php 中的analysis方法
 返回接口格式如下
```
return [
    "code" => 200,  // 200表示解析成功   -1 表示失败
    "data" => [
        "title" => "这里是分享文案",
        "cover" => "这里是封面图片链接",
        "images" => [], // 这里是图集的数组
        "video" => "这里是视频链接",
    ],
    "msg" => "解析成功"
];
```

下方是模板
```
public function analysis($videoUrl)
{
    try {
        $url = "https://解析接口/Analyse?url=" . $videoUrl;
        $s = file_get_contents($url);
        $s = json_decode($s, true);

        // 这个接口返回的状态码code 200表示解析成功
        if ($s['code'] == '200') {

           // 直接取返回数据中的data值
            $s = $s['data'];

            $reData = [
                "title" => $s['desc'], // 将分享文案存入
                "cover" => $s['cover'] // 将封面链接存入
            ];

            // 这个接口返回的type 等于image则表示返回图集
            if ($s['type'] == 'image') {

                // 存入图集
                $reData['images'] = $s['pics'];
            } else {

                // 存入视频链接
                $reData['video'] = $this->getUrl302($s['playAddr']);
            }

            return [
                "code" => 200,
                "data" => $reData,
                "msg" => "解析成功"
            ];
        } else {
            return [
                "code" => -1,
                "data" => null,
                "msg" => $s['message']
            ];
        }
    } catch (\Exception $e) {
        return [
            "code" => -1,
            "data" => null,
            "msg" => "解析失败，出错了"
        ];
    }
}

```

## 免责声明

本仓库只为学习研究，如涉及侵犯个人或者团体利益，请与我取得联系，我将主动删除一切相关资料，谢谢！
