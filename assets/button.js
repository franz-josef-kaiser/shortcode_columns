;( function() {
	tinymce.create( 'tinymce.plugins.column', {
		init : function( ed, url ) {
			ed.addButton( 'column', {
				title :   'Add Column',
				image :   url + '/icon.png',
				onclick : function() {
					var prompt_number = prompt( "Columns in this row?", "1" ),
						caret = "caret_pos_holder";

					if ( prompt_number !== null && prompt_number !== 'undefined' ) {
						console.log( ed.selection.getContent() );
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
				author:    'TBScols',
				authorurl: 'http://unserkaiser.com/',
				infourl:   'http://unserkaiser.com/',
				version:   '1.0'
			}
		}
	} );
	tinymce.PluginManager.add( 'column', tinymce.plugins.column );
} )();