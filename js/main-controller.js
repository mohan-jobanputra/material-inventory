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
                    console.log(method, model, options);
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
        var purchasesColumns = [{
            name: "purchase_id",
            label: "Purchase ID",
            cell: "integer",
            editable: "false"
        }, {
            name: "product_id",
            label: "Product ID",
            cell: "integer",
            editable: "false"
        }, {
            name: "product",
            label: "Product",
            cell: "string",
            editable: "false"
        }, {
            name: "color",
            label: "Color",
            cell: "string",
            editable: "false"
        }, {
            name: "store_name",
            label: "Store Name",
            cell: "string",
            editable: "false"
        }, {
            name: "quantity",
            label: "Quantity",
            cell: "integer",
            editable: "false"
        }, {
            name: "date",
            label: "Date",
            cell: "date",
            editable: "false"
        }, ];
        initiateGrid("purchases-table", purchasesColumns, "purchasesController");

        //THE SALES TABLE
        var salesColumns = [{
            name: "sale_id",
            label: "Sale ID",
            cell: "integer",
            editable: "false"
        }, {
            name: "customer_name",
            label: "Customer Name",
            cell: "string",
            editable: "false"
        }, {
            name: "store_name",
            label: "Store",
            cell: "string",
            editable: "false"
        }, {
            name: "product_id",
            label: "Product ID",
            cell: "integer",
            editable: "false"
        }, {
            name: "product",
            label: "Product",
            cell: "string",
            editable: "false"
        }, {
            name: "color",
            label: "Color",
            cell: "string",
            editable: "false"
        }, {
            name: "quantity",
            label: "Quantity",
            cell: "integer",
            editable: "false"
        }, {
            name: "date",
            label: "Date",
            cell: "date",
            editable: "false"
        }, {
            name: "imei",
            label: "IMEI",
            cell: "string",
            editable: "false"
        }, ];
        initiateGrid("sales-table", salesColumns, "salesController");

        //THE TRANSFERS TABLE
        var transferColumns = [{
            name: "transfer_id",
            label: "Transfer ID",
            cell: "integer",
            editable: "false"
        }, {
            name: "product_id",
            label: "Product ID",
            cell: "integer",
            editable: "false"
        }, {
            name: "product",
            label: "Product",
            cell: "string",
            editable: "false"
        }, {
            name: "from_store_name",
            label: "From Store",
            cell: "string",
            editable: "false"
        }, {
            name: "to_store_name",
            label: "To Store",
            cell: "string",
            editable: "false"
        }, {
            name: "quantity",
            label: "Quantity",
            cell: "integer"
        }, {
            name: "date",
            label: "Date",
            cell: "date",
            editable: "false"
        }, ];
        initiateGrid("transfers-table", transferColumns, "transfersController");

        //THE PRODUCTS TABLE
        var productColumns = [{
            name: "product_id",
            label: "Product ID",
            cell: "integer",
            editable: "false",
            editable: "false"
        }, {
            name: "product",
            label: "Product",
            cell: "string",
            editable: "false"
        }, {
            name: "color",
            label: "Color",
            cell: "string",
            editable: "false"
        }, {
            name: "cost_price",
            label: "Cost Price",
            cell: "number",
            editable: "false"
        }, {
            name: "selling_price",
            label: "Selling Price",
            cell: "number",
            editable: "false"
        }];
        initiateGrid("products-table", productColumns, "productsController");

        //THE Stores TABLE
        var storeColumns = [{
            name: "store_id",
            label: "ID",
            cell: "string",
            editable: "false"
        }, {
            name: "store_name",
            label: "Name",
            cell: "string",
            editable: "false"
        }, {
            name: "store_address",
            label: "Address",
            cell: "string",
            editable: "false"
        }, {
            name: "store_contact_number",
            label: "Contact Number",
            cell: "string",
            editable: "false"
        }];
        initiateGrid("stores-table", storeColumns, "storesController");
    });

});
