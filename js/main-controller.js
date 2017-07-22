billingApp.controller('mainController', ['$http', '$scope', function($http, $scope) {

    /*
     * LOGIN
     */

    var loginForm = $('#login-form');

    this.createNew = function(action, id) {
        var form = $('#' + id);
        var data = form.serialize();
        console.log(data);
        var req = $http
            ({
                "url": action, 
                "data": data,
                "method": "POST",
                "headers": {"Content-Type": "application/x-www-form-urlencoded"}
            })
            .then(function(data) {
                if (data.status == 200) {
                    return true;
                } else {
                    console.log('Network error encountered while logging in. Error code: ' + data.status)
                    return false;
                }
            });

    }

    this.attemptLogin = function() {

        var opts = {
            method: 'POST',
            url: 'php/gateway.php?sender=authenticationController&action=login',
            data: loginForm.serialize()
        }

        var req = $http
            .post(opts.url, opts.data)
            .then(function(data) {
                if (data.status == 200) {
                    var result = data.data;
                    if (result['did_authenticate']) {
                        $scope.isActionButtonHidden = false;
                        $scope.isLoginLayerHidden = true;
                        if (result['is_administrator']) {
                            $scope.isAdminDashLayerHidden = false;
                        } else {
                            $scope.isRepresentativeDashLayerHidden = false;
                        }
                    }
                } else {
                    console.log('Network error encountered while logging in. Error code: ' + data.status)
                }
            });
    }

    function loginSucceeded(isAdmin) {
        if (isAdmin === true) {
            console.log("Admin");
        } else {
            console.log("Rep");
        }
    }

    /*
     *  THE VARIABLES
     */

    this.currentNewMenuIndex = 1;

    $scope.autocompleteResults = {};

    this.querySearch = function(key) {
        if (!(key in $scope.autocompleteResults)) {
            $scope.autocompleteResults[key] = {};
            $scope.autocompleteResults[key]['available'] = false;
            $http
                .get(encodeURI('php/gateway.php?sender=autocompleteController&info=' + key))
                .then(function(data) {
                    if (data.status != 200) {
                        return [];
                    }
                    $scope.autocompleteResults[key]['results'] = data.data;
                    $scope.autocompleteResults[key]['available'] = true;
            });
            return [];
        }
        if (!($scope.autocompleteResults[key]['available'])) {
            return [];
        }
        var results = [];
        var array = $scope.autocompleteResults[key]['results'];
        for (var i = 0; i < array.length; i++) {
            if (array[i]['display'].toLowerCase().indexOf($scope.searchText.toLowerCase()) > -1) {
                results.push(array[i]);
            }
        }
        return results;
    };

    this.shouldShow = function(i) {
        console.log(i)
        if (this.currentNewMenuIndex == i) {
            return true;
        }
        return false;
    };

    this.toggleCreateItemOverlay = function() {
        $scope.isCreateItemOverlayHidden = !$scope.isCreateItemOverlayHidden;
    };

    this.createNewItem = function(index) {
        $scope.isCreateItemOverlayHidden = !$scope.isCreateItemOverlayHidden;
    };

    this.setCurrentNewMenuIndex = function(index) {
        this.currentNewMenuIndex = index;
        if (index == 6) {
            $scope.showActionButton = false;
        } else {
            $scope.showActionButton = true;
        }
    };

    /*
     *
     * TAB MANAGEMENT
     *
     */
     
    this.tabs = [
        { index: 1, label: 'Purchases',  tableId: 'purchases-table' }, 
        { index: 2, label: 'Sales', tableId: 'sales-table' }, 
        { index: 3, label: 'Transfers', tableId: 'transfers-table' }, 
        { index: 4, label: 'Products', tableId: 'products-table' }, 
        { index: 5, label: 'Stores', tableId: 'stores-table' }, 
        { index: 6, label: 'Stocks', tableId: '' }
    ];

    /*
     *
     *  TABLE MANAGEMENT
     *
     */

    $(document).ready(function() {

        var initiateGrid = function(element_id, columns, controllerName) {

            var gridModel = Backbone.Model.extend({

                initialize: function() {
                    Backbone.Model.prototype.initialize.apply(this, arguments);
                    this.on("change", function(model, options) {
                        this.sync("update", model, options);
                    });
                },
                sync: function(method, model, options) {
                    var methodUrl = {
                        'update': 'php/gateway.php?sender=' + controllerName + '&action=update'
                    };
                    if (methodUrl && methodUrl[method.toLowerCase()]) {
                        options = options || {};
                        options.url = methodUrl[method.toLowerCase()];
                    }
                    Backbone.sync(method, model, options);
                }
            });

            var gridCollectionModel = Backbone.Collection.extend({
                model: gridModel,
                url: 'php/gateway.php?sender=' + controllerName + '&action=list',
            });

            var gridCollection = new gridCollectionModel();

            var grid = new Backgrid.Grid({
                columns: columns,
                collection: gridCollection,
                emptyText: "No Data"
            });

            var gridContainer = $("#" + element_id);
            gridContainer.append(grid.render().el);

            gridCollection.fetch({
                reset: true
            });

        };

        //THE PURHASES TABLE
        var purchasesColumns = [
            { name: "purchase_id", label: "Purchase ID", cell: "integer", editable: "false" }, 
            { name: "product_id", label: "Product ID", cell: "integer", editable: "false" }, 
            { name: "product", label: "Product", cell: "string", editable: "false" }, 
            { name: "color", label: "Color", cell: "string", editable: "false" }, 
            { name: "store_name", label: "Store Name", cell: "string", editable: "false" }, 
            { name: "quantity", label: "Quantity", cell: "integer", editable: "false" }, 
            { name: "date", label: "Date", cell: "date", editable: "false" }, 
            { name: "rate", label: "Rate", cell: "number", editable: "false" }
        ];
        initiateGrid("purchases-table", purchasesColumns, "purchasesController");

        //THE SALES TABLE
        var salesColumns = [
            {name: "sale_id", label: "Sale ID", cell: "integer", editable: "false" }, 
            { name: "customer_name", label: "Customer Name", cell: "string", editable: "false" }, 
            { name: "store_name", label: "Store", cell: "string", editable: "false" }, 
            { name: "product_id", label: "Product ID", cell: "integer", editable: "false" }, 
            { name: "product", label: "Product", cell: "string", editable: "false" }, 
            { name: "color", label: "Color", cell: "string", editable: "false" }, 
            { name: "quantity", label: "Quantity", cell: "integer", editable: "false" }, 
            { name: "date", label: "Date", cell: "date", editable: "false" }, 
            { name: "imei", label: "IMEI", cell: "string", editable: "false" }, 
            { name: "selling_price", label: "Selling Price", cell: "number", editable: "false" }
        ];
        initiateGrid("sales-table", salesColumns, "salesController");

        //THE TRANSFERS TABLE
        var transferColumns = [
            { name: "transfer_id", label: "Transfer ID", cell: "integer", editable: "false" }, 
            { name: "product_id", label: "Product ID", cell: "integer", editable: "false" }, 
            { name: "product", label: "Product", cell: "string", editable: "false" }, 
            { name: "from_store_name", label: "From Store", cell: "string", editable: "false" }, 
            { name: "to_store_name", label: "To Store", cell: "string", editable: "false" }, 
            { name: "quantity", label: "Quantity", cell: "integer" }, 
            { name: "date", label: "Date", cell: "date", editable: "false" }
        ];
        initiateGrid("transfers-table", transferColumns, "transfersController");

        //THE PRODUCTS TABLE
        var productColumns = [
            { name: "product_id", label: "Product ID", cell: "integer", editable: "false", editable: "false" }, 
            { name: "product", label: "Product", cell: "string", editable: "false" }, 
            { name: "color", label: "Color", cell: "string", editable: "false" }, 
            { name: "optimal_selling_price", label: "Optimal Selling Price", cell: "number", editable: "false" }
        ];
        initiateGrid("products-table", productColumns, "productsController");

        //THE Stores TABLE
        var storeColumns = [
            { name: "store_id", label: "ID", cell: "string", editable: "false" }, 
            { name: "store_name", label: "Name", cell: "string", editable: "false" }, 
            { name: "store_address", label: "Address", cell: "string", editable: "false" }, 
            { name: "store_contact_number", label: "Contact Number", cell: "string", editable: "false" }
        ];
        initiateGrid("stores-table", storeColumns, "storesController");
    });
}]);
