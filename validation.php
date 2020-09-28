<?php
/**
 * Copyright 2013-2018 Payzone
 *
 *   Licensed under the Apache License, Version 2.0 (the "License");
 *   you may not use this file except in compliance with the License.
 *   You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing, software
 *   distributed under the License is distributed on an "AS IS" BASIS,
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *   See the License for the specific language governing permissions and
 *   limitations under the License.
 *
 *  @author    Regis Vidal
 *  @copyright 2013-2018 Payzone
 *  @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0 (the "License")
 */

/* Used for Prestashop < 1.5 */

/* SSL Management */
$useSSL = true;

require_once(dirname(__FILE__) . '/../../config/config.inc.php');
require_once(dirname(__FILE__) . '/../../init.php');
require_once(dirname(__FILE__) . '/payzone.php');
require_once(dirname(__FILE__) . '/lib/Connect2PayClient.php');

$payzone = new Payzone();

// init api
$c2pClient = new Payzone\Connect2Pay\Connect2PayClient(
    $payzone->getPayzoneUrl(),
    Configuration::get('PAYZONE_ORIGINATOR'),
    html_entity_decode(Configuration::get('PAYZONE_PASSWORD'))
);

if ($c2pClient->handleCallbackStatus()) {
    $status = $c2pClient->getStatus();

    // get the Error code
    $errorCode = $status->getErrorCode();
    $errorMessage = $status->getErrorMessage();

    $transaction = $status->getLastTransactionAttempt();

    if ($transaction !== null) {
        $transactionId = $transaction->getTransactionID();

        $orderId = $status->getOrderID();
        $amount = number_format($status->getAmount() / 100, 2, '.', '');
		$amount = (float) $_GET['a'];
        $callbackData = $status->getCtrlCustomData();

        $message = "Payzone payment module: ";

        // load the customer cart and perform some checks
        $cart = new Cart((int) ($orderId));
        if (!$cart->id) {
            $message .= "Cart is empty: " . $orderId;
            error_log($message);
        }

        $responseStatus = "KO";
        $responseMessage = "Callback validation failed";
        $customer = new Customer((int) ($cart->id_customer));

        if (!$customer) {
            $message .= "Customer is empty for order " . $orderId;
            error_log($message);
        } else {
            if (!Payzone::checkCallbackAuthenticityData($callbackData, $cart->id, $customer->secure_key)) {
                $message .= "Invalid callback received for order " . $orderId . ". Validation failed.";
                error_log($message);
            } else {
                $responseStatus = "OK";
                $responseMessage = "Status recorded";

                $message .= "Error code: " . $errorCode . "<br />";
                $message .= "Error message: " . $errorMessage . "<br />";
                $message .= "Transaction ID: " . $transactionId . "<br />";
                $message .= "Order ID: " . $orderId . "<br />";

                error_log(str_replace("<br />", " ", $message));

                $paymentMean = $payzone->l('Credit Card') . ' (Payzone)';

                switch ($errorCode) {
                    case "000":
                        /* Payment OK */
                        $payzone->validateOrder((int) $orderId, _PS_OS_PAYMENT_, $amount, $paymentMean, $message);
                        break;
                    default:
                        $payzone->validateOrder((int) $orderId, _PS_OS_ERROR_, $amount, $paymentMean, $message);
                        break;
                }
            }
        }
    }

    // Send a response to mark this transaction as notified
    $response = array("status" => $responseStatus, "message" => $responseMessage);
    header("Content-type: application/json");
    echo json_encode($response);
}
