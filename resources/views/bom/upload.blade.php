@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'BOM  Upload'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            
            {{-- Global Validation / Flash Status Messages --}}
            @if(session('error'))
                <div class="alert alert-danger text-white alert-dismissible fade show mx-4" role="alert">
                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-text"><strong>Error!</strong> {{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('bom.upload.save') }}" method="POST" id="bulk_upload_form" enctype="multipart/form-data">
                @csrf
                
                {{-- If your method requires a project_id context, pass it here --}}
                <input type="hidden" name="project_id" value="{{ $project_id ?? 1 }}">

                <div class="card card-frame mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0">BOM Spreadsheet  Upload</h5>
                                <p class="text-sm mb-0">Upload bulk material requirements details directly to production allocations.</p>
                            </div>
                            <a href="javascript:history.back()" class="btn btn-sm btn-secondary mb-0">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                        </div>
                    </div>
                    
                    <hr class="horizontal dark my-3">

                    <div class="card-body pt-0">
                        <div class="row align-items-center">
                            
                            {{-- Instructions Column --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold text-dark">1. Download Template Structure</label>
                                    <p class="text-xs text-secondary">Use our standardized template columns to avoid ingestion and parsing mismatch failures during processing.</p>
                                    <a href="{{ asset('assets/sample/BOM_REV_1_test.xlsx') }}" class="btn btn-sm btn-outline-primary" download>
                                        <i class="fas fa-download me-2"></i>Download Sample Format
                                    </a>
                                </div>
                            </div>

                            {{-- File Drop Area Column --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="mb-3">
                                    <label for="bom_file" class="form-label font-weight-bold text-dark">2. Choose Your Spreadsheet Document</label>
                                    <input class="form-control @error('bom_file') is-invalid @enderror" type="file" id="bom_file" name="bom_file" accept=".xlsx,.xls,.csv">
                                    
                                    @error('bom_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @error('project_id')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Form Control Buttons --}}
                    <div class="card-footer bg-gray-100 border-top-0 d-flex justify-content-end py-3">
                        <a href="javascript:history.back()" class="btn btn-light mb-0 me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary mb-0">Upload & Verify BOM</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection