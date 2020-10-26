<?php

/* 享元模式
享元模式（Flyweight Pattern）主要用于减少创建对象的数量，以减少内存占用和提高性能。这种类型的设计模式属于结构型模式，它提供了减少对象数量从而改善应用所需的对象结构的方式。

享元模式尝试重用现有的同类对象，如果未找到匹配的对象，则创建新对象。我们将通过创建 5 个对象来画出 20 个分布于不同位置的圆来演示这种模式。由于只有 5 种可用的颜色，所以 color 属性被用来检查现有的 Circle 对象。

介绍
意图：运用共享技术有效地支持大量细粒度的对象。

主要解决：在有大量对象时，有可能会造成内存溢出，我们把其中共同的部分抽象出来，如果有相同的业务请求，直接返回在内存中已有的对象，避免重新创建。

何时使用： 1、系统中有大量对象。 2、这些对象消耗大量内存。 3、这些对象的状态大部分可以外部化。 4、这些对象可以按照内蕴状态分为很多组，当把外蕴对象从对象中剔除出来时，每一组对象都可以用一个对象来代替。 5、系统不依赖于这些对象身份，这些对象是不可分辨的。

如何解决：用唯一标识码判断，如果在内存中有，则返回这个唯一标识码所标识的对象。

关键代码：用 HashMap 存储这些对象。

应用实例： 1、JAVA 中的 String，如果有则返回，如果没有则创建一个字符串保存在字符串缓存池里面。 2、数据库的数据池。

优点：大大减少对象的创建，降低系统的内存，使效率提高。

缺点：提高了系统的复杂度，需要分离出外部状态和内部状态，而且外部状态具有固有化的性质，不应该随着内部状态的变化而变化，否则会造成系统的混乱。

使用场景： 1、系统有大量相似对象。 2、需要缓冲池的场景。

注意事项： 1、注意划分外部状态和内部状态，否则可能会引起线程安全问题。 2、这些类必须有一个工厂对象加以控制。

享元模式中主要角色：
抽象享元（Flyweight）角色：此角色是所有的具体享元类的超类，为这些类规定出需要实现的公共接口。那些需要外运状态的操作可以通过调用商业以参数形式传入

具体享元（ConcreteFlyweight）角色：实现Flyweight接口，并为内部状态（如果有的话）拉回存储空间。ConcreteFlyweight对象必须是可共享的。它所存储的状态必须是内部的

不共享的具体享元（UnsharedConcreteFlyweight）角色：并非所有的Flyweight子类都需要被共享。Flyweigth使共享成为可能，但它并不强制共享

享元工厂(FlyweightFactory)角色：负责创建和管理享元角色。本角色必须保证享元对象可能被系统适当地共享

客户端(Client)角色：本角色需要维护一个对所有享元对象的引用。本角色需要自行存储所有享元对象的外部状态 */

/***
 * 享元模式
 * Class Flyweight
 */

abstract class Resources
{
    public $resource = null;

    abstract public function operate();
}

class unShareFlyWeight extends Resources
{
    public function __construct($resource_str)
    {
        $this->resource = $resource_str;
    }

    public function operate()
    {
        echo $this->resource . "<br>";
    }
}

class shareFlyWeight extends Resources
{
    private $resources = array();

    public function get_resource($resource_str)
    {
        if (isset($this->resources[$resource_str])) {
            return $this->resources[$resource_str];
        } else {
            return $this->resources[$resource_str] = $resource_str;
        }
    }

    public function operate()
    {
        foreach ($this->resources as $key => $resources) {
            echo $key . ":" . $resources . "<br>";
        }
    }
}

// client
$flyweight = new shareFlyWeight();
$flyweight->get_resource('a');
$flyweight->operate();

$flyweight->get_resource('b');
$flyweight->operate();

$flyweight->get_resource('c');
$flyweight->operate();

// 不共享的对象，单独调用
$uflyweight = new unShareFlyWeight('A');
$uflyweight->operate();

$uflyweight = new unShareFlyWeight('B');
$uflyweight->operate();

//结果
//a:a
//a:a
//b:b
//a:a
//b:b
//c:c
//A
//B
