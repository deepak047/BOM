@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Material Allocation Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Material Allocations</h6>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">BOM Ref</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Item Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Allocated Qty</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Allocated To</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Allocated By</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Allocated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allocations as $allocation)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <h6 class="mb-0 text-sm">{{ $allocation->id }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $allocation->bom_reference }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $allocation->item_code }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $allocation->description }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">{{ $allocation->allocated_qty }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">
                                            <i class="fas fa-user-tag text-xs me-1 text-secondary"></i>
                                            {{ $allocation->allocated_to }}
                                        </p>
                                    </td>
                                    <td>
                                        @if(str_contains($allocation->allocated_by, 'system'))
                                            <span class="badge badge-sm bg-gradient-secondary">
                                                <i class="fas fa-robot me-1"></i>{{ $allocation->allocated_by }}
                                            </span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-dark">
                                                <i class="fas fa-user me-1"></i>{{ $allocation->allocated_by }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $allocation->created_at->format('Y-m-d H:i') }}</p>
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