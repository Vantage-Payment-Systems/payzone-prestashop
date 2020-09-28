{*
* Copyright 2013-2018 payzone
*
*   Licensed under the Apache License, Version 2.0 (the "License");
*   you may not use this file except in compliance with the License.
*   You may obtain a copy of the License at
*
*       http://www.apache.org/licenses/LICENSE-2.0
*
*   Unless required by applicable law or agreed to in writing, software
*   distributed under the License is distributed on an "AS IS" BASIS,
*   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*   See the License for the specific language governing permissions and
*   limitations under the License. 
*   
*  @author Regis Vidal
*}
<form method="post">
    <fieldset>
        <legend><img src="../img/admin/contact.gif" />payzone - {l s='Settings' mod='payzone'}</legend>
        
        <div class="clean">&nbsp;</div>
        <label for="PAYZONE_ORIGINATOR">{l s='Originator ID' mod='payzone'}</label>
        <div class="margin-form">
            <input type="text" id="PAYZONE_ORIGINATOR" size="64" name="PAYZONE_ORIGINATOR" value="{$PAYZONE_ORIGINATOR|escape:'htmlall':'UTF-8'}" />
            <p>{l s='The identifier of your Originator' mod='payzone'}</p>
        </div>
        <div class="clean">&nbsp;</div>
        
        <label for="PAYZONE_PASSWORD">{l s='Originator password' mod='payzone'}</label>
        <div class="margin-form">
            <input type="password" id="PAYZONE_PASSWORD" size="64" name="PAYZONE_PASSWORD" />
            <p>{l s='The password associated with your Originator (leave empty to keep the current one)' mod='payzone'}</p>
        </div>
        <div class="clean">&nbsp;</div>
        
        <label for="PAYZONE_URL">{l s='Payment Gateway URL' mod='payzone'}</label>
        <div class="margin-form">
            <input type="text" id="PAYZONE_URL" size="64" name="PAYZONE_URL" value="{$PAYZONE_URL|escape:'htmlall':'UTF-8'}" />
            <p>{l s='Leave this field empty unless you have been given an URL"' mod='payzone'}</p>
        </div>
        <div class="clean">&nbsp;</div>
        
        <label for="PAYZONE_MERCHANT_NOTIF">{l s='Merchant notifications' mod='payzone'}</label>
        <div class="margin-form">
          <input type="checkbox" id="PAYZONE_MERCHANT_NOTIF" name="PAYZONE_MERCHANT_NOTIF"{if $PAYZONE_MERCHANT_NOTIF eq 'true'} checked="true"{/if} />
          <!--<input type="hidden" name="PAYZONE_MERCHANT_NOTIF" value="false" />-->
          <p>{l s='Whether or not to send a notification to the merchant for each processed payment' mod='payzone'}</p>
        </div>
        <div class="clean">&nbsp;</div>
        
        <label for="PAYZONE_MERCHANT_NOTIF_TO">{l s='Merchant notifications recipient' mod='payzone'}</label>
        <div class="margin-form">
            <input type="text" id="PAYZONE_MERCHANT_NOTIF_TO" size="64" name="PAYZONE_MERCHANT_NOTIF_TO" value="{$PAYZONE_MERCHANT_NOTIF_TO|escape:'htmlall':'UTF-8'}" />
            <p>{l s='Recipient email address for merchant notifications' mod='payzone'}</p>
        </div>
        <div class="clean">&nbsp;</div>
        
        <label for="PAYZONE_MERCHANT_NOTIF_LANG">{l s='Merchant notifications lang' mod='payzone'}</label>
        <div class="margin-form">
            <select id="PAYZONE_MERCHANT_NOTIF_LANG" size="1" name="PAYZONE_MERCHANT_NOTIF_LANG">
              <option value="en"{if $PAYZONE_MERCHANT_NOTIF_LANG eq 'en'} selected="selected"{/if}>{l s='English' mod='payzone'}</option>
              <option value="fr"{if $PAYZONE_MERCHANT_NOTIF_LANG eq 'fr'} selected="selected"{/if}>{l s='French' mod='payzone'}</option>
              <option value="es"{if $PAYZONE_MERCHANT_NOTIF_LANG eq 'es'} selected="selected"{/if}>{l s='Spanish' mod='payzone'}</option>
              <option value="it"{if $PAYZONE_MERCHANT_NOTIF_LANG eq 'it'} selected="selected"{/if}>{l s='Italian' mod='payzone'}</option>
            </select>
            <p>{l s='Language to use for merchant notifications' mod='payzone'}</p>
        </div>
        <div class="clean">&nbsp;</div>
		
		<label for="PAYZONE_CURRENCY_USED">{l s='theme' mod='payzone'}</label>
        <div class="margin-form">
            <select id="PAYZONE_CURRENCY_USED" size="1" name="PAYZONE_CURRENCY_USED">
              <option value="devise"{if $PAYZONE_CURRENCY_USED eq 'devise'} selected="selected"{/if}>{l s='Devise' mod='payzone'}</option>
              <option value="both"{if $PAYZONE_CURRENCY_USED eq 'both'} selected="selected"{/if}>{l s='MAD' mod='payzone'}</option>
             </select>
            <p>{l s='Currency used' mod='payzone'}</p>
        </div>
		
		<div class="clean">&nbsp;</div>
        
        <div class="margin-form">
          <input type="submit" name="btnSubmit" value="{l s='Update settings' mod='payzone'}" class="button" />
        </div>
        <div class="clean">&nbsp;</div>
    </fieldset>
</form>
<div class="clean">&nbsp;</div>
