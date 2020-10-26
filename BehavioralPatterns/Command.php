<?php

/* 命令模式
将一个请求封装为一个对象，从而使用户可用不同的请求对客户进行参数化。对请求排队或记录请求日志，以及支持撤销的操作。

命令模式以松散耦合主题为基础，发送消息、命令和请求，或通过一组处理程序发送任意内容。每个处理程序都会自行判断自己能否处理请求。如果可以，该请求被处理，进程停止。您可以为系统添加或移除处理程序，而不影响其他处理程序。

命令模式的四种角色：

1. 接收者（Receiver）负责执行与请求相关的操作

2. 命令接口（Command）封装execute()、undo()等方法

3. 具体命令（ConcreteCommand）实现命令接口中的方法

4. 请求者（Invoker）包含Command接口变量 */

interface ICommand
{
    public function onCommand($name, $args);
}

class CommandChain
{
    private $_commands = array();
    public function addCommand($cmd)
    {
        $this->_commands[] = $cmd;
    }

    public function runCommand($name, $args)
    {
        foreach ($this->_commands as $cmd) {
            if ($cmd->onCommand($name, $args)) {
                return;
            }

        }
    }
}

class UserCommand implements ICommand
{
    public function onCommand($name, $args)
    {
        if ($name != 'addUser') {
            return false;
        }

        echo ("UserCommand handling 'addUser'\n");
        return true;
    }
}

class MailCommand implements ICommand
{
    public function onCommand($name, $args)
    {
        if ($name != 'mail') {
            return false;
        }

        echo ("MailCommand handling 'mail'\n");
        return true;
    }
}

$cc = new CommandChain();
$cc->addCommand(new UserCommand());
$cc->addCommand(new MailCommand());
$cc->runCommand('addUser', null);
$cc->runCommand('mail', null);
