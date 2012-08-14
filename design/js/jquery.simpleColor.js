/*
 * jQuery simpleColor plugin
 * @requires jQuery v1.1 or later
 *
 * Examples at: http://recurser.com/articles/2007/12/18/jquery-simplecolor-color-picker/
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Revision: $Id$
 * Version: 1.0.0  Aug-03-2007
 */
 (function($) {
/**
 * simpleColor() provides a mechanism for displaying simple color-pickers.
 *
 * If an options Object is provided, the following attributes are supported:
 *
 *  defaultColor: Default (initially selected) color
 *                 default value: '#FFF'
 *
 *  border:       CSS border properties
 *                 default value: '1px solid #000'
 *
 *  cellWidth:    Width of each individual color cell
 *                 default value: 10
 *
 *  cellHeight:   Height of each individual color cell
 *                 default value: 10
 *
 *  cellMargin:   Margin of each individual color cell
 *                 default value: 1
 *
 *  boxWidth:     Width of the color display box
 *                 default value: 115px
 *
 *  boxHeight:    Height of the color display box
 *                 default value: 20px
 *
 *  columns:      Number of columns to display. Color order may look strange if this is altered
 *                 default value: 16
 *
 *  insert:       The position to insert the color picker. 'before' or 'after'
 *                 default value: 'after'
 */
$.fn.simpleColor = function(options) {
	
	var default_colors = 
		['FFFFCC','FFFF99','FFFF66','FFFF33','FFFF00','CCCC00',
'FFCC66','FFCC00','FFCC33','CC9900','CC9933','996600',
'FF9900','FF9933','CC9966','CC6600','996633','663300',
'FFCC99','FF9966','FF6600','CC6633','993300','660000',
'FF6633','CC3300','FF3300','FF0000','CC0000','990000',
'FFCCCC','FF9999','FF6666','FF3333','FF0033','CC0033',
'CC9999','CC6666','CC3333','993333','990033','330000',
'FF6699','FF3366','FF0066','CC3366','996666','663333',
'FF99CC','FF3399','FF0099','CC0066','993366','660033',
'FF66CC','FF00CC','FF33CC','CC6699','CC0099','990066',
'FFCCFF','FF99FF','FF66FF','FF33FF','FF00FF','CC3399',
'CC99CC','CC66CC','CC00CC','CC33CC','990099','993399',
'CC66FF','CC33FF','CC00FF','9900CC','996699','660066',
'CC99FF','9933CC','9933FF','9900FF','660099','663366',
'9966CC','9966FF','6600CC','6633CC','663399','330033',
'CCCCFF','9999FF','6633FF','6600FF','330099','330066',
'9999CC','6666FF','6666CC','666699','333399','333366',
'3333FF','3300FF','3300CC','3333CC','000099','000066',
'6699FF','3366FF','0000FF','0000CC','0033CC','000033',
'0066FF','0066CC','3366CC','0033FF','003399','003366',
'99CCFF','3399FF','0099FF','6699CC','336699','006699',
'66CCFF','33CCFF','00CCFF','3399CC','0099CC','003333',
'99CCCC','66CCCC','339999','669999','006666','336666',
'CCFFFF','99FFFF','66FFFF','33FFFF','00FFFF','00CCCC',
'99FFCC','66FFCC','33FFCC','00FFCC','33CCCC','009999',
'66CC99','33CC99','00CC99','339966','009966','006633',
'66FF99','33FF99','00FF99','33CC66','00CC66','009933',
'99FF99','66FF66','33FF66','00FF66','339933','006600',
'CCFFCC','99CC99','66CC66','669966','336633','003300',
'33FF33','00FF33','00FF00','00CC00','33CC33','00CC33',
'66FF00','66FF33','33FF00','33CC00','339900','009900',
'CCFF99','99FF66','66CC00','66CC33','669933','336600',
'99FF00','99FF33','99CC66','99CC00','99CC33','669900',
'CCFF66','CCFF00','CCFF33','CCCC99','666633','333300',
'CCCC66','CCCC33','999966','999933','999900','666600',
'FFFFFF','CCCCCC','999999','666666','333333','000000'];
		
	// Option defaults
    options = $.extend({
        defaultColor:  this.attr('defaultColor') || '#FFF',
        border:        this.attr('border') || '1px solid #b2c4c8',
        cellWidth:     this.attr('cellWidth') || 24,
        cellHeight:    this.attr('cellHeight') || 10,
        cellMargin:    this.attr('cellMargin') || 0,
        boxWidth:      this.attr('boxWidth') || '129px',
        boxHeight:     this.attr('boxHeight') || '18px',
        columns:       this.attr('columns') || 6,
        insert:        this.attr('insert') || 'after',
        buttonClass:   this.attr('buttonClass') || '',
        colors:        this.attr('colors') || default_colors,
        indicator:     this.attr('indicator') || null
    }, options || {});
	
	// Hide the input
	this.hide();
	
	// Figure out the cell dimensions
	options.totalWidth = options.columns * (options.cellWidth + (2 * options.cellMargin));
	if ($.browser.msie) {
		options.totalWidth += 2;
	}
	
	options.totalHeight = Math.ceil(options.colors.length / options.columns) * (options.cellHeight + (2 * options.cellMargin));
	
	// Store these options so they'll be available to the other functions
	// TODO - must be a better way to do this, not sure what the 'official'
	// jQuery method is. Ideally i want to pass these as a parameter to the 
	// each() function but i'm not sure how
	$.simpleColorOptions = options;
	
	this.each(buildSelector);
	
	return this;
	
	
	
	function buildSelector(index) {
		
		var options = $.simpleColorOptions;
		
		// Create a container to hold everything
		var container = $("<div class='simpleColorContainer' />");
		
		// Create the color display box
		var default_color = (this.value && this.value != '') ? this.value : options.defaultColor;

		default_color =  '#' + default_color;//Изменение(1) так как в value у нас без #

		var display_box = $("<div class='simpleColorDisplay' />");
		display_box.css('backgroundColor', default_color);
		display_box.css('border',          options.border);
		display_box.css('width',           options.boxWidth);
		display_box.css('height',          options.boxHeight);
		display_box.text("FFFFFF");
		container.append(display_box);
		
		// Create the select button 
		var select_button = $("<input type='button' value='Выбрать'" + 
							  " class='simpleColorSelectButton "+options.buttonClass+"'>");
		container.append(select_button);
		
		// Create the cancel button
		var cancel_button = $("<input type='button' value='Закрыть'" + 
							  " class='simpleColorCancelButton "+options.buttonClass+"'>");
		cancel_button.hide();
		container.append(cancel_button);
		
		// Bind the select button to display the chooser
		select_button.bind('click', {
				container: container, 
				input: this, 
				cancel_button: cancel_button, 
				display_box: display_box}, 
			function (event) {
				$(this).hide();
				event.data.cancel_button.show();
				
				// Use an existing chooser if there is one
				if (event.data.container.chooser) {
					event.data.container.chooser.show();
					
				// Build the chooser
				} else {
		
					// Make a chooser div to hold the cells
					var chooser = $("<div class='simpleColorChooser'/>");
					chooser.css('border',  options.border);
					chooser.css('margin',  '0px');
					chooser.css('margin-top',  '3px');
					chooser.css('width',   options.totalWidth + 'px');
					chooser.css('height',  options.totalHeight + 'px');
					
					event.data.container.chooser = chooser;
					event.data.container.append(chooser);
					
					// Create the cells
					for (var i=0; i<options.colors.length; i++) {
						var cell = $("<div class='simpleColorCell' id='" + options.colors[i] + "'/>");
						cell.css('width',           options.cellWidth + 'px');
						cell.css('height',          options.cellHeight + 'px');
						cell.css('margin',          options.cellMargin + 'px');
						cell.css('cursor',          'pointer');
						cell.css('lineHeight',      options.cellHeight + 'px');
						cell.css('fontSize',        '1px');
						cell.css('float',           'left');
						cell.css('backgroundColor', '#'+options.colors[i]);
						chooser.append(cell);
						
						cell.bind('click', {
								input: event.data.input, 
								chooser: chooser, 
								select_button: select_button, 
								cancel_button: cancel_button, 
								display_box: display_box}, 
							function(event) {
								event.data.input.value = '' + this.id;
								event.data.display_box.css('backgroundColor', '#' + this.id);
								event.data.display_box.text(this.id);
								event.data.chooser.hide();
								event.data.cancel_button.hide();
								event.data.display_box.show();
								event.data.select_button.show();
							}
						);
					}
				}
			}
		);
		
		// Bind the cancel button to hide the chooser
		cancel_button.bind('click', {
				container: container, 
				select_button: select_button, 
				display_box: display_box}, 
			function (event) {
				$(this).hide();
				event.data.container.find('.simpleColorChooser').hide();
				event.data.display_box.show();
				event.data.select_button.show();
			}
		);
		
		$(this).after(container);
		
	};
};
	
/*
 * Close the given color selectors
 */
$.fn.closeSelector = function() {
	this.each( function(index) {
		var container = $(this).parent().find('div.simpleColorContainer');
		container.find('.simpleColorCancelButton').hide();
		container.find('.simpleColorChooser').hide();
		container.find('.simpleColorDisplay').show();
		container.find('.simpleColorSelectButton').show();
	});
	
	return this;
}
	
	
	


})(jQuery);
