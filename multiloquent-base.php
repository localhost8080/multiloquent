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
	}

	// -------------------------------------------------------------------------
	// Version
	// -------------------------------------------------------------------------

	public function multiloquent_version(): string
	{
		return '26.1.4';
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
		add_theme_support('title-tag');
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
?>
		<article id="post-<?php the_ID(); ?>" <?php post_class($card_class); ?>>
			<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('multiloquent-card', [
					'loading' => $is_hero ? 'eager' : 'lazy',
				]); ?>
			<?php else : ?>
				<div style="position:absolute;inset:0;background:var(--color-surface-alt);"></div>
			<?php endif; ?>
			<div class="archive-card-overlay">
				<header>
					<h2 style="margin:0;line-height:1.3;font-weight:<?php echo $is_hero ? '700' : '600'; ?>;font-size:<?php echo $is_hero ? '1.125rem' : '0.875rem'; ?>;">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<p style="font-size:0.75rem;margin:0.25rem 0 0;opacity:0.7;">
						<?php echo esc_html(get_the_date()); ?>
						<?php if (get_the_author()) : ?>
							&mdash; <?php echo esc_html(get_the_author()); ?>
						<?php endif; ?>
					</p>
				</header>
				<?php if ('excerpt' === $featured_style && $is_hero) : ?>
					<p style="font-size:0.75rem;margin:0.25rem 0 0;opacity:0.8;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
						<?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?>
					</p>
				<?php elseif ('tags' === $featured_style) : ?>
					<div style="display:flex;flex-wrap:wrap;gap:0.25rem;margin-top:0.25rem;">
						<?php
						$tags = get_the_tags();
						if ($tags) {
							foreach (array_slice($tags, 0, $is_hero ? 4 : 2) as $tag) {
								printf(
									'<a href="%s" class="tag-label" style="font-size:0.75rem;opacity:0.9;">%s</a>',
									esc_url(get_tag_link($tag->term_id)),
									esc_html($tag->name)
								);
							}
						} else {
							$cats = get_the_category();
							if ($cats) : ?>

								<?php foreach ($cats as $cat) : ?>
									<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="tag-label" rel="category tag"><?php echo esc_html($cat->name); ?></a>
								<?php endforeach; ?>
						<?php endif;
						}
						?>
					</div>
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
		<section class="featured-slider bg-[var(--color-surface)] py-6 px-4 md:px-6"
			aria-label="<?php esc_attr_e('Featured posts', 'multiloquent'); ?>">
			<div class="archive-grid max-w-[var(--width-wide)] mx-auto">
				<?php foreach ($featured_posts as $i => $fp) :
					$thumb   = get_the_post_thumbnail_url($fp->ID, 'multiloquent-card');
					$is_hero = ($i === 0);
					$card_class = $is_hero ? 'archive-card archive-card-hero' : 'archive-card';
				?>
					<a href="<?php echo esc_url(get_permalink($fp->ID)); ?>" class="<?php echo $card_class; ?>">
						<?php if ($thumb) : ?>
							<img src="<?php echo esc_url($thumb); ?>"
								alt="<?php echo esc_attr(get_the_title($fp->ID)); ?>"
								loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>">
						<?php else : ?>
							<div style="position:absolute;inset:0;background:var(--color-surface-alt);"></div>
						<?php endif; ?>
						<div class="archive-card-overlay">
							<h3 style="margin:0;line-height:1.3;color:white;font-weight:<?php echo $is_hero ? '700' : '600'; ?>;font-size:<?php echo $is_hero ? '1.125rem' : '0.875rem'; ?>;">
								<?php echo esc_html(get_the_title($fp->ID)); ?>
							</h3>
							<?php if ('excerpt' === $featured_style && $is_hero) : ?>
								<p style="font-size:0.75rem;margin:0.25rem 0 0;opacity:0.8;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
									<?php echo esc_html(wp_trim_words(get_the_excerpt($fp->ID), 20)); ?>
								</p>
							<?php elseif ('tags' === $featured_style) : ?>
								<div style="display:flex;flex-wrap:wrap;gap:0.25rem;margin-top:0.25rem;">
									<?php
									$tags = get_the_tags($fp->ID);
									if ($tags) {
										foreach (array_slice($tags, 0, $is_hero ? 4 : 2) as $tag) {
											printf('<span class="tag-label" style="font-size:0.75rem;opacity:0.9;">%s</span>', esc_html($tag->name));
										}
									}
									?>
								</div>
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
