<?php

/* 责任链模式
责任链模式（Chain of Responsibility Pattern）为请求创建了一个接收者对象的链。这种模式给予请求的类型，对请求的发送者和接收者进行解耦。这种类型的设计模式属于行为型模式。

在这种模式中，通常每个接收者都包含对另一个接收者的引用。如果一个对象不能处理该请求，那么它会把相同的请求传给下一个接收者，依此类推。

介绍
意图：避免请求发送者与接收者耦合在一起，让多个对象都有可能接收请求，将这些对象连接成一条链，并且沿着这条链传递请求，直到有对象处理它为止。

主要解决：职责链上的处理者负责处理请求，客户只需要将请求发送到职责链上即可，无须关心请求的处理细节和请求的传递，所以职责链将请求的发送者和请求的处理者解耦了。

何时使用：在处理消息的时候以过滤很多道。

如何解决：拦截的类都实现统一接口。

关键代码：Handler 里面聚合它自己，在 HandlerRequest 里判断是否合适，如果没达到条件则向下传递，向谁传递之前 set 进去。

应用实例： 1、红楼梦中的"击鼓传花"。 2、JS 中的事件冒泡。 3、JAVA WEB 中 Apache Tomcat 对 Encoding 的处理，Struts2 的拦截器，jsp servlet 的 Filter。

优点： 1、降低耦合度。它将请求的发送者和接收者解耦。 2、简化了对象。使得对象不需要知道链的结构。 3、增强给对象指派职责的灵活性。通过改变链内的成员或者调动它们的次序，允许动态地新增或者删除责任。 4、增加新的请求处理类很方便。

缺点： 1、不能保证请求一定被接收。 2、系统性能将受到一定影响，而且在进行代码调试时不太方便，可能会造成循环调用。 3、可能不容易观察运行时的特征，有碍于除错。

使用场景： 1、有多个对象可以处理同一个请求，具体哪个对象处理该请求由运行时刻自动确定。 2、在不明确指定接收者的情况下，向多个对象中的一个提交一个请求。 3、可动态指定一组对象处理请求。

实例

短信内容过滤的功能。大家都知道，我们对广告有着严格的规定，许多词都在广告法中被标记为禁止使用的词汇，更有些严重的词汇可能会引来不必要的麻烦。
这时候，我们就需要一套过滤机制来进行词汇的过滤。针对不同类型的词汇，我们可以通过责任链来进行过滤，比如严重违法的词汇当然是这条信息都不能通过。
一些比较严重但可以绕过的词，我们可以进行替换或者加星处理，这样，客户端不需要一大堆的if..else..来进行逻辑判断，使用责任链让他们一步步的进行审批就好啦！！ */

// 词汇过滤链条
abstract class FilterChain
{
    protected $next;
    public function setNext($next)
    {
        $this->next = $next;
    }
    abstract public function filter($message);
}

// 严禁词汇
class FilterStrict extends FilterChain
{
    public function filter($message)
    {
        foreach (['枪X', '弹X', '毒X'] as $v) {
            if (strpos($message, $v) !== false) {
                throw new \Exception('该信息包含敏感词汇！');
            }
        }
        if ($this->next) {
            return $this->next->filter($message);
        } else {
            return $message;
        }
    }
}

// 警告词汇
class FilterWarning extends FilterChain
{
    public function filter($message)
    {
        $message = str_replace(['打架', '丰胸', '偷税'], '*', $message);
        if ($this->next) {
            return $this->next->filter($message);
        } else {
            return $message;
        }
    }
}

// 手机号加星
class FilterMobile extends FilterChain
{
    public function filter($message)
    {
        $message = preg_replace("/(1[3|5|7|8]\d)\d{4}(\d{4})/i", "$1****$2", $message);
        if ($this->next) {
            return $this->next->filter($message);
        } else {
            return $message;
        }
    }
}

$f1 = new FilterStrict();
$f2 = new FilterWarning();
$f3 = new FilterMobile();

$f1->setNext($f2);
$f2->setNext($f3);

$m1 = "现在开始测试链条1：语句中不包含敏感词，需要替换掉打架这种词，然后给手机号加上星：13333333333，这样的数据才可以对外展示哦";
echo $f1->filter($m1);
echo PHP_EOL;

$m2 = "现在开始测试链条2：这条语句走不到后面，因为包含了毒X，直接就报错了！！！语句中不包含敏感词，需要替换掉打架这种词，然后给手机号加上星：13333333333，这样的数据才可以对外展示哦";
echo $f1->filter($m2);
echo PHP_EOL;
