(function() {
  "use strict";

  var elements = stripe.elements({
    fonts: [
      {
        cssSrc: "https://rsms.me/inter/inter-ui.css"
      }
    ],
    // Stripe's examples are localized to specific languages, but if
    // you wish to have Elements automatically detect your user's locale,
    // use `locale: 'auto'` instead.
    locale: window.__exampleLocale
  });

  /**
   * Card Element
   */
  var card = elements.create("card", {
    style: {
      base: {
        color: "#32325D",
        fontWeight: 500,
        fontFamily: "Inter UI, Open Sans, Segoe UI, sans-serif",
        fontSize: "16px",
        fontSmoothing: "antialiased",

        "::placeholder": {
          color: "#CFD7DF"
        }
      },
      invalid: {
        color: "#E25950"
      }
    }
  });

  card.mount("#example4-card");

  /**
   * Payment Request Element
   */
  var paymentRequest = stripe.paymentRequest({
    country: "US",
    currency: "usd",
    total: {
      amount: 2000,
      label: "Total"
    },
    requestShipping: true
  });

  paymentRequest.on('shippingaddresschange', function(ev) {
    console.log(ev);
    var myShippingOptions = [
    // The first shipping option in this list appears as the default
    // option in the browser payment interface.
      {
        id: 'free-shipping',
        label: 'Free shipping',
        detail: 'Arrives in 5 to 7 days',
        amount: 0,
      },
      {
        id: 'costly-shipping',
        label: 'Costly shipping',
        detail: 'Arrives in 5 to 7 days',
        amount: 100,
      },
    ];

    if(ev.shippingAddress.country !== 'US') {
      ev.updateWith({status: 'invalid_shipping_address'});
    } 

    ev.updateWith({
        status: 'success',
        shippingOptions: myShippingOptions,
      });
  });

  paymentRequest.on('shippingoptionchange', function(ev) {
    console.log(ev);
    var myDisplayItems = [
      {
        label: 'Special Tax',
        detail: 'Arrives in 5 to 7 days',
        amount: 100,
      },
    ];

    var myTotal = {
        label: 'Merchant Name',
        amount: 2100,
      };

    var myNewShippingOptions = [
    // The first shipping option in this list appears as the default
    // option in the browser payment interface.
      {
        id: 'yo-dawg',
        label: 'Handle this bitch!',
        detail: 'Arrives in 5 to 7 days',
        amount: 10,
      },
    ];


    ev.updateWith({
        status: 'success',
        shippingOptions: myNewShippingOptions,
        displayItems: myDisplayItems,
        total:myTotal
      });
  });


  paymentRequest.on("token", function(result) {
    var example = document.querySelector(".example4");
    example.querySelector(".token").innerText = result.token.id;
    example.classList.add("submitted");
    result.complete("success");
  });

  var paymentRequestElement = elements.create("paymentRequestButton", {
    paymentRequest: paymentRequest,
    style: {
      paymentRequestButton: {
        type: "donate"
      }
    }
  });

  paymentRequest.canMakePayment().then(function(result) {
    if (result) {
      document.querySelector(".example4 .card-only").style.display = "none";
      document.querySelector(
        ".example4 .payment-request-available"
      ).style.display =
        "block";
      paymentRequestElement.mount("#example4-paymentRequest");
    }
  });

  registerElements([card, paymentRequestElement], "example4");
})();
