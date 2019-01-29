(function ($) {

    var useAjax = !!premmerce_filter_settings.useAjax;
    var loadDeferred = !!premmerce_filter_settings.loadDeferred;


    function followLink(e, link) {
        e.preventDefault();

        if (useAjax) {
            ajaxUpdate(link, 'reload');
        } else {
            location.href = link;
        }
    }

    function fixWoocommerceOrdering() {
        $('.woocommerce-ordering').on('change', 'select.orderby', function () {
            $(this).closest('form').submit();
        });
    }

    function ajaxUpdate(link, action) {

        var requestData = {'premmerce_filter_ajax_action': action};
        var spin = action === 'reload';

        $.ajax({
            'method': 'POST',
            'data': requestData,
            'url': link,
            'dataType': 'json',
            beforeSend: function () {
                if (spin) {
                    showSpinner();
                }
            },
            complete: function () {
                if (spin) {
                    hideSpinner();
                }
            },
            success: function (response) {
                if (response instanceof Object) {
                    for (var key in response) {

                        var html = response[key].html;
                        var selector = response[key].selector;

                        switch (response[key].callback) {
                            case 'replacePart':
                                var part = $(html).find(selector);
                                $(selector).replaceWith(part);
                                break;
                            case 'replaceWith':
                                $(selector).replaceWith(html);
                                break;
                            case 'insertAfter':
                                $(selector).insertAfter(html);
                                break;
                            case 'append':
                                $(selector).append(html);
                                break;
                            case 'remove':
                                $(selector).remove();
                                break;
                            default:
                                $(selector).html(html);
                        }
                    }
                }
                history.pushState({}, null, link);

                initScrolls();
                initSliders();
                fixWoocommerceOrdering();
            }
        });
    }

    var fieldMin = 'data-premmerce-filter-slider-min';
    var fieldMax = 'data-premmerce-filter-slider-max';
    var slider = 'data-premmerce-filter-range-slider';

    function initSlider(form) {

        // Default valued at start
        var initialMinVal = parseFloat(form.find('[' + fieldMin + ']').attr(fieldMin));
        var initialMaxVal = parseFloat(form.find('[' + fieldMax + ']').attr(fieldMax));

        // Values after applying filter
        var curMinVal = parseFloat(form.find('[' + fieldMin + ']').attr('value'));
        var curMaxVal = parseFloat(form.find('[' + fieldMax + ']').attr('value'));

        // Setting value into form inputs when slider is moving
        form.find('[' + slider + ']').slider({
            min: initialMinVal,
            max: initialMaxVal,
            values: [curMinVal, curMaxVal],
            range: true,
            slide: function (event, elem) {
                var instantMinVal = elem.values[0];
                var instantMaxVal = elem.values[1];

                form.find('[' + fieldMin + ']').val(instantMinVal);
                form.find('[' + fieldMax + ']').val(instantMaxVal);
            },
            change: function (event) {
                submitSliderForm(event, form);
            }
        });

        form.submit(function (e) {
            //Remove ? sign if form is empty
            if (($(this).serialize().length === 0)) {
                e.preventDefault();
                window.location.assign(window.location.pathname);
            }
        });
    }

    function submitSliderForm(event, form) {
        if (event.originalEvent) {

            var sliderEl = form.find('[' + slider + ']');

            var minField = form.find('[' + fieldMin + ']');
            var maxField = form.find('[' + fieldMax + ']');

            var minVal = parseFloat(minField.val());
            var maxVal = parseFloat(maxField.val());

            var initialMin = sliderEl.slider('option', 'min');
            var initialMax = sliderEl.slider('option', 'max');

            if (minVal === initialMin) {
                form.find('[' + fieldMin + ']').attr('disabled', true);
            }

            if (maxVal === initialMax) {
                form.find('[' + fieldMax + ']').attr('disabled', true);
            }

            if (useAjax) {
                var search = form.serialize();
                ajaxUpdate(form.attr('action') + '?' + search, 'reload');
                form.find('[' + fieldMin + '], [' + fieldMax + ']').attr('disabled', false);
            } else {

                form.trigger('submit');
            }

        }
    }

    /**
     * Launch filter after clicking on radio or checkbox control
     */
    $(document).on('change', '[data-premmerce-filter-link]', function (e) {
        followLink(e, $(this).attr('data-premmerce-filter-link'));
    });

    /**
     * Launch filter after changing select control
     */
    $(document).on('change', '[data-filter-control-select]', function (e) {
            followLink(e, $(this).val());
        }
    );

    /**
     * Launch filter after clicking on radio or checkbox control
     */
    $(document).on('click', '[data-premmerce-active-filter-link]', function (e) {

            followLink(e, $(this).attr('href'));
        }
    );

    /**
     * Toogle filter block visibility
     */
    $(document).on('click', '[data-premerce-filter-drop-handle],[data-premmerce-filter-drop-handle]', function (e) {
        e.preventDefault();

        $(this).closest('[data-premmerce-filter-drop-scope]').find('[data-premmerce-filter-inner]').slideToggle(300);
        $(this).closest('[data-premmerce-filter-drop-scope]').find('[data-premmerce-filter-drop-ico]').toggleClass('hidden', 300);
    });


    $(document).on('change', '[data-premmerce-slider-trigger-change]', function (e) {
        var form = $(e.target).closest('form');
        submitSliderForm(e, form);
    });


    function initScrolls() {
        /**
         * Positioning scroll into the middle of checked value
         * Working only if scroll option in filter setting is true
         */
        $('[data-filter-scroll]').each(function () {
            var frame = $(this);
            var fieldActive = frame.find('[data-filter-control]:checked').first().closest('[data-filter-control-checkgroup]');

            if (fieldActive.length > 0) {
                var fieldActivePos = fieldActive.offset().top - frame.offset().top;
                frame.scrollTop(fieldActivePos - (frame.height() / 2 - fieldActive.height()));
            }
        });
    }

    function initSliders() {
        $('[data-premmerce-filter-slider-form]').each(function (p, el) {
            initSlider($(el));
        });

    }


    if (loadDeferred) {
        ajaxUpdate(location.href, 'deferred');
    } else {
        initScrolls();
        initSliders();
    }

    function showSpinner() {
        var wrapper = $('<div>', {class: 'premmerce-filter-loader-wrapper'});

        $('body').prepend(wrapper);
    }

    function hideSpinner() {
        $('.premmerce-filter-loader-wrapper').remove();
    }

})(jQuery);