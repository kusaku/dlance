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
		var keywords =	'abstract assert boolean break byte case catch char class const ' +
						'continue default do double else enum extends ' +
						'false final finally float for goto if implements import ' +
						'instanceof int interface long native new null ' +
						'package private protected public return ' +
						'short static strictfp super switch synchronized this throw throws true ' +
						'transient try void volatile while';

		this.regexList = [
			// one line comments
			{ regex: SyntaxHighlighter.regexLib.singleLineCComments,	css: 'comments' },		
			// multiline comments
			{ regex: /\/\*([^\*][\s\S]*)?\*\//gm,						css: 'comments' },	 	
			// documentation comments
			{ regex: /\/\*(?!\*\/)\*[\s\S]*?\*\//gm,					css: 'preprocessor' },	
			// strings
			{ regex: SyntaxHighlighter.regexLib.doubleQuotedString,		css: 'string' },		
			// strings
			{ regex: SyntaxHighlighter.regexLib.singleQuotedString,		css: 'string' },		
			// numbers
			{ regex: /\b([\d]+(\.[\d]+)?|0x[a-f0-9]+)\b/gi,				css: 'value' },			
			// annotation @anno
			{ regex: /(?!\@interface\b)\@[\$\w]+\b/g,					css: 'color1' },		
			// @interface keyword
			{ regex: /\@interface\b/g,									css: 'color2' },		
			// java keyword
			{ regex: new RegExp(this.getKeywords(keywords), 'gm'),		css: 'keyword' }		
			];

		this.forHtmlScript({
			left	: /(&lt;|<)%[@!=]?/g, 
			right	: /%(&gt;|>)/g 
		});
	};

	Brush.prototype	= new SyntaxHighlighter.Highlighter();
	Brush.aliases	= ['java'];

	SyntaxHighlighter.brushes.Java = Brush;

// CommonJS
	typeof(exports) != 'undefined' ? exports.Brush = Brush : null;
})();
