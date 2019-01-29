jQuery(document).ready(function ($) {
    'use strict';


    //Sortable for filters
    $('.aws-form-filters tbody').sortable({
        handle: ".aws-sort",
        items: ".aws-filter-item:not(.disabled)",
        axis: "y",
        update: function() {
            var instanceId;
            var order = new Array();

            $('.aws-filter-item').each( function() {
                instanceId = $(this).data('instance');
                order.push( $(this).data('id') );
            });

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'aws-orderFilter',
                    instanceId: instanceId,
                    order: JSON.stringify(order)
                },
                dataType: "json"
            });

        }
    }).disableSelection();


    // Advanced select
    $(".chosen-select").chosen({
        width: '30em'
    });


    // Image upload
    $('.image-upload-btn').click(function(e) {

        e.preventDefault();

        var container = $(this).closest('td');
        var size = $(this).data('size');
        var custom_uploader;

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false,
            type : 'image'
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            //console.log(attachment);

            var image_size = attachment.sizes[size];
            var image_src = image_size.url;

            container.find('.image-hidden-input').val(image_src);
            container.find('.image-preview').attr('src', image_src );
        });

        //Open the uploader dialog
        custom_uploader.open();

    });


    $('.image-remove-btn').click(function(e) {
        e.preventDefault();

        var container = $(this).closest('td');

        container.find('img').attr('src', '');
        container.find('.image-hidden-input').val('');

    });

    // Rename instance
    $('.aws-instance-name').on( 'click', function(e) {

        var self = $(this);

        var name = self.text();
        var newName = prompt( 'Type new name for this search form', name );
        var instanceId = self.data('id');

        if ( newName && ( name !== newName ) ) {

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'aws-renameForm',
                    id: instanceId,
                    name: newName
                },
                dataType: "json",
                success: function (data) {
                    self.text(newName);
                }
            });

        }

    });

    // Copy instance
    $('.aws-table.aws-form-instances .aws-actions .copy').on( 'click', function(e) {

        e.preventDefault();

        var self = $(this);
        var instanceId = self.data('id');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'aws-copyForm',
                id: instanceId
            },
            dataType: "json",
            success: function (data) {
                location.reload();
            }
        });

    });

    // Remove instance
    $('.aws-table.aws-form-instances .aws-actions .delete').on( 'click', function(e) {

        e.preventDefault();

        var self = $(this);
        var instanceId = self.data('id');

        if ( confirm( "Are you sure want to delete this search form?" ) ) {

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'aws-deleteForm',
                    id: instanceId
                },
                dataType: "json",
                success: function (data) {
                    location.reload();
                }
            });

        }

    });

    // Add instance
    $('.aws-insert-instance').on( 'click', function(e) {

        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'aws-addForm'
            },
            dataType: "json",
            success: function (data) {
                location.reload();
            }
        });

    });

    // Add filter
    $('.aws-insert-filter').on( 'click', function(e) {

        e.preventDefault();

        var self = $(this);
        var instanceId = self.data('instance');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'aws-addFilter',
                instanceId: instanceId
            },
            dataType: "json",
            success: function (data) {
                location.reload();
            }
        });

    });

    // Copy filter
    $('.aws-table.aws-form-filters .aws-actions .copy').on( 'click', function(e) {

        e.preventDefault();

        var self = $(this);
        var instanceId = self.data('instance');
        var filterId = self.data('id');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'aws-copyFilter',
                instanceId: instanceId,
                filterId: filterId
            },
            dataType: "json",
            success: function (data) {
                location.reload();
            }
        });

    });

    // Remove filter
    $('.aws-table.aws-form-filters .aws-actions .delete').on( 'click', function(e) {

        e.preventDefault();

        var self = $(this);
        var instanceId = self.data('instance');
        var filterId = self.data('id');

        if ( confirm( "Are you sure want to delete this filter?" ) ) {

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'aws-deleteFilter',
                    instanceId: instanceId,
                    filterId: filterId
                },
                dataType: "json",
                success: function (data) {
                    window.top.location.href = window.location.href.replace(/&filter=\d*/g,"");
                }
            });

        }

    });

    var changingState = false;

    // Change option state
    $('[data-change-state]').on( 'click', function(e) {

        e.preventDefault();

        if ( changingState ) {
            return;
        } else {
            changingState = true;
        }

        var self = $(this);
        var $parent = self.closest('td');
        var setting = self.data('setting');
        var option = self.data('name');
        var state = self.data('change-state');

        $parent.addClass('loading');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'aws-changeState',
                instanceId: aws_vars.instance,
                filterId: aws_vars.filter,
                setting: setting,
                option: option,
                state: state
            },
            dataType: "json",
            success: function (data) {
                $parent.removeClass('loading');
                $parent.toggleClass('active');
                changingState = false;
            }
        });

    });

    // Clear cache
    $('#aws-clear-cache .button').on( 'click', function(e) {

        e.preventDefault();

        var $clearCacheBlock = $(this).closest('#aws-clear-cache');

        $clearCacheBlock.addClass('loading');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'aws-clear-cache'
            },
            dataType: "json",
            success: function (data) {
                alert('Cache cleared!');
                $clearCacheBlock.removeClass('loading');
            }
        });

    });

    // Reindex table
    var $reindexBlock = $('#aws-reindex');
    var $reindexBtn = $('#aws-reindex .button');
    var $reindexProgress = $('#aws-reindex .reindex-progress');
    var $reindexCount = $('#aws-reindex-count strong');
    var syncStatus;
    var processed;
    var toProcess;
    var processedP;
    var syncData = false;

    // Reindex table
    $reindexBtn.on( 'click', function(e) {

        e.preventDefault();

        syncStatus = 'sync';
        processed  = 0;
        toProcess  = 0;
        processedP = 0;

        $reindexBlock.addClass('loading');
        $reindexProgress.html ( processedP + '%' );

        sync('start');

    });


    function sync( data ) {

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'aws-reindex',
                data: data
            },
            dataType: "json",
            timeout:0,
            success: function (response) {
                if ( 'sync' !== syncStatus ) {
                    return;
                }

                toProcess = response.data.found_posts;
                processed = response.data.offset;

                processedP = Math.floor( processed / toProcess * 100 );

                syncData = response.data;

                if ( 0 === response.data.offset && ! response.data.start ) {

                    // Sync finished
                    syncStatus = 'finished';

                    console.log( response.data );
                    console.log( "Reindex finished!" );

                    $reindexBlock.removeClass('loading');

                    $reindexCount.text( response.data.found_posts );

                } else {

                    console.log( response.data );

                    $reindexProgress.html ( processedP + '%' );

                    // We are starting a sync
                    syncStatus = 'sync';

                    sync( response.data );
                }

            },
            error : function( jqXHR, textStatus, errorThrown ) {
                console.log( "Request failed: " + textStatus );

                if ( textStatus == 'timeout' || jqXHR.status == 504 ) {
                    console.log( 'timeout' );
                    if ( syncData ) {
                        setTimeout(function() { sync( syncData ); }, 1000);
                    }
                } else if ( textStatus == 'error') {
                    if ( syncData ) {

                        if ( 0 !== syncData.offset && ! syncData.start ) {
                            setTimeout(function() { sync( syncData ); }, 3000);
                        }

                    }
                }

            },
            complete: function ( jqXHR, textStatus ) {
            }
        });

    }

});