billingApp.run(['$templateCache', function($templateCache) {

    $templateCache.put('autocomplete-template-product.html',
        '<md-autocomplete' +
        ' md-autoselect="true"' +
        ' name="product"' +
        ' md-selected-item="mCtrl.selectedItem"' +
        ' md-search-text="mCtrl.searchText"' +
        ' md-items="item in mCtrl.querySearch(\'products\', \'product\')"' +
        ' md-item-text="item.product"' +
        ' md-label="Search" flex>' +
        '	<span' +
        ' 		md-highlight-text="mCtrl.searchText">{{item.product}}' +
        '	</span>' +
        '</md-autocomplete>'
    );

    $templateCache.put('autocomplete-template-stock.html',
        '<md-autocomplete' +
        ' md-autoselect="true"' +
        ' name="stock"' +
        ' md-selected-item="mCtrl.selectedItem"' +
        ' md-search-text="mCtrl.searchText"' +
        ' md-items="item in mCtrl.querySearch(\'stocks\', \'product\')"' +
        ' md-item-text="item.product"' +
        ' md-label="Search" flex>' +
        '<span' +
        ' md-highlight-text="mCtrl.searchText">{{item.product}} ({{item.color}}) | {{item.store_name}}: {{item.quantity}}' +
        '</span>' +
        '</md-autocomplete>'
    );

    $templateCache.put('autocomplete-template-store.html',
        '<md-autocomplete' +
        ' md-autoselect="true"' +
        ' name="store"' +
        ' md-selected-item="mCtrl.selectedItem"' +
        ' md-search-text="mCtrl.searchText"' +
        ' md-items="item in mCtrl.querySearch(\'stores\', \'store_name\')"' +
        ' md-item-text="item.store_name"' +
        ' md-label="Search" flex>' +
        '<span' +
        ' md-highlight-text="mCtrl.searchText">{{item.store_name}}' +
        '</span>' +
        '</md-autocomplete>'
    );

    $templateCache.put('autocomplete-template-color.html',
        '<md-autocomplete' +
        ' md-autoselect="true"' +
        ' name="color"' +
        ' md-selected-item="mCtrl.selectedItem"' +
        ' md-search-text="mCtrl.searchText"' +
        ' md-items="item in mCtrl.querySearch(\'colors\', \'color\')"' +
        ' md-item-text="item.color"' +
        ' md-label="Search" flex>' +
        '<span' +
        ' md-highlight-text="mCtrl.searchText">{{item.color}}' +
        '</span>' +
        '</md-autocomplete>'
    );

}]);
