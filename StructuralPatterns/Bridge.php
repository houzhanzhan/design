<?php

// 桥接模式(Bridge)
// 桥接（Bridge）是用于把抽象化与实现化解耦，使得二者可以独立变化。这种类型的设计模式属于结构型模式，它通过提供抽象化和实现化之间的桥接结构，来实现二者的解耦。

// 这种模式涉及到一个作为桥接的接口，使得实体类的功能独立于接口实现类。这两种类型的类可被结构化改变而互不影响。

// 我们通过下面的实例来演示桥接模式（Bridge Pattern）的用法。其中，可以使用相同的抽象类方法但是不同的桥接实现类，来画出不同颜色的圆。

// 介绍
// 意图：将抽象部分与实现部分分离，使它们都可以独立的变化。

// 主要解决：在有多种可能会变化的情况下，用继承会造成类爆炸问题，扩展起来不灵活。

// 何时使用：实现系统可能有多个角度分类，每一种角度都可能变化。

// 如何解决：把这种多角度分类分离出来，让它们独立变化，减少它们之间耦合。

// 关键代码：抽象类依赖实现类。

// 应用实例： 1、猪八戒从天蓬元帅转世投胎到猪，转世投胎的机制将尘世划分为两个等级，即：灵魂和肉体，前者相当于抽象化，后者相当于实现化。生灵通过功能的委派，调用肉体对象的功能，使得生灵可以动态地选择。 2、墙上的开关，可以看到的开关是抽象的，不用管里面具体怎么实现的。

// 优点： 1、抽象和实现的分离。 2、优秀的扩展能力。 3、实现细节对客户透明。

// 缺点：桥接模式的引入会增加系统的理解与设计难度，由于聚合关联关系建立在抽象层，要求开发者针对抽象进行设计与编程。

// 使用场景： 1、如果一个系统需要在构件的抽象化角色和具体化角色之间增加更多的灵活性，避免在两个层次之间建立静态的继承联系，通过桥接模式可以使它们在抽象层建立一个关联关系。 2、对于那些不希望使用继承或因为多层次继承导致系统类的个数急剧增加的系统，桥接模式尤为适用。 3、一个类存在两个独立变化的维度，且这两个维度都需要进行扩展。

// 注意事项：对于两个独立变化的维度，使用桥接模式再适合不过了。

// 桥接与适配器模式的关系（适配器模式上面已讲解）：
// 桥接属于聚合关系，两者关联 但不继承
// 适配器属于组合关系，适配者需要继承源

/**
 *
 *安全式合成模式
 */
interface Component
{
    public function getComposite(); //返回自己的实例
    public function operation();
}

class Composite implements Component
{ // 树枝组件角色
    private $_composites;
    public function __construct()
    {$this->_composites = array();}
    public function getComposite()
    {return $this;}
    public function operation()
    {
        foreach ($this->_composites as $composite) {
            $composite->operation();
        }
    }

    public function add(Component $component)
    { //聚集管理方法 添加一个子对象
        $this->_composites[] = $component;
    }

    public function remove(Component $component)
    { // 聚集管理方法 删除一个子对象
        foreach ($this->_composites as $key => $row) {
            if ($component == $row) {unset($this->_composites[$key]);return true;}
        }
        return false;
    }

    public function getChild()
    { // 聚集管理方法 返回所有的子对象
        return $this->_composites;
    }

}

class Leaf implements Component
{
    private $_name;
    public function __construct($name)
    {$this->_name = $name;}
    public function operation()
    {}
    public function getComposite()
    {return null;}
}

// client
$leaf1 = new Leaf('first');
$leaf2 = new Leaf('second');

$composite = new Composite();
$composite->add($leaf1);
$composite->add($leaf2);
$composite->operation();

$composite->remove($leaf2);
$composite->operation();

/**
 *
 *透明式合成模式
 */
/* interface Component
{ // 抽象组件角色
public function getComposite(); // 返回自己的实例
public function operation(); // 示例方法
public function add(Component $component); // 聚集管理方法,添加一个子对象
public function remove(Component $component); // 聚集管理方法 删除一个子对象
public function getChild(); // 聚集管理方法 返回所有的子对象
} */

/* class Composite implements Component
{ // 树枝组件角色
private $_composites;
public function __construct()
{$this->_composites = array();}
public function getComposite()
{return $this;}
public function operation()
{ // 示例方法，调用各个子对象的operation方法
foreach ($this->_composites as $composite) {
$composite->operation();
}
}
public function add(Component $component)
{ // 聚集管理方法 添加一个子对象
$this->_composites[] = $component;
}
public function remove(Component $component)
{ // 聚集管理方法 删除一个子对象
foreach ($this->_composites as $key => $row) {
if ($component == $row) {unset($this->_composites[$key]);return true;}
}
return false;
}
public function getChild()
{ // 聚集管理方法 返回所有的子对象
return $this->_composites;
}

} */

/* class Leaf implements Component
{
private $_name;
public function __construct($name)
{$this->_name = $name;}
public function operation()
{echo $this->_name . "<br>";}
public function getComposite()
{return null;}
public function add(Component $component)
{return false;}
public function remove(Component $component)
{return false;}
public function getChild()
{return null;}
}

// client
$leaf1 = new Leaf('first');
$leaf2 = new Leaf('second');

$composite = new Composite();
$composite->add($leaf1);
$composite->add($leaf2);
$composite->operation();

$composite->remove($leaf2);
$composite->operation(); */
