/**
 * SyntaxHighlighter
 * http://alexgorbatchev.com/SyntaxHighlighter
 *
 * SyntaxHighlighter is donationware. If you are using it, please donate.
 * http://alexgorbatchev.com/SyntaxHighlighter/donate.html
 *
 * @version
 * 3.0.83 (July 02 2010)
 * 
 * @copyright
 * Copyright (C) 2004-2010 Alex Gorbatchev.
 *
 * @license
 * Dual licensed under the MIT and GPL licenses.
 */
;(function()
{
// CommonJS
	typeof(require) != 'undefined' ? SyntaxHighlighter = require('shCore').SyntaxHighlighter : null;

	function Brush()
	{
	// Contributed by Yegor Jbanov and David Bernard.
		var keywords =	'val sealed case def true trait implicit forSome import match object null finally super ' +
						'override try lazy for var catch throw type extends class while with new final yield abstract ' +
						'else do if return protected private this package false';

		var keyops =	'[_:=><%#@]+';

		this.regexList = [
			// one line comments
			{ regex: SyntaxHighlighter.regexLib.singleLineCComments,			css: 'comments' },	
			// multiline comments
			{ regex: SyntaxHighlighter.regexLib.multiLineCComments,				css: 'comments' },	
			// multi-line strings
			{ regex: SyntaxHighlighter.regexLib.multiLineSingleQuotedString,	css: 'string' },	
			// double-quoted string
			{ regex: SyntaxHighlighter.regexLib.multiLineDoubleQuotedString,    css: 'string' },	
			// strings
			{ regex: SyntaxHighlighter.regexLib.singleQuotedString,				css: 'string' },	
			// numbers
			{ regex: /0x[a-f0-9]+|\d+(\.\d+)?/gi,								css: 'value' },		
			// keywords
			{ regex: new RegExp(this.getKeywords(keywords), 'gm'),				css: 'keyword' },	
			// scala keyword
			{ regex: new RegExp(keyops, 'gm'),									css: 'keyword' }	
			];
	}

	Brush.prototype	= new SyntaxHighlighter.Highlighter();
	Brush.aliases	= ['scala'];

	SyntaxHighlighter.brushes.Scala = Brush;

// CommonJS
	typeof(exports) != 'undefined' ? exports.Brush = Brush : null;
})();
