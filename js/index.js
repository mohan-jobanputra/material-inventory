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

billingApp.controller('stocksController', function() {

    var self = this;

    function stocksArray() {
        var uri = encodeURI('php/gateway.php?sender=stocksController&action=list');
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", uri, false);
        xmlhttp.send();
        return JSON.parse(xmlhttp.responseText);
    }

    self.querySearch = function() {
        var results = [];
        var array = stocksArray();
        for (var i = 0; i < array.length; i++) {
            if (array[i].product_name.indexOf(self.searchText) > -1) {
                results.push(array[i]);
            }
        }
        console.log(results);
        return results;
    };

    self.selectedItemChange = function(item) {
        console.log('Selected Item: ' + item);
    };

});

billingApp.controller('mainController', function() {

    var self = this;

    /*
     *  THE VARIABLES
     */

    self.currentNewMenuIndex = 1;

    self.isOverlayHidden = true;

    self.toggleOverlay = function() {
        self.isOverlayHidden = !self.isOverlayHidden;
    };

    self.setCurrentNewMenuIndex = function(index) {
        self.currentNewMenuIndex = index;
        if (index == 6) {
            self.showActionButton = false;
        } else {
            self.showActionButton = true;
        }
    };

    self.createNewItem = function(index) {
        self.isOverlayHidden = !self.isOverlayHidden;
    };

    self.tabs = [{
        index: 1,
        label: 'Purchases',
        tableId: 'purchases-table'
    }, {
        index: 2,
        label: 'Sales',
        tableId: 'sales-table'

    }, {
        index: 3,
        label: 'Transfers',
        tableId: 'transfers-table'
    }, {
        index: 4,
        label: 'Products',
        tableId: 'products-table'
    }, {
        index: 5,
        label: 'Stores',
        tableId: 'stores-table'
    }, {
        index: 6,
        label: 'Stocks',
        tableId: ''
    }, ];

    /*
     *  THE FUNCTIONS
     */

    $(document).ready(function() {
        var $form = $('.new-form');
        $form.submit(function() {
            $.post($(this).attr('action'), $(this).serialize(), function(response) {
                self.toggleOverlay();
            }, 'json');
            return false;
        });
    });

});
