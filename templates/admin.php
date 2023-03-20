<?php
    if (isset($_POST['email'])){
        if (!get_option( 'post_email_user' )){
            add_option( 'post_email_user', $_POST['email'] );
        }
        update_option( 'post_email_user', $_POST['email'] );
    }
?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post" action="">
        <div id="universal-message-container">
			<h2></h2>
			<div class="options">
				<p>
					<label>Receiver Email Id</label>
					<br />
					<input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="email address" required />
				</p>
		</div><!-- #universal-message-container -->
        <button class="btn btn-success" type="submit">Submit</button>
    </form>
</div><!-- .wrap -->