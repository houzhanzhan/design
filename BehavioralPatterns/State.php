<?php

/* 状态模式
状态模式当一个对象的内在状态改变时允许改变其行为，这个对象看起来像是改变了其类。状态模式主要解决的是当控制一个对象状态的条件表达式过于复杂时的情况。把状态的判断逻辑转移到表示不同状态的一系列类中，可以把复杂的判断逻辑简化。

角色：
上下文环境（Work）：它定义了客户程序需要的接口并维护一个具体状态角色的实例，将与状态相关的操作委托给当前的具体对象来处理。
抽象状态（State）：定义一个接口以封装使用上下文环境的的一个特定状态相关的行为。
具体状态（AmState）：实现抽象状态定义的接口。

优点： 1、封装了转换规则。 2、枚举可能的状态，在枚举状态之前需要确定状态种类。 3、将所有与某个状态有关的行为放到一个类中，并且可以方便地增加新的状态，只需要改变对象状态即可改变对象的行为。 4、允许状态转换逻辑与状态对象合成一体，而不是某一个巨大的条件语句块。 5、可以让多个环境对象共享一个状态对象，从而减少系统中对象的个数。

缺点： 1、状态模式的使用必然会增加系统类和对象的个数。 2、状态模式的结构与实现都较为复杂，如果使用不当将导致程序结构和代码的混乱。 3、状态模式对"开闭原则"的支持并不太好，对于可以切换状态的状态模式，增加新的状态类需要修改那些负责状态转换的源代码，否则无法切换到新增状态，而且修改某个状态类的行为也需修改对应类的源代码。

使用场景： 1、行为随状态改变而改变的场景。 2、条件、分支语句的代替者。 */
interface State
{ // 抽象状态角色
    public function handle(Context $context); // 方法示例
}

class ConcreteStateA implements State
{ // 具体状态角色A
    private static $_instance = null;
    private function __construct()
    {}
    public static function getInstance()
    { // 静态工厂方法，返还此类的唯一实例
        if (is_null(self::$_instance)) {
            self::$_instance = new ConcreteStateA();
        }
        return self::$_instance;
    }

    public function handle(Context $context)
    {
        echo 'concrete_a' . "<br>";
        $context->setState(ConcreteStateB::getInstance());
    }

}

class ConcreteStateB implements State
{ // 具体状态角色B
    private static $_instance = null;
    private function __construct()
    {}
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new ConcreteStateB();
        }
        return self::$_instance;
    }

    public function handle(Context $context)
    {
        echo 'concrete_b' . "<br>";
        $context->setState(ConcreteStateA::getInstance());
    }
}

class Context
{ // 环境角色
    private $_state;
    public function __construct()
    { // 默认为stateA
        $this->_state = ConcreteStateA::getInstance();
    }
    public function setState(State $state)
    {
        $this->_state = $state;
    }
    public function request()
    {
        $this->_state->handle($this);
    }
}

// client
$context = new Context();
$context->request();
$context->request();
$context->request();
$context->request();
/* 输出：
concrete_a
concrete_b
concrete_a
concrete_b */
