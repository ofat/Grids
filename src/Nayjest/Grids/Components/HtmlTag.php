<?php
namespace Nayjest\Grids\Components;

use HTML;
use Nayjest\Grids\Components\Base\RenderableRegistry;

class HtmlTag extends RenderableRegistry
{
    const SECTION_BEGIN = 'begin';
    const SECTION_END = 'end';
    const SECTION_BEFORE = 'before';
    const SECTION_AFTER = 'after';

    protected $tag_name;

    protected $content;

    /**
     * HTML tag attributes.
     * Keys are attribute names and values are attribute values.
     * @var array
     */
    protected $attributes = [];

    /**
     * Returns component name.
     * If empty, tag_name will be used instead
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name ?: $this->getTagName();
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setTagName($name)
    {
        $this->tag_name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tag_name ?: $this->suggestTagName();
    }

    private function suggestTagName()
    {
        $class_name = get_class($this);
        $parts = explode('\\', $class_name);
        $base_name = array_pop($parts);
        return ($base_name === 'HtmlTag') ? 'div' : strtolower($base_name);
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets html tag attributes.
     * Keys are attribute names and values are attribute values.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes = [])
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Returns html tag attributes.
     * Keys are attribute names and values are attribute values.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Renders opening tag
     *
     * @return string
     */
    public function renderOpeningTag()
    {
        return '<'
        . $this->getTagName()
        . HTML::attributes($this->getAttributes())
        . '>';
    }

    /**
     * Renders closing tag
     *
     * @return string
     */
    public function renderClosingTag()
    {
        return "</$this->tag_name>";
    }

    /**
     * Renders tag if no template specified
     *
     * @return string
     */
    protected function renderWithoutTemplate()
    {
        $this->is_rendered = true;
        return
            $this->renderComponents(self::SECTION_BEFORE)
            . $this->renderOpeningTag()
            . $this->renderComponents(self::SECTION_BEGIN)
            . $this->getContent()
            . $this->renderComponents(null)
            . $this->renderComponents(self::SECTION_END)
            . $this->renderClosingTag()
            . $this->renderComponents(self::SECTION_AFTER);
    }

    /**
     * Renders component
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->getTemplate() ?
            $this->renderTemplate() : $this->renderWithoutTemplate();

    }
}