jQuery(function ($) {

    if ($().select2) {
        $('.filter-settings-select').select2({'allowClear': false, 'minimumResultsForSearch': 10});
    }
    
    //fix column sizes on
    $('[data-sortable] td').each(function () {
        $(this).css('width', $(this).width() + 'px');
    });

    //follow main checkbox by selectable
    $('[data-select-all]').change(function () {
        var main = $(this);
        var name = main.data('select-all');
        $('[data-selectable="' + name + '"]').prop('checked', main.prop('checked'));
    });

    var table = $('[data-sortable]');

    table.sortable({
        handle: '[data-sortable-handle]',
        axis: "y",
        update: function () {
            var ids = [];
            var action = table.data('sortable');
            $('input[data-id]').each(function () {
                ids.push($(this).data('id'));
            });

            showPreloader($('[data-bulk-actions]'));

            $.post(ajaxurl, {ids: ids, action: action}, function () {
                window.location.reload();
            });
        }
    });

    $('select[data-single-action]').change(function () {
        var $this = $(this);
        showPreloader($this.closest('td'));
        update([$this.data('id')], $this.data('single-action'), $this.val());
    });

    $('span[data-single-action]').click(function () {
        var $this = $(this);
        showPreloader($this.closest('td'));
        update([$this.data('id')], $this.data('single-action'), $this.data('value'));
    });

    $('button[data-action]').click(function () {
        var $this = $(this);

        showPreloader($this.closest('[data-bulk-actions]'));

        var action = $this.data('action');
        var value = $this.parent('.bulkactions').find('[data-bulk-action-select]').val();

        var ids = [];
        $('input[data-id]:checked').each(function () {
            ids.push($(this).data('id'));
        });

        update(ids, action, value);

    });

    function update(ids, action, value) {
        $.post(ajaxurl, {ids: ids, action: action, value: value}, function () {
            window.location.reload();
        })
    }

    var colorDialog = $('[data-color-dialog]');
    // Init color dialog

    colorDialog.dialog({
        modal: true,
        autoOpen: false,
        closeOnEscape: true,
        closeText: '',
        dialogClass: 'wp-dialog',
        minWidth: 700,
        buttons: [
            {
                text: colorDialog.attr('data-save-text'),
                click: function () {
                    var data = [];
                    var $this = $(this);
                    $('[data-color-dialog] [data-color-input]').each(function () {
                        var $input = $(this);
                        data.push({'id': $input.attr('name'), 'value': $input.val()});
                    });

                    showPreloader($('.ui-dialog-buttonset'), 'prepend');

                    var taxonomy = $('[data-color-dialog] [name="taxonomy"]').val();

                    $.ajax({
                        url: ajaxurl,
                        method: 'POST',
                        data: {
                            action: 'premmerce_filter_save_colors',
                            taxonomy: taxonomy,
                            data: data
                        },
                        dataType: 'json'
                    }).success(function (data) {
                        $this.dialog('close');
                    });
                }
            }
        ]
    });

    // Color dialog open logic
    $(document).on('click', '[data-open-dialog]', function (e) {
        e.preventDefault();
        var dialogSelector = $(this).data('open-dialog');
        var attributeId = $(this).data('attribute-id');

        showPreloader($(this).closest('td'));

        $.ajax({
            url: ajaxurl,
            method: 'GET',
            data: {
                action: 'premmerce_filter_get_colors',
                id: attributeId
            },
            dataType: 'json'
        }).success(function (data) {

            hideLoader();

            var dialog = $(dialogSelector);
            var ul = $("<ul>", {
                class: 'pc-colors-list'
            });

            for (var key in data.results) {
                var item = data.results[key];

                var li = $('<li>', {
                    text: item.text,
                    class: 'pc-colors-list__item'
                });

                var input = $('<input>', {
                    type: 'text',
                    name: item.id,
                    value: item.value,
                    class: 'term-color-picker',
                    'data-color-input': 'data-color-input'
                });
                li.append(input);
                ul.append(li);

            }

            dialog.empty().append(ul);
            dialog.append($('<input>', {type: 'hidden', name: 'taxonomy', value: data.taxonomyName}));
            dialog.dialog('option', 'title', data.taxonomyLabel).dialog('open');
            $('.term-color-picker').wpColorPicker();
        });
    });

    function showPreloader(element, position) {

        position = position || 'append';

        var loader = $('<span>', {
            class: 'spinner is-active pc-filter-loader'
        });

        if (position === 'append') {
            element.append(loader);
        } else if (position === 'prepend') {
            element.prepend(loader);
        }

    }

    function hideLoader() {
        $('.pc-filter-loader').remove();
    }

});
