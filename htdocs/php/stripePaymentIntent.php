<HTML>
<?php
  require_once '/var/secrets/stripeTestKey.php';
  require_once('vendor/autoload.php');
  
 	\Stripe\Stripe::setApiKey($key);

	$intent = \Stripe\PaymentIntent::create([
	  "amount" => 100,
	  "currency" => "eur",
	  "allowed_source_types" => ["card"],
	]);
?>

<head>
	<script src="https://js.stripe.com/v3/"></script>
	<style>
		.container {
			width:400px;
		}
	</style>
</head>

<body>
	<div class=container>
		CardHolder Name: <input id="cardholder-name" type="text"> <br><br>
		<div id="card-element" style="border-size:solid; border-size:1px"></div><br><br>
		<button id="card-button" data-secret="<?= $intent->client_secret ?>">
		  Submit Payment
		</button>
	</div>

	<script> 
		var stripe = Stripe('pk_test_bC4fwLOsJOPNerzh2wQz8KGN', {
		  betas: ['payment_intent_beta_3']
		});

		var elements = stripe.elements();
		var cardElement = elements.create('card');
		cardElement.mount('#card-element');

		var cardholderName = document.getElementById('cardholder-name');
		var cardButton = document.getElementById('card-button');
		var clientSecret = cardButton.dataset.secret;

		cardButton.addEventListener('click', function(ev) {
		  stripe.handleCardPayment(
		    clientSecret, cardElement, {
		      source_data: {
		        owner: {name: cardholderName.value}
		      }
		    }
		  ).then(function(result) {
		    if (result.error) {
		      alert("Payment failed");
		    } else {
		      alert("Payment successful");
		    }
		  });
		});
	</script>
</body>

</HTML>