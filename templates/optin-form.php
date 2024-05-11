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

    <input type="submit" value="<?php _e( 'Subscribe', 'leadpress' ); ?>">
</form>