define([
    'jquery',
    'Hiberus_LazyLoad/js/jquery-lazy-load'
], function ($) {

    return function (options) {
        $(function () {
            var lazy = $(".lazy");
            lazy.lazyload({
                event : "scroll",
                data_attribute  : "src",
            });
        });
    };
});