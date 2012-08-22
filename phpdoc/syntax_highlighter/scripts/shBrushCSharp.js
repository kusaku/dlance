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
		var keywords =	'abstract as base bool break byte case catch char checked class const ' +
						'continue decimal default delegate do double else enum event explicit ' +
						'extern false finally fixed float for foreach get goto if implicit in int ' +
						'interface internal is lock long namespace new null object operator out ' +
						'override params private protected public readonly ref return sbyte sealed set ' +
						'short sizeof stackalloc static string struct switch this throw true try ' +
						'typeof uint ulong unchecked unsafe ushort using virtual void while';

		function fixComments(match, regexInfo)
		{
			//") == 0)
			var css = (match[0].indexOf("/
				? 'color1'
				: 'comments'
				;
			
			return [new SyntaxHighlighter.Match(match[0], match.index, css)];
		}

		this.regexList = [
			// one line comments
			{ regex: SyntaxHighlighter.regexLib.singleLineCComments,	func : fixComments },		
			// multiline comments
			{ regex: SyntaxHighlighter.regexLib.multiLineCComments,		css: 'comments' },			
			// @-quoted strings
			{ regex: /@"(?:[^"]|"")*"/g,								css: 'string' },			
			// strings
			{ regex: SyntaxHighlighter.regexLib.doubleQuotedString,		css: 'string' },			
			// strings
			{ regex: SyntaxHighlighter.regexLib.singleQuotedString,		css: 'string' },			
			// preprocessor tags like #region and #endregion
			{ regex: /^\s*#.*/gm,										css: 'preprocessor' },		
			// c# keyword
			{ regex: new RegExp(this.getKeywords(keywords), 'gm'),		css: 'keyword' },			
			// contextual keyword: 'partial'
			{ regex: /\bpartial(?=\s+(?:class|interface|struct)\b)/g,	css: 'keyword' },			
			// contextual keyword: 'yield'
			{ regex: /\byield(?=\s+(?:return|break)\b)/g,				css: 'keyword' }			
			];
		
		this.forHtmlScript(SyntaxHighlighter.regexLib.aspScriptTags);
	};

	Brush.prototype	= new SyntaxHighlighter.Highlighter();
	Brush.aliases	= ['c#', 'c-sharp', 'csharp'];

	SyntaxHighlighter.brushes.CSharp = Brush;

// CommonJS
	typeof(exports) != 'undefined' ? exports.Brush = Brush : null;
})();

