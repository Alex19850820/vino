jQuery(function ($) {


    function RuleTable(taxonomyManager) {

        this.taxonomyManager = taxonomyManager;

        this.prototype = $('[data-prototype-table] tr');

        this.container = $('[data-row-container]');

        var self = this;

        this.addRow = function () {
            var row = self.prototype.clone();
            self.container.append(row);
            row.find('select').select2();
            self.checkAddButton();
        };

        this.removeRow = function () {
            var tr = $(this).closest('tr');
            var taxonomy = tr.find('[data-select-taxonomy]').val();
            tr.remove();
            taxonomyManager.enable(taxonomy);
            self.checkAddButton();
        };

        this.getNumRows = function () {
            return self.container.find('tr').length;
        };

        this.checkAddButton = function () {
            if (self.getNumRows() >= self.taxonomyManager.getTaxonomies().length) {
                $('[data-add-row]').closest('tr').hide();
            } else {
                $('[data-add-row]').closest('tr').show();
            }

        };

        this.checkAddButton();
    }

    function TaxonomyManager() {

        var self = this;

        this.onTaxonomySelectChange = function () {
            var el = $(this);
            var taxonomy = el.val();
            var previous = el.attr('data-val');

            if (taxonomy === previous) {
                return;
            }

            var termSelect = el.closest('tr').find('[data-select-term]');

            self.initTermSelect(termSelect, taxonomy);
            self.enable(previous);
            self.disable(taxonomy);

            el.attr('data-val', taxonomy);
        };

        this.initTermSelect = function (termSelect, taxonomy) {

            termSelect.attr('name', 'terms[' + taxonomy + '][]');

            var selectedTerms = termSelect.attr('data-selected-value');

            var params = this.getAjaxParams(taxonomy);

            $.ajax(params).then(function (data) {
                termSelect.empty().select2({
                    data: data.results
                });
                if (selectedTerms) {
                    selectedTerms = JSON.parse(selectedTerms);
                    termSelect.val(selectedTerms).trigger('change');
                }
            });

        };

        this.getAjaxParams = function (taxonomy) {
            return {
                url: ajaxurl,
                method: 'POST',
                dataType: "json",
                data: {
                    'taxonomy': taxonomy,
                    'action': 'get_taxonomy_terms'
                }

            };
        };

        this.getTaxonomies = function () {
            return this.collectTaxonomies('[data-select-taxonomy]:first option');
        };

        this.collectTaxonomies = function (selector) {
            var taxonomies = [];

            $(selector).each(function () {
                if (this.value) {
                    taxonomies.push(this.value)
                }
            });

            return taxonomies;
        };

        this.enable = function (taxonomy) {
            $('[data-select-taxonomy] option[value="' + taxonomy + '"]').each(function () {
                $(this).removeAttr('disabled')
            });
        };
        this.disable = function (taxonomy) {
            if (!taxonomy) {
                return;
            }
            $('[data-select-taxonomy]').find('option[value="' + taxonomy + '"]:not(:selected)').each(function () {
                $(this).attr('disabled', 'disabled')
            });
        }

    }


    $('[data-term-table] [data-select-two]').select2();

    var tx = new TaxonomyManager();
    var table = new RuleTable(tx);

    $(document).on('change', '[data-select-taxonomy]', tx.onTaxonomySelectChange);

    $(document).on('click', '[data-add-row]', table.addRow);
    $(document).on('click', '[data-remove-row]', table.removeRow);

    //Trigger change to load terms to selects
    $('[data-term-table] [data-select-taxonomy]').trigger('change');

    //Insert variable into input
    $(document).on('click', 'button[data-var]', function () {
        var variable = $(this).attr('data-var');
        var field = $(this).attr('data-field');
        insertText(field, variable);
    });

    //Insert text into input,textarea or text editor
    function insertText(fieldSelector, text) {

        var field = document.querySelector(fieldSelector);

        if (!field) {
            return;
        }

        field.focus();
        var value = field.value;
        var position = field.selectionStart;
        field.value = value.slice(0, position) + text + value.slice(position);
        position += text.length;
        field.setSelectionRange(position, position);

        if (field.classList.contains('wp-editor-area') && typeof tinyMCE !== 'undefined') {
            if (tinyMCE.get(field.id)) {
                tinyMCE.get(field.id).execCommand('mceInsertContent', false, text);
            }
        }

    }

    //Rules generation

    $('[data-generate-select-two]').each(function () {
        initSelect2WithPlaceholder($(this));
    });

    $(document).on('click', '[data-add-taxonomy-button]', function () {
        var selectRow = $('[data-taxonomy-prototype]');
        var clone = selectRow.clone();
        var select = clone.find('select');
        clone.removeAttr('data-taxonomy-prototype');
        clone.removeAttr('hidden');

        var num = $('[data-taxonomy-select]').length;
        select.attr('name', 'filter_taxonomy[' + num + '][]');

        $('[data-taxonomies-wrapper]').append(clone);
        initSelect2WithPlaceholder(select);
    });

    function initSelect2WithPlaceholder(select) {
        var placeholder = select.attr('placeholder');
        select.select2({
            placeholder: placeholder
        })
    }

    $(document).on('click', '[data-remove-element]', function () {

        var $this = $(this);
        var remove = $this.attr('data-remove-element');
        $this.closest(remove).remove()
    });

    //Progress bar
    function initProgressBar() {
        var widget = $(".progress-bar__widget");
        var max = $('[data-progressbar-max]').text();
        widget.progressbar({
            value: 0,
            max: max,
            create: function () {
                generateNextRule(widget);
            }
        });
    }

    function generateNextRule(widget) {

        var complete = $('[data-progress-complete-url]').val();
        var action = $('[data-progress-action]').val();
        $.ajax({
            url: ajaxurl,
            method: 'post',
            dataType: 'json',
            data: {action: action},
        }).then(function (data) {
            var value = widget.progressbar('value') + 1;
            widget.progressbar('value', value);
            $('[data-progressbar-current]').text(value);
            if (data.status === 'next') {
                generateNextRule(widget);
            } else {
                location.assign(complete);
            }
        });
    }

    initProgressBar();
});
