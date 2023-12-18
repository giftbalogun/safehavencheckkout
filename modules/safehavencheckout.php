<?php
/**
 * ****************************************************************** **\
 *                                                                      *
 *   Safe Haven Checkout                                                *
 *   Version: 1.0.0                                                     *
 *   Build Date: 17 Decemmber 2023                                      *
 *                                                                      *
 * **********************************************************************
 *                                                                      *
 *   Email: hello@safehavenmfb.com                                      *
 *   Website: https://safehavenmfb.com                                  *
 *                                                                      *
\
************************************************************************/

/**
 * Define Safe Haven gateway configuration options.
 *
 * @return array
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function safehavencheckout_config()
{   
    return array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'SafeHaven Checkout'
        ),
        'testMode' => array(
            'FriendlyName' => 'Test Mode',
            'Type' => 'yesno',
            'Description' => 'Tick to enable test mode',
            'Default' => '0'
        ),
        'liveauthtoken' => array(
            'FriendlyName' => 'Client Auth Token',
            'Type' => 'text',
            'Description' => 'Safe Haven Generated Auth Token',
            'Default' => ''
        ),
        'liveaccountno' => array(
            'FriendlyName' => 'Account Number',
            'Type' => 'text',
            'Size' => '10',
            'Default' => ''
        ),
        'testauthtoken' => array(
            'FriendlyName' => 'Client Auth Token',
            'Type' => 'text',
            'Description' => 'Safe Haven Generated Auth Token',
            'Default' => ''
        ),
        'testaccountno' => array(
            'FriendlyName' => 'Account Number',
            'Type' => 'text',
            'Size' => '10',
            'Default' => ''
        ),
    );
}

function safehavencheckout_link($params) {
    // Client
    $email = $params['clientdetails']['email'];
    $phone = $params['clientdetails']['phonenumber'];
    $params['langpaynow'] 
        = array_key_exists('langpaynow', $params) ? 
            $params['langpaynow'] : 'Pay with ATM' ;

    // Config Options
    if ($params['testMode'] == 'on') {
        $clienttoken = $params['testauthtoken'];
        $accountno = $params['testaccountno'];
    } else {
        $clienttoken = $params['liveauthtoken'];
        $accountno = $params['liveaccountno'];
    }
    
    $invoiceid = $params['invoiceid'];
    $amount = $params['amount'];
    $currency = $params['currency'];

    $txnref         = $invoiceid . '_' .time();

    if (!in_array(strtoupper($currency), [ 'NGN'])) {
        return ("<b style='color:red;margin:2px;padding:2px;border:1px dotted;display: block;border-radius: 10px;font-size: 13px;'>Sorry, this version of the Safe Haven WHMCS plugin only accepts NGN payments. <i>$currency</i> not yet supported.</b>");
    }

    $redirectUrl = $params['systemurl'].'/modules/gateways/callback/safehavencheckout.php';

    $htmlOutput = <<<HTML
    <!-- <form method="post" action="{$redirectUrl}">

        <button type="button" onclick="payWithSafeHaven()">Pay with SafeHaven</button>
    </form> -->

    <script src="https://checkout.safehavenmfb.com/assets/checkout.min.js"></script>
    <script type="text/javascript">
        // let payWithSafeHaven = () => {
            // Get values from the input fields
            let authToken = document.getElementById('authToken').value;
            let accountNumber = document.getElementById('accountNumber').value;

            let checkOut = SafeHavenCheckout({
                environment: "production",
                clientId: \''.addslashes(trim($clienttoken)).'\',,
                referenceCode: $txnref,
                customer: {
                    firstName: "{$params['clientdetails']['firstname']}",
                    lastName: "{$params['clientdetails']['lastname']}",
                    emailAddress: "{$params['clientdetails']['email']}",
                    phoneNumber: "{$params['clientdetails']['phonenumber']}"
                },
                currency: "{$currency}",
                amount: {$amount},
                settlementAccount: {
                    bankCode: "090286",
                    accountNumber: accountNumber
                },
                redirectUrl: "{$redirectUrl}",
                authToken: authToken
            });
        // }
    </script>
    HTML;

    return $htmlOutput;
}