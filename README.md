### Magento2 Product Slider
The Dexa ProductSlider is Magento2 module allows to create sliders based on
category products or any predefined products set.

As javascript engine for slider Mobify.js library is used.


### INSTALLATION
1. To install product slider place source code into your project by next path:
app/code/Dexa/ProductSlider

2. Clear cache
bin/magento cache:f

3. Make sure module is activated
bin/magento module:status
bin/magento module:enable Dexa_ProductSlider

4. Execute
bin/magento setup:upgrade

5. There should be created table in your database "dexa_productslider"

6. You can observe sliders grid in admin following "Content -> Product Slider"
Options making sense to be configured for now:
- type:
  * 1 - category slider
  * 2 - products slider
- category_ids:
  category id, or some categories split by comma, for instance - 7 or 7,8,9
  used for category slider (type = 1)
- product_ids:
  product ids split by comma, example - 55,52,49,46,44,42,41

7. Add block in required place. Detailed info in "MODULE FRONTEND OUTPUT" part of this topic.

8. Run css and js generation in console.
bin/magento setup:static-content:deploy
for multi multi language sites should be specified required locales
bin/magento setup:static-content:deploy en_US uk_UA

### MODULE FRONTEND OUTPUT
* There is two options how to show slider on frontend pages
    1. Add block in layout xml files.
    You can find sample in file: app/code/Dexa/ProductSlider/view/frontend/layout/cms_index_index.xml

    2. Add block to cms page content in admin using next syntax:
    {{block class="Dexa\ProductSlider\Block\Slider" slider_id="11"}}

### SUPPORT
Feel free contact me if you have any questions
email: art.klimoff@gmail.com

### SAMPLES
You can find slider samples in next places:
1. http://kiri.com.ua