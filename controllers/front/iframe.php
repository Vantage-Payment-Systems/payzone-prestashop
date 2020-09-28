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

require_once dirname(__FILE__) . '/../../lib/Connect2PayClient.php';

/**
 *
 * @since 1.5.0
 */
class PayzoneIframeModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;

    /**
     *
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();
        $this->context->controller->addCSS(($this->module->getPath()) . 'views/css/iframe.css', 'all');
        $cart = $this->context->cart;

        $params = array();

        // These should be filled only with Prestashop >= 1.7
        $paymentType = Tools::getValue('payment_type', null);
        $paymentProvider = Tools::getValue('payment_provider', null);

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            if ($paymentType !== null && Payzone\Connect2Pay\C2PValidate::isPayment($paymentType)) {
                $payment = $this->module->getPaymentClient($cart, $paymentType, $paymentProvider);

                if ($payment->preparePayment() == false) {
                    $message = "Payzone : can't prepare transaction - " . $payment->getClientErrorMessage();
                    $this->module->addLog($message, 3);
                    Tools::redirect($this->module->getPageLinkCompat('order', true, null, "step=3"));
                }

                $src = $payment->getCustomerRedirectURL();
            }
        }

        $this->context->smarty->assign(
            array(/* */
                'src' => $src, /* */
                'this_link_back' => $this->module->getPageLinkCompat('order', true, null, "step=3")
            ) /* */
        );

        $this->setTemplate('module:payzone/views/templates/hook/iframe.tpl');
    }
}
