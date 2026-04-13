/**
 * Multiloquent custom blocks — editor registration (no build step required).
 *
 * Both blocks delegate all rendering to PHP (dynamic blocks), so the editor
 * just shows a static placeholder for each.
 */
( function ( blocks, element ) {
	var el = element.createElement;

	function placeholder( label, hint ) {
		return el(
			'div',
			{
				style: {
					background: '#f9fafb',
					border: '1px dashed #d1d5db',
					borderRadius: '0.375rem',
					padding: '1rem 1.25rem',
					fontSize: '0.875rem',
					color: '#6b7280',
					lineHeight: '1.5',
				},
			},
			el( 'strong', { style: { display: 'block', color: '#111827', marginBottom: '0.25rem' } }, label ),
			el( 'span', {}, hint )
		);
	}

	blocks.registerBlockType( 'multiloquent/featured-slider', {
		edit: function () {
			return placeholder(
				'Featured Slider',
				'Displays the featured posts parallax slider — rendered on the frontend.'
			);
		},
		save: function () {
			return null; // dynamic block: PHP handles output
		},
	} );

	blocks.registerBlockType( 'multiloquent/breadcrumbs', {
		edit: function () {
			return placeholder(
				'Breadcrumbs',
				'Home / Category / Post title — rendered on the frontend.'
			);
		},
		save: function () {
			return null; // dynamic block: PHP handles output
		},
	} );

	blocks.registerBlockType( 'multiloquent/archive-loop', {
		edit: function () {
			return placeholder(
				'Archive Loop',
				'Renders the current query using the theme's archive card style — rendered on the frontend.'
			);
		},
		save: function () {
			return null; // dynamic block: PHP handles output
		},
	} );
} )( window.wp.blocks, window.wp.element );
