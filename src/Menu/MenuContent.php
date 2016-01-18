<?php

namespace Menus\Menu;

use Cake\Core\InstanceConfigTrait;
use Cake\Network\Request;
use Cake\Routing\Router;
use Cake\View\StringTemplateTrait;
use Menus\Menu\MenuGroup;

class MenuContent
{
    use InstanceConfigTrait;
    use StringTemplateTrait;

    protected $_defaultConfig = [
        'templates' => [
            'content' => '<a href="{{url}}">{{name}}</a>',
        ],
        'content' => [
            'name' => '',
            'url' => '#',
        ],
    ];

    protected $_here = null;

    protected $_active = false;

    /**
     * TODO
     */
    public function __construct(array $config = [], $here = null)
    {
        $this->_here = $here;
        $this->config($config);

        if ($here === Router::url($this->config('content.url'))) {
            $this->_active = true;
        }
    }

    /**
     * TODO
     */
    public function render($group = null)
    {
        $this->config('content.url', Router::url($this->config('content.url')));
        $content = $this->formatTemplate('content', $this->config('content'));

        if ($group) {
            $this->config(array_shift($this->_config['childConfig']));
            $menu = new MenuGroup([$this->config()], $this->_here);
            $content .= $menu->render($group);
            $this->_active = $this->_active || $menu->active();
        }

        return $content;
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
