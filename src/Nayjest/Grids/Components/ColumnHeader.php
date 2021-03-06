<?php
namespace Nayjest\Grids\Components;

use Nayjest\Grids\FieldConfig;

class ColumnHeader extends TableCell
{
    protected $tag_name = 'th';

    /**
     * @param FieldConfig $column
     * @return $this
     */
    public function setColumn(FieldConfig $column)
    {
        $this->setContent($column->getLabel());
        if ($column->isSortable()) {
            $this->addComponent(new SortingControl($column));
        }
        return parent::setColumn($column);
    }
} 