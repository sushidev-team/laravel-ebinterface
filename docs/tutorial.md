# How to create an invoice

Create an xml for the invoice requires some steps:

```php

Config::set('ebinterface.payment', [
      'iban' => 'DE75512108001245126199',
      'bic' => 'GIBAATWWXXX',
      'owner' => 'AMBERSIVE KG'
]);

$invoiceHandler = new EbInterfaceInvoiceHandler();
$invoice = $invoiceHandler->create();

// Biller
$addressBiller = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT", "office@ambersive.com");

// Delivery
$addressDelivery = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT", "office@ambersive.com");
$contactDelivery = new EbInterfaceContact("Mr", "Manuel Pirker-XXX");

// Invoice reciepient
$addressInvoiceRecipient = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT", "office@ambersive.com");
$contact = new EbInterfaceContact("Mr", "Manuel Pirker-XXX");
$legal = new EbInterfaceCompanyLegal();
$reference = new EbInterfaceOrderReference("U37", now(), "test");

$invoice
    ->setInvoiceNumber("TEST1")
    ->setDelivery(function($invoice) use ($addressDelivery, contactDelivery) {
        return new EbInterfaceInvoiceDelivery(
            Carbon::now(),
            $addressDelivery->setEmail("office@ambersive.com"),
            $contactDelivery
        );
    })
    ->setBiller(function($invoice) use ($addressBiller, $contactBiller) {
        return new EbInterfaceInvoiceBiller(
            $addressBiller,
            $contactBiller
        );
    })
    ->setRecipient(function($invoice) use ($legal, $addressInvoiceRecipient, $reference, $contact){
        return new EbInterfaceInvoiceRecipient(
            $legal,
            $addressInvoiceRecipient,
            $reference,
            $contact
        );
    })
    ->setLines(function($invoice, $lines) use () {

        $lines->add(null, function($line){

            $line->setQuantity("STK", 100)
                 ->setUnitPrice(1)
                 ->setTax(new EbInterfaceTax("S", 0, $line->getLineAmount()));

        })->add(null, function($line){

            $line->setQuantity("STK", 10)
                 ->setUnitPrice(1)
                 ->setTax(new EbInterfaceTax("S", 0, $line->getLineAmount()));

        });

    })
    ->setPaymentMethod(function($paymentMethod){
        $paymentMethod->setAccount(new EbInterfacePaymentMethodBank());
    })
    ->setPaymentConditions(null, [
        new EbInterfaceDiscount(now()->addDays(2), 1),
        new EbInterfaceDiscount(now(), 2),
    ]);

// Create xml
$xml = $this->invoice->toXml();
```