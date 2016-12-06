<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Item;
use common\models\Page;
use \mrssoft\sitemap\Sitemap;

class SitemapController extends \mrssoft\sitemap\SitemapController
{
    /**
     * @var int Cache duration, set null to disabled
     */
    protected $cacheDuration = 43200; // default 12 hour

    /**
     * @var string Cache filename
     */
    protected $cacheFilename = 'sitemap.xml';

    public function models()
    {
        return [
            [
                'class' => Item::className(),
                'change' => Sitemap::MONTHLY,
                'priority' => 0.7
            ],
            [
                'class' => Category::className(),
                'change' => Sitemap::MONTHLY,
                'priority' => 0.8
            ],
            [
                'class' => Page::className(),
                'change' => Sitemap::MONTHLY,
                'priority' => 0.5
            ],
        ];
    }

    public function urls()
    {
        return [
            [
                'url' => '/site/index',
                'change' => Sitemap::MONTHLY,
                'priority' => 1
            ]
        ];
    }
}