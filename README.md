# DeveloperHub Product Custom Tabs

The Product Custom Tabs extension for Magento 2 allows store admin to create Custom tabs for specific products, Attribute sets and for all the products available in the Magento and show on the product description page as an additional guide for the customers.DeveloperHub product_custom_tabs allows the admin to create a custom block that contain diffrent type of data like Pictures, Tables, Widgets, Lists, Static pages and static Blocks and many more.


## Features
 1. Allow to create multiple custom blocks for products.
 2. Add an unlimited number of custom blocks creation.
 3. Customer can view the custom created blocks on PDP page.
 4. One custom Block can contain Multiple Images, Widgets, Tables, Static Blocks and Pages.  

## Installation
Install the module as a composer requirement for environments:

```
    composer require devhub/product-custom-tabs
    php bin/magento module:enable DeveloperHub_Core DeveloperHub_ProductCustomTabs
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento setup:static-content:deploy
```
