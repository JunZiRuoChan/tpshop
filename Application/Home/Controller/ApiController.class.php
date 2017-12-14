<?php
/**
 * @Author: Marte
 * @Date:   2017-07-15 14:44:11
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-07-15 15:05:29
 */
namespace Home\Controller;
class ApiController{
    public function getWeather(){
        $city = '成都';
        //1、确定url
        $url = "http://api.map.baidu.com/telematics/v2/weather?location=".$city."&ak=B8aced94da0b345579f481a1294c9094";
        //2、判断请求方式
        //3、发送请求
        $weather_info = request($url,false);
        //处理返回数据XML
        $weather_info = simplexml_load_string($weather_info);
        echo '实时温度：'.$weather_info->results->result[0]->date."<br>";
        echo '天气情况：'.$weather_info->results->result[0]->weather;
    }
    public function getPhone(){
        $phone = "15228876285";
        //1、确定url
        $url = "http://cx.shouji.360.cn/phonearea.php?number=".$phone;
        //2、判断请求方式
        //3、发送请求
        $phone_info = request($url,false);
        $phone_info = json_decode($phone_info);
        echo '查询号码为：'.$phone."<br />";
        echo '省份：'.$phone_info->data->province."<br />";
        echo '城市：'.$phone_info->data->city."<br />";
        echo '运营商：'.$phone_info->data->sp."<br />";
    }
}