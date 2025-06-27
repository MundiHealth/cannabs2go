<?php


namespace PureEncapsulations\Shop\Http\Controllers;

use Webkul\CMS\Http\Controllers\Shop\PagePresenterController as PagePresenterControllerBase;


class PagePresenterController extends PagePresenterControllerBase
{

    /**
     * To extract the page content and load it in the respective view file\
     *
     * @return view
     */
    public function presenter($slug)
    {
        $currentChannel = core()->getCurrentChannel();
        $currentLocale = app()->getLocale();

        $currentLocale = $this->locale->findOneWhere([
            'code' => $currentLocale
        ]);

        $page = $this->cms->findOneWhere([
            'url_key' => $slug,
            'locale_id' => $currentLocale->id,
            'channel_id' => $currentChannel->id
        ]);

        if ($page) {
            return view('shop::cms.page')->with('page', $page);
        } else {
            abort(404);
        }

    }

}