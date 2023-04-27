<?php

use common\Badge;
use common\Country;
use common\Icon;
use state\OrderState;
use state\PaymentPlatform;
use state\ProductState;
use state\UserRole;
use state\UserState;

include ("class/common/Badge.php");
include ("class/common/Country.php");
include ("class/common/Icon.php");
include ("class/state/UserState.php");
include ("class/state/UserRole.php");
include ("class/state/OrderState.php");
include ("class/state/ProductState.php");
include ("class/state/PaymentPlatform.php");

$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);

function getUserStateList() : array {
    global $pdo;
    $stmt = $pdo->prepare("
        select * from user_state
    ");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $user_state = array();

    foreach ($result as $item) {
        $badge_info = json_decode($item["badge"], True);
        $user_state[$item["id"]] = new UserState(
            $item["id"],
            $item["name"],
            new Badge(
                $badge_info["text"],
                $badge_info["style"],
                $badge_info["icon"]
            )
        );
    }

    return $user_state;
}

function getUserRoleList() : array {
    global $pdo;
    $stmt = $pdo->prepare("
            select * from user_role
    ");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $user_role = array();

    foreach ($result as $item) {
        $badge_info = json_decode($item["badge"], True);
        $user_role[$item["id"]] = new UserRole(
            $item["id"],
            $item["name"],
            new Badge(
                $badge_info["text"],
                $badge_info["style"],
                $badge_info["icon"]
            )
        );
    }

    return $user_role;
}

function getCountryList() : array {
    global $pdo;
    $stmt = $pdo->prepare("
            select * from address_country
    ");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $country = array();

    foreach ($result as $item) {
        $country[$item["code"]] = new Country(
            $item["code"],
            $item["name"],
        );
    }
    return $country;
}

function getPaymentPlatformList() : array {
    global $pdo;
    $stmt = $pdo->prepare("
            select * from payment_platform
    ");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $payment_platform = array();

    foreach ($result as $item) {
        $icon_info = json_decode($item["icon"], True);
        $payment_platform[$item["id"]] = new PaymentPlatform(
            $item["id"],
            $item["name"],
            $item["type"],
            new Icon(
                $icon_info["icon"],
                $icon_info["color"]
            )
        );
    }
    return $payment_platform;
}

function getOrderStateList() : array {
    global $pdo;
    $stmt = $pdo->prepare("
            select * from order_state
    ");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $order_state = array();

    foreach ($result as $item) {
        $badge_info = json_decode($item["badge"], True);
        $order_state[$item["id"]] = new OrderState(
            $item["id"],
            $item["name"],
            new Badge(
                $badge_info["text"],
                $badge_info["style"],
                $badge_info["icon"]
            )
        );
    }
    return $order_state;
}

function getProductStateList() : array {
    global $pdo;
    $stmt = $pdo->prepare("
            select * from product_state
    ");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $product_state = array();

    foreach ($result as $item) {
        $badge_info = json_decode($item["badge"], True);
        $product_state[$item["id"]] = new ProductState(
            $item["id"],
            $item["name"],
            new Badge(
                $badge_info["text"],
                $badge_info["style"],
                $badge_info["icon"]
            )
        );
    }

    return $product_state;
}