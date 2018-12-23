<?php
	// Include the Square Connect API resources
	require_once(__DIR__ . '/vendor/autoload.php');

	$accessToken = 'sq0atp-VIZMHV7uZSuhyKIF7o6MFA';
	$locationId = '4G6PEANTEK6WM';
// Create and configure a new API client object
	$defaultApiConfig = new \SquareConnect\Configuration();
	$defaultApiConfig->setAccessToken($accessToken);
	$defaultApiClient = new \SquareConnect\ApiClient($defaultApiConfig);
	$checkoutClient = new SquareConnect\Api\CheckoutApi($defaultApiClient);

	//Create a Money object to represent the price of the line item.
	$price = new \SquareConnect\Model\Money;
	$price->setAmount(600);
	$price->setCurrency('USD');

	//Create the line item and set details
	$book = new \SquareConnect\Model\CreateOrderRequestLineItem;
	$book->setName('The Shining');
	$book->setQuantity('2');
	$book->setBasePriceMoney($price);

	//Puts our line item object in an array called lineItems.
	$lineItems = array();
	array_push($lineItems, $book);

	// Create an Order object using line items from above
	$order = new \SquareConnect\Model\CreateOrderRequest();

	$order->setIdempotencyKey(uniqid()); //uniqid() generates a random string.

	//sets the lineItems array in the order object
	$order->setLineItems($lineItems);

	$checkout = new \SquareConnect\Model\CreateCheckoutRequest();

	$checkout->setIdempotencyKey(uniqid()); //uniqid() generates a random string.
	$checkout->setOrder($order); //this is the order we created in the previous step

	try {
	    $result = $checkoutClient->createCheckout(
	      $locationId,
	      $checkout
	    );
    //Save the checkout ID for verifying transactions
	    $checkoutId = $result->getCheckout()->getId();
	    //Get the checkout URL that opens the checkout page.
	    $checkoutUrl = $result->getCheckout()->getCheckoutPageUrl();
    	// print_r('Complete your transaction: ' + $checkoutUrl);
    	// echo(json_encode($checkoutUrl));

    	header( 'Location:'. $checkoutUrl) ;
	} catch (Exception $e) {
    echo 'Exception when calling CheckoutApi->createCheckout: ', $e->getMessage(), PHP_EOL;
	}

?>