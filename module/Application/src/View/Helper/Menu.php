<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper
{
    /**
     * Menu items array.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Active item's ID.
     *
     * @var string
     */
    protected $activeItemId = '';

    /**
     * Constructor.
     *
     * @param array $items menu items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * Sets menu items.
     *
     * @param array $items menu items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * Sets ID of the active items.
     *
     * @param string $activeItemId
     */
    public function setActiveItemId($activeItemId)
    {
        $this->activeItemId = $activeItemId;
    }

    public function renderIcon($item)
    {
        switch ($item) {
		case 'DashBoard':
                return 'flaticon-381-television';
				
		case 'SPT Form':
                return 'flaticon-381-notepad';
				
		case 'DCR Form':
                return 'flaticon-381-layer-1';
				
		case 'Road Map':
                return 'flaticon-381-internet';
				
		case 'Reports':
                return 'flaticon-381-controls-3';
				
		case 'Masters':
                return 'flaticon-381-network';

        case 'Settings':
                return 'flaticon-381-settings-2';
		
		case 'Contacts':
                return 'flaticon-381-user-9';

        default:
            return 'flaticon-381-networking';
        }
    }

    public function renderMenu()
    {
        if (0 == count($this->items)) {
            return '';
        } // Do nothing if there are no items.
        $escapeHtml = $this->getView()->plugin('escapeHtml');
        $result = '<ul class="metismenu" id="menu">';

        // Render items
        foreach ($this->items as $item) {
            $link = isset($item['link']) ? $item['link'] : '#';
            $label = isset($item['label']) ? $item['label'] : '';
            if (!isset($item['location']) || 'mainmenu' == $item['location']) {
                $result .= $this->renderMenuItem($item);
            }
        }

        $result .= '</ul>';

        return $result;
    }

    protected function renderMenuItem($item)
    {
        $id = isset($item['id']) ? $item['id'] : '';
        $isActive = ($id == $this->activeItemId);
        $label = isset($item['label']) ? $item['label'] : '';

        $result = '';

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        if (isset($item['dropdown'])) {
            $dropdownItems = $item['dropdown'];
            $result .= $isActive ? '<li class="mm-active">' : '<li>';
            $result .= '<a href="#" class="has-arrow ai-icon"><i class="'.$this->renderIcon($item['label']).'"></i><span class="nav-text">';
            $result .= $escapeHtml($label);
            $result .= '</span></a>';

            $result .= '<ul aria-expanded="false">';
            foreach ($dropdownItems as $item) {
                $link = isset($item['link']) ? $item['link'] : '#';
                $label = isset($item['label']) ? $item['label'] : '';
                $result .= '<li><a href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a></li>';
            }
            $result .= '</ul>';
            $result .= '</li>';
        } else {
            $link = isset($item['link']) ? $item['link'] : '#';
            $result .= $isActive ? '<li class="mm-active">' : '<li>';
            $result .= '<a href="'.$escapeHtml($link).'"><i class="'.$this->renderIcon($item['label']).'"></i><span class="nav-text">'.$escapeHtml($label).'</span></a>';
            $result .= '</li>';
        }

        return $result;
    }
}
