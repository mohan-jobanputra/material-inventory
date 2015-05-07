<?php

require_once("sale_manager.php");
require_once("purchase_manager.php");
require_once("product_manager.php");
require_once("transfer_manager.php");
require_once("store_manager.php");
require_once("stock_manager.php");

header("Cache-Control: no-cache,no-store");

//
//      SALES
//

if ($_GET["sender"] == "salesController") {
    $manager = new SaleManager();
    if ($_GET["action"] == "list") {
        $data = $manager->listSales();
        print($data);
    }

    if ($_GET["action"] == "delete") {
        $data = $manager->removeSale($_POST['sale-id']);
        print($data);
    }

    if ($_GET["action"] == "create") {
        $data = $manager->createSale($_POST['customer-name'], $_POST['store-name'], $_POST['product-name'], $_POST['product-color'], $_POST['quantity'], $_POST['date'], $_POST['imei']);
    }

    if ($_GET["action"] == "update") {
        $data = $manager->updateSale($_POST['customer-name'], $_POST['store-name'], $_POST['product-name'], $_POST['quantity'], $_POST['date'], $_POST['imei']);
    }
}

//
//      PURCHASES
//

if ($_GET["sender"] == "purchasesController") {
    $manager = new PurchaseManager();
    if ($_GET["action"] == "list") {
        $data = $manager->listPurchases();
        print($data);
    }

    if ($_GET["action"] == "delete") {
        $manager->removePurchase($_POST['purchase-id']);
    }

    if ($_GET["action"] == "create") {
        $manager->createPurchase($_POST['store-name'], $_POST['product-name'], $_POST['product-color'], $_POST['quantity'], $_POST['date']);
    }

    if ($_GET["action"] == "update") {
        $manager->updatePurchase($_POST['store-name'], $_POST['product-name'], $_POST['quantity'], $_POST['date']);
    }
}

//
//      TRANSFERS
//


if ($_GET["sender"] == "transfersController") {
    $manager = new TransferManager();
    if ($_GET["action"] == "list") {
        $data = $manager->listTransfers();
        print($data);
    }

    if ($_GET["action"] == "delete") {
        $manager->removeTransfer($_POST['transfer_id']);
    }

    if ($_GET["action"] == "create") {
        $manager->createTransfer($_POST['product-name'], $_POST['product-color'], $_POST['from-store'], $_POST['to-store'], $_POST['quantity'], $_POST['date']);
    }

    if ($_GET["action"] == "update") {
        $dump = json_decode(file_get_contents('php://input'));
        $transfer_info = array();
        foreach ($dump as $key => $value) {
            $transfer_info[$key] = $value;
        }
        $manager->updateTransfer($transfer_info['transfer_id'], $transfer_info['product_id'], $transfer_info['from_store_id'], $transfer_info['to_store_id'], $transfer_info['quantity'], $transfer_info['date']);
    }
}

//
//      PRODUCTS
//

if ($_GET["sender"] == "productsController") {
    $manager = new ProductManager();
    if ($_GET["action"] == "list") {
        $data = $manager->listProducts();
        print($data);
    }

    if ($_GET["action"] == "delete") {
        $manager->removeProduct($_POST['product-id']);
    }

    if ($_GET["action"] == "create") {
        $manager->createProduct($_POST['product-name'], $_POST['product-color'], $_POST['cost-price'], $_POST['selling-price']);
    }

    if ($_GET["action"] == "update") {
        $manager->updateProduct($_POST['product-id'], $_POST['product-name'], $_POST['product-color'], $_POST['cost-price'], $_POST['selling-price']);
    }
}

//
//      STORES
//


if ($_GET["sender"] == "storesController") {
    $manager = new StoreManager();
    if ($_GET["action"] == "list") {
        $data = $manager->listStores();
        print($data);
    }

    if ($_GET["action"] == "delete") {
        $manager->removeStore($_POST['store-id']);
    }

    if ($_GET["action"] == "create") {
        $manager->createStore($_POST['store-name'], $_POST['store-phone-number'], $_POST['store-address']);
    }

    if ($_GET["action"] == "update") {
        $manager->updateStore($_POST['store-id'], $_POST['store-name'], $_POST['store-phone-number'], $_POST['store-address']);
    }
}

//
//      AUTOCOMPLETE
//

if ($_GET["sender"] == "autocompleteController") {
    if ($_GET["info"] == "stocks") {
        $manager = new StockManager();
        if ($_GET["action"] == "suggest") {
            $data = $manager->listStock();
            print($data);
        }
    }
    if ($_GET["info"] == "products") {
        $manager = new ProductManager();
        if ($_GET["action"] == "suggest") {
            $data = $manager->listStock();
            print($data);
        }
    }
}

?>