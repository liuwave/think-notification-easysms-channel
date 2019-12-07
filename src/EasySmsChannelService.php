<?php
/**
 * Created by PhpStorm.
 * User: liuwave
 * Date: 2019/12/7 16:46
 * Description:
 */

namespace liuwave\notification\EasySms;

use Overtrue\EasySms\EasySms;
use think\facade\Config;
use think\Service;

/**
 * Class EasySmsChannelService
 * @package liuwave\notification\EasySms
 */
class EasySmsChannelService extends Service
{
    
    /**
     *
     */
    public function register()
    {
        
        $this->app->bind(EasySms::class,function (){
            $config=Config::get('easysms');
            return new EasySms($config);
        });
    
    }
}