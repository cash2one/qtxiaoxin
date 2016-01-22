/**
 *
 * @authors H君 (you@example.org)
 * @date    2014-11-06 17:37:57
 * @version $Id$
 */

var tmpLibrary = {
	initTmp: function(url) {
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'html',
			data: {}
		}).done(function(data) {
			if (data) {
				$('#msgTmp').html(data)
				showPromptsRemind('#msgTmpBox');
				tmpLibrary.tmpEvent();

			};

		})
	},
	tmpEvent: function() {
		var msgBox = $('#msgTmpBox');
		msgBox.on('click', 'a', function(event) {
			var _left = $(this),
				action = _left.data('action');
			if (action === 'diy') {
				$('.msgGiy').show();
				$('.msgSystem').hide();
				$(this).addClass('focus').parent().siblings().find('a').removeClass('focus');
			} else if (action === 'system') {
				$('.msgGiy').hide();
				$('.msgSystem').show();
				$(this).addClass('focus').parent().siblings().find('a').removeClass('focus');
			};;
		});
		msgBox.on('click', '.msgUl li a.delBtn', function(event) {
			var id = $(this).attr('sid');
			var url = $(this).data('url');
			var rm = $(this).parent().parent();
			var ulP=$(this).parents('ul');
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'JSON',
				data: {
					id: id
				}
			}).done(function(data) {
				if (data) {
					if (data.status == 1) {
						rm.remove();
						var liLen=ulP.find('li.msgLi').length;
						ulP.next().find('span').text(liLen);
						if (liLen == 0) {
							ulP.find('.noMsg').show().removeClass('high');
						};
					};
				};

			})

		});
		msgBox.on('click', '.msgUl li a.useBtn', function(event) {
			var val = $(this).parent().prev().text();
			$('#textareaCont').val(val);
			$('#textareaCont').keydown();
			hidePormptMaskWeb('#msgTmpBox');


		});

		msgBox.find('.msgGiy ul li:odd').addClass('high');
		msgBox.find('.msgSystem ul li:odd').addClass('high');
	}

}