<form id="leadpress-optin-form">
    <div class="leadpress-optin-form-inputs">
        <label for="leadpress-optin-name">
            <?php _e( 'Name', 'leadpress' ); ?>
            <input type="text" name="name" id="leadpress-optin-name" required>
        </label>
    
        <label for="leadpress-optin-email">
            <?php _e( 'Email', 'leadpress' ); ?>
            <input type="email" name="email" id="leadpress-optin-email" required>
        </label>
    </div>

    <button type="submit" id="leadpress-optin-submit">
        <?php _e( 'Subscribe', 'leadpress' ); ?>
    </button>
</form>

<div class="leadpress-optin-message hide">
    <h3><?php _e( 'Thank you for Subscribing', 'leadpress' ); ?></h3>
    <div class="leadpress-optin-message-icon">
        <img src="<?php echo esc_url( LEADPRESS_ASSET . '/img/check.png' ); ?>" alt="check">
    </div>
    <p><?php _e( 'You have been subscribed to our mailing list', 'leadpress' ); ?></p>
    <p><?php _e( 'You will receive an email shortly', 'leadpress' ); ?></p>
</div>