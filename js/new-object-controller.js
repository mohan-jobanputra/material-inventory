billingApp.controller('newObjectController', function() {

    this.cards = [{
        index: 1,
        header: "New Purchase",
        formInfo: {
            name: "purchaseForm",
            action: "php/gateway.php?sender=purchasesController&action=create",
            id: "purchaseForm",
        },
        inputsInfo: [
        {
            icon: "store_name",
            placeholder: "Store Name",
            search_key: "stores",
            name: "store-name",
            template: "input-store.html",
            search_key: "stores",
            autocomplete: true
        }, {
            icon: "product_name",
            placeholder: "Product",
            name: "product-name",
            search_key: "products",
            template: "input-product.html",
            autocomplete: true
        }, {
            icon: "color",
            placeholder: "Color",
            search_key: "colors",
            name: "product-color",
            autocomplete: true
        }, {
            icon: "quantity",
            type: "number",
            placeholder: "Quantity",
            name: "quantity",
            autocomplete: false
        }, {
            icon: "date",
            type: "date",
            placeholder: "Date",
            name: "date",
            autocomplete: false
        }, {
            icon: "cost_price",
            type: "number",
            placeholder: "Rate",
            name: "rate",
            autocomplete: false
        }]
    }, {
        index: 2,
        header: "New Sale",
        formInfo: {
            name: "saleForm",
            action: "php/gateway.php?sender=salesController&action=create",
            id: "saleForm",
        },
        inputsInfo: [{
            icon: "person",
            type: "text",
            placeholder: "Customer Name",
            name: "customer-name",
            autocomplete: false
        }, {
            icon: "store_name",
            placeholder: "Store Name",
            search_key: "stores",
            name: "store-name",
            template: "input-store.html",
            search_key: "stores",
            autocomplete: true
        }, {
            icon: "product_name",
            type: "text",
            placeholder: "Product",
            search_key: "products",
            name: "product-name",
            autocomplete: true
        }, {
            icon: "color",
            type: "text",
            placeholder: "Color",
            search_key: "colors",
            name: "product-color",
            autocomplete: true
        }, {
            icon: "quantity",
            type: "number",
            placeholder: "Quantity",
            name: "quantity",
            autocomplete: false
        }, {
            icon: "date",
            type: "date",
            placeholder: "Date",
            name: "date",
            autocomplete: false
        }, {
            icon: "imei",
            type: "integer",
            placeholder: "IMEI",
            name: "imei",
            autocomplete: false
        }, {
            icon: "selling_price",
            type: "number",
            placeholder: "Rate",
            name: "rate",
            autocomplete: false
        }]
    }, {
        index: 3,
        header: "New Transfer",
        formInfo: {
            name: "transferForm",
            action: "php/gateway.php?sender=transfersController&action=create",
            id: "transferForm",
        },
        inputsInfo: [{
            icon: "product_name",
            type: "text",
            placeholder: "Product Name",
            search_key: "products",
            name: "product-name",
            autocomplete: true
        }, {
            icon: "color",
            type: "text",
            placeholder: "Color",
            search_key: "colors",
            name: "product-color",
            autocomplete: true
        }, {
            icon: "store_name",
            type: "text",
            placeholder: "From Store",
            search_key: "stores",
            name: "from-store",
            template: "input-store.html",
            autocomplete: true
        }, {
            icon: "store_name",
            type: "text",
            placeholder: "To Store",
            search_key: "stores",
            name: "to-store",
            template: "input-store.html",
            autocomplete: true
        }, {
            icon: "quantity",
            type: "number",
            placeholder: "Quantity",
            name: "quantity",
            autocomplete: false
        }, {
            icon: "date",
            type: "date",
            placeholder: "Date",
            name: "date",
            autocomplete: false
        }]
    }, {
        index: 4,
        header: "New Product",
        formInfo: {
            name: "productForm",
            action: "php/gateway.php?sender=productsController&action=create",
            id: "productForm",
        },
        inputsInfo: [{
            icon: "product_name",
            type: "text",
            placeholder: "Product Name",
            search_key: "products",
            name: "product-name",
            autocomplete: false
        }, {
            icon: "color",
            type: "text",
            placeholder: "Color",
            search_key: "colors",
            name: "product-color",
            autocomplete: true
        }, {
            icon: "selling_price",
            type: "currency",
            placeholder: "Optimal Selling Price",
            name: "optimal-selling-price",
            autocomplete: false
        }]
    }, {
        index: 5,
        header: "New Store",
        formInfo: {
            name: "storeForm",
            action: "php/gateway.php?sender=storesController&action=create",
            id: "storeForm",
        },
        inputsInfo: [{
            icon: "store_name",
            type: "text",
            placeholder: "Store Name",
            search_key: "stores",
            name: "store-name",
            autocomplete: false
        }, {
            icon: "phone",
            type: "text",
            placeholder: "Phone Number",
            name: "store-phone-number",
            autocomplete: false
        }, {
            icon: "place",
            type: "text",
            placeholder: "Location",
            name: "store-address",
            autocomplete: false
        }]
    }, ];
});
