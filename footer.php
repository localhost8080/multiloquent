<?php
/**
 * Site footer
 *
 * @package multiloquent\template_parts
 */
?>
	</main><!-- #main-content -->

	<!-- ===== Site footer ===== -->
	<footer class="site-footer mt-auto" role="contentinfo">
		<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6 py-10">

			<?php if ( is_active_sidebar( 'footer-col-1' ) || is_active_sidebar( 'footer-col-2' ) ) : ?>
				<div class="grid gap-8 sm:grid-cols-2 mb-8">
					<?php if ( is_active_sidebar( 'footer-col-1' ) ) : ?>
						<div><?php dynamic_sidebar( 'footer-col-1' ); ?></div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-col-2' ) ) : ?>
						<div><?php dynamic_sidebar( 'footer-col-2' ); ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="border-t border-white/10 pt-6 flex flex-wrap items-center justify-between gap-3 text-sm text-[oklch(70%_0_0)]">
				<p>
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
					   class="hover:text-white transition-colors">
						<?php bloginfo( 'name' ); ?>
					</a>
				</p>

				<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
					<nav aria-label="<?php esc_attr_e( 'Footer Navigation', 'multiloquent' ); ?>">
						<?php wp_nav_menu( [
							'theme_location' => 'footer-menu',
							'depth'          => 1,
							'container'      => false,
							'menu_class'     => 'flex flex-wrap gap-4',
						] ); ?>
					</nav>
				<?php endif; ?>

				<p>
					<?php printf(
						/* translators: %s: WordPress link */
						esc_html__( 'Powered by %s', 'multiloquent' ),
						'<a href="https://wordpress.org" class="hover:text-white transition-colors">WordPress</a>'
					); ?>
				</p>
			</div>
		</div>
	</footer>

</div><!-- #page-wrapper -->

<?php wp_footer(); ?>
</body>
</html>
