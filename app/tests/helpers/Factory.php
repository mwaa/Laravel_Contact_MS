<?php

trait Factory{

    protected $times = 1;

    /**
     * @param $count
     * @return $this
     */
    protected  function times($count)
    {
        $this->times =$count;
        return $this;
    }

    /**
     * @param $type
     * @param array $fields
     */
    protected function make($type, array $fields = [])
    {
        while ($this->times--){
            $stub = array_merge($this->getStub(), $fields);
            $type::create($stub);
        }
    }

    /**
     * @return mixed
     */
    protected  function getStub()
    {
        throw new BadMethodCallException('Create your own method stub to declare the fields');
    }
}