<?php

/* 给定一个语言, 定义它的文法的一种表示，并定义一个解释器，该解释器使用该表示来解释语言中的句子。
角色：
环境角色(PlayContent)：定义解释规则的全局信息。
抽象解释器(Empress)：定义了部分解释具体实现，封装了一些由具体解释器实现的接口。
具体解释器(MusicNote)：实现抽象解释器的接口，进行具体的解释执行。

应用实例：编译器、运算表达式计算。

优点： 1、可扩展性比较好，灵活。 2、增加了新的解释表达式的方式。 3、易于实现简单文法。

缺点： 1、可利用场景比较少。 2、对于复杂的文法比较难维护。 3、解释器模式会引起类膨胀。 4、解释器模式采用递归调用方法。

使用场景： 1、可以将一个需要解释执行的语言中的句子表示为一个抽象语法树。 2、一些重复出现的问题可以用一种简单的语言来进行表达。 3、一个简单语法需要解释的场景。 */

class Expression
{ //抽象表示
    public function interpreter($str)
    {
        return $str;
    }
}

class ExpressionNum extends Expression
{ //表示数字
    public function interpreter($str)
    {
        switch ($str) {
            case "0":return "零";
            case "1":return "一";
            case "2":return "二";
            case "3":return "三";
            case "4":return "四";
            case "5":return "五";
            case "6":return "六";
            case "7":return "七";
            case "8":return "八";
            case "9":return "九";
        }
    }
}

class ExpressionCharater extends Expression
{ //表示字符
    public function interpreter($str)
    {
        return strtoupper($str);
    }
}

class Interpreter
{ //解释器
    public function execute($string)
    {
        $expression = null;
        for ($i = 0; $i < strlen($string); $i++) {
            $temp = $string[$i];
            switch (true) {
                case is_numeric($temp): $expression = new ExpressionNum();
                    break;
                default:$expression = new ExpressionCharater();
            }
            echo $expression->interpreter($temp);
            echo "<br>";
        }
    }
}

//client
$obj = new Interpreter();
$obj->execute("123s45abc");
/* 输出：
一
二
三
S
四
五
A
B
C */
