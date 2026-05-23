<p>Dear Team,</p>

<p>Material has been allocated to your department:</p>

<ul> 
    <li><strong>Item Code:</strong> {{ $allocation->item_code }}</li> 
    <li><strong>Description:</strong> {{ $allocation->description ?? 'No description provided' }}</li> 
    <li><strong>Allocated To:</strong> {{ $allocation->allocated_to }}</li> 
    <li><strong>Quantity:</strong> {{ $allocation->allocated_qty }}</li>
</ul>

<!-- Safely points to your main material allocations view table page -->
<a href="{{ route('material_allocations.index') }}" style="display: inline-block; padding: 10px 20px; color: #ffffff; background-color: #5e72e4; border-radius: 4px; text-decoration: none; font-weight: bold;">
    View Allocations Ledger
</a>

<p style="margin-top: 20px; font-size: 0.9em; color: #888888;">Generated automatically by the system.</p>