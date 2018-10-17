define(
    [
        "jquery",
        "mobifyCarousel"
    ], function($) {
        var mobifyInit = function() {
            if (typeof Mobify.carouselInit == 'undefined') {
                $('.m-carousel').carousel();
                $.extend(Mobify, {
                    carouselInit: true,

                    setEqualHeight: function (sliderId) {
                        var tallestColumn = 0;
                        var tallestName = 0;
                        var nameSelector = '.product-item-name';
                        var sliderSelector = '#mobify-slider-' + sliderId;
                        var sliderInnerSelector = sliderSelector + ' .m-carousel-inner';
                        var productSelector = sliderSelector + ' .m-card-light';
                        var arrowsSelector = 'a.group-Prev, a.group-Next';

                        var products = $(productSelector);
                        // Fix names height
                        for (var i = 0; i < products.length; i++) {
                            var currentNameHeight = $(products[i]).find(nameSelector).height();
                            if (currentNameHeight > tallestName) {
                                tallestName = currentNameHeight;
                            }
                        }

                        $.each(products, function() {
                            $(this).find(nameSelector).height(tallestName);
                        });

                        // Check sliders height
                        for (var i = 0; i < products.length; i++) {
                            var currentHeight = $(products[i]).height();
                            if (currentHeight > tallestColumn) {
                                tallestColumn = currentHeight;
                            }
                        }
                        $.each(products, function() {
                            $(this).height(tallestColumn);
                        });

                        // Fix arrows position
                        var arrowsHeight = $(arrowsSelector).height();
                        var sliderHeight = $(sliderInnerSelector).height();
                        var arrowsTop = (sliderHeight - arrowsHeight) / 2;
                        if (arrowsTop > 0) {
                            $(arrowsSelector).each(function() {
                                $(this).css('top', arrowsTop);
                            });
                        }
                    }
                });
            }
        };

        return {
            mobifyCarouselInit: function(config) {
                mobifyInit();
                if (config.sliderId) {
                    Mobify.setEqualHeight(config.sliderId);
                }
            }
        }

    }
);