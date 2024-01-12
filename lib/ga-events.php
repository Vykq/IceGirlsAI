<?php
function thankYouEvent( $order_id ) {
    ?>
	<script>
        gtag("event", "purchase", {
                currency: 'USD',
                value: 15,
                transaction_id: '<?php echo $order_id; ?>',
                items: [
                    {
                        item_name: 'Premium subscription',
                        item_id: '01',
                        price: 15,
                        quantity: 1,
                    },
                   ]
        });
    </script>
<?php }

function viewItemEvent() {
    ?>
    <script>

        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: 'view_item',
            ecommerce: {
                items: [{
                    item_name: 'Premium subscription',
                    item_id: '01',
                    price: '15',
                    quantity: '1'
                }]
            }
        });

    </script>
<?php }