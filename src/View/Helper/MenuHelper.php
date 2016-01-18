<?php

namespace Menus\View\Helper;

use Cake\View\Helper;
use Menus\Menu\MenuGroup;

class MenuHelper extends Helper
{
    /**
     * Creates the menu
     *
     * The menu config defines the templates to be used. Each item of the array
     * represents a level of nesting. The config is inherited by default, and
     * each subsequent level can override the previous configuration
     *
     * ```
     * $config = [
     *     [
     *         'templates' => [
     *             'group' => '<ul class="sidebar-menu">{{group}}</ul>',
     *             'wrapper' => '<li class="{{class}}">{{wrapper}}</li>',
     *             'content' => '<a href="{{url}}"><i class="{{icon}}"></i>{{name}}</a>',
     *         ],
     *         'wrapper' => ['class' => 'treeview'],
     *         'content' => ['icon' => 'fa fa-angle-right'],
     *     ],
     *     [
     *         'templates' => [
     *             'group' => '<ul class="treeview-menu">{{group}}</ul>',
     *             'wrapper' => '<li class="{{class}}">{{wrapper}}</li>',
     *         ],
     *         'content' => ['icon' => 'fa fa-angle-right'],
     *     ],
     * ]
     * ```
     *
     * The data array is defined as follow
     *
     * $menu = [
     *     [
     *         'content' => ['left' => 'fa fa-users', 'name' => 'users'],
     *         'group' => [
     *             [
     *                 'content' => [
     *                     'name' => 'index',
     *                     'url' => ['controller' => 'users', 'action' => 'index'],
     *                 ],
     *             ],
     *             [
     *                 'content' => [
     *                     'name' => 'add',
     *                     'url' => ['controller' => 'users', 'action' => 'add'],
     *                 ],
     *             ],
     *         ],
     *     ],
     *     [
     *         'content' => ['left' => 'fa fa-image', 'name' => 'images'],
     *         'group' => [
     *             [
     *                 'content' => [
     *                     'name' => 'index',
     *                     'url' => ['controller' => 'images', 'action' => 'index'],
     *                 ]
     *             ],
     *         ],
     *     ],
     * ];
     *
     * The content of the menu can be defined with
     *
     * @param array $config Configuration options
     * @param array $data Content of the menu
     * @return string
     */
    public function create(array $config = [], array $data = [])
    {
        $here = $this->_View->request->here();
        $menu = new MenuGroup($config, $here);
        return $menu->render($data);
    }
}
