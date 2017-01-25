<?php

require_once("sale_manager.php");
require_once("purchase_manager.php");
require_once("product_manager.php");
require_once("transfer_manager.php");
require_once("store_manager.php");
require_once("stock_manager.php");
require_once("authentication_manager.php");

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
        $data = $manager->createSale($_POST['customer-name'], $_POST['store-name'], $_POST['product-name'], $_POST['product-color'], $_POST['quantity'], $_POST['date'], $_POST['imei'], $_POST['rate']);
    }

    if ($_GET["action"] == "update") {
        $data = $manager->updateSale($_POST['customer-name'], $_POST['store-name'], $_POST['product-name'], $_POST['product-color'], $_POST['quantity'], $_POST['date'], $_POST['imei'], $_POST['rate']);
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
        $manager->createPurchase($_POST['store-name'], $_POST['product-name'], $_POST['product-color'], $_POST['quantity'], $_POST['date'], $_POST['rate']);
    }

    if ($_GET["action"] == "update") {
        $manager->updatePurchase($_POST['store-name'], $_POST['product-name'], $_POST['product-color'], $_POST['quantity'], $_POST['date'], $_POST['rate']);
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
        $manager->createProduct($_POST['product-name'], $_POST['product-color'], $_POST['optimal-selling-price']);
    }

    if ($_GET["action"] == "update") {
        $manager->updateProduct($_POST['product-id'], $_POST['product-name'], $_POST['product-color'], $_POST['optimal-selling-price']);
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
        $data = $manager->autocomplete();
        print($data);
    }
    if ($_GET["info"] == "products") {
        $manager = new ProductManager();
        $data = $manager->autocomplete();
        print($data);
    }
    if ($_GET["info"] == "stores") {
        $manager = new StoreManager();
        $data = $manager->autocomplete();
        print($data);
    }
    if ($_GET["info"] == "colors") {
        $manager = new StoreManager();
        $data = array(array("color" => "Red"), array("color" => "Yellow"), array("color" => "Blue"), array("color" => "Green"), array("color" => "Orange"), array("color" => "Pink"), array("color" => "Brown"), array("color" => "Black"), array("color" => "White"));
        print(json_encode($data));
    }
}

//
//      AUTHENTICATOR
//

if ($_GET["sender"] == "authenticationController") {
    if ($_GET["action"] == "login") {
        $manager = new AuthenticationManager();
        $request_body = file_get_contents('php://input');
        $req_data = json_decode($request_body);
        print($req_data);
        $data = $manager->authenticate($req_data['username'], $req_data['password']);
        print($data);
    }
}


?>