<?php

namespace app\api\controller;

use app\api\model\Wxapp as WxappModel;
use app\api\model\WxappHelp;
use think\Exception;

/**
 * 解析接口配置
 * Class Apis
 * @package app\api\controller
 */
class Apis extends Controller
{


    public function analysis($videoUrl)
    {
        try {
            $url = "这里填写接口" . $videoUrl;
            $s = file_get_contents($url);
            $s = json_decode($s, true);

            if ($s['code'] == '0001') {
                $s = $s['data'];

                $reData = [
                    "title" => $s['desc'],
                    "cover" => $s['cover']
                ];
                if ($s['type'] == '2') {
                    $reData['images'] = $s['pics'];
                } else {
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
                    "msg" => "解析失败，不支持该平台"
                ];
            }
        } catch (Exception $e) {
            return [
                "code" => -1,
                "data" => null,
                "msg" => "解析失败，程序出错了"
            ];
        }
    }




    /**
     * 抖音用户主页批量解析
     * 一个很辣鸡的方式实现的，需要定期更换cookie，因为我不会js逆向，所以只能这样了！
     * 抖音已验证cookie获取方法是浏览器使用手机端模拟访问，找到这个接口的cookie （https://m.douyin.com/web/api/v2/aweme/post/）
     * @param $url
     * @param int $times
     * @return array
     */
    public function batch($url, $times = 0)
    {
        $loc = get_headers($url, true)['Location'];
        preg_match('/user\/(.*)\?/', $loc, $id);

        $header = [
            'User-Agent:Mozilla/5.0 (Linux; U; Android 9; zh-cn; Redmi Note 5 Build/PKQ1.180904.001) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/11.10.8',

            // cookie需要定期更换
            'cookie:ttwid=1|NZaWlL7NzUVDOZ6etldwTWK-saQirfFEmY71rji0j-U|1663404934|d85fbbd95be41fd789cbb03c82f2761eedbdba93afe1fe8f2a4b501e230edfbd; s_v_web_id=verify_laewio5w_Zoffu7Sb_B9vb_4qIf_9PEJ_sUW3L7inFbk2; _tea_utm_cache_1243={"utm_source":"copy","utm_medium":"android","utm_campaign":"client_share"}; ttcid=9d8eeec9b44047c6af47a4b2f080709c12; _tea_utm_cache_2018={"utm_source":"copy","utm_medium":"android","utm_campaign":"client_share"}; __ac_nonce=063bf8b1e000821019c04; __ac_signature=_02B4Z6wo00f01UeqHxgAAIDBx6jlWXV8QCVHihuAADJY95; msToken=fJM_PEtbVGpqkOpONkXtRy8TEFbIx8J8L0t_3vtLvs4P_R33yDoPXTMAjMT5CzCPR4HQYELsm19cskCTVnviTWTYdEmYyGI7zf-XmC5keQ1dquHfUwwV; msToken=2g4NAFm3s1wU-DY9LPpIb0eStrcs5yY95WHNT8UC9RdTKqH9fKgQw4-6B70dWC3vRSVqN59YH7WbZZFqFVxeLbRud3BMzs_D5O7ZISgjNu943ddRYTtJ'
            ];
        $arr = json_decode($this->curl($this->splicingUrl($id[1], $times),$header), true);

        if (count($arr['aweme_list']) <= 0) {
            return $this->renderError("解析失败或该账号是私密账号");
        }

        $videoList = [];
        foreach ($arr['aweme_list'] as $item) {
            array_push($videoList, [
                "title" => $item['desc'],
                "cover" => $item['video']['origin_cover']['url_list'][0],
                "video" => $item['video']['play_addr']['url_list'][0],
            ]);
        }

        $videoList = [
            "list" => $videoList,
            "times" => $arr['has_more'] == 1 ? $arr['max_cursor'] : -1
        ];
        return $this->renderSuccess($videoList, "解析成功");
    }

    function splicingUrl($sec_uid, $max_cursor = 0, $count = 21)
    {
        $data = [
            "reflow_source" => "reflow_page",
            "sec_uid" => $sec_uid,
            "count" => $count,
            "max_cursor" => $max_cursor,
            "msToken" => "9dF1LXc8TN7d_q4QpJPCjTwKPskRHaGk-9BcjSOi8FAe1KIIoNOVuXpLQS5XvRGi_zwMawKyIZtL5c04VotilnDd_kVrhMm_7qXhDxU0frbAuedXS-pu",
            "X-Bogus" => "DFSzswSOZSkANjtISDOqCM9WX7jy",
            "_signature" => "_02B4Z6wo00001Vsi-TQAAIDB2yADdVedF-1bMv2AADV68d"
        ];

        return "https://m.douyin.com/web/api/v2/aweme/post/?reflow_source=reflow_page&sec_uid=" .
            $data['sec_uid'] . "&count=" .
            $data['count'] . "&max_cursor=" .
            $data['max_cursor'] . "&msToken=" .
            $data['msToken'] . "&X-Bogus=" .
            $data['X-Bogus'] . "&_signature=" .
            $data['_signature'] . "";

    }


    private function curl($url, $headers = [])
    {
        $header = ['User-Agent:Mozilla/5.0 (Linux; U; Android 9; zh-cn; Redmi Note 5 Build/PKQ1.180904.001) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/11.10.8'];
        $con = curl_init((string)$url);
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
        if (!empty($headers)) {
            curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
        } else {
            curl_setopt($con, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($con, CURLOPT_TIMEOUT, 5000);
        $result = curl_exec($con);
        return $result;
    }

    function getUrl302($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $header = array('User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $info['url'];
    }

}
