<?php
require_once '../../config.php';
?>

<html>
  <head>
  <title>Standard without iframe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
  
  <style type="text/css">
        /* Please include the min-width, max-width, min-height and max-height	 */
        /* if you plan to use a relative CSS unit measurement to make sure the */
        /* widget renders in the optimal size allowed.							           */

        #login_with_amazon_address_widget {min-width: 300px; max-width: 600px; min-height:
        228px; max-height: 400px;}
        #login_with_amazon_payment_widget {min-width: 300px; max-width:600px; min-height: 228px;
        max-height: 400px;}

        /* Smartphone and small window */
        #login_with_amazon_address_widget {width: 100%; height: 228px;}
        #login_with_amazon_payment_widget {width: 100%; height: 228px;}

        /* Desktop and tablet */
        @media only screen and (min-width: 768px) {
            #login_with_amazon_address_widget {width: 400px; height: 228px;}
            #login_with_amazon_payment_widget {width: 400px; height: 228px;}
        }
</style>
  </head>
<body>
    <div id="login_with_amazon_address_widget"></div>
    <div id="login_with_amazon_payment_widget"></div>
    <script>
      window.onAmazonLoginReady = function(){
        amazon.Login.setClientId("<?php echo $config['client_id']; ?>");	
      };
      window.onAmazonPaymentsReady = function() {
         renderAddressWidget();
      };
      
      var paymentRendered = false;
      var orderReferenceId;
      function renderAddressWidget(){
        new OffAmazonPayments.Widgets.AddressBook({
            sellerId: '<?php echo $config['merchant_id']?>',
            onOrderReferenceCreate: function(orderReference) {
              orderReferenceId = orderReference.getAmazonOrderReferenceId();
            },
            onAddressSelect: function(orderReference) {
              if(!paymentRendered){
                  renderPaymentWidget();
              }
			  document.getElementById("infoContainer").innerHTML += "address selected<br />";
            },
            design: {
              designMode: 'responsive'
            },
            onError: function(error) {
              console.log(error);
            }
          }).bind("login_with_amazon_address_widget");
      }
      
      
      function renderPaymentWidget(){
        new OffAmazonPayments.Widgets.Wallet({
            sellerId: '<?php echo $config['merchant_id']?>',
            onPaymentSelect: function(orderReference) {
              // Replace this code with the action that you want to perform
              // after the payment method is selected.
			  document.getElementById("infoContainer").innerHTML += "payment method selected<br />";
            },
            design: {
              designMode: 'responsive'
            },
            onError: function(error) {
              console.log(error);
            }
          }).bind("login_with_amazon_payment_widget");
          
          paymentRendered = true;
      }
	  
      
</script>
<script async='async' type='text/javascript' 
src='https://static-eu-beta.payments-amazon.com/OffAmazonPayments/uk/sandbox/lpa/js/Widgets.js'>
</script> 

<br />


	  <div id="infoContainer"></div>
  </body>
</html>