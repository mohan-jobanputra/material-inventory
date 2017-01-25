/*
 * Declaring the App Module
 */


/*global $, XMLHttpRequest, document, angular, Backgrid, Backbone  */

//
var billingApp = angular.module('billingApp', ['ngMaterial', 'ng-mfb']);

/*
 * Declaring filter to sanitize HTML, which can then be injected into the DOM
 * In the future, remove this if it is not used
 */
billingApp.filter("sanitize", ['$sce', function($sce) {
    return function(htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    };
}]);

billingApp.directive('includeReplace', function() {
    return {
        require: 'ngInclude',
        restrict: 'A',
        /* optional */
        link: function(scope, el, attrs) {
            el.replaceWith(el.children());
        }
    };
});

/*
 * Configuring the default Material Theme
 */
billingApp.config(function($mdThemingProvider, $mdIconProvider) {

    $mdIconProvider
        .icon("expand_less", "icns/24px/ic_expand_less_24px.svg", 24)
        .icon("expand_more", "icns/24px/ic_expand_more_24px.svg", 24)
        .icon("add", "icns/24px/ic_add_24px.svg", 24)
        .icon("quantity", "icns/24px/ic_content_copy_24px.svg", 24)
        .icon("place", "icns/24px/ic_place_24px.svg", 24)
        .icon("selling_price", "icns/24px/ic_local_offer_24px.svg", 24)
        .icon("store_name", "icns/24px/ic_location_city_24px.svg", 24)
        .icon("person", "icns/24px/ic_person_24px.svg", 24)
        .icon("product_name", "icns/24px/ic_perm_device_info_24px.svg", 24)
        .icon("imei", "icns/24px/ic_info_24px.svg", 24)
        .icon("cost_price", "icns/24px/ic_payment_24px.svg", 24)
        .icon("search", "icns/24px/ic_search_24px.svg", 24)
        .icon("color", "icns/24px/ic_palette_24px.svg", 24)
        .icon("date", "icns/24px/ic_access_time_24px.svg", 24)
        .icon("password", "icns/24px/ic_lock_24px.svg", 24)
        .icon("username", "icns/24px/ic_account_circle_24px.svg", 24)
        .icon("phone", "icns/24px/ic_phone_24px.svg", 24);


    var themeProvider = $mdThemingProvider.theme('default');
    themeProvider.accentPalette('grey');
});