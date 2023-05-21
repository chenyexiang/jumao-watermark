# 橘猫去水印 （微信小程序）
 
 后端代码可以去GitHub获取，有更新的话也在那里
 
 有问题可联系微信小号：FanmoNetwork。或者QQ交流群：790720186
 
 前端基于uniapp框架开发的，引用了colorUI、uviewUI组件库，感谢作者！
 
 后端部分业务php文件加密了一下，只想保留一下作者名字。也可以自行二开不使用加密的文件。

 小白在线教程文档：https://www.kancloud.cn/xiaofanmo/jumao_free


 自定义解析接口配置的文件路径是 
 source/application/api/controller/Apis.php 中的analysis函数
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
