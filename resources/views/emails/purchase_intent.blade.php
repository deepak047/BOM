<p>Dear Purchase Department,</p>

<p>A new purchase intent has been raised:</p>

<ul> 
    <li>BOM Reference: <strong>{{ $intent->bom_reference }}</strong></li> 
    <li>Item Code: <strong>{{ $intent->item_code }}</strong></li> 
    <li>Description: {{ $intent->description }}</li> 
    <li>Shortfall: <strong>{{ $intent->shortfall_qty }} {{ $intent->bomHeader->bom_line_unit ?? '' }}</strong></li>
</ul>

<div style="margin-top: 20px; margin-bottom: 20px;">
    <a href="{{ route('purchase_intents.index') }}" style="background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;">
        View Purchase Intent
    </a>
</div>

<p style="color: #666; font-size: 12px;">Generated automatically by the system.</p>