<?php
/**
 * Created by PhpStorm.
 * User: liuwave
 * Date: 2019/12/7 16:19
 * Description:
 */

namespace liuwave\notification\channel;

use yunwuxin\Notification;
use yunwuxin\notification\Channel;
use yunwuxin\notification\Notifiable;

class EasySms extends Channel
{
    
    /**
     * @inheritDoc
     */
    public function send($notifiable, Notification $notification)
    {
        // TODO: Implement send() method.
        
        $to = $notifiable->getPreparedData('EasySms');
        
        $message = $this->getMessage($notifiable, $notification);
        
        return app()
          ->make(\Overtrue\EasySms\EasySms::class)
          ->send($to, $message);
    
    
    }
}