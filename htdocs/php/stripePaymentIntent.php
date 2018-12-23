<HTML>
<?php
  require_once '/var/secrets/stripeTestKey.php';
  
 	\Stripe\Stripe::setApiKey($key);

	$intent = \Stripe\PaymentIntent::create([
	  "amount" => 100,
	  "currency" => "eur",
	  "allowed_source_types" => ["card"],
	]);
	echo $intent->client_secret;
?>



<body>
	<input id="cardholder-name" type="text">
	<div id="card-element"></div>
	<button id="card-button" data-secret="<?= $intent->client_secret ?>">
	  Submit Payment
	</button>
</body>

</HTML>