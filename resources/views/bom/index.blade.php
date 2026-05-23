@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'BOM Line Items Management'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success text-white">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="card mb-4">
            <div class="card-header pb-0 p-3">
                <div class="row align-items-center">
                    <div class="col-6 d-flex align-items-center gap-3">
                        <h6 class="mb-0">BOM Line Items</h6>
                        <!-- Permanent Read-Only Immutable Badge Record Flag -->
                        <span class="badge bg-gradient-secondary text-xxs px-3 py-2 rounded-pill shadow-sm">
                            <i class="fas fa-lock me-1"></i> Read-Only Record
                        </span>
                    </div>
                    <div class="col-6 text-end">
                        <a class="btn bg-gradient-light mb-0" href="{{ route('bom.upload') }}">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;File Upload
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body px-0 pt-0 pb-2">
                <hr class="horizontal dark">
                

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="table_format">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Header ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Item Code</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Required Qty</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">UOM</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Allocated To</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lineItems as $item)
                            <tr class="bg-hover-neutral">
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <h6 class="mb-0 text-sm text-secondary">{{ $item->id }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0 text-secondary">#{{ $item->bom_header_id }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0 text-dark">{{ $item->item_code }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0 text-dark">
                                        {{ $item->description ?? 'N/A' }}
                                        @if($item->specification)
                                        <br><small class="text-secondary text-xs font-weight-normal">{{ $item->specification }}</small>
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0 text-dark">{{ $item->required_qty }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0 text-secondary">{{ $item->uom }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0 text-dark">
                                        {{ $item->allocated_to ?? 'Unallocated' }}
                                    </p>
                                </td>
                                <td class="align-middle text-center">
                                    @if($item->status === 'in_stock')
                                    <span class="text-sm font-weight-bold text-success">
                                        ✅ In Stock
                                    </span>
                                    @elseif($item->status === 'partial_stock')
                                    <span class="text-sm font-weight-bold text-warning">
                                        ⚠️ Partial Stock
                                    </span>
                                    @else
                                    <span class="text-sm font-weight-bold text-danger">
                                        ❌ Out of Stock
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#table_format').DataTable({
            "ordering": true,
            "info": true,
            "lengthChange": false,
            "sDom": 'ltipr'
        });
    });
</script>
@endpush