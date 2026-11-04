/**
 * Paperpane block editor.
 *
 * Dynamic block (rendered in PHP), authored without a build step using
 * wp.element.createElement so it runs straight from source.
 */
( function ( wp ) {
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var blocks = wp.blocks;
	var be = wp.blockEditor;
	var cmp = wp.components;

	var useBlockProps = be.useBlockProps;
	var InspectorControls = be.InspectorControls;
	var BlockControls = be.BlockControls;
	var MediaUpload = be.MediaUpload;
	var MediaUploadCheck = be.MediaUploadCheck;
	var MediaPlaceholder = be.MediaPlaceholder;

	var PanelBody = cmp.PanelBody;
	var RangeControl = cmp.RangeControl;
	var ToggleControl = cmp.ToggleControl;
	var TextControl = cmp.TextControl;
	var ToolbarGroup = cmp.ToolbarGroup;
	var ToolbarButton = cmp.ToolbarButton;

	blocks.registerBlockType( 'paperpane/embed', {
		edit: function ( props ) {
			var a = props.attributes;
			var setA = props.setAttributes;
			var blockProps = useBlockProps();

			function onSelect( media ) {
				setA( {
					id: media.id,
					url: media.url,
					title: a.title || media.title || ''
				} );
			}

			var inspector = el(
				InspectorControls,
				{},
				el(
					PanelBody,
					{ title: __( 'PDF settings', 'paperpane' ), initialOpen: true },
					el( RangeControl, {
						label: __( 'Viewer height (px)', 'paperpane' ),
						value: a.height,
						min: 200,
						max: 1500,
						step: 10,
						onChange: function ( v ) {
							setA( { height: v || 600 } );
						}
					} ),
					el( ToggleControl, {
						label: __( 'Show PDF toolbar', 'paperpane' ),
						checked: a.toolbar,
						onChange: function ( v ) {
							setA( { toolbar: v } );
						}
					} ),
					el( TextControl, {
						label: __( 'Accessible title', 'paperpane' ),
						help: __( 'Describes the PDF for screen readers.', 'paperpane' ),
						value: a.title,
						onChange: function ( v ) {
							setA( { title: v } );
						}
					} )
				)
			);

			if ( ! a.url ) {
				return el(
					'div',
					blockProps,
					inspector,
					el( MediaPlaceholder, {
						icon: 'media-document',
						labels: {
							title: __( 'Paperpane PDF Embed', 'paperpane' ),
							instructions: __( 'Upload a PDF or choose one from your Media Library.', 'paperpane' )
						},
						accept: 'application/pdf',
						allowedTypes: [ 'application/pdf' ],
						onSelect: onSelect
					} )
				);
			}

			var controls = el(
				BlockControls,
				{},
				el(
					ToolbarGroup,
					{},
					el(
						MediaUploadCheck,
						{},
						el( MediaUpload, {
							onSelect: onSelect,
							allowedTypes: [ 'application/pdf' ],
							value: a.id,
							render: function ( o ) {
								return el(
									ToolbarButton,
									{ onClick: o.open },
									__( 'Replace PDF', 'paperpane' )
								);
							}
						} )
					)
				)
			);

			return el(
				'div',
				blockProps,
				inspector,
				controls,
				el( 'iframe', {
					className: 'paperpane__frame',
					src: a.url,
					title: a.title || __( 'Embedded PDF', 'paperpane' ),
					style: {
						width: '100%',
						height: ( a.height || 600 ) + 'px',
						border: '1px solid #e2e2e2',
						borderRadius: '6px'
					}
				} )
			);
		},

		// Dynamic block: markup comes from the PHP render_callback.
		save: function () {
			return null;
		}
	} );
} )( window.wp );
