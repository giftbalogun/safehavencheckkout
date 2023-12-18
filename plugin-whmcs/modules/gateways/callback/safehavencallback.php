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

// Retrieve parameters from the callback
$invoiceId = $_REQUEST['invoiceid'];
$transactionId = $_REQUEST['transactionid'];
$paymentStatus = $_REQUEST['paymentstatus'];

// Perform any necessary actions based on the payment status
if ($paymentStatus == 'completed') {
    // Payment was successful, mark the invoice as paid
    addInvoicePayment(
        $invoiceId,
        $transactionId,
        $_REQUEST['amount'],
        $_REQUEST['fee'],
        'safehavencheckout' // Replace with your payment gateway module name
    );
    logTransaction('safehavencheckout', 'Payment Successful', 'Transaction ID: ' . $transactionId, 'Success');
} else {
    // Payment failed, log the transaction
    logTransaction('safehavencheckout', 'Payment Failed', 'Transaction ID: ' . $transactionId, 'Failure');
}

// Redirect the user back to the WHMCS invoice view
$redirectUrl = "/viewinvoice.php?id=" . $invoiceId;
header("Location: " . $redirectUrl);
exit;
?>