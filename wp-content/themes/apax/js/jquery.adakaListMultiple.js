/*

 *	jQuery adakaListMultiple 1.0

 *

 *	Copyright (c) 2014 Agence ADAKA

 *	www.adaka.fr

 *

 *	Dual licensed under the MIT and GPL licenses.

 *	http://en.wikipedia.org/wiki/MIT_License

 *	http://en.wikipedia.org/wiki/GNU_General_Public_License

 */



(function($) {

    var methods = {

        destroy: function() {

            var $list = $(this),
                $isMultiple = $list.attr("multiple") ? true : false,
                $next = $list.next();

            if ($next.hasClass("adakaListMultiple")) {

                if (!$isMultiple) {

                    $list.find("option:first").remove();

                }

                $next.remove();

                $list.show();

            }

        }

    };

    $.fn.adakaListMultiple = function(options) {



        if (methods[options]) {

            return methods[options].apply(this, Array.prototype.slice.call(arguments, 1));

        }



        var settings = $.extend({

            width: "100%",

            txtList: "Faites votre choix...",

            txtSel: "élement(s) sélectionné(s)",

            flottant: false,

            overflow: false,

            closeOthers: true,

            showNbElementChecked: true,

            callback: function(ele) {},

            firstSelectAll: false

        }, options);



        return this.each(function() {



            var $list = $(this);

            var $isMultiple = $list.attr("multiple") ? true : false;



            var select_val = $(this).val();



            $list.hide();



            var $select = $('<div class="adakaListMultipleSelect" style="width:' + settings.width + '"><span class="txtSel">' + settings.txtList + '</span><span class="cursor"></span></div>');

            var $box = $('<div class="adakaListMultiple"><div class="list-options'

                +
                (settings.flottant ? ' list-options-absolute' : '')

                +
                '" style="display:none;\width:' + settings.width + ';'

                +
                (settings.overflow && !isNaN(parseInt(settings.overflow)) ? 'max-height: ' + settings.overflow + 'px; overflow-x: auto;' : '')

                +
                '"></div></div>');



            $list.find("option").each(function() {

                var $active = select_val == $(this).attr("value");

                $box.find(".list-options").append('<div class="option' + ($active ? ' active' : '') + '" data-value="' + $(this).attr("value") + '">'

                    +
                    ($isMultiple ? '<input type="checkbox" class="chk-option"' + ($active ? ' checked="checked"' : '') + ' value="' + $(this).attr("value") + '" />' : '')

                    +
                    ($(this).attr("data-image") ? '<div class="image-option"><img src="' + $(this).attr("data-image") + '" alt="" /></div>' : '')

                    +
                    ($(this).attr("data-icon") ? '<div class="icon-option"><i class="' + $(this).attr("data-icon") + '"></i></div>' : '')

                    +
                    '<div class="text-option"><div class="text">' + $(this).text() + '</div>' + ($(this).attr("data-description") ? '<div class="description">' + $(this).attr("data-description") + '</div>' : '') + '</div>'

                    +
                    '<div style="clear:both"></div>'

                    +
                    '</div>');

            });

            if (!$isMultiple)

                $list.prepend('<option value=""></option>');



            $box.find("div.option").click(function(e) {

                $(this).toggleClass("active");

                if ($isMultiple && !$(e.target).hasClass("chk-option")) {

                    var $chk = $(this).find("input");

                    $chk.prop("checked", !$chk.prop("checked"));

                }

                var val = $(this).attr("data-value");

                var $lstOpt = $list.find("option[value='" + val + "']");



                if ($isMultiple) {

                    $lstOpt.prop("selected", !$lstOpt.prop("selected"));



                    if (settings.firstSelectAll && $lstOpt.index() == 0) {

                        $list.find("option").prop("selected", true);

                        $lstOpt.prop("selected", false);



                        $box.find("div.option").addClass("active");

                        $(this).removeClass("active");



                        $box.find("div.option").not(this).each(function() {

                            $(this).hasClass("chk-option");

                        });

                        $box.trigger('list-close');

                    }



                    if (settings.showNbElementChecked) {

                        var nbSel = $list.find("option:selected").length;

                        $box.find(".adakaListMultipleSelect").html('<span class="txtSel">' + (nbSel == 0 ? settings.txtList : nbSel + ' ' + settings.txtSel) + '</span><span class="cursor cursor-down"></span>');

                    } else {

                        var strSel = '';

                        $list.find("option:selected").each(function() {

                            strSel += (strSel == '' ? '' : ', ') + $(this).text();

                        });

                        $box.find(".adakaListMultipleSelect").html('<span class="txtSel">' + (strSel == '' ? settings.txtList : strSel.toLowerCase().capitalizeFirstLetter()) + '</span><span class="cursor cursor-down"></span>');

                    }

                } else {

                    $box.find("div.option").removeClass("active");

                    $list.find("option").removeAttr("selected");

                    $(this).addClass("active");

                    $lstOpt.prop("selected", true);



                    var image = $(this).find(".image-option").html();

                    $box.find(".adakaListMultipleSelect").html('<span class="txtSel">' + $(this).html() + '</span><span class="cursor"></span>');

                    $(this).parent().stop().slideUp(200);

                    $box.find(".adakaListMultipleSelect").removeClass("list-down");

                }



                if (typeof settings.callback == 'function')

                    settings.callback.call(this, $list);

                $list.trigger("change");

            });



            $box.prepend($select);

            $list.after($box);



            $box.find(".adakaListMultipleSelect").on("click", function(e) {

                if (settings.closeOthers == true) // ferme toutes les listes

                    $(".adakaListMultiple").trigger('list-close');

                if ($(this).parent().find(".list-options").css("display") == "none") {

                    $(this).parent().find(".list-options").stop().slideDown(200);

                    $(this).find("span.cursor").addClass("cursor-down");

                    $(this).addClass("list-down");

                } else {

                    $(this).parent().find(".list-options").stop().slideUp(200);

                    $(this).find("span.cursor").removeClass("cursor-down");

                    $(this).removeClass("list-down");

                }

            });



            $("html").click(function(e) {

                if ($(e.target).parents(".adakaListMultiple").length == 0 && $box.find(".list-options").css("display") != "none") {

                    $(this).parent().find(".list-options").stop().slideUp(200);

                    $box.find(".adakaListMultipleSelect span.cursor").removeClass("cursor-down");

                    $box.find(".adakaListMultipleSelect").removeClass("list-down");

                }

            });



            if ($isMultiple) {

                if (settings.showNbElementChecked) {

                    var nbSel = $list.find("option:selected").length;

                    $box.find(".adakaListMultipleSelect").html('<span class="txtSel">' + (nbSel == 0 ? settings.txtList : nbSel + ' ' + settings.txtSel) + '</span><span class="cursor cursor-down"></span>');

                } else {

                    var strSel = '';

                    $list.find("option:selected").each(function() {

                        strSel += (strSel == '' ? '' : ', ') + $(this).text();

                    });

                    $box.find(".adakaListMultipleSelect").html('<span class="txtSel">' + (strSel == '' ? settings.txtList : strSel.toLowerCase().capitalizeFirstLetter()) + '</span><span class="cursor cursor-down"></span>');

                }

            } else {

                var $activeOption = $box.find(".option.active");

                if ($activeOption.length > 0) {

                    var image = $activeOption.find(".image-option").html();

                    $box.find(".adakaListMultipleSelect").html('<span class="txtSel">' + $activeOption.html() + '</span><span class="cursor"></span>');

                } else {

                    $list.find("option:first").prop("selected", true);

                }

            }



            // trigger permettant la fermeture de la liste

            $box.on("list-close", function() {

                $(this).find(".list-options").stop().slideUp(200);

                $(this).find("span.cursor").removeClass("cursor-down");

                $(this).find(".adakaListMultipleSelect").removeClass("list-down");

            });

        });



    };



}(jQuery));



String.prototype.capitalizeFirstLetter = function() {

    return this.charAt(0).toUpperCase() + this.slice(1);

}