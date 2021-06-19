<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * This view helper class displays breadcrumbs.
 */
class PageActions extends AbstractHelper
{
    /**
     * Array of items.
     *
     * @var array
     */
    private $items = [];

    /**
     * Constructor.
     *
     * @param array $items array of items (optional)
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * Sets the items.
     *
     * @param array $items items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * Renders the breadcrumbs.
     *
     * @return string HTML code of the breadcrumbs
     */
    public function render()
    {
        if (0 == count($this->items)) {
            return '';
        } // Do nothing if there are no items.

        // Resulting HTML code will be stored in this var
        $result = '<div id="action-holder">';

        // Get item count
        $itemCount = count($this->items);

        $itemNum = 1; // item counter

        // Walk through items
        foreach ($this->items as $item) {
            if (isset($item['data-toggle'])) {
                $result .= $this->renderModalItem($item['label'], $item['data-target'], $item['icon'], $item['class']);
            } else {
                $result .= $this->renderItem($item['label'], $item['url'], $item['icon'], $item['class']);
            }
            // Increment item counter
            ++$itemNum;
        }

        $result .= '</div>';

        return $result;
    }

    protected function renderItem($label, $link, $icon, $class)
    {
        $escapeHtml = $this->getView()->plugin('escapeHtml');

        return '<a class="btn btn-rounded btn-primary '.$class.' btn-uppercase" href="'.$escapeHtml($link).'">
		<span class="btn-icon-left text-primary"><i class="'.$icon.'" aria-hidden="true"></i></span>'.$escapeHtml($label).'</a>';
    }

    protected function renderModalItem($label, $link, $icon, $class)
    {
        $escapeHtml = $this->getView()->plugin('escapeHtml');

        return '<a class="btn btn-rounded btn-primary '.$class.' btn-uppercase" href="#" data-toggle="modal" data-target="'.$escapeHtml($link).'">
		<span class="btn-icon-left text-primary"><i class="'.$icon.'" class="wd-10 mg-r-5"></i></span>'.$escapeHtml($label).'</a>';
    }
}
