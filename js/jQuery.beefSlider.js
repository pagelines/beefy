(function($)
{
	$.fn.beefSlider=function(hover,unhover,click)
	{
		var el=this,
			inner=$(el).find('.beefSliderInner'),
			list=$(el).find('ul'),
			items=$(el).find('li'),
			itemWidth=0,
			width=0,
			offset=$(el).offset().left,
			offsetWidth=$(el).width(),
			move=true,
			animating=false,
			target=0;
			slide=function()
		{
			if(move)
			{
				var left=parseInt(list.css('margin-left'));
				list.css('margin-left',left-1);
				if(left<=-itemWidth)
				{
					list.css('margin-left',left+itemWidth);
					list.find('li:first').appendTo(list);
				}
				setTimeout(slide,22)
			}
		}
		
		items.each(function()
		{
			itemWidth=$(this).outerWidth(true);
			width+=$(this).outerWidth(true);
		});
		
		width+=parseInt(inner.css('border-left-width'))
				+parseInt(inner.css('border-right-width'))
				+parseInt(inner.css('padding-left'))
					+parseInt(inner.css('padding-right'));
		
		$(inner).css('width',width);
		
		
		items.hover(hover,unhover);
		items.mousedown(click);
		
		$(el).hover(function(){move=false;},function(){move=true;setTimeout(slide,30);});
		
		$(el).mouseenter(function(e)
		{
			var pos=parseInt((e.pageX-offset)/offsetWidth*(items.length-(offsetWidth/itemWidth)));
			var margin=parseInt(list.css('margin-left'));
			target=-((e.pageX-offset)/offsetWidth*(width-offsetWidth));
			for(var i=0;i<pos;++i)
			{
				list.find('li:last').prependTo(list);
				margin-=itemWidth;
			}
			list.css('margin-left',margin);
			list.animate({'margin-left':target},
			{
				duration:100,
				step:function(now,fx){fx.end=target;},
				complete:function(){animating=false;}
			});
			animating=true;
		});
		
		$(el).mousemove(function(e)
		{
			if(animating) return;
			target=-((e.pageX-offset)/offsetWidth*(width-offsetWidth));
			list.css('margin-left',target);
		});
		
		setTimeout(slide,30)
	}
}) (jQuery);