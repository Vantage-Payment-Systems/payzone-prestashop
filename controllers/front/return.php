<?php
/**
 * Copyright 2013-2018 PayXpert
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
 *  @copyright 2013-2018 PayXpert
 *  @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0 (the "License")
 */

/**
 *
 * @since 1.5.0
 *
 */
class PayzoneReturnModuleFrontController extends ModuleFrontController
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

        $url = $this->module->getPageLinkCompat('order-confirmation');

        $cart = $this->context->cart;
        $customer = new Customer((int) ($cart->id_customer));
        $ctrlURLPrefix = Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://';

        $url .= '?id_cart=' . (int)($cart->id) . '&id_module=' . (int)($this->module->id) . '&key=' . $customer->secure_key;

        $this->context->smarty->assign(
            array(/* */
                'url' => $url
            ) /* */
        );

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->setTemplate('module:' . $this->module->name . '/views/templates/front/payment_return.tpl');
        } else {
            $this->setTemplate('payment_return.tpl');
        }
    }
}
