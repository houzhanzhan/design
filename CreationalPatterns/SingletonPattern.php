<?php
// 单例模式(Singleton)
// 单例模式（Singleton Pattern）是 Java 中最简单的设计模式之一。这种类型的设计模式属于创建型模式，它提供了一种创建对象的最佳方式。

// 这种模式涉及到一个单一的类，该类负责创建自己的对象，同时确保只有单个对象被创建。这个类提供了一种访问其唯一的对象的方式，可以直接访问，不需要实例化该类的对象。

// 注意：

// 1、单例类只能有一个实例。
// 2、单例类必须自己创建自己的唯一实例。
// 3、单例类必须给所有其他对象提供这一实例。

// 介绍
// 意图：保证一个类仅有一个实例，并提供一个访问它的全局访问点。

// 主要解决：一个全局使用的类频繁地创建与销毁。

// 何时使用：当您想控制实例数目，节省系统资源的时候。

// 如何解决：判断系统是否已经有这个单例，如果有则返回，如果没有则创建。

// 关键代码：构造函数是私有的。

// 应用实例：

// 1、一个班级只有一个班主任。
// 2、Windows 是多进程多线程的，在操作一个文件的时候，就不可避免地出现多个进程或线程同时操作一个文件的现象，所以所有文件的处理必须通过唯一的实例来进行。
// 3、一些设备管理器常常设计为单例模式，比如一个电脑有两台打印机，在输出的时候就要处理不能两台打印机打印同一个文件。
// 优点：

// 1、在内存里只有一个实例，减少了内存的开销，尤其是频繁的创建和销毁实例（比如管理学院首页页面缓存）。
// 2、避免对资源的多重占用（比如写文件操作）。
// 缺点：没有接口，不能继承，与单一职责原则冲突，一个类应该只关心内部逻辑，而不关心外面怎么样来实例化。

// 使用场景：

// 1、要求生产唯一序列号。
// 2、WEB 中的计数器，不用每次刷新都在数据库里加一次，用单例先缓存起来。
// 3、创建的一个对象需要消耗的资源过多，比如 I/O 与数据库的连接等。
/**
 * Singleton class[单例模式]
 * @author 侯蜀黍
 */
final class Mysql
{

    /**
     *
     * @var self[该属性用来保存实例]
     */
    private static $instance;

    /**
     *
     * @var mixed
     */
    public $mix;

    /**
     * Return self instance[创建一个用来实例化对象的方法]
     *
     * @return self
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 构造函数为private,防止创建对象
     */
    private function __construct()
    {}

    /**
     * 防止对象被复制
     */
    private function __clone()
    {
        trigger_error('Clone is not allowed !');
    }
}

// @test
$firstMysql = Mysql::getInstance();
$secondMysql = Mysql::getInstance();

$firstMysql->mix = 'ityangs_one';
$secondMysql->mix = 'ityangs_two';

print_r($firstMysql->mix);
// 输出： ityangs_two
print_r($secondMysql->mix);
// 输出： ityangs_two
