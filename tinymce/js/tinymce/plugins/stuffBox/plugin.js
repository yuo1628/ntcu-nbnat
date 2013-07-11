/**
 * plugin.js
 *
 * Copyright, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*global tinymce:true */

tinymce.PluginManager.add('stuffbox', function(editor) {
	editor.addCommand('InsertStuffBox', function() {
		//editor.execCommand('mceInsertContent', false, '<hr />');
		editor.execCommand('mceInsertContent', false, '/*___*/');
	});

	editor.addButton('stuffbox', {
		title: 'Stuff box',		
		icon: 'code',
		tooltip: 'Insert Stuff box',
		cmd: 'InsertStuffBox'
	});

	editor.addMenuItem('stuffbox', {
		icon: 'code',
		title: 'Stuff box',
		cmd: 'Insert Stuff box',
		context: 'insert'
	});
});
