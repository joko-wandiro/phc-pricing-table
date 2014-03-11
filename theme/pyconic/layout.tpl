<!-- Based on Pyconic Pricing Table -->
<li class="{feature_class}" style="min-width: {li_width}">
<div class="header-title">
<h2>{title}</h2>
</div>
<div class="description">
<p>{detail}</p>
</div>
<div class="feature">
	<ul>
	{loop}
	<li>{item}</li>
	{/loop}
	</ul>
</div>
<div class="description">
	<div class="buy">
	<sup class="currency">{currency}</sup><span class="price">{price}</span>
	<span class="price_per">/{price_per}</span>
	<a class="addtocart" href="{button_url}">{button_text}</a>
	</div>
</div>
</li>