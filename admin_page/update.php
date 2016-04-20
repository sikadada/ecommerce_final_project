<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/27/16
 * Time: 1:30 AM
 */
require_once 'valid_session_handler.php';

require_once '../customer_view/Twig-1.x/lib/Twig/Autoloader.php';

require_once '../model/laptop.php';

require_once '../model/orders.php';

Twig_Autoloader::register();



$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$template =$twig->loadTemplate('update.html.twig');
$params = array();

$laptop = new laptop();
$orders = new order();

if(isset($_SESSION['message'])){
    $params['message'] = $_SESSION['message'];
}


if(isset($_REQUEST['fid'])){
    $fid = intval($_REQUEST['fid']);

    $result = $laptop->getDetailedLaptop($fid);
    $prod = $result->fetch_assoc();

    $params['prod'] = $prod;

}

//get orders
$result = $orders->getNumOrders();
$nOrders = $result->fetch_assoc();
$params['order_count'] = $nOrders['numOrders'];


//get sales
$result = $orders->getNumSales();
$nSales = $result->fetch_assoc();
$params['sales_count'] = $nOrders['numSales'];


//get oses
$result = $laptop->getOS();
$cat = $result->fetch_all(MYSQLI_ASSOC);
$params['os'] = $cat;


//brands
$result = $laptop->getBrands();
$brands = $result->fetch_all(MYSQLI_ASSOC);
$params['brands'] = $brands;

//processors
$result = $laptop->getProcessor();
$types = $result->fetch_all(MYSQLI_ASSOC);
$params['processor'] = $types;

//processors
$result = $laptop->getHardDrive();
$types = $result->fetch_all(MYSQLI_ASSOC);
$params['hard_drive'] = $types;

//display
$result = $laptop->getDisplay();
$types = $result->fetch_all(MYSQLI_ASSOC);
$params['display'] = $types;

//processors
$result = $laptop->getRam();
$types = $result->fetch_all(MYSQLI_ASSOC);
$params['ram'] = $types;

$params['currentPage'] = $_SERVER['PHP_SELF'];
//$_SERVER['HTTP_REFERER']);

$params['admin_username'] = $_SESSION['admin_username'];
$params['admin_id'] = $_SESSION['admin_id'];
$params['admin_firstname'] = $_SESSION['admin_firstname'];
$params['admin_lastname'] = $_SESSION['admin_lastname'];

$template->display($params);

