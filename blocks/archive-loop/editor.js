( function ( blocks, element ) {
	var el = element.createElement;
	blocks.registerBlockType( 'multiloquent/archive-loop', {
		edit: function () {
			return el(
				'div',
				{ style: { background: '#f9fafb', border: '1px dashed #d1d5db', borderRadius: '0.375rem', padding: '1rem 1.25rem', fontSize: '0.875rem', color: '#6b7280', lineHeight: '1.5' } },
				el( 'strong', { style: { display: 'block', color: '#111827', marginBottom: '0.25rem' } }, 'Archive Loop' ),
				el( 'span', {}, 'Renders the current query using the theme\u2019s archive card style \u2014 rendered on the frontend.' )
			);
		},
		save: function () { return null; }
	} );
} )( window.wp.blocks, window.wp.element );
