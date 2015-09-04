(function($)
{
	$.Redactor.prototype.definedlinks = function()
	{
		return {
			init: function()
			{
				if (!this.opts.definedLinks) return;

				this.modal.addCallback('link', $.proxy(this.definedlinks.load, this));

			},
			load: function()
			{
				var $select = $('<select id="redactor-defined-links" />');
				$select.append($('<option value="">---</option>'));

				var $input = $('#redactor-link-url');

				$('#redactor-modal-link-insert').prepend($select);

				this.definedlinks.formOptions = $select;
				this.definedlinks.formUrl = $input;
				this.definedlinks.formName = $('#redactor-link-url-text');
				this.definedlinks.storage = {};

				$.getJSON(this.opts.definedLinks, $.proxy(function(data)
				{
					$.each(data, $.proxy(function(key, val)
					{
						this.definedlinks.storage[key] = val;
						$select.append($('<option>').val(key).html(val.name));

					}, this));

					$input.on('keyup', $.proxy(this.definedlinks.change, this)).trigger('keyup');
					$select.on('change', $.proxy(this.definedlinks.select, this));
				}, this));
			},
			select: function(e)
			{
				var key = $(e.target).val();
				var name = '', url = '';

				if (key !== 0)
				{
					name = this.definedlinks.storage[key].name;
					url = this.definedlinks.storage[key].url;
				}

				this.definedlinks.formUrl.val(url);

				var $el = $('#redactor-link-url-text');
				if (this.definedlinks.formName.val() === '') this.definedlinks.formName.val(name);
			},
			change: function(e)
			{
				var url = $(e.target).val();
				var found = false;

				for (key in this.definedlinks.storage)
				{
					if (this.definedlinks.storage[key].url == url)
					{
						this.definedlinks.formOptions.val(key);

						return;
					}
				}

				if (found === false) this.definedlinks.formOptions.val('');
			}
		};
	};
})(jQuery);
