billingApp.controller('newObjectController', function() {

    var self = this;

    /*
     *  THE VARIABLES
     */

    self.cards = [{
        index: 1,
        header: "New Purchase",
        formInfo: {
            name: "purchaseForm",
            action: "php/gateway.php?sender=purchasesController&action=create",
        },
        inputsInfo: [{
            icon: "product_name",
            type: "text",
            placeholder: "Product",
            name: "product-name"
        }, {
            icon: "color",
            type: "text",
            placeholder: "Color",
            name: "product-color"
        }, {
            icon: "quantity",
            type: "number",
            placeholder: "Quantity",
            name: "quantity"
        }, {
            icon: "date",
            type: "date",
            placeholder: "Date",
            name: "date"
        }]
    }, {
        index: 2,
        header: "New Sale",
        formInfo: {
            name: "saleForm",
            action: "php/gateway.php?sender=salesController&action=create",
        },
        inputsInfo: [{
            icon: "person",
            type: "text",
            placeholder: "Customer, Name",
            name: "customer-name"
        }, {
            icon: "store_name",
            type: "text",
            placeholder: "Store, Name",
            name: "store-name"
        }, {
            icon: "product_name",
            type: "text",
            placeholder: "Product",
            name: "product-name"
        }, {
            icon: "color",
            type: "text",
            placeholder: "Color",
            name: "product-color"
        }, {
            icon: "quantity",
            type: "number",
            placeholder: "Quantity",
            name: "quantity"
        }, {
            icon: "date",
            type: "date",
            placeholder: "Date",
            name: "date"
        }, {
            icon: "imei",
            type: "integer",
            placeholder: "IMEI",
            name: "imei"
        }]
    }, {
        index: 3,
        header: "New Transfer",
        formInfo: {
            name: "transferForm",
            action: "php/gateway.php?sender=transfersController&action=create",
        },
        inputsInfo: [{
            icon: "product_name",
            type: "text",
            placeholder: "Product Name",
            name: "product-name"
        }, {
            icon: "color",
            type: "text",
            placeholder: "Color",
            name: "product-color"
        }, {
            icon: "store_name",
            type: "text",
            placeholder: "From, Store",
            name: "from-store"
        }, {
            icon: "store_name",
            type: "text",
            placeholder: "To, Store",
            name: "to-store"
        }, {
            icon: "quantity",
            type: "number",
            placeholder: "Quantity",
            name: "quantity"
        }, {
            icon: "date",
            type: "date",
            placeholder: "Date",
            name: "date"
        }]
    }, {
        index: 4,
        header: "New Product",
        formInfo: {
            name: "productForm",
            action: "php/gateway.php?sender=productsController&action=create",
        },
        inputsInfo: [{
            icon: "product_name",
            type: "text",
            placeholder: "Product Name",
            name: "product-name"
        }, {
            icon: "color",
            type: "text",
            placeholder: "Color",
            name: "product-color"
        }, {
            icon: "cost_price",
            type: "number",
            placeholder: "Cost, Price",
            name: "cost-price"
        }, {
            icon: "selling_price",
            type: "number",
            placeholder: "Selling, Price",
            name: "selling-price"
        }]
    }, {
        index: 5,
        header: "New Store",
        formInfo: {
            name: "storeForm",
            action: "php/gateway.php?sender=storesController&action=create",
        },
        inputsInfo: [{
            icon: "store_name",
            type: "text",
            placeholder: "Store, Name",
            name: "store-name"
        }, {
            icon: "phone",
            type: "text",
            placeholder: "Phone, Number",
            name: "store-phone-number"
        }, {
            icon: "place",
            type: "text",
            placeholder: "Location",
            name: "store-address"
        }]
    }, ];
});
