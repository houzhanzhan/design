<?php
/* 访问者模式是一种行为型模式，访问者表示一个作用于某对象结构中各元素的操作。它可以在不修改各元素类的前提下定义作用于这些元素的新操作，即动态的增加具体访问者角色。

访问者模式利用了双重分派。先将访问者传入元素对象的Accept方法中，然后元素对象再将自己传入访问者，之后访问者执行元素的相应方法。

主要角色

抽象访问者角色(Visitor)：为该对象结构(ObjectStructure)中的每一个具体元素提供一个访问操作接口。该操作接口的名字和参数标识了 要访问的具体元素角色。
这样访问者就可以通过该元素角色的特定接口直接访问它。

具体访问者角色(ConcreteVisitor)：实现抽象访问者角色接口中针对各个具体元素角色声明的操作。

抽象节点（Node）角色：该接口定义一个accept操作接受具体的访问者。
具体节点（Node）角色：实现抽象节点角色中的accept操作。
对象结构角色(ObjectStructure)：这是使用访问者模式必备的角色。它要具备以下特征：能枚举它的元素；可以提供一个高层的接口以允许该访问者访问它的元素；可以是一个复合（组合模式）或是一个集合，如一个列表或一个无序集合(在PHP中我们使用数组代替，因为PHP中的数组本来就是一个可以放置任何类型数据的集合)

优点： 1、符合单一职责原则。 2、优秀的扩展性。 3、灵活性。

缺点： 1、具体元素对访问者公布细节，违反了迪米特原则。 2、具体元素变更比较困难。 3、违反了依赖倒置原则，依赖了具体类，没有依赖抽象。

使用场景： 1、对象结构中对象对应的类很少改变，但经常需要在此对象结构上定义新的操作。 2、需要对一个对象结构中的对象进行很多不同的并且不相关的操作，而需要避免让这些操作"污染"这些对象的类，
也不希望在增加新操作时修改这些类。
 */

interface ServiceVisitor
{
    public function SendMsg(SendMessage $s);
    function PushMsg(PushMessage $p);
}

class AliYun implements ServiceVisitor
{
    public function SendMsg(SendMessage $s)
    {
        echo '阿里云发送短信！', PHP_EOL;
    }
    public function PushMsg(PushMessage $p)
    {
        echo '阿里云推送信息！', PHP_EOL;
    }
}

class JiGuang implements ServiceVisitor
{
    public function SendMsg(SendMessage $s)
    {
        echo '极光发送短信！', PHP_EOL;
    }
    public function PushMsg(PushMessage $p)
    {
        echo '极光推送短信！', PHP_EOL;
    }
}

interface Message
{
    public function Msg(ServiceVisitor $v);
}

class PushMessage implements Message
{
    public function Msg(ServiceVisitor $v)
    {
        echo '推送脚本启动：';
        $v->PushMsg($this);
    }
}

class SendMessage implements Message
{
    public function Msg(ServiceVisitor $v)
    {
        echo '短信脚本启动：';
        $v->SendMsg($this);
    }
}

class ObjectStructure
{
    private $elements = [];

    public function Attach(Message $element)
    {
        $this->elements[] = $element;
    }

    public function Detach(Message $element)
    {
        $position = 0;
        foreach ($this->elements as $e) {
            if ($e == $element) {
                unset($this->elements[$position]);
                break;
            }
            $position++;
        }
    }

    public function Accept(ServiceVisitor $visitor)
    {
        foreach ($this->elements as $e) {
            $e->Msg($visitor);
        }
    }

}

$o = new ObjectStructure();
$o->Attach(new PushMessage());
$o->Attach(new SendMessage());

$v1 = new AliYun();
$v2 = new JiGuang();

$o->Accept($v1);
$o->Accept($v2);
