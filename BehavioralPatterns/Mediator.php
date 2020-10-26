<?php

/* 中介者模式
中介者模式（Mediator Pattern）是用来降低多个对象和类之间的通信复杂性。这种模式提供了一个中介类，该类通常处理不同类之间的通信，并支持松耦合，使代码易于维护。中介者模式属于行为型模式。

主要角色

中介者模式用于开发一个对象，这个对象能够在类似对象相互之间不直接相互的情况下传送或者调解对这些对象的集合的修改。 一般处理具有类似属性，需要保持同步的非耦合对象时，最佳的做法就是中介者模式。
PHP中不是特别常用的设计模式。

应用实例： 1、中国加入 WTO 之前是各个国家相互贸易，结构复杂，现在是各个国家通过 WTO 来互相贸易。 2、机场调度系统。 3、MVC 框架，其中C（控制器）就是 M（模型）和 V（视图）的中介者。

优点： 1、降低了类的复杂度，将一对多转化成了一对一。 2、各个类之间的解耦。 3、符合迪米特原则。

缺点：中介者会庞大，变得复杂难以维护。

使用场景： 1、系统中对象之间存在比较复杂的引用关系，导致它们之间的依赖关系结构混乱而且难以复用该对象。 2、想通过一个中间类来封装多个类中的行为，而又不想生成太多的子类。 */

abstract class Mediator
{
    abstract public function Send(String $message, Colleague $colleague);
}

class ConcreteMediator extends Mediator
{
    public $colleague1;
    public $colleague2;

    public function Send(String $message, Colleague $colleague)
    {
        if ($colleague == $this->colleague1) {
            $this->colleague2->Notify($message);
        } else {
            $this->colleague1->Notify($message);
        }
    }
}
abstract class Colleague
{
    protected $mediator;
    public function __construct(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }

}

class ConcreteColleague1 extends Colleague
{
    public function Send(String $message)
    {
        $this->mediator->Send($message, $this);
    }
    public function Notify(String $message)
    {
        echo "同事1得到信息：" . $message, PHP_EOL;
    }
}

class ConcreteColleague2 extends Colleague
{
    public function Send(String $message)
    {
        $this->mediator->Send($message, $this);
    }
    public function Notify(String $message)
    {
        echo "同事2得到信息：" . $message;
    }
}

$m = new ConcreteMediator();

$c1 = new ConcreteColleague1($m);
$c2 = new ConcreteColleague2($m);

$m->colleague1 = $c1;
$m->colleague2 = $c2;

$c1->Send("吃过饭了吗？");
$c2->Send("没有呢，你打算请客？");
