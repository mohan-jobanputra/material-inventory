billingApp.run(['$templateCache', function($templateCache) {

    $templateCache.put('input-stock.html',
        '<md-autocomplete' +
        ' md-autoselect="true"' +
        ' name="{{inputInfo.name}}"' +
        ' md-selected-item="mCtrl.selectedItem"' +
        ' md-search-text="mCtrl.searchText"' +
        ' md-items="item in mCtrl.querySearch(\'stocks\', \'product\')"' +
        ' md-item-text="item.product"' +
        ' md-label="{{inputInfo.placeholder}}" flex>' +
        '   <span' +
        '       md-highlight-text="mCtrl.searchText">{{item.product}} ({{item.color}}) | {{item.store_name}}: {{item.quantity}}' +
        '   </span>' +
        '</md-autocomplete>'
    );

    $templateCache.put('input-store.html',
        '<md-autocomplete' +
        ' md-autoselect="true"' +
        ' name="{{inputInfo.name}}"' +
        ' md-selected-item="mCtrl.selectedItem"' +
        ' md-search-text="mCtrl.searchText"' +
        ' md-items="item in mCtrl.querySearch(\'stores\', \'store_name\')"' +
        ' md-item-text="item.store_name"' +
        ' md-floating-label="{{inputInfo.placeholder}}" flex>' +
        '<span' +
        ' md-highlight-text="mCtrl.searchText">{{item.store_name}}' +
        '</span>' +
        '</md-autocomplete>'
    );

    $templateCache.put('input-color.html',
        '<md-autocomplete' +
        ' md-autoselect="true"' +
        ' name="{{inputInfo.name}}"' +
        ' md-selected-item="mCtrl.selectedItem"' +
        ' md-search-text="mCtrl.searchText"' +
        ' md-items="item in mCtrl.querySearch(\'colors\', \'color\')"' +
        ' md-item-text="item.color"' +
        ' md-floating-label="{{inputInfo.placeholder}}" flex>' +
        '<span' +
        ' md-highlight-text="mCtrl.searchText">{{item.color}}' +
        '</span>' +
        '</md-autocomplete>'
    );

}]);
