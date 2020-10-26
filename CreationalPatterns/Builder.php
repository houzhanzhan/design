<?php

// 建造者模式(Builder)
// 建造者模式（Builder Pattern）使用多个简单的对象一步一步构建成一个复杂的对象。这种类型的设计模式属于创建型模式，它提供了一种创建对象的最佳方式。

// 一个 Builder 类会一步一步构造最终的对象。该 Builder 类是独立于其他对象的。

// 介绍
// 意图：将一个复杂的构建与其表示相分离，使得同样的构建过程可以创建不同的表示。

// 主要解决：主要解决在软件系统中，有时候面临着"一个复杂对象"的创建工作，其通常由各个部分的子对象用一定的算法构成；由于需求的变化，这个复杂对象的各个部分经常面临着剧烈的变化，但是将它们组合在一起的算法却相对稳定。

// 何时使用：一些基本部件不会变，而其组合经常变化的时候。

// 如何解决：将变与不变分离开。

// 关键代码：建造者：创建和提供实例，导演：管理建造出来的实例的依赖关系。

// 应用实例： 1、去肯德基，汉堡、可乐、薯条、炸鸡翅等是不变的，而其组合是经常变化的，生成出所谓的"套餐"。

// 优点： 1、建造者独立，易扩展。 2、便于控制细节风险。

// 缺点： 1、产品必须有共同点，范围有限制。 2、如内部变化复杂，会有很多的建造类。

// 使用场景： 1、需要生成的对象具有复杂的内部结构。 2、需要生成的对象内部属性本身相互依赖。

// 注意事项：与工厂模式的区别是：建造者模式更加关注与零件装配的顺序。

// 建造者模式一般认为有四个角色:
//      1.产品角色，产品角色定义自身的组成属性

//      2.抽象建造者，抽象建造者定义了产品的创建过程以及如何返回一个产品

//      3.具体建造者，具体建造者实现了抽象建造者创建产品过程的方法，给产品的具体属性进行赋值定义

//      4.指挥者，指挥者负责与调用客户端交互，决定创建什么样的产品

/**
 *
 * 产品本身
 */
class Product
{
    private $_parts;
    public function __construct()
    {$this->_parts = array();}
    public function add($part)
    {return array_push($this->_parts, $part);}
}

/**
 * 建造者抽象类
 *
 */
abstract class Builder
{
    abstract public function buildPart1();
    abstract public function buildPart2();
    abstract public function getResult();
}

/**
 *
 * 具体建造者
 * 实现其具体方法
 */
class ConcreteBuilder extends Builder
{
    private $_product;
    public function __construct()
    {$this->_product = new Product();}
    public function buildPart1()
    {$this->_product->add("Part1");}
    public function buildPart2()
    {$this->_product->add("Part2");}
    public function getResult()
    {return $this->_product;}
}
/**
 *
 *导演者
 */
class Director
{
    public function __construct(Builder $builder)
    {
        $builder->buildPart1(); //导演指挥具体建造者生产产品
        $builder->buildPart2();
    }
}

// client
$buidler = new ConcreteBuilder();
$director = new Director($buidler);
$product = $buidler->getResult();
echo "<pre>";
var_dump($product);
echo "</pre>";
/*输出： object(Product)#2 (1) {
["_parts":"Product":private]=>
array(2) {
[0]=>string(5) "Part1"
[1]=>string(5) "Part2"
}
} */
