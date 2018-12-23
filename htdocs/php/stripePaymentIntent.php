<?php
  $intent = 'test' # ... Fetch or create the PaymentIntent;
?>

<HTML>

<body>
<!-- 	<input id="cardholder-name" type="text">
	<div id="card-element"></div>
	<button id="card-button" data-secret="<?= $intent->client_secret ?>">
	  Submit Payment
	</button> -->
	<div> <?=$intent?> </div>div>
</body>

</HTML>