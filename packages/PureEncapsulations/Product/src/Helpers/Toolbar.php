<?php


namespace PureEncapsulations\Product\Helpers;


class Toolbar extends \Webkul\Product\Helpers\Toolbar
{

    /**
     * Checks if sort order is active
     *
     * @param string $key
     * @return boolean
     */
    public function isOrderCurrent($key)
    {
        $params = request()->input();

        if (isset($params['sort']) && $key == $params['sort'] . '-' . $params['order'])
            return true;
        else if (! isset($params['sort']) && $key == 'name-asc')
            return true;

        return false;
    }

}