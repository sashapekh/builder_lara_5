'use strict';

var ForeignDefinition  = {

    createDefinition  : function (content, table, attributes, foreign_field_id) {

        var attributesJson = jQuery.parseJSON(attributes);
        var definition = attributesJson.definition;
        var foreign_field = attributesJson.foreign_field;


        if (foreign_field_id == undefined) {
            var loader = content.parent().find('.loader_create_definition');
            loader.removeClass('hide').text('Сохранение данных..');

            content.parents('form').submit();

            TableBuilder.handlerCreate = function (url, idCreated) {

                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        'id' : idCreated,
                        'query_type' : 'show_edit_form'
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('.table_form_create').html(data.html);
                        $('.table_form_create #modal_form_edit').addClass('in').show();

                        content = $('.table_form_create #' + content.attr('id'))
                        TableBuilder.initFroalaEditor();
                        TableBuilder.refreshMask();
                        TableBuilder.handleActionSelect();
                        loader.addClass('hide');


                        ForeignDefinition.sendRequestForShowDefinition(content, table, definition, idCreated, foreign_field, attributes);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorResult = jQuery.parseJSON(xhr.responseText);

                        TableBuilder.showErrorNotification(errorResult.message);
                    }
                });
            }

            return ;
        }

        ForeignDefinition.sendRequestForShowDefinition(content, table, definition, foreign_field_id, foreign_field, attributes);
    },

    sendRequestForShowDefinition : function (content, table, definition, foreign_field_id, foreign_field, attributes) {
        var loader = content.parent().find('.loader_create_definition');
        loader.removeClass('hide').text('Загрузка окна...');

        jQuery.ajax({
            type: "POST",
            url: "/admin/handle/" + definition,
            data: {
                'query_type' :'show_add_form',
                'foreign_field_id' : foreign_field_id,
                'foreign_field' : foreign_field,
                'foreign_attributes' :  attributes
            },
            success: function (data) {
                $('.foreign_popups').append(data);
                loader.addClass('hide');
                ForeignDefinition.afterOpenPopup(table);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorResult = jQuery.parseJSON(xhr.responseText);

                TableBuilder.showErrorNotification(errorResult.message);
            }
        });

    },

    callbackForeignDefinition : function (foreignFieldId, foreignAttributes) {
        var attributesJson = jQuery.parseJSON(foreignAttributes);
        // TableBuilder.showSuccessNotification(phrase['Сохранено']);
        TableBuilder.doClosePopup(attributesJson.table);
        $('.definition_' + attributesJson.name + " .loader_definition").show();

        jQuery.ajax({
            type: "POST",
            url: "/admin/handle/" + attributesJson.definition,
            data: {
                'id' : foreignFieldId,
                'paramsJson' : foreignAttributes,
                'query_type' : 'get_html_foreign_definition'
            },
            dataType: 'json',
            success: function (response) {
                if (response.html) {
                    $('.definition_' + attributesJson.name).html(response.html);

                    if (attributesJson.sortable != undefined) {
                        $('.definition_' + attributesJson.name + ' tbody').sortable({
                            handle: ".handle",
                            update: function ( event, ui ) {
                                ForeignDefinition.changePosition($(this), foreignAttributes);
                            }
                        });
                    } else {
                        $('.definition_' + attributesJson.name + ' .col_sort').hide();
                    }

                    if (attributesJson.only_once != undefined) {
                        if (response.count_records) {
                            $('.definition_' + attributesJson.name).parent().find('.btn-success').hide();
                        } else {
                            $('.definition_' + attributesJson.name).parent().find('.btn-success').show();
                        }
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorResult = jQuery.parseJSON(xhr.responseText);

                TableBuilder.showErrorNotification(errorResult.message);
            }
        });

    },

    delete : function (idDelete, idUpdate, jsonParams) {
        jQuery.SmartMessageBox({
            title : phrase["Удалить?"],
            content : phrase["Эту операцию нельзя будет отменить."],
            buttons : '[' + phrase["Нет"] + '][' + phrase["Да"] + ']'
        }, function (ButtonPressed) {
            if (ButtonPressed === phrase["Да"]) {
                var attributesJson = jQuery.parseJSON(jsonParams);
                $('.definition_' + attributesJson.name + " .loader_definition").show();
                jQuery.ajax({
                    type: "POST",
                    url: "/admin/handle/" + attributesJson.definition,
                    data: {
                        'idDelete' : idDelete,
                        'id' : idUpdate,
                        'paramsJson' : jsonParams,
                        'query_type' : 'delete_foreign_row'
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.html) {
                            $('.definition_' + attributesJson.name).html(response.html);
                            TableBuilder.showSuccessNotification('Удалено');

                            if (attributesJson.only_once != undefined) {
                                if (response.count_records) {
                                    $('.definition_' + attributesJson.name).parent().find('.btn-success').hide();
                                } else {
                                    $('.definition_' + attributesJson.name).parent().find('.btn-success').show();
                                }
                            }
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorResult = jQuery.parseJSON(xhr.responseText);

                        TableBuilder.showErrorNotification(errorResult.message);
                    }
                });
            }
        });
    },

    edit : function (idEdit, idUpdate, jsonParams) {

        var attributesJson = jQuery.parseJSON(jsonParams);

        var loader = $('.loader_definition_' + attributesJson.name);
        loader.removeClass('hide').text('Загрузка окна...');

        jQuery.ajax({
            type: "POST",
            url: "/admin/handle/" + attributesJson.definition,
            data: {
                'id' : idEdit,
                'idUpdate' : idUpdate,
                'foreign_attributes' : jsonParams,
                'foreign_field' : attributesJson.foreign_field,
                'foreign_field_id' : idUpdate,
                'query_type' : 'show_edit_form'
            },
            dataType: 'json',
            success: function (data) {
                $('.foreign_popups').append(data.html);
                loader.addClass('hide');
                ForeignDefinition.afterOpenPopup(attributesJson.table);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorResult = jQuery.parseJSON(xhr.responseText);

                TableBuilder.showErrorNotification(errorResult.message);
            }
        });
    },

    afterOpenPopup : function (table) {
        $('.foreign_popups .fade').addClass('in').show();
        $('.modal_form_' + table).css('top', $(window).scrollTop() + 50);
        $(".modal-dialog").draggable({ handle: ".modal-header" });
        TableBuilder.initFroalaEditor(table);
        TableBuilder.handleActionSelect();
    },

    changePosition : function (context, attributesJson) {
        var arrIds = new Array();
        context.find('tr').each(function ( index ) {
            arrIds.push($(this).attr('data-id'));
        });

        var jsonIds = JSON.stringify(arrIds);
        var foreignAttributes = jQuery.parseJSON(attributesJson);

        jQuery.ajax({
            type: "POST",
            url: "/admin/handle/" + foreignAttributes.definition,
            data: {
                'paramsJson' : attributesJson,
                'idsPosition' : jsonIds,
                'query_type' : 'change_position'
            },
            dataType: 'json',
            success: function (response) {
                TableBuilder.showSuccessNotification('Порядок сохранен');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorResult = jQuery.parseJSON(xhr.responseText);

                TableBuilder.showErrorNotification(errorResult.message);
            }
        });
    }

};

