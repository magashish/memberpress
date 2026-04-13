<?php
defined('ABSPATH') || exit;
?>

<?php if (MeprStripeGateway::stripe_connect_status($id) === 'connected') : ?>
    <?php
    $disconnect_url         = add_query_arg([
        'action'    => 'mepr_stripe_connect_disconnect',
        'method-id' => $id,
        '_wpnonce'  => wp_create_nonce('stripe-disconnect'),
    ], admin_url('admin-ajax.php'));
    $disconnect_confirm_msg = __('Disconnecting from this Stripe Account will block webhooks from being processed, and prevent MemberPress subscriptions associated with it from working.', 'memberpress');
    ?>
  <div id="stripe-connected-actions" class="mepr-payment-option-prompt connected">
    <?php if (empty($service_account_name)) : ?>
        <?php esc_html_e('Connected to Stripe', 'memberpress'); ?>
    <?php else : ?>
        <?php printf(
            // Translators: %1$s: opening strong tag, %2$s: service account name, %3$s: closing strong tag.
            esc_html__('Connected to: %1$s %2$s %3$s', 'memberpress'),
            '<strong>',
            esc_html($service_account_name),
            '</strong>'
        ); ?>
    <?php endif; ?>
    &nbsp;
    <a href="<?php echo esc_url($disconnect_url); ?>" class="stripe-btn mepr_stripe_disconnect_button button-secondary"
       data-disconnect-msg="<?php echo esc_attr($disconnect_confirm_msg); ?>">
      <?php esc_html_e('Disconnect', 'memberpress'); ?>
    </a>
  </div>
<?php else : ?>
  <div id="mepr-stripe-connect-migrate-prompt" class="mepr-payment-option-prompt">
    <div><img src="<?php echo esc_url(MEPR_IMAGES_URL . '/Stripe_with_Tagline.svg'); ?>" alt="Stripe logo"/></div>
    <p><?php esc_html_e('Enter your Stripe API keys below to connect your Stripe account.', 'memberpress'); ?></p>
    <p><?php
      printf(
        // Translators: %1$s opening anchor, %2$s closing anchor.
        esc_html__('You can find your API keys in the %1$sStripe Dashboard%2$s under Developers &rarr; API keys.', 'memberpress'),
        '<a href="https://dashboard.stripe.com/apikeys" target="_blank" rel="noopener noreferrer">',
        '</a>'
      );
    ?></p>
  </div>
<?php endif; ?>
