<!-- Based on Sort Pricing Table -->
<li class="{feature_class}" style="min-width: {li_width}">
<h2>{title}</h2>
<div class="price"><span class="currency">{currency}</span>{price}<span class="price_per">/{price_per}<span></div>
<div class="details">
<p>{detail}</p>
</div>
<ul>
{loop}
<li>{item}</li>
{/loop}
</ul>
<div class="button">
<a href="{button_url}">{button_text}</a>
</div>
</li>