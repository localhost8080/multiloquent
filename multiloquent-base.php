<?php

/**
 * Multiloquent theme core class
 *
 * @package multiloquent
 */

class MultiloquentBase
{

	public function __construct()
	{
		add_action('after_setup_theme', [$this, 'multiloquent_register']);
		add_action('init',              [$this, 'multiloquent_register_blocks']);
		add_action('admin_menu',        [$this, 'multiloquent_cookie_banner_admin_menu']);
		add_action('admin_init',        [$this, 'multiloquent_cookie_banner_register_settings']);
		add_action('init',              [$this, 'multiloquent_cookie_apply_default_consent']);
		add_action('wp_head',           [$this, 'multiloquent_cookie_scripts_output']);
		add_action('wp_footer',         [$this, 'multiloquent_cookie_banner_render']);
	}

	// -------------------------------------------------------------------------
	// Version
	// -------------------------------------------------------------------------

	public function multiloquent_version(): string
	{
		return '26.2.4';
	}

	// -------------------------------------------------------------------------
	// Theme setup
	// -------------------------------------------------------------------------

	public function multiloquent_register(): void
	{
		load_theme_textdomain('multiloquent', get_template_directory() . '/languages');

		// Core HTML5 support
		add_theme_support('html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		]);
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');

		// Post formats
		add_theme_support('post-formats', ['image', 'gallery', 'video', 'audio', 'quote', 'link']);

		// Block editor / FSE
		add_theme_support('align-wide');
		add_theme_support('wp-block-styles');
		add_theme_support('responsive-embeds');
		add_theme_support('editor-styles');
		add_theme_support('appearance-tools');
		add_theme_support('custom-spacing');
		add_theme_support('custom-line-height');
		add_theme_support('custom-units', 'px', 'em', 'rem', 'vw', 'vh', '%');
		add_theme_support('block-templates');

		// Editor stylesheet (Tailwind output injected into block editor)
		add_editor_style('assets/css/main.css');

		// Thumbnail sizes
		set_post_thumbnail_size(780, 400, true);
		add_image_size('multiloquent-hero',  1200, 480, true);
		add_image_size('multiloquent-card',  600,  340, true);
		add_image_size('multiloquent-thumb', 300,  200, true);

		global $content_width;
		if (! isset($content_width)) {
			$content_width = 1000;
		}

		// Hooks
		add_action('wp_enqueue_scripts', [$this, 'multiloquent_enqueue_assets']);
		add_action('customize_register',  [$this, 'multiloquent_customize_register']);
		add_action('widgets_init',        [$this, 'multiloquent_register_sidebars']);

		// Filters
		add_filter('the_content',          [$this, 'multiloquent_featured_image_in_feed']);
		add_filter('widget_tag_cloud_args', [$this, 'multiloquent_widget_tag_cloud_args']);
		add_filter('wp_tag_cloud',         [$this, 'multiloquent_tag_cloud_filter'], 10, 2);
		add_filter('get_avatar',           [$this, 'multiloquent_get_avatar']);
		add_filter('widget_text',          'do_shortcode');
		add_filter('nav_menu_css_class',   [$this, 'multiloquent_nav_menu_css_class'], 10, 2);

		$this->multiloquent_register_menus();
	}

	// -------------------------------------------------------------------------
	// Custom blocks
	// -------------------------------------------------------------------------

	public function multiloquent_register_blocks(): void
	{
		register_block_type(get_template_directory() . '/blocks/featured-slider');
		register_block_type(get_template_directory() . '/blocks/breadcrumbs');
		register_block_type(get_template_directory() . '/blocks/archive-loop');

		// "Inverted" button style — cream pill / dark-green text, for buttons
		// placed on a forest-green (or dark-green) section background, e.g.
		// the bundled CTA-band pattern.
		register_block_style('core/button', [
			'name'  => 'inverted',
			'label' => esc_html__('Inverted', 'multiloquent'),
		]);
	}

	// -------------------------------------------------------------------------
	// Asset enqueueing
	// -------------------------------------------------------------------------

	public function multiloquent_enqueue_assets(): void
	{
		$ver = $this->multiloquent_version();
		$uri = get_template_directory_uri();

		// Compiled Tailwind CSS (built from src/tailwind.css)
		wp_enqueue_style(
			'multiloquent-main',
			$uri . '/assets/css/main.css',
			[],
			$ver
		);

		// Vanilla JS for sidebar toggle, mobile nav, etc.
		wp_enqueue_script(
			'multiloquent-theme',
			$uri . '/assets/js/theme.js',
			[],
			$ver,
			['strategy' => 'defer', 'in_footer' => true]
		);

		// Cookie banner (only while enabled in Settings > Cookie Banner).
		if (get_option('multiloquent_cookie_banner_enabled', false)) {
			wp_enqueue_style(
				'multiloquent-cookie-banner',
				$uri . '/assets/css/cookie-banner.css',
				[],
				$ver
			);
			wp_enqueue_script(
				'multiloquent-cookie-banner',
				$uri . '/assets/js/cookie-banner.js',
				[],
				$ver,
				['strategy' => 'defer', 'in_footer' => true]
			);
			wp_localize_script('multiloquent-cookie-banner', 'multiloquentConsent', [
				'categories' => get_option('multiloquent_cookie_categories', $this->multiloquent_cookie_category_defaults()),
				'consentMap' => $this->multiloquent_cookie_category_consent_map(),
			]);
		}
	}

	// -------------------------------------------------------------------------
	// Menus
	// -------------------------------------------------------------------------

	public function multiloquent_register_menus(): void
	{
		register_nav_menus([
			'primary-menu' => esc_html__('Primary Menu', 'multiloquent'),
			'footer-menu'  => esc_html__('Footer Menu',  'multiloquent'),
		]);
	}

	public function multiloquent_nav_menu_css_class(array $classes, WP_Post $item): array
	{
		$classes = array_filter($classes, fn($c) => ! str_starts_with($c, 'nav-item'));
		return array_values($classes);
	}

	// -------------------------------------------------------------------------
	// Widget areas (sidebars)
	// -------------------------------------------------------------------------

	public function multiloquent_register_sidebars(): void
	{
		$defaults = [
			'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title text-base font-semibold mb-3 pb-1 border-b border-[var(--color-border)]">',
			'after_title'   => '</h3>',
		];

		register_sidebar(array_merge($defaults, [
			'id'          => 'sidebar-primary',
			'name'        => esc_html__('Primary Sidebar', 'multiloquent'),
			'description' => esc_html__('Main sidebar — search, navigation, recent posts.', 'multiloquent'),
		]));

		register_sidebar(array_merge($defaults, [
			'id'          => 'sidebar-top',
			'name'        => esc_html__('Sidebar Top', 'multiloquent'),
			'description' => esc_html__('Widget area above the main sidebar content.', 'multiloquent'),
		]));

		register_sidebar(array_merge($defaults, [
			'id'          => 'sidebar-bottom',
			'name'        => esc_html__('Sidebar Bottom', 'multiloquent'),
			'description' => esc_html__('Widget area below the main sidebar content.', 'multiloquent'),
		]));

		register_sidebar(array_merge($defaults, [
			'id'          => 'footer-col-1',
			'name'        => esc_html__('Footer Column 1', 'multiloquent'),
			'description' => esc_html__('First footer column.', 'multiloquent'),
		]));

		register_sidebar(array_merge($defaults, [
			'id'          => 'footer-col-2',
			'name'        => esc_html__('Footer Column 2', 'multiloquent'),
			'description' => esc_html__('Second footer column.', 'multiloquent'),
		]));
	}

	// -------------------------------------------------------------------------
	// Customizer
	// -------------------------------------------------------------------------

	public function multiloquent_customize_register(WP_Customize_Manager $wp_customize): void
	{
		$wp_customize->add_section('multiloquent_settings', [
			'title'    => esc_html__('Multiloquent Settings', 'multiloquent'),
			'priority' => 30,
		]);

		// Featured posts display style
		$wp_customize->add_setting('multiloquent_featured_style', [
			'default'           => 'tags',
			'transport'         => 'refresh',
			'sanitize_callback' => [$this, 'sanitize_featured_style'],
		]);
		$wp_customize->add_control('multiloquent_featured_style', [
			'label'   => esc_html__('Featured posts display style', 'multiloquent'),
			'section' => 'multiloquent_settings',
			'type'    => 'select',
			'choices' => [
				'tags'    => esc_html__('Tags', 'multiloquent'),
				'excerpt' => esc_html__('Excerpt', 'multiloquent'),
				'none'    => esc_html__('None', 'multiloquent'),
			],
		]);

		// Sidebar position
		$wp_customize->add_setting('multiloquent_sidebar_position', [
			'default'           => 'left',
			'transport'         => 'refresh',
			'sanitize_callback' => [$this, 'sanitize_sidebar_position'],
		]);
		$wp_customize->add_control('multiloquent_sidebar_position', [
			'label'   => esc_html__('Sidebar position (on desktop)', 'multiloquent'),
			'section' => 'multiloquent_settings',
			'type'    => 'select',
			'choices' => [
				'left'  => esc_html__('Left', 'multiloquent'),
				'right' => esc_html__('Right', 'multiloquent'),
			],
		]);
	}

	public function sanitize_featured_style(string $value): string
	{
		return in_array($value, ['tags', 'excerpt', 'none'], true) ? $value : 'tags';
	}

	public function sanitize_sidebar_position(string $value): string
	{
		return in_array($value, ['left', 'right'], true) ? $value : 'left';
	}

	// -------------------------------------------------------------------------
	// Cookie banner — admin settings
	// -------------------------------------------------------------------------

	public function multiloquent_cookie_banner_admin_menu(): void
	{
		add_options_page(
			esc_html__('Cookie Banner', 'multiloquent'),
			esc_html__('Cookie Banner', 'multiloquent'),
			'manage_options',
			'multiloquent-cookie-banner',
			[$this, 'multiloquent_cookie_banner_settings_page']
		);
	}

	public function multiloquent_cookie_banner_register_settings(): void
	{
		register_setting('multiloquent_cookie_banner', 'multiloquent_cookie_banner_enabled', [
			'type'              => 'boolean',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => false,
		]);

		register_setting('multiloquent_cookie_banner', 'multiloquent_cookie_banner_message', [
			'type'              => 'string',
			'sanitize_callback' => 'wp_kses_post',
			'default'           => esc_html__('We use cookies to improve your experience. By continuing to use this site, you agree to our use of cookies.', 'multiloquent'),
		]);

		register_setting('multiloquent_cookie_banner', 'multiloquent_cookie_categories', [
			'type'              => 'array',
			'sanitize_callback' => [$this, 'sanitize_cookie_categories'],
			'default'           => $this->multiloquent_cookie_category_defaults(),
		]);

		register_setting('multiloquent_cookie_banner', 'multiloquent_cookie_analytics_code', [
			'type'              => 'string',
			'sanitize_callback' => [$this, 'sanitize_cookie_analytics_code'],
			'default'           => '',
		]);

		add_settings_section(
			'multiloquent_cookie_banner_section',
			'',
			'__return_false',
			'multiloquent-cookie-banner'
		);

		add_settings_field(
			'multiloquent_cookie_banner_enabled',
			esc_html__('Enable cookie banner', 'multiloquent'),
			[$this, 'multiloquent_cookie_banner_enabled_field'],
			'multiloquent-cookie-banner',
			'multiloquent_cookie_banner_section'
		);

		add_settings_field(
			'multiloquent_cookie_banner_message',
			esc_html__('Banner message', 'multiloquent'),
			[$this, 'multiloquent_cookie_banner_message_field'],
			'multiloquent-cookie-banner',
			'multiloquent_cookie_banner_section'
		);

		add_settings_field(
			'multiloquent_cookie_categories',
			esc_html__('Cookie categories', 'multiloquent'),
			[$this, 'multiloquent_cookie_categories_field'],
			'multiloquent-cookie-banner',
			'multiloquent_cookie_banner_section'
		);

		add_settings_field(
			'multiloquent_cookie_analytics_code',
			esc_html__('Analytics code', 'multiloquent'),
			[$this, 'multiloquent_cookie_analytics_code_field'],
			'multiloquent-cookie-banner',
			'multiloquent_cookie_banner_section'
		);
	}

	/**
	 * Cookie categories the banner offers, and whether each is granted by
	 * default (i.e. does not wait for a visitor to accept the banner).
	 */
	private function multiloquent_cookie_category_defaults(): array
	{
		return [
			'functional' => true,
			'analytics'  => false,
			'marketing'  => false,
		];
	}

	private function multiloquent_cookie_category_labels(): array
	{
		return [
			'functional' => esc_html__('Functional', 'multiloquent'),
			'analytics'  => esc_html__('Analytics', 'multiloquent'),
			'marketing'  => esc_html__('Marketing', 'multiloquent'),
		];
	}

	/**
	 * Maps our own category keys to the WP Consent API's standard category
	 * names (https://github.com/WordPress/wp-consent-level-api) — the ones
	 * consent-aware plugins (e.g. Site Kit by Google) actually read. Notably
	 * "analytics" here is "statistics" over there.
	 */
	private function multiloquent_cookie_category_consent_map(): array
	{
		return [
			'functional' => 'functional',
			'analytics'  => 'statistics',
			'marketing'  => 'marketing',
		];
	}

	/**
	 * Signals consent for every category enabled by default, on every
	 * request, via the WP Consent API's wp_set_consent() — the same
	 * function its own JS uses. This is what lets a consent-aware plugin
	 * (e.g. Site Kit by Google) run its own tags automatically, without the
	 * visitor needing to click Accept and without this theme having to
	 * output any tracking code itself.
	 *
	 * Requires the WP Consent API plugin (https://wordpress.org/plugins/wp-consent-api/)
	 * to be installed and active — it defines wp_set_consent(). Without it
	 * there is nothing for other plugins to read, so this is a no-op.
	 */
	public function multiloquent_cookie_apply_default_consent(): void
	{
		if (is_admin() || ! get_option('multiloquent_cookie_banner_enabled', false)) {
			return;
		}
		if (! function_exists('wp_set_consent')) {
			return;
		}

		$categories = get_option('multiloquent_cookie_categories', $this->multiloquent_cookie_category_defaults());
		foreach ($this->multiloquent_cookie_category_consent_map() as $key => $consent_category) {
			if (! empty($categories[$key])) {
				wp_set_consent($consent_category, 'allow');
			}
		}
	}

	public function sanitize_cookie_categories($value): array
	{
		$value = is_array($value) ? $value : [];
		$out   = [];
		foreach ($this->multiloquent_cookie_category_defaults() as $key => $default) {
			$out[$key] = ! empty($value[$key]);
		}
		return $out;
	}

	public function sanitize_cookie_analytics_code(string $value): string
	{
		// Not passed through wp_kses_post: this field exists to hold a raw
		// tracking snippet (e.g. Google Analytics' <script> tags), and it's
		// only reachable by users with the manage_options capability.
		return trim($value);
	}

	public function multiloquent_cookie_banner_enabled_field(): void
	{
		$enabled = get_option('multiloquent_cookie_banner_enabled', false);
	?>
		<label for="multiloquent_cookie_banner_enabled">
			<input type="checkbox" id="multiloquent_cookie_banner_enabled" name="multiloquent_cookie_banner_enabled" value="1" <?php checked($enabled); ?>>
			<?php esc_html_e('Show a cookie consent banner on the site.', 'multiloquent'); ?>
		</label>
	<?php
	}

	public function multiloquent_cookie_banner_message_field(): void
	{
		$message = get_option('multiloquent_cookie_banner_message', '');
	?>
		<textarea id="multiloquent_cookie_banner_message" name="multiloquent_cookie_banner_message" rows="4" class="large-text" cols="50"><?php echo esc_textarea($message); ?></textarea>
		<p class="description"><?php esc_html_e('Message shown on the banner. Basic HTML (e.g. a link to your privacy policy) is allowed.', 'multiloquent'); ?></p>
	<?php
	}

	public function multiloquent_cookie_categories_field(): void
	{
		$categories = get_option('multiloquent_cookie_categories', $this->multiloquent_cookie_category_defaults());
		$labels     = $this->multiloquent_cookie_category_labels();
	?>
		<fieldset>
			<legend class="screen-reader-text"><?php esc_html_e('Cookie categories', 'multiloquent'); ?></legend>
			<?php foreach ($labels as $key => $label) : ?>
				<label style="display:block;margin-bottom:0.4em;">
					<input type="checkbox" name="multiloquent_cookie_categories[<?php echo esc_attr($key); ?>]" value="1" <?php checked(! empty($categories[$key])); ?>>
					<?php
					printf(
						/* translators: %s: cookie category name, e.g. "Analytics" */
						esc_html__('%s — enabled by default (runs for every visitor, no opt-in required)', 'multiloquent'),
						esc_html($label)
					);
					?>
				</label>
			<?php endforeach; ?>
			<p class="description">
				<?php esc_html_e('A category left unchecked stays off for a visitor until they click Accept on the banner — most privacy regulations require this for anything beyond strictly necessary functionality.', 'multiloquent'); ?>
			</p>
			<p class="description">
				<?php esc_html_e('Checking a category here calls the WP Consent API\'s wp_set_consent() for it on every page load, so plugins that already read that API — e.g. Site Kit by Google\'s Consent Mode — run their own tags automatically. You only need the "Analytics code" field below for a tracking snippet that isn\'t already wired up to a plugin like that.', 'multiloquent'); ?>
			</p>
		</fieldset>
	<?php
	}

	public function multiloquent_cookie_analytics_code_field(): void
	{
		$code = get_option('multiloquent_cookie_analytics_code', '');
	?>
		<textarea id="multiloquent_cookie_analytics_code" name="multiloquent_cookie_analytics_code" rows="6" class="large-text code" cols="50"><?php echo esc_textarea($code); ?></textarea>
		<p class="description">
			<?php esc_html_e('Optional: paste a tracking snippet here (e.g. a hand-rolled Google Analytics / gtag.js embed code) if you\'re not already using a plugin that reads consent itself. It runs immediately if Analytics is enabled by default above; otherwise it only runs after a visitor accepts the banner. Leave blank if a plugin like Site Kit by Google is handling this.', 'multiloquent'); ?>
		</p>
	<?php
	}

	public function multiloquent_cookie_banner_settings_page(): void
	{
		if (! current_user_can('manage_options')) {
			return;
		}
	?>
		<div class="wrap">
			<h1><?php esc_html_e('Cookie Banner', 'multiloquent'); ?></h1>
			<p>
				<?php esc_html_e('A lightweight cookie consent banner. Accept/decline choices are reported through the WP Consent API, so any other consent-aware plugin or script on the site respects the same decision. Categories and the analytics code below only take effect while the banner is enabled.', 'multiloquent'); ?>
			</p>
			<?php if (! function_exists('wp_set_consent')) : ?>
				<div class="notice notice-warning inline">
					<p>
						<?php
						printf(
							wp_kses(
								/* translators: %s: URL to the WP Consent API plugin on wordpress.org */
								__('The <a href="%s" target="_blank" rel="noopener noreferrer">WP Consent API</a> plugin isn\'t active. Install and activate it so other consent-aware plugins (e.g. Site Kit by Google) can see the choices made below — without it, the categories here have no effect outside this site.', 'multiloquent'),
								['a' => ['href' => [], 'target' => [], 'rel' => []]]
							),
							esc_url('https://wordpress.org/plugins/wp-consent-api/')
						);
						?>
					</p>
				</div>
			<?php endif; ?>
			<form method="post" action="options.php">
				<?php
				settings_fields('multiloquent_cookie_banner');
				do_settings_sections('multiloquent-cookie-banner');
				submit_button();
				?>
			</form>
		</div>
	<?php
	}

	// -------------------------------------------------------------------------
	// Cookie banner — frontend
	// -------------------------------------------------------------------------

	/**
	 * Prints the admin-configured analytics snippet.
	 *
	 * Runs unmodified if the "analytics" category is enabled by default;
	 * otherwise each <script> tag is rewritten to type="text/plain" so the
	 * browser parses but does not execute it — cookie-banner.js swaps the
	 * matching tags back to real, running scripts once a visitor accepts.
	 */
	public function multiloquent_cookie_scripts_output(): void
	{
		if (! get_option('multiloquent_cookie_banner_enabled', false)) {
			return;
		}

		$code = get_option('multiloquent_cookie_analytics_code', '');
		if ('' === trim($code)) {
			return;
		}

		$categories = get_option('multiloquent_cookie_categories', $this->multiloquent_cookie_category_defaults());

		echo "\n<!-- Multiloquent: analytics code -->\n";

		if (! empty($categories['analytics'])) {
			echo $code . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- intentional raw tracking snippet, see sanitize_cookie_analytics_code().
			return;
		}

		$gated = preg_replace_callback(
			'/<script\b([^>]*)>/i',
			function (array $matches): string {
				if (false !== stripos($matches[1], 'type=')) {
					return $matches[0];
				}
				return '<script type="text/plain" data-multiloquent-consent="analytics"' . $matches[1] . '>';
			},
			$code
		);
		echo $gated . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- intentional raw tracking snippet, see sanitize_cookie_analytics_code().
	}

	public function multiloquent_cookie_banner_render(): void
	{
		if (! get_option('multiloquent_cookie_banner_enabled', false)) {
			return;
		}

		$message = get_option('multiloquent_cookie_banner_message', '');
		if ('' === trim(wp_strip_all_tags($message))) {
			return;
		}
	?>
		<div id="multiloquent-cookie-banner" class="multiloquent-cookie-banner" role="region" aria-label="<?php esc_attr_e('Cookie notice', 'multiloquent'); ?>" hidden>
			<div class="multiloquent-cookie-banner-inner">
				<div class="multiloquent-cookie-banner-message"><?php echo wp_kses_post($message); ?></div>
				<div class="multiloquent-cookie-banner-actions">
					<button type="button" class="multiloquent-cookie-banner-decline"><?php esc_html_e('Decline', 'multiloquent'); ?></button>
					<button type="button" class="multiloquent-cookie-banner-accept"><?php esc_html_e('Accept', 'multiloquent'); ?></button>
				</div>
			</div>
		</div>
	<?php
	}

	// -------------------------------------------------------------------------
	// Featured image in RSS feed
	// -------------------------------------------------------------------------

	public function multiloquent_featured_image_in_feed(string $content): string
	{
		global $post;
		if (is_feed() && has_post_thumbnail($post->ID)) {
			$img     = get_the_post_thumbnail($post->ID, 'medium', ['style' => 'float:right;margin:0 0 10px 10px;']);
			$content = $img . $content;
		}
		return $content;
	}

	// -------------------------------------------------------------------------
	// Tag cloud
	// -------------------------------------------------------------------------

	public function multiloquent_widget_tag_cloud_args(array $args): array
	{
		$args['largest']  = 1.1;
		$args['smallest'] = 0.8;
		$args['unit']     = 'rem';
		return $args;
	}

	public function multiloquent_tag_cloud_filter(string $return, array $args): string
	{
		return str_replace("'", '"', $return);
	}

	// -------------------------------------------------------------------------
	// Avatar
	// -------------------------------------------------------------------------

	public function multiloquent_get_avatar(string $avatar): string
	{
		return str_replace('class="avatar', 'class="avatar rounded-full', $avatar);
	}

	// -------------------------------------------------------------------------
	// Archive card renderer
	// -------------------------------------------------------------------------

	public function multiloquent_render_the_archive(): void
	{
		global $wp_query;
		$is_hero        = (0 === $wp_query->current_post);
		$featured_style = get_theme_mod('multiloquent_featured_style', 'tags');
		$card_class     = $is_hero ? 'archive-card archive-card-hero' : 'archive-card';
		$tags           = get_the_tags();
		$cats           = get_the_category();
		$tax_items      = $tags ? array_slice($tags, 0, $is_hero ? 4 : 2) : array_slice($cats ?: [], 0, $is_hero ? 4 : 2);
		$is_tags        = (bool) $tags;
?>
		<article id="post-<?php the_ID(); ?>" <?php post_class($card_class); ?>>
			<div class="archive-card-image">
				<?php if (has_post_thumbnail()) : ?>
					<?php the_post_thumbnail('multiloquent-card', ['loading' => 'lazy']); ?>
				<?php else : ?>
					<div class="archive-card-placeholder"></div>
				<?php endif; ?>
				<span aria-hidden="true" class="archive-card-overlay"></span>
			</div>
			<div class="archive-card-body">
				<?php if ('tags' === $featured_style && $tax_items) : ?>
					<div class="archive-card-tags">
						<?php foreach ($tax_items as $item) : ?>
							<?php if ($is_tags) : ?>
								<a href="<?php echo esc_url(get_tag_link($item->term_id)); ?>" class="tag-label"><?php echo esc_html($item->name); ?></a>
							<?php else : ?>
								<a href="<?php echo esc_url(get_category_link($item->term_id)); ?>" class="tag-label" rel="category tag"><?php echo esc_html($item->name); ?></a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<h2 class="archive-card-title <?php echo $is_hero ? 'archive-card-title-hero' : ''; ?>">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<p class="archive-card-meta">
					<?php echo esc_html(get_the_date()); ?>
					<?php if (get_the_author()) : ?>
						&mdash; <?php echo esc_html(get_the_author()); ?>
					<?php endif; ?>
				</p>
				<?php if ('excerpt' === $featured_style && $is_hero) : ?>
					<p class="archive-card-excerpt">
						<?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?>
					</p>
				<?php endif; ?>
			</div>
		</article>
	<?php
	}

	// -------------------------------------------------------------------------
	// Breadcrumbs
	// -------------------------------------------------------------------------

	public function multiloquent_breadcrumbs(): void
	{
		if (is_front_page()) {
			return;
		}

		echo '<nav aria-label="' . esc_attr__('Breadcrumb', 'multiloquent') . '" class="breadcrumb px-4 md:px-6 py-2 text-sm">';
		echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'multiloquent') . '</a>';
		echo '<span class="mx-1" aria-hidden="true">/</span>';

		if (is_single()) {
			$cats = get_the_category();
			if ($cats) {
				echo '<a href="' . esc_url(get_category_link($cats[0]->term_id)) . '">' . esc_html($cats[0]->name) . '</a>';
				echo '<span class="mx-1" aria-hidden="true">/</span>';
			}
			echo '<span aria-current="page">' . esc_html(get_the_title()) . '</span>';
		} elseif (is_page()) {
			echo '<span aria-current="page">' . esc_html(get_the_title()) . '</span>';
		} elseif (is_category()) {
			echo '<span aria-current="page">' . esc_html(single_cat_title('', false)) . '</span>';
		} elseif (is_tag()) {
			echo '<span aria-current="page">' . esc_html(single_tag_title('', false)) . '</span>';
		} elseif (is_author()) {
			echo '<span aria-current="page">' . esc_html(get_the_author()) . '</span>';
		} elseif (is_search()) {
			echo '<span aria-current="page">' . esc_html__('Search results', 'multiloquent') . '</span>';
		} elseif (is_404()) {
			echo '<span aria-current="page">' . esc_html__('Page not found', 'multiloquent') . '</span>';
		}

		echo '</nav>';
	}

	// -------------------------------------------------------------------------
	// Post title helper
	// -------------------------------------------------------------------------

	public function multiloquent_post_title(): string
	{
		return esc_html(get_the_title());
	}

	// -------------------------------------------------------------------------
	// Featured / hero slider (homepage)
	// -------------------------------------------------------------------------

	public function multiloquent_paralax_slider(): string
	{
		$featured_posts = $this->multiloquent_get_featured_posts();
		if (empty($featured_posts)) {
			return '';
		}

		// Trim to a multiple of 3, max 21.
		$count = (int) floor(min(count($featured_posts), 21) / 3) * 3;
		if ($count === 0) {
			return '';
		}
		$featured_posts = array_slice($featured_posts, 0, $count);

		$featured_style = get_theme_mod('multiloquent_featured_style', 'tags');

		ob_start();
	?>
		<section class="featured-slider py-6"
			aria-label="<?php esc_attr_e('Featured posts', 'multiloquent'); ?>">
			<div class="archive-grid max-w-[var(--width-wide)] mx-auto">
				<?php foreach ($featured_posts as $i => $fp) :
					$is_hero    = ($i === 0);
					$card_class = $is_hero ? 'archive-card archive-card-hero' : 'archive-card';
					$img_size   = $is_hero ? 'multiloquent-card' : 'multiloquent-thumb';
					$thumb_id   = get_post_thumbnail_id($fp->ID);
					$thumb      = get_the_post_thumbnail_url($fp->ID, $img_size);
					$srcset     = $thumb_id ? wp_get_attachment_image_srcset($thumb_id, $img_size) : false;
					$sizes      = $thumb_id ? wp_get_attachment_image_sizes($thumb_id, $img_size) : false;
					$cats       = get_the_category($fp->ID);
				?>
					<a href="<?php echo esc_url(get_permalink($fp->ID)); ?>" class="<?php echo $card_class; ?>">
						<div class="archive-card-image">
							<?php if ($thumb) : ?>
								<img src="<?php echo esc_url($thumb); ?>"
									<?php if ($srcset) : ?>srcset="<?php echo esc_attr($srcset); ?>" <?php endif; ?>
									<?php if ($sizes) : ?>sizes="<?php echo esc_attr($sizes); ?>" <?php endif; ?>
									alt="<?php echo esc_attr(get_the_title($fp->ID)); ?>"
									loading="<?php echo $is_hero ? 'eager' : 'lazy'; ?>">
							<?php else : ?>
								<div class="archive-card-placeholder"></div>
							<?php endif; ?>
							<span aria-hidden="true" class="archive-card-overlay"></span>
						</div>
						<div class="archive-card-body">
							<?php if ('tags' === $featured_style && $cats) : ?>
								<div class="archive-card-tags">
									<?php foreach (array_slice($cats, 0, $is_hero ? 4 : 2) as $cat) : ?>
										<span class="tag-label"><?php echo esc_html($cat->name); ?></span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<h3 class="archive-card-title <?php echo $is_hero ? 'archive-card-title-hero' : ''; ?>">
								<?php echo esc_html(get_the_title($fp->ID)); ?>
							</h3>
							<?php if ('excerpt' === $featured_style && $is_hero) : ?>
								<p class="archive-card-excerpt">
									<?php echo esc_html(wp_trim_words(get_the_excerpt($fp->ID), 20)); ?>
								</p>
							<?php endif; ?>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</section>
<?php
		return ob_get_clean();
	}

	// Same as multiloquent_paralax_slider — kept for back-compat with old templates.
	public function multiloquent_paralax_featured_sliders(): string
	{
		return $this->multiloquent_paralax_slider();
	}

	private function multiloquent_get_featured_posts(): array
	{

		// Pull posts from the 'featured' category.
		$posts = get_posts([
			'post_type'      => 'post',
			'posts_per_page' => 21,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'category_name'  => 'featured',
		]);

		if (! empty($posts)) {
			return $posts;
		}


		// Fall back to sticky posts, then latest posts.
		$sticky = get_option('sticky_posts');
		$args   = [
			'post_type'      => 'post',
			'posts_per_page' => 21,
			'orderby'        => 'date',
			'order'          => 'DESC',
		];
		if (! empty($sticky)) {
			$args['post__in'] = $sticky;
		}
		return get_posts($args);
	}

	// -------------------------------------------------------------------------
	// Category list as hierarchy
	// -------------------------------------------------------------------------

	public function multiloquent_category_list_as_hierarchy(int $parent = 0, int $depth = 0): void
	{
		$categories = get_categories(['parent' => $parent, 'hide_empty' => false]);
		if (empty($categories)) {
			return;
		}
		echo '<ul class="space-y-1 ' . ($depth > 0 ? 'pl-4 mt-1' : '') . '">';
		foreach ($categories as $category) {
			printf(
				'<li><a href="%s" class="text-[var(--color-primary)] hover:underline">%s</a> <span class="text-[var(--color-muted)] text-xs">(%d)</span>',
				esc_url(get_category_link($category->term_id)),
				esc_html($category->name),
				(int) $category->count
			);
			$this->multiloquent_category_list_as_hierarchy($category->term_id, $depth + 1);
			echo '</li>';
		}
		echo '</ul>';
	}
}
