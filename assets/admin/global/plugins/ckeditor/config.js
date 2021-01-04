/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
// Define changes to default configuration here.
// For complete reference see:
// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [


		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },

		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },

		{ name: 'basicstyles', groups: [ 'basicstyles' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },

	];

// Remove some buttons provided by the standard plugins, which are
// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

// Define changes to default configuration here. For example:
// config.language = 'fr';
// config.uiColor = '#AADC6E';
	config.filebrowserBrowseUrl = '/admin/global/plugins/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = '/admin/global/plugins/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = '/admin/global/plugins/kcfinder/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = '/admin/global/plugins/kcfinder/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = '/admin/global/plugins/kcfinder/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = '/admin/global/plugins/kcfinder/upload.php?opener=ckeditor&type=flash';
};