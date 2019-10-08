 <?php

return [

    // default items for scraping
    'default' => [
        /**
         * especial cases and info
         */
        'item' => '.search-results-product',
        'products_number' => '.products-count',
        'link' => '.product-description h4 a',
        'click_next' => 'next',
        'click_last' => 'last',
        'more_info' => '.item-info-more',
        'properties' => '.result-list-item-desc-list li',

        /**
         * images downloads
         */
        // image path generic from public
        'img_path' => 'img',
        'imgs' => [
            'product_img' => '.product-image img',
            'warranty_img' => '.sales-container img',
            'brand_img' => '.product-description img',
        ],

        /**
         * generic cases, no special processing
         */
        'others' => [
            'name' => '.product-description h4 a',
            'price' => '.section-title',
            'rrp' => '.price-value'
        ],
    ],



    /**
     * specific pages/categories
     */
    'categories' => [

        'dishwashers' => [

            'url' => 'https://www.appliancesdelivered.ie/dishwashers?sort=price_asc&page=2',

            /**
             * images downloads
             */
            'img_path' => 'img/dishwashers/',
            'imgs' => [
                'sales_img' => '.sale-default-icon img'
            ],
        ],


        'small_appliances' => [

            'url' => 'https://www.appliancesdelivered.ie/search/small-appliances?sort=price_desc',

        ],
    ],


];