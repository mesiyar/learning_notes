<?php
/**
 * 实现堆栈数据结构
 *
 * 使用方法
 *
 * $stack = new Stack;
 * $stack->push('php');
 * $stack->push('java');
 * $stack->push('golang');
 * $stack->push('python');
 *  echo $stack->pop();// python
 *  echo $stack->pop();// golang
 *  echo $stack->pop();// java
 *  echo $stack->pop();// php
 *  echo $stack->pop();// false
 */

class Stack
{
    private $_data = [];

    private $_end = 0;

    /**
     * 入栈
     * @param $data
     */
    public function push($data)
    {
        $this->_end++;
        $this->_data[$this->_end] = $data;
    }

    public function pop()
    {
        if (!$this->_end) return false;

        $return = $this->_data[$this->_end];

        unset($this->_data[$this->_end]);
        $this->_end--;
        return $return;

    }

    public function showData()
    {
        var_dump($this->_data);
    }
}

 $stack = new Stack;
 $stack->push('php');
 $stack->push('java');
 $stack->push('golang');
 $stack->push('python');
