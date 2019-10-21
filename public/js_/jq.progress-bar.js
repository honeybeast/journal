/*
	jQuery Plugin
	Name: Collapsible Progress Bar
	Version: 0.9
	Description: Uses Twitter Bootstrap 3.0 styling to present an accessible, simple progress bar for a web form, with customizable messages of encouragement.
	Dependencies: Bootstrap 3.0 (http://getbootstrap.com/), Font Awesome 4.0.3 (http://fortawesome.github.io/Font-Awesome/), jQuery 1.10.2 or later (http://jquery.com/)
	Author: Joshua Blackwood
	Copyright: 2013-2014 Joshua Blackwood under the MIT License (http://opensource.org/licenses/MIT)
 */

(function($) {

	$.fn.showProgress = function(options) {

		var defaults = {
			message: {
				'25': 'You\'re doing great so far!',
				'50': 'You\'re halfway there!',
				'75': 'Look at that, you\'re nearly done already!',
				'100': 'All done! Just click <strong>Submit</strong> to continue!'
			},
			position: 'top'
		};

		options = $.extend(defaults, options);

		var markup = '<!-- Progress Bar --><div class="navbar navbar-default navbar-fixed-'+ options.position +'" id="progress-bar-wrap"><div class="container"><h4>Completion Progress <small class="encouragement"></small><button type="button" class="close" data-dismiss="progress-bar" aria-hidden="true" title="Collapse"><span class="sr-only">Collapse</span></button></h4><div class="progress"><div id="form-progress" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">0% Complete</span></div></div></div></div> <!-- /progress bar -->';

		$('body').append(markup);

		var dismiss = $('button[data-dismiss="progress-bar"]'),
        radioSiblings = $(this).find('input[type=radio][required], input[type=radio].required').parents('label').siblings().children('input[type=radio]'),
			  input = $(this).find('input[required], select[required], textarea[required], input.required, select.required, textarea.required').add(radioSiblings),
			  magicNumber = 100 / (input.length - radioSiblings.length),
			  pbw = $('#progress-bar-wrap');

		dismiss.on('click', function() {
			pbw.toggleClass('collapsed', 300);
		});

		input.data('progress', '0');
    
		input.change(function(){

			var $this = $(this),
				progressBar = $('#form-progress'),
				srText = $('#form-progress > span'),
				avn = progressBar.attr('aria-valuenow'),
				hasProgress = $this.data('progress'),
				siblingInput = $this.parents('label').siblings().children('input'),
				siblingName = siblingInput.attr('name'),
				encouragement = $('.encouragement');

			if (pbw.not(':visible')) {
				pbw.show(300);
			}

			if (hasProgress == '0') {
				if ($this.attr('name') == siblingName) {
					siblingInput.data('progress', '1');
				}
				avnMath = parseFloat(avn) + parseFloat(magicNumber);
				updateAVN = avnMath.toFixed(3);
				pbWidth = updateAVN;
				progressBar.width(pbWidth + '%');
				progressBar.attr('aria-valuenow', updateAVN);
				srText.text(updateAVN + '% Complete');
				$this.data('progress', '1');
				console.log('AVN is: ' + updateAVN);
			} else if (! $this.val() ) { // If the field value is emptied, we need to remove that progress.
				$this.data('progress', '0');
				avnMath = parseFloat(avn) - parseFloat(magicNumber);
				updateAVN = avnMath.toFixed(2);
				pbWidth = updateAVN;
				progressBar.width(pbWidth + '%');
				progressBar.attr('aria-valuenow', updateAVN);
				srText.text(updateAVN + '% Complete');
				console.log('AVN is: ' + updateAVN);
			}
			
			for (var key in options.message) {
				keyMatch = parseFloat(key - 5.00);
				var value = options.message[key];
				if (encouragement.not(':visible')) {
					encouragement.show(300);
				}
				if (updateAVN >= keyMatch) {
					encouragement.html(value);
					console.log(key + ' : ' + value);
				}
			}

		});
	};

})(jQuery);