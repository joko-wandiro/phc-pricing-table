<!-- Based on Shopify Pricing Table -->
<li class="{feature_class}" style="min-width: {li_width}">
<div class="price"><span class="currency">{currency}</span>{price}<span class="price_per">/{price_per}<span></div>
<h2>{title}</h2>
<div class="details">
<p>{detail}</p>
</div>
<div class="button">
<a href="{button_url}">{button_text}</a>
</div>
<ul>
{loop}
<li>{item}</li>
{/loop}
</ul>
</li>