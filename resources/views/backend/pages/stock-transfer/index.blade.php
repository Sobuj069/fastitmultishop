@extends('backend.layouts.master')
@section('section-title', __('Stock Transfer'))
@section('page-title', __('Transfer List'))
@if (check_permission('transfer.create'))
    @section('action-button')
        <a href="{{ route('transfer.create') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            {{ __('Add Stock Transfer') }}
        </a>
    @endsection
@endif
@push('css')
    <style>
        @media print {

            table,
            table th,
            table td {
                color: black !important;
            }

            .h-hide {
                display: none;
            }
        }

        .table-responsive {
            overflow-x: auto;
            min-height: 250px;
        }

        @media (min-width: 992px) {
            .table-responsive {
                overflow: visible !important;
            }
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form action="{{ route('transfer.index') }}" method="GET">
                        <div class="row h-hide">
                            <div class="col-md-3 col-12 mt-2">
                                <label class="form-label font-weight-bold mb-1">{{ __('Start Date') }}</label>
                                <input type="date" class="form-control" name="startDate" value="{{ $startDate ?? '' }}" />
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                <label class="form-label font-weight-bold mb-1">{{ __('End Date') }}</label>
                                <input type="date" class="form-control" name="endDate" value="{{ $endDate ?? '' }}" />
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                <label class="form-label font-weight-bold mb-1">{{ __('Search') }}</label>
                                <input type="text" placeholder="{{ __('Scan Barcode / Transfer No') }}" name="barcode"
                                    value="{{ $barcode ?? ($invoice_no ?? '') }}" class="form-control barcode-filter-input" data-barcode-input>
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                <label class="form-label font-weight-bold mb-1">{{ __('Product') }}</label>
                                <select name="product_id" id="product_id" class="select2 form-control">
                                    <option value="">{{ __('Select Product') }}</option>
                                    @foreach ($products as $item)
                                        <option value="{{ $item->id }}" {{ ($product_id ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} @if(!empty($item->barcode)) ({{ $item->barcode }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row h-hide">
                            <div class="col-md-3 col-12 mt-2">
                                <label class="form-label font-weight-bold mb-1">{{ __('Status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="">{{ __('All Statuses') }}</option>
                                    <option value="0" {{ isset($status) && (string)$status === '0' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="1" {{ isset($status) && (string)$status === '1' ? 'selected' : '' }}>{{ __('Received') }}</option>
                                    <option value="2" {{ isset($status) && (string)$status === '2' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                </select>
                            </div>
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->role_id == 1)
                            <div class="col-md-3 col-12 mt-2">
                                <label class="form-label font-weight-bold mb-1">{{ __('From Branch') }}</label>
                                <select name="from_branch_id" class="form-control">
                                    <option value="">{{ __('All Branches') }}</option>
                                    @foreach ($branches ?? [] as $b)
                                        <option value="{{ $b->id }}" {{ ($from_branch_id ?? '') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                <label class="form-label font-weight-bold mb-1">{{ __('To Branch') }}</label>
                                <select name="to_branch_id" class="form-control">
                                    <option value="">{{ __('All Branches') }}</option>
                                    @foreach ($branches ?? [] as $b)
                                        <option value="{{ $b->id }}" {{ ($to_branch_id ?? '') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-12 mt-2 d-flex align-items-end">
                                <button type="submit" class="btn add_list_btn mr-2">{{ __('Filter') }}</button>
                                <a href="{{ route('transfer.index') }}" class="btn add_list_btn_reset mr-2">{{ __('Reset') }}</a>
                                <a href="javascript:void(0);" class="btn add_list_btn ml-auto" onclick="window.print()">{{ __('Print') }}</a>
                            </div>
                            @else
                            <div class="col-md-9 col-12 mt-2 d-flex align-items-end">
                                <button type="submit" class="btn add_list_btn mr-2">{{ __('Filter') }}</button>
                                <a href="{{ route('transfer.index') }}" class="btn add_list_btn_reset mr-2">{{ __('Reset') }}</a>
                                <a href="javascript:void(0);" class="btn add_list_btn ml-auto" onclick="window.print()">{{ __('Print') }}</a>
                            </div>
                            @endif
                        </div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead class="header_bg">
                                <tr class="text-center">
                                    <th class="header_style_left"> {{ __('SL#') }} </th>
                                    <th> {{ __('Date') }} </th>
                                    <th> {{ __('Transfer No') }} </th>
                                    <th> {{ __('From') }} </th>
                                    <th> {{ __('To') }} </th>
                                    <th> {{ __('Product Item(s)') }} </th>
                                    <th> {{ __('Status') }} </th>
                                    <th> {{ __('Create By') }} </th>
                                    <th class="header_style_right"> {{ __('Action') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transfers as $key => $data)
                                    @php
                                        $userBranchId = auth()->user()->branch_id;
                                        $filterBranchId = session('branch_filter_id', auth()->user()->branch_id);
                                        $receive = false;
                                        $cancel = false;
                                        if ($userBranchId == 1) {
                                            if ($filterBranchId) {
                                                if (
                                                    $filterBranchId == $data->to_branch_id ||
                                                    $filterBranchId == $data->from_branch_id
                                                ) {
                                                    $receive = true;
                                                    $cancel = true;
                                                }
                                            } else {
                                                $receive = true;
                                                $cancel = true;
                                            }
                                        } else {
                                            if ($userBranchId == $data->to_branch_id) {
                                                $receive = true;
                                                $cancel = true;
                                            }
                                            if ($userBranchId == $data->from_branch_id) {
                                                $cancel = true;
                                            }
                                        }
                                    @endphp
                                    <tr class="text-center">
                                        <td class="table_data_style_left">{{ $transfers->firstItem() + $key }}</td>
                                        <td>{{ $data->date }}</td>
                                        <td><strong>{{ $data->transfer_no }}</strong></td>
                                        <td>{{ $data->fromBranch?->name ?? 'N/A' }}</td>
                                        <td>{{ $data->toBranch?->name ?? 'N/A' }}</td>
                                        <td class="text-left">
                                            @foreach ($data->transferItems as $item)
                                                <div class="mb-1">
                                                    <strong>{{ $item->product?->name }}</strong>
                                                    @if($item->product_variation_id != null && $item->product_variation)
                                                        <span class="badge badge-info" style="font-size: 11px;">
                                                            {{ $item->product_variation->color?->color ?? '' }} {{ $item->product_variation->size?->size ? '- '.$item->product_variation->size->size : '' }}
                                                        </span>
                                                    @endif
                                                    <span class="text-muted">
                                                        (@if ($item->product?->unit?->related_unit == null)
                                                            {{ $item->main_qty . ' ' . ($item->product?->unit?->name ?? 'pcs') }}
                                                        @else
                                                            {{ $item->main_qty . ' ' . ($item->product->unit->name ?? '') . ' ' . $item->sub_qty . ' ' . ($item->product->unit->related_unit->name ?? '') }}
                                                        @endif)
                                                    </span>
                                                    @if(!empty($item->imei))
                                                        <br><small class="text-muted"><i class="fa fa-barcode"></i> {{ $item->imei }}</small>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($data->status == 0)
                                                <span class="badge bg-info">{{ __('Pending') }}</span>
                                            @elseif($data->status == 1)
                                                <span class="badge bg-success">{{ __('Receive') }}</span>
                                            @elseif($data->status == 2)
                                                <span class="badge bg-danger">{{ __('Cancel') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $data->user?->name }}</td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    {{ __('Action') }}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ route('transfer.print', $data->id) }}"
                                                        class="btn btn-success-rgba">
                                                        <i class="feather icon-printer"></i> {{ __('Print') }}
                                                    </a>
                                                    @if ($data->status == 0)
                                                        @if ($receive)
                                                            <form action="{{ route('transfer.receive', $data->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item btn">
                                                                    <i class="fa fa-envelope-open"></i> {{ __('Receive') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                    @if ($data->status == 0)
                                                        @if ($cancel)
                                                        <form action="{{ route('transfer.cancel', $data->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item btn">
                                                                    <i class="fa fa-times"></i> {{ __('Cancel') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                    
                                                    {{-- delete --}}
                                                    @if (check_permission('transfer.destroy'))
                                                        <a href="#" class="dropdown-item" data-toggle="modal"
                                                            data-target="#deleteModal-{{ $data->id }}"
                                                            class="btn btn-danger-rgba">
                                                            <i class="feather icon-trash"></i> {{ __('Delete') }}
                                                        </a>
                                                        {{-- @endif --}}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- delete modal --}}
                                    <form action="{{ route('transfer.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="{{ __('Stock Transfer') }}" id="{{ $data->id }}" />
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-danger no_data_style">{{ __('No Data Found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $transfers->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
