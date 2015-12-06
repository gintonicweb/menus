<?php

namespace Menu\Menu;

use Cake\Core\InstanceConfigTrait;
use Cake\View\StringTemplateTrait;
use Menu\Menu\MenuContent;

class MenuWrapper
{
    use InstanceConfigTrait;
    use StringTemplateTrait;

    protected $_defaultConfig = [
        'templates' => [
            'wrapper' => '<li class="{{class}}">{{wrapper}}</li>',
        ],
        'wrapper' => [
            'class' => '',
            'wrapper' => 'empty wrapper',
        ],
    ];

    protected $_here;

    protected $_active;

    /**
     * TODO
     */
    public function __construct(array $config = [], $here = null)
    {
        $this->_here = $here;
        $this->config($config);
    }

    /**
     * TODO
     */
    public function render($data)
    {
        if (isset($data['content'])) {
            $this->config(['content' => $data['content']]);
            $content = new MenuContent($this->config(), $this->_here);
            $group = isset($data['group'])? $data['group'] : null;
            $contents = $content->render($group);
            $this->_active = $this->_active || $content->active();
            $this->config('wrapper.wrapper', $contents);
        }

        if ($this->_active) {
            $class = $this->config('wrapper.class') . ' active';
            $this->config('wrapper.class', $class);
        }

        return $this->formatTemplate('wrapper', $this->config('wrapper'));
    }

    /**
     * Returns the active status of the current menu item
     *
     * @return bool
     */
    public function active()
    {
        return $this->_active;
    }
}
