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
        .icon("expand_less", "icons/24px/ic_expand_less_24px.svg", 24)
        .icon("expand_more", "icons/24px/ic_expand_more_24px.svg", 24)
        .icon("add", "icons/24px/ic_add_24px.svg", 24)
        .icon("quantity", "icons/24px/ic_content_copy_24px.svg", 24)
        .icon("place", "icons/24px/ic_place_24px.svg", 24)
        .icon("selling_price", "icons/24px/ic_local_offer_24px.svg", 24)
        .icon("store_name", "icons/24px/ic_location_city_24px.svg", 24)
        .icon("person", "icons/24px/ic_person_24px.svg", 24)
        .icon("product_name", "icons/24px/ic_perm_device_info_24px.svg", 24)
        .icon("imei", "icons/24px/ic_info_24px.svg", 24)
        .icon("cost_price", "icons/24px/ic_payment_24px.svg", 24)
        .icon("search", "icons/24px/ic_search_24px.svg", 24)
        .icon("color", "icons/24px/ic_palette_24px.svg", 24)
        .icon("date", "icons/24px/ic_access_time_24px.svg", 24)
        .icon("phone", "icons/24px/ic_phone_24px.svg", 24);


    var themeProvider = $mdThemingProvider.theme('default');
    themeProvider.primaryPalette('blue-grey');
    themeProvider.accentPalette('teal');
});
