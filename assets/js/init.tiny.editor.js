var editor = new TINY.editor.edit('editor', {
	id: 'tinyeditor',
	width: 800,
	height: 175,
	cssclass: 'tinyeditor',
	controlclass: 'tinyeditor-control',
	rowclass: 'tinyeditor-header',
	dividerclass: 'tinyeditor-divider',
	controls: ['bold', 'italic', 'underline', 'strikethrough', '|',
		'orderedlist', 'unorderedlist', '|', 'outdent', 'indent', '|', 'leftalign',
		'centeralign', 'rightalign', 'blockjustify', '|', 'unformat', '|', 'undo', 'redo', '|',
		'style', 'size', '|', 'hr', 'link', 'unlink'],
	footer: false,
	xhtml: true,
	cssfile: '/assets/css/custom.css',
	bodyid: 'editor',
	footerclass: 'tinyeditor-footer',
	toggle: {text: 'source', activetext: 'wysiwyg', cssclass: 'toggle'}
});
