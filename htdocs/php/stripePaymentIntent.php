<?php
  require_once '/var/secrets/stripeTestKey.php';
  
  echo $key;
 // 	\Stripe\Stripe::setApiKey($key);

	// \Stripe\PaymentIntent::create([
	//   "amount" => 100,
	//   "currency" => "eur",
	//   "allowed_source_types" => ["card"],
	// ]);
?>

<HTML>

<body>
<!-- 	<input id="cardholder-name" type="text">
	<div id="card-element"></div>
	<button id="card-button" data-secret="<?= $intent->client_secret ?>">
	  Submit Payment
	</button> -->
</body>

</HTML>