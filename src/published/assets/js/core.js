"use strict";

var Core =
    {
        init: function () {
            Core.setOnlyNum();
        },

        //delete record
        Delete: function (id, table) {
            jQuery.SmartMessageBox({
                title : phrase["Удалить?"],
                content : phrase["Эту операцию нельзя будет отменить."],
                buttons : '[' + phrase['Нет'] + '][' + phrase['Да'] + ']'
            }, function (ButtonPressed) {
                if (ButtonPressed === phrase['Да']) {
                    jQuery.ajax({
                        type: "POST",
                        url: "/admin/delete",
                        data: { id: id, table:table},
                        dataType: 'json',
                        success: function (response) {

                            if (response.status) {
                                TableBuilder.showSuccessNotification('Удалено успешно');

                                $(".tr_" + id).remove();
                            } else {
                                TableBuilder.showErrorNotification(phrase['Что-то пошло не так, попробуйте позже']);
                            }

                        }
                    });
                }
            });
        }, // end Delete

        //delete get paran in url
        delPrm: function (Prm) {
            var  Url = window.location.href;
            var a = Url.split('?');
            var re = new RegExp('(\\?|&)' + Prm + '=[^&]+','g');

            Url = ('?' + a[1]).replace(re,'');
            Url = Url.replace(/^&|\?/,'');
            var dlm = (Url == '') ? '' : '?';

            if (typeof a[1] == "undefined") {
                return a[0];
            }

            return a[0] + dlm + Url;
        },

        //add get param in url
        setAttr: function (prmName, val) {
            var res = '';
            var d = location.href.split("#")[0].split("?");
            var base = d[0];
            var query = d[1];
            if (query) {
                var params = query.split("&");
                for (var i = 0; i < params.length; i++) {
                    var keyval = params[i].split("=");
                    if (keyval[0] != prmName) {
                        res += params[i] + '&';
                    }
                }
            }
            res += prmName + '=' + val;

            return base + '?' + res;
        }, // end setAttr

        urlParam: function (name) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results == null) {
                return null;
            } else {
                return results[1] || 0;
            }
        },//end urlParam

        // keyup event for class only_num
        setOnlyNum: function () {
            $(document).on("keyup", '.only_num', function () {
                var val = String($(this).val());
                var newstr = val.replace(/[^0-9]/gi,"");
                $(this).val(newstr);
            });
        },// end setOnlyNum

    };

jQuery(document).ready(function () {
    Core.init();
    $.getQuery = function ( query, url) {
        query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
        var expr = "[\\?&]" + query + "=([^&#]*)";
        var regex = new RegExp(expr);
        var results = regex.exec(url);
        if (results !== null) {
            return results[1];
            return decodeURIComponent(results[1].replace(/\+/g, " "));
        } else {
            return false;
        }
    };
});

