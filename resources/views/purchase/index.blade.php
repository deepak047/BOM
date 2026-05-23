@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Purchase Intent Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Purchase Intents</h6>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Required</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Available</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Shortfall</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Priority</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Raised</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($intents as $intent)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <h6 class="mb-0 text-sm">{{ $intent->id }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $intent->bom_reference }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $intent->item_code }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">
                                            {{ $intent->description }}
                                            @if($intent->specification)
                                                <br><small class="text-secondary text-xs">{{ $intent->specification }}</small>
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-info">{{ $intent->required_qty }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-success">{{ $intent->available_qty }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-danger">{{ $intent->shortfall_qty }}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm @if($intent->priority == 'high') bg-gradient-danger @elseif($intent->priority == 'medium') bg-gradient-warning @else bg-gradient-secondary @endif">
                                            {{ ucfirst($intent->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm @if($intent->status == 'po_raised') bg-gradient-success @elseif($intent->status == 'acknowledged') bg-gradient-info @else bg-gradient-light text-dark @endif">
                                            {{ str_replace('_', ' ', ucfirst($intent->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($intent->date_raised)->format('Y-m-d H:i') }}</p>
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