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

/**
 *
 * @since 1.5.0
 *
 */
class PayzoneRedirectModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     *
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        if (!isset($this->context->cart)) {
            $this->context->cart = new Cart();
        }

        $cart = $this->context->cart;

        // These should be filled only with Prestashop >= 1.7
        $paymentType = Tools::getValue('payment_type', null);
        $paymentProvider = Tools::getValue('payment_provider', null);

        $errorMessage = $this->module->redirect($cart, $paymentType, $paymentProvider);

        $this->display_column_left = false;
        parent::initContent();

        $this->context->smarty->assign(
            array(/* */
                'errorMessage' => $errorMessage, /* */
                'this_path' => $this->module->getPathUri(), /* */
                'this_path_ssl' => Configuration::get('PS_SSL_ENABLED') ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . 'modules/payzone/', /* */
                'this_link_back' => $this->module->getPageLinkCompat('order', true, null, "step=3") /* */
            ) /* */
        );

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->setTemplate('module:' . $this->module->name . '/views/templates/front/payment_error17.tpl');
        } else {
            $this->setTemplate('payment_error.tpl');
        }
    }
}
