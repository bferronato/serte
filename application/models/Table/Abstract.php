<?php

abstract class Default_Model_Abstract {

    // define a classe de mapper ligada ao model
    protected $_mapper;
    // indica qual o modelo usado
    protected $_model;

    public function __construct(array $options = null)
    {
        if (is_array($options))
        {
            $this->setOptions($options);
        }
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
        {
            throw new Exception('Invalid property');
        }
        return $this->$method();
    }

    public function getMapper()
    {
        if (null === $this->_mapper)
        {
            $model = "Default_Model_Mapper_".$this->getModel();
            $this->setMapper(new $model());
        }
        return $this->_mapper;
    }

    public function getModel()
    {
        if (null === $this->_model)
        {
            $this->setModel('Abstract');
        }
        return $this->_model;
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
        {
            throw new Exception('Invalid property');
        }
        $this->$method($value);
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value)
        {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods))
            {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function setModel($model)
    {
        $this->_model = $model;
    }

    public function add()
    {
        $this->getMapper()->add($this);
    }

    public function edit()
    {
        $this->getMapper()->edit($this);
    }

    public function remove()
    {
        $this->getMapper()->remove($this->getId());
    }

    public function find($id)
    {
        $this->getMapper()->find($id, $this);
        return $this;
    }

    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }

}