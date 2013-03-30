;( function() {
	tinymce.create( 'tinymce.plugins.column', {
		init : function( ed, url ) {
			ed.addButton( 'column', {
				title :   'Add Column',
				image :   url + '/icon.png',
				onclick : function() {
					var prompt_number = prompt( "Columns in this row?", "1" );

					if ( prompt_number !== null && prompt_number !== 'undefined' ) {
						ed.selection.setContent(
							'[column amount="' + prompt_number + '"]'
							+ ed.selection.getContent()
							+ '[/column]'
						);
					}
				}
			} );
		},
		createControl : function( n, cm ) {
			return null;
		},
		getInfo : function() {
			return {
				longname:  'TinyMCE Twitter Bootstrap columns button',
				author:    'Franz Josef Kaiser',
				authorurl: 'http://unserkaiser.com/',
				infourl:   'http://git.io/quHvvg',
				version:   '1.0'
			}
		}
	} );
	tinymce.PluginManager.add( 'column', tinymce.plugins.column );
} )();