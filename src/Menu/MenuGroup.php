<?php

namespace Menus\Menu;

use Cake\Core\InstanceConfigTrait;
use Cake\View\StringTemplateTrait;
use Menus\Menu\MenuWrapper;

class MenuGroup
{
    use InstanceConfigTrait;
    use StringTemplateTrait;

    protected $_defaultConfig = [
        'templates' => [
            'group' => '<ul>{{group}}</ul>',
        ],
        'group' => [
            'group' => 'empty group',
        ],
    ];

    protected $_here = null;

    protected $_active = false;

    /**
     * The MenuGroup is the top container of a group of elements.
     * It defines typicly the top <ul> of a menu. It's also called recursively
     * for every ul nested in the menu.
     *
     * @param array $config Configuration array
     * @param string $here Location of current page
     * @return void
     */
    public function __construct(array $config = [], $here = null)
    {
        $this->_here = $here;
        $this->config(array_shift($config));

        if (!empty($config)) {
            $this->config('childConfig', $config);
        }
    }

    /**
     * Renders the list of elements containd in the MenuGroup. Lets call them
     * MenuWrappers. Typicly they are <li> elements.
     *
     * @param array $items list of items to be used as menu-wrappers.
     * @return string formatted list of menu items.
     */
    public function render($items)
    {
        $wrappers = '';

        foreach ($items as $item) {
            $wrapper = new MenuWrapper($this->config(), $this->_here);
            $wrappers .= $wrapper->render($item);
            $this->_active = $this->_active || $wrapper->active();
        }

        $this->config('group.group', $wrappers);
        return $this->formatTemplate('group', $this->config('group'));
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
