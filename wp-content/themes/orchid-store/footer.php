<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Orchid_Store
 */

?>
	</div><!-- #content.site-title -->

	<footer class="footer secondary-widget-area">
		<div class="footer-inner">
			<div class="footer-mask">
				<div class="__os-container__">
					<div class="footer-entry">
						<?php
						if ( orchid_store_get_option( 'display_footer_widget_area' ) ) {

							$orchid_store_footer_widget_area_no = orchid_store_get_option( 'footer_widgets_area_columns' );
							?>
							<div class="footer-top columns-<?php echo esc_attr( $orchid_store_footer_widget_area_no ); ?>">
								<div class="row">
									<?php
									if ( ! empty( $orchid_store_footer_widget_area_no ) ) {

										for ( $orchid_store_count = 1; $orchid_store_count <= $orchid_store_footer_widget_area_no; $orchid_store_count++ ) {
											$orchid_store_sidebar_id = 'footer-' . $orchid_store_count;
											?>
											<div class="os-col column">
												<?php
												if ( is_active_sidebar( $orchid_store_sidebar_id ) ) {
													dynamic_sidebar( $orchid_store_sidebar_id );
												}
												?>
											</div><!-- .col -->
											<?php
										}
									}
									?>
								</div><!-- .row -->
							</div><!-- .footer-top -->
							<?php
						}
						?>
						<div class="footer-bottom">
							<div class="os-row">
								<div class="os-col copyrights-col">
									<?php
									/**
									 * Hook - orchid_store_footer_left.
									 *
									 * @hooked orchid_store_footer_left_action - 10
									 */
									do_action( 'orchid_store_footer_left' );
									?>
								</div><!-- .os-col -->
								<div class="os-col">
									<?php
									/**
									 * Hook - orchid_store_footer_right.
									 *
									 * @hooked orchid_store_footer_right_action - 10
									 */
									do_action( 'orchid_store_footer_right' );
									?>
								</div><!-- .os-col -->
							</div><!-- .os-row -->
						</div><!-- .footer-bottom -->
					</div><!-- .footer-entry -->
				</div><!-- .__os-container__ -->
			</div><!-- .footer-mask -->
		</div><!-- .footer-inner -->
	</footer><!-- .footer -->

	<?php
	if ( orchid_store_get_option( 'display_scroll_top_button' ) ) {
		?>
		<div class="orchid-backtotop">
			<span>
				<i class="bx bx-chevron-up"></i>
			</span>
		</div>
		<?php
	}
	?>

</div><!-- .__os-page-wrap__ -->
<!-- Quick View Modal -->
<div class="quick-viewi-2"  id="quick-view-modal" >
    <div class="quick-viewi">
        <span id="close-modal" style="cursor:pointer; float:right;">&times;</span>
        <h2 id="modal-product-name"></h2>
        <div id="modal-product-image"></div>
        <p id="modal-product-price"></p>
        <p id="modal-product-description"></p>
        <a id="whatsapp-button" href="#" class="button alt" style="background-color: #FD0405; color: white; padding: 10px 20px; border-radius: 5px;" target="_blank">Send on WhatsApp</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all quick view buttons
    const quickViewButtons = document.querySelectorAll('.open-popup');

    // Add click event for each button
    quickViewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');

            // Fetch product details using AJAX
            fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=get_product_details&product_id=' + productId)
                .then(response => response.json())
                .then(data => {
                    // Fill the modal with product details
                    document.getElementById('modal-product-name').innerText = data.name;
                    document.getElementById('modal-product-image').innerHTML = '<img src="' + data.image + '" alt="' + data.name + '" style="width:100%;"/>';
                    document.getElementById('modal-product-price').innerText = 'Price: ' + data.price;
                    document.getElementById('modal-product-description').innerText = data.description;

                    // Create WhatsApp message
                    const whatsappMessage = encodeURIComponent(`Hello! I'm interested in the following product:\n\nProduct Name: ${data.name}\nPrice: ${data.price}\nURL: ${data.url}\nImage: ${data.image}`);
                    document.getElementById('whatsapp-button').href = 'https://api.whatsapp.com/send?text=' + whatsappMessage;

                    // Show the modal
                    document.getElementById('quick-view-modal').style.display = 'block';
                });
        });
    });

    // Close modal functionality
    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('quick-view-modal').style.display = 'none';
    });

    // Close modal on clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('quick-view-modal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});
</script>


<?php wp_footer(); ?>

</body>
</html>
