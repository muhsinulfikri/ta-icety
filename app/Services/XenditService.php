<?php

namespace App\Services;

use Xendit\Configuration;
use Xendit\PaymentRequest\PaymentRequestApi;
use Xendit\Invoice\InvoiceApi;
use Xendit\PaymentMethod\PaymentMethodApi;

class XenditService
{
    public function __construct()
    {
        Configuration::setXenditKey('xnd_development_4ZELaL2sdqbdfMBH4FRlgMfqa8fdVXIzrDtiJXsm033h3OwZ2gm7mtSHrnnJOR');
        // Configuration::setXenditKey('xnd_production_HALDbZ0wkKNqsgeZw8cb04RxfwA3okR3lkpRZs9xRd6FtwntQUieg8vJLiCiU');
    }

    // public function createPaymentRequest($params)
    // {
    //     return PaymentRequestApi::createPaymentRequest($params);
    // }

    public function createInvoice($params)
    {
        $invoiceApi = new InvoiceApi();
        return $invoiceApi->createInvoice($params);
    }

    public function retrieveInvoice(string $invoice_id, string $for_user_id = null)
    {
        $invoiceApi = new InvoiceApi();
        return $invoiceApi->getInvoices($invoice_id, $for_user_id);
    }

    public function retrieveInvoiceById(string $invoice_id, string $for_user_id = null)
    {
        $invoiceApi = new InvoiceApi();
        return $invoiceApi->getInvoiceById($invoice_id, $for_user_id);
    }

    // public function createPaymentMethod($params)
    // {
    //     try {
    //         return PaymentMethodApi::createPaymentMethod($params);
    //     } catch (\Exception $e) {
    //         throw new \Exception('Error creating payment method: ' . $e->getMessage());
    //     }
    // }
}
