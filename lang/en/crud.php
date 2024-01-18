<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'user_notifications' => [
        'name' => 'User Notifications',
        'index_title' => 'Notifications List',
        'new_title' => 'New Notification',
        'create_title' => 'Create Notification',
        'edit_title' => 'Edit Notification',
        'show_title' => 'Show Notification',
        'inputs' => [
            'content' => 'Content',
        ],
    ],

    'affiliate_programs' => [
        'name' => 'Affiliate Programs',
        'index_title' => 'AffiliatePrograms List',
        'new_title' => 'New Affiliate program',
        'create_title' => 'Create AffiliateProgram',
        'edit_title' => 'Edit AffiliateProgram',
        'show_title' => 'Show AffiliateProgram',
        'inputs' => [
            'affiliate_id' => 'Customer',
            'referral_id' => 'Referral',
            'commission' => 'Commission',
        ],
    ],

    'affiliate_program_affiliate_commissions' => [
        'name' => 'AffiliateProgram Affiliate Commissions',
        'index_title' => 'AffiliateCommissions List',
        'new_title' => 'New Affiliate commission',
        'create_title' => 'Create AffiliateCommission',
        'edit_title' => 'Edit AffiliateCommission',
        'show_title' => 'Show AffiliateCommission',
        'inputs' => [
            'amount' => 'Amount',
        ],
    ],

    'customers' => [
        'name' => 'Customers',
        'index_title' => 'Customers List',
        'new_title' => 'New Customer',
        'create_title' => 'Create Customer',
        'edit_title' => 'Edit Customer',
        'show_title' => 'Show Customer',
        'inputs' => [
            'user_id' => 'User',
            'address' => 'Address',
            'city' => 'City',
        ],
    ],

    'products' => [
        'name' => 'Products',
        'index_title' => 'Products List',
        'new_title' => 'New Product',
        'create_title' => 'Create Product',
        'edit_title' => 'Edit Product',
        'show_title' => 'Show Product',
        'inputs' => [
            'categorie_id' => 'Categorie',
            'title' => 'Title',
            'slug' => 'Slug',
            'image' => 'Image',
            'description' => 'Description',
            'price' => 'Price',
            'content' => 'Content',
        ],
    ],

    'product_product_images' => [
        'name' => 'Product Product Images',
        'index_title' => 'ProductImages List',
        'new_title' => 'New Product image',
        'create_title' => 'Create ProductImage',
        'edit_title' => 'Edit ProductImage',
        'show_title' => 'Show ProductImage',
        'inputs' => [
            'image_url' => 'Image Url',
            'image' => 'Image',
        ],
    ],

    'product_product_variants' => [
        'name' => 'Product Product Variants',
        'index_title' => 'ProductVariants List',
        'new_title' => 'New Product variant',
        'create_title' => 'Create ProductVariant',
        'edit_title' => 'Edit ProductVariant',
        'show_title' => 'Show ProductVariant',
        'inputs' => [
            'name' => 'Name',
            'price' => 'Price',
        ],
    ],

    'product_product_attributes' => [
        'name' => 'Product Product Attributes',
        'index_title' => 'ProductAttributes List',
        'new_title' => 'New Product attribute',
        'create_title' => 'Create ProductAttribute',
        'edit_title' => 'Edit ProductAttribute',
        'show_title' => 'Show ProductAttribute',
        'inputs' => [
            'name' => 'Name',
            'value' => 'Value',
        ],
    ],

    'product_product_tags' => [
        'name' => 'Product Product Tags',
        'index_title' => 'ProductTags List',
        'new_title' => 'New Product tag',
        'create_title' => 'Create ProductTag',
        'edit_title' => 'Edit ProductTag',
        'show_title' => 'Show ProductTag',
        'inputs' => [
            'tag' => 'Tag',
        ],
    ],

    'product_inventories' => [
        'name' => 'Product Inventories',
        'index_title' => 'Inventories List',
        'new_title' => 'New Inventory',
        'create_title' => 'Create Inventory',
        'edit_title' => 'Edit Inventory',
        'show_title' => 'Show Inventory',
        'inputs' => [
            'quantity' => 'Quantity',
        ],
    ],

    'product_product_reviews' => [
        'name' => 'Product Product Reviews',
        'index_title' => 'ProductReviews List',
        'new_title' => 'New Product review',
        'create_title' => 'Create ProductReview',
        'edit_title' => 'Edit ProductReview',
        'show_title' => 'Show ProductReview',
        'inputs' => [
            'customer_id' => 'Customer',
            'rating' => 'Rating',
            'text' => 'Text',
        ],
    ],

    'categories' => [
        'name' => 'Categories',
        'index_title' => 'Categories List',
        'new_title' => 'New Categorie',
        'create_title' => 'Create Categorie',
        'edit_title' => 'Edit Categorie',
        'show_title' => 'Show Categorie',
        'inputs' => [
            'title' => 'Title',
            'image' => 'Image',
            'description' => 'Description',
            'slug' => 'Slug',
        ],
    ],

    'carts' => [
        'name' => 'Carts',
        'index_title' => 'Carts List',
        'new_title' => 'New Cart',
        'create_title' => 'Create Cart',
        'edit_title' => 'Edit Cart',
        'show_title' => 'Show Cart',
        'inputs' => [
            'customer_id' => 'Customer',
        ],
    ],

    'cart_cart_items' => [
        'name' => 'Cart Cart Items',
        'index_title' => 'CartItems List',
        'new_title' => 'New Cart item',
        'create_title' => 'Create CartItem',
        'edit_title' => 'Edit CartItem',
        'show_title' => 'Show CartItem',
        'inputs' => [
            'product_id' => 'Product',
            'quantity' => 'Quantity',
        ],
    ],

    'customer_customer_wishlists' => [
        'name' => 'Customer Customer Wishlists',
        'index_title' => 'CustomerWishlists List',
        'new_title' => 'New Customer wishlist',
        'create_title' => 'Create CustomerWishlist',
        'edit_title' => 'Edit CustomerWishlist',
        'show_title' => 'Show CustomerWishlist',
        'inputs' => [
            'product_id' => 'Product',
        ],
    ],

    'orders' => [
        'name' => 'Orders',
        'index_title' => 'Orders List',
        'new_title' => 'New Order',
        'create_title' => 'Create Order',
        'edit_title' => 'Edit Order',
        'show_title' => 'Show Order',
        'inputs' => [
            'customer_id' => 'Customer',
            'total' => 'Total',
            'status' => 'Status',
        ],
    ],

    'order_order_items' => [
        'name' => 'Order Order Items',
        'index_title' => 'OrderItems List',
        'new_title' => 'New Order item',
        'create_title' => 'Create OrderItem',
        'edit_title' => 'Edit OrderItem',
        'show_title' => 'Show OrderItem',
        'inputs' => [
            'product_id' => 'Product',
            'quantity' => 'Quantity',
        ],
    ],

    'payments' => [
        'name' => 'Payments',
        'index_title' => 'Payments List',
        'new_title' => 'New Payment',
        'create_title' => 'Create Payment',
        'edit_title' => 'Edit Payment',
        'show_title' => 'Show Payment',
        'inputs' => [
            'order_id' => 'Order',
            'amount' => 'Amount',
            'payment_method_id' => 'Payment Method',
        ],
    ],

    'payment_methods' => [
        'name' => 'Payment Methods',
        'index_title' => 'PaymentMethods List',
        'new_title' => 'New Payment method',
        'create_title' => 'Create PaymentMethod',
        'edit_title' => 'Edit PaymentMethod',
        'show_title' => 'Show PaymentMethod',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'seo_settings' => [
        'name' => 'Seo Settings',
        'index_title' => 'SeoSettings List',
        'new_title' => 'New Seo setting',
        'create_title' => 'Create SeoSetting',
        'edit_title' => 'Edit SeoSetting',
        'show_title' => 'Show SeoSetting',
        'inputs' => [
            'meta_description' => 'Meta Description',
            'image' => 'Image',
        ],
    ],

    'seo_setting_seo_metas' => [
        'name' => 'SeoSetting Seo Metas',
        'index_title' => 'SeoMetas List',
        'new_title' => 'New Seo meta',
        'create_title' => 'Create SeoMeta',
        'edit_title' => 'Edit SeoMeta',
        'show_title' => 'Show SeoMeta',
        'inputs' => [
            'type' => 'Type',
            'key' => 'Key',
        ],
    ],

    'shipments' => [
        'name' => 'Shipments',
        'index_title' => 'Shipments List',
        'new_title' => 'New Shipment',
        'create_title' => 'Create Shipment',
        'edit_title' => 'Edit Shipment',
        'show_title' => 'Show Shipment',
        'inputs' => [
            'order_id' => 'Order',
            'tracking_number' => 'Tracking Number',
            'shipping_method_id' => 'Shipping Method',
        ],
    ],

    'shipping_methods' => [
        'name' => 'Shipping Methods',
        'index_title' => 'ShippingMethods List',
        'new_title' => 'New Shipping method',
        'create_title' => 'Create ShippingMethod',
        'edit_title' => 'Edit ShippingMethod',
        'show_title' => 'Show ShippingMethod',
        'inputs' => [
            'name' => 'Name',
            'cost' => 'Cost',
        ],
    ],

    'user_activities' => [
        'name' => 'User Activities',
        'index_title' => 'UserActivities List',
        'new_title' => 'New User activitie',
        'create_title' => 'Create UserActivitie',
        'edit_title' => 'Edit UserActivitie',
        'show_title' => 'Show UserActivitie',
        'inputs' => [
            'user_id' => 'User',
            'name' => 'Name',
            'description' => 'Description',
            'type' => 'Type',
        ],
    ],

    'discounts' => [
        'name' => 'Discounts',
        'index_title' => 'Discounts List',
        'new_title' => 'New Discount',
        'create_title' => 'Create Discount',
        'edit_title' => 'Edit Discount',
        'show_title' => 'Show Discount',
        'inputs' => [
            'name' => 'Name',
            'amount' => 'Amount',
            'coupon_code' => 'Coupon Code',
        ],
    ],

    'settings' => [
        'name' => 'Settings',
        'index_title' => 'Settings List',
        'new_title' => 'New Setting',
        'create_title' => 'Create Setting',
        'edit_title' => 'Edit Setting',
        'show_title' => 'Show Setting',
        'inputs' => [
            'key' => 'Key',
            'value' => 'Value',
        ],
    ],

    'setting_social_media_links' => [
        'name' => 'Setting Social Media Links',
        'index_title' => 'SocialMediaLinks List',
        'new_title' => 'New Social media link',
        'create_title' => 'Create SocialMediaLink',
        'edit_title' => 'Edit SocialMediaLink',
        'show_title' => 'Show SocialMediaLink',
        'inputs' => [
            'platform' => 'Platform',
            'url' => 'Url',
        ],
    ],

    'taxes' => [
        'name' => 'Taxes',
        'index_title' => 'Taxes List',
        'new_title' => 'New Taxe',
        'create_title' => 'Create Taxe',
        'edit_title' => 'Edit Taxe',
        'show_title' => 'Show Taxe',
        'inputs' => [
            'name' => 'Name',
            'rate' => 'Rate',
        ],
    ],

    'pages' => [
        'name' => 'Pages',
        'index_title' => 'Pages List',
        'new_title' => 'New Page',
        'create_title' => 'Create Page',
        'edit_title' => 'Edit Page',
        'show_title' => 'Show Page',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
            'image' => 'Image',
            'content' => 'Content',
        ],
    ],

    'banners' => [
        'name' => 'Banners',
        'index_title' => 'Banners List',
        'new_title' => 'New Banner',
        'create_title' => 'Create Banner',
        'edit_title' => 'Edit Banner',
        'show_title' => 'Show Banner',
        'inputs' => [
            'image' => 'Image',
            'image_url' => 'Image Url',
            'url' => 'Url',
        ],
    ],

    'email_templates' => [
        'name' => 'Email Templates',
        'index_title' => 'EmailTemplates List',
        'new_title' => 'New Email template',
        'create_title' => 'Create EmailTemplate',
        'edit_title' => 'Edit EmailTemplate',
        'show_title' => 'Show EmailTemplate',
        'inputs' => [
            'name' => 'Name',
            'subject' => 'Subject',
            'content' => 'Content',
        ],
    ],

    'external_integrations' => [
        'name' => 'External Integrations',
        'index_title' => 'ExternalIntegrations List',
        'new_title' => 'New External integration',
        'create_title' => 'Create ExternalIntegration',
        'edit_title' => 'Edit ExternalIntegration',
        'show_title' => 'Show ExternalIntegration',
        'inputs' => [
            'name' => 'Name',
            'api_key' => 'Api Key',
            'token' => 'Token',
        ],
    ],

    'return_prodcts' => [
        'name' => 'Return Prodcts',
        'index_title' => 'ReturnProdcts List',
        'new_title' => 'New Return prodct',
        'create_title' => 'Create ReturnProdct',
        'edit_title' => 'Edit ReturnProdct',
        'show_title' => 'Show ReturnProdct',
        'inputs' => [
            'order_id' => 'Order',
            'reason' => 'Reason',
        ],
    ],

    'return_prodct_refunds' => [
        'name' => 'ReturnProdct Refunds',
        'index_title' => 'Refunds List',
        'new_title' => 'New Refund',
        'create_title' => 'Create Refund',
        'edit_title' => 'Edit Refund',
        'show_title' => 'Show Refund',
        'inputs' => [
            'amount' => 'Amount',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
