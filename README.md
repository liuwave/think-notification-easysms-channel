# EasySms Notification channel  For ThinkPHP6"

使用 [overtrue/easy-sms](https://github.com/overtrue/easy-sms) 发送 ThinkPHP6 消息通知。

## 安装

```shell
$ composer require liuwave/think-notification-easysms-channel
```

## 配置

1、安装插件会自动生成 `config/easysms.php` 文件，若未生成，可以执行以下命令：
```shell 
$ php think vendor:publish
```
2、在`config/easysms.php` 中修改配置。



## 使用

### 1、创建通知
通知类，需要实现`channels`和`toEasySms`方法
```php
namespace app\common\notification;

use liuwave\notification\EasySms\channel\EasySms as EasySmsChannel;
use liuwave\notification\EasySms\message\EasySms as EasySmsMessage;
use yunwuxin\Notification;

/**
 * Class ValidateCode
 * @package app\common\notification
 */
class ValidateCode extends Notification
{
    
    /**
     * @var string
     */
    public $code = '';
    /**
     * @var string
     */
    public $template = "";
    
    /**
     * ValidateCode constructor.
     *
     * @param        $template
     * @param string $code
     */
    public function __construct(string $template, string $code = '')
    {
        $this->template = $template;
        $this->code      = $code;
        
    }
    
    /**
     * @inheritDoc
     */
    public function channels($notifiable)
    {
        return [ EasySmsChannel::class ];
    }
    
    /**
     * @param \yunwuxin\notification\Notifiable $notifiable
     *
     * @return \liuwave\notification\EasySms\message\EasySms
     */
    public function toEasySms($notifiable)
    {
        return ( new EasySmsMessage )->setContent('验证码是$code')
          ->setTemplate($this->template)
          ->setData([
            'code' => empty($this->code) ? rand(1000, 9999) : $this->code,
          ]);
    }
    
}
```
 ### 发送短信通知
 
 继承创建手机号码类,需要插入trait `yunwuxin\notification\Notifiable` ，这里直接继承`\Overtrue\EasySms\PhoneNumber`，并实现`prepareEasySms`方法。
 ```php
namespace app\common\notification\user;

use yunwuxin\notification\Notifiable;

/**
 * Class PhoneNumber
 * @package app\common\notification\notifiable
 * @mixin  Notifiable
 */
class PhoneNumber extends \Overtrue\EasySms\PhoneNumber
{
    use Notifiable;
    
    /**
     * @return $this
     */
    public function prepareEasySms()
    {
        return $this;
    }
    
}

```
 

执行发送短信

```php
        $to = '181*****932';   
        // 使用 Notifiable Trait 发送
        (new \app\common\notification\user\PhoneNumber($to))->notify(new \app\common\notification\ValidateCode('SMS_15****670'));

        // 使用 Notification Facade 发送
        \yunwuxin\facade\Notification::send( new \app\common\notification\user\PhoneNumber($to), new \app\common\notification\ValidateCode('SMS_15****670'));
        

```
 
