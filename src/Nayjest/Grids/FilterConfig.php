<?php
namespace Nayjest\Grids;

class FilterConfig
{
    const OPERATOR_LIKE = 'like';
    const OPERATOR_EQ = '=';
    const OPERATOR_NOT_EQ = '<>';
    const OPERATOR_GT = '>';
    const OPERATOR_LS = '<';
    const OPERATOR_LSE = '<=';
    const OPERATOR_GTE = '>=';


    /** @var  FieldConfig */
    protected $column;

    protected $operator = FilterConfig::OPERATOR_EQ;

    protected $template = '*.input';

    protected $default_value;

    protected $name;

    protected $label;

    /** @var  callable */
    protected $filtering_func;

    public function getOperator()
    {
        return $this->operator;
    }

    public function setOperator($operator)
    {
        $this->operator = $operator;
        return $this;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return callable
     */
    public function getFilteringFunc()
    {
        return $this->filtering_func;
    }

    /**
     * @param callable $func($value, $data_provider)
     * @return $this
     */
    public function setFilteringFunc($func)
    {
        $this->filtering_func = $func;
        return $this;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }


    public function getDefaultValue()
    {
        return $this->default_value;
    }

    public function setDefaultValue($value)
    {
        $this->default_value = $value;
        return $this;
    }

    public function getName()
    {
        if (null === $this->name) {
            if ($this->column) {
                $this->name = $this->column->getName();
            }
        }
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function attach(FieldConfig $column)
    {
        $this->column = $column;
    }

    public function getId()
    {
        return $this->getName() . '-' . $this->getOperator();
    }

} 