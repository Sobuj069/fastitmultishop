@extends('backend.layouts.master')
@section('page-title', 'Invoice Exchange')

@push('css')
    <style>
        .invoice-contentbar {
            margin: 0 !important;
            padding: 20px;
            margin-bottom: 60px;
        }

        .cart-container {
            padding-top: 5px !important;
        }

        .table-responsive {
            margin-bottom: 4px !important;
        }

        .footerpos {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .footerpos .footerpos_left {
            background-color: #000ce2 !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 12px 10px; 
            border-top-left-radius: 35px;
            border-bottom-left-radius: 35px;
        }

        .footerpos .footerpos_left div {
            font-size: 25px;
            color: #fff;
        }

        .footerpos_right {
            background-color: #00a65a !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 12px 10px;
            border-top-right-radius: 35px;
            border-bottom-right-radius: 35px;
        }

        .footerpos_right div {
            font-size: 25px;
            color: #fff;
            cursor: pointer;
        }

        .productcss {
            border: 1px solid #DDD;
            cursor: pointer;
            padding-bottom: 30px;
            height: 262px;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* ======= DARK MODE OVERRIDES ======= */
        body.dark-theme .rightbar,
        body.dark-theme #containerbar,
        body.dark-theme .invoice-contentbar {
            background-color: #0d1220 !important;
            color: #f1f5f9 !important;
        }

        body.dark-theme .invoice-contentbar .card.card_top, 
        body.dark-theme .invoice-contentbar .card {
            background-color: #121829 !important;
            border: 1px solid #1e293b !important;
        }

        body.dark-theme .cart-search-header,
        body.dark-theme .cart-head,
        body.dark-theme .cart-container {
            background: transparent !important;
        }

        body.dark-theme .form-control {
            background-color: #1a2035 !important;
            border-color: #2e3856 !important;
            color: #ffffff !important;
        }

        body.dark-theme .form-control:focus {
            background-color: #1a2035 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }

        body.dark-theme .table tbody td input.form-control,
        body.dark-theme .table tbody td select.form-control,
        body.dark-theme .table tbody td textarea.form-control {
            color: #f8fafc !important;
            background-color: #1e293b !important;
            border-color: #475569 !important;
        }

        body.dark-theme .table tbody td input.form-control[readonly],
        body.dark-theme .table tbody td input.form-control[disabled],
        body.dark-theme .table tbody td textarea.form-control[readonly],
        body.dark-theme .table tbody td textarea.form-control[disabled] {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #38bdf8 !important;
        }

        body.dark-theme .table tbody td .input-group-text {
            background-color: #334155 !important;
            color: #cbd5e1 !important;
            border-color: #475569 !important;
        }

        body.dark-theme tbody tr {
            background: #2d3748 !important;
            color: #e2e8f0 !important;
        }

        body.dark-theme tbody tr td {
            color: #e2e8f0 !important;
            border-color: #4a5568 !important;
        }

        body.dark-theme .table-striped tbody tr:nth-of-type(odd) {
            background: #263044 !important;
        }

        body.dark-theme .bg-light-primary {
            background-color: #182235 !important;
            color: #f1f5f9 !important;
        }

        body.dark-theme .bg-light-primary td {
            color: #f1f5f9 !important;
        }

        body.dark-theme .bg-light-primary .form-control {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #38bdf8 !important;
        }

        body.dark-theme .text-dark {
            color: #f1f5f9 !important;
        }

        body.dark-theme .input-group-prepend .input-group-text {
            background-color: #1e293b !important;
            border-color: #2e3856 !important;
            color: #cbd5e1 !important;
        }

        body.dark-theme .input-group-prepend .barcod_style {
            background-color: #1e293b !important;
            border-color: #2e3856 !important;
            color: #cbd5e1 !important;
        }

        body.dark-theme .table tfoot tr {
            background-color: #121829 !important;
            color: #f1f5f9 !important;
        }

        body.dark-theme .table tfoot tr td {
            color: #f1f5f9 !important;
            border-color: #1e293b !important;
        }

        body.dark-theme .footerpos .footerpos_left {
            background-color: #1c2b5c !important;
        }

        body.dark-theme .footerpos_right {
            background-color: #0a693c !important;
        }

        .table tbody tr td,
        .table tbody tr td:first-child,
        .table tbody tr td:last-child,
        .table_data_style_left,
        .table_data_style_right {
            border-radius: 0px !important;
        }
    </style>
@endpush

@section('invoice')
    <div class="invoice-contentbar">
        <div class="row">
            <!-- Start col -->
            <div class="col-md-12">
                <div class="card card_top">
                    <form action="{{ route('invoice.ex.update') }}" id="" method="POST">
                        @csrf
                        <div class="cart-container">
                            <div class="cart-head">
                                <div class="input-group text-dark">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text barcod_style" id="basic-addon1">Selling Date :</span>
                                    </div>
                                    <input type="date" class="form-control" id="" readonly value="{{ $invoice->date }}"
                                        name="date">
                                </div>
                                <hr>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text barcod_style" id="basic-addon1"><i
                                                class="fa fa-barcode"></i></span>
                                    </div>
                                    <input type="text" id="product_search" class="form-control"
                                        placeholder="Type & Barcode" aria-label="Type & Barcode"
                                        onkeydown="return event.keyCode !== 13" autocomplete="off">
                                </div>
                            </div>
                            <div class="cart-head">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center">
                                        <thead class="header_bg text-white">
                                            <tr class="">
                                                <th width="17%" class="header_style_left">Product</th>
                                                <th width="45%">Quantity</th>
                                                <th width="19%">Rate</th>
                                                {{-- <th width="19%">Discount</th> --}}
                                                <th width="19%">Total</th>
                                                <th class="header_style_right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            @php
                                                $invoiceItem = App\Models\InvoiceItem::where(
                                                    'invoice_id',
                                                    $invoice->id,
                                                )->get();
                                            @endphp
                                                <input type="hidden" name="id" value="{{ $invoice->id }}">
                                            @forelse ($invoiceItem as $item)
                                                <tr>
                                                    <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                                    <td class="table_data_style_left">
                                                        {{ $item->product?->name }} - {{ $item->product?->barcode }}
                                                        <input type="hidden" value="{{ $item->product?->id }}" name="product_id[]" />
                                                    </td>
                                                    <td style="width:250px">
                                                        <div class="form-row">
                                                            @if ($item->product->unit->related_unit == null)
                                                                {{-- ONLY MAIN UNIT --}}
                                                                <input type="text" class="has_sub_unit" hidden
                                                                    value="false">
                                                                <label class="ml-2 mt-2  mr-2"
                                                                    style="padding-top: 5px;">{{ $item->product->unit->name }}:</label>

                                                                <input type="number" value="{{ $item->main_qty }}"
                                                                    class="form-control col main_qty"
                                                                    name="main_qty[]"
                                                                    data-value="{{ product_stock($item->product) }}"
                                                                    data-related="{{ $item->product->unit->related_value }}"
                                                                    onkeydown="return event.keyCode !== 190" min="1">
                                                                <input type="hidden" value="{{ $item->sub_qty }}"
                                                                    class="form-control col sub_qty mr-1"
                                                                    name="sub_qty[]"
                                                                    onkeydown="return event.keyCode !== 190" min="0"
                                                                    max="{{ $item->product->unit->related_value - 1 }}">
                                                            @else
                                                                {{-- HAS SUB UNIT --}}
                                                                <input type="text" class="has_sub_unit" hidden
                                                                    value="true">
                                                                <input type="text" class="conversion" hidden
                                                                    value="{{ $item->product->unit->related_value }}">

                                                                <label class="mr-1 ml-1"
                                                                    style="padding-top: 5px;">{{ $item->product->unit->name }}:</label>
                                                                <input type="number" value="{{ $item->main_qty }}"
                                                                    class="form-control col main_qty mr-1"
                                                                    name="main_qty[]"
                                                                    data-value="{{ product_stock($item->product) }}"
                                                                    data-related="{{ $item->product->unit->related_value }}"
                                                                    onkeydown="return event.keyCode !== 190" min="0">

                                                                <label class="mr-1"
                                                                    style="padding-top: 5px;">{{ $item->product->unit->related_unit->name }}:</label>
                                                                <input type="number" value="{{ $item->sub_qty }}"
                                                                    class="form-control col sub_qty mr-1"
                                                                    name="sub_qty[]"
                                                                    onkeydown="return event.keyCode !== 190" min="0"
                                                                    max="{{ $item->product->unit->related_value - 1 }}">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" style="min-width: 100px;"
                                                            class="form-control rate"
                                                            name="rate[]" value="{{ $item->rate }}" />
                                                    </td>
                                                    <td>
                                                        <input type="number" style="min-width: 100px;" readonly
                                                            name="sub_total[]"
                                                            class="form-control sub_total"
                                                            value="{{ $item->subtotal }}" />
                                                    </td>
                                                    <td class="table_data_style_right">
                                                        <a href="#" class="remove-btn item-index" data-value="${index}"><i class="fa fa-undo text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">No Invoice Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-light-primary">
                                                <td colspan="3" class="text-right fw-bold">Total</td>
                                                <td colspan="1">
                                                    <input type="number" step="any" name="estimated_amount"
                                                        value="0" class="form-control estimated_amount" readonly>
                                                </td>
                                                <td class="text-right"></td>
                                            </tr> 
                                            {{-- Discount --}}
                                            <tr class="bg-light-primary">
                                                <td colspan="3" class="text-right fw-bold">Discount</td>
                                                <td>
                                                    @php
                                                        $ex_discount = $item->invoice->discount;
                                                        if (is_numeric($ex_discount) && ($item->invoice->discount_amount && (str_contains($item->invoice->discount_amount, '%') || !is_numeric($item->invoice->discount_amount)))) {
                                                            $ex_discount = $item->invoice->discount_amount;
                                                        }
                                                        $ex_discount = ($ex_discount == 0.00) ? '0' : $ex_discount;
                                                    @endphp
                                                    <input type="text" class="form-control discount_amount"
                                                        name="discount_amount" placeholder="0%" value="{{ $ex_discount }}">

                                                    <input type="hidden" class="form-control discount"
                                                        name="discount" placeholder="0%">
                                                </td>
                                                <td class="text-right"></td>
                                            </tr>
                                             <tr class="bg-blue-600 text-white font-black">
                                                 <td colspan="3" class="text-right py-3">{{ __('Payable Amount') }}</td>
                                                 <td colspan="1" class="text-center">
                                                     <div id="grand_total" class="text-lg">0.00</div>
                                                     <input type="hidden" name="payable_amount" id="payable_amount" value="">
                                                 </td>
                                                 <td class="text-right"></td>
                                             </tr>
                                             <tr class="bg-light-primary">
                                                 <td colspan="3" class="text-right fw-bold" style="color: #2563eb;">{{ __('Previously Paid on Invoice') }}</td>
                                                 <td>
                                                     <input type="text" readonly value="৳ {{ number_format($invoice->total_paid ?? 0, 2) }}" class="form-control text-center font-weight-bold" style="font-size: 15px; color: #1d4ed8; background-color: #eff6ff; border: 1px solid #bfdbfe;">
                                                 </td>
                                                 <td class="text-right"></td>
                                             </tr>
                                             <tr class="bg-light-primary">
                                                 <td colspan="3" class="text-right fw-bold">
                                                     {{ __('Paid Amount') }}
                                                     <button type="button" class="btn btn-xs btn-outline-primary ml-2 py-0 px-1" id="btn_pay_full" style="font-size: 11px;">{{ __('Pay Full') }}</button>
                                                     <button type="button" class="btn btn-xs btn-outline-secondary ml-1 py-0 px-1" id="btn_pay_reset" style="font-size: 11px;">{{ __('Reset') }}</button>
                                                 </td>
                                                 <td>
                                                     <input type="number" step="any" id="total_paid" name="total_paid"
                                                         value="{{ $invoice->total_paid }}" class="form-control text-center font-weight-bold" style="font-size: 16px;">
                                                 </td>
                                                 <td class="text-right"></td>
                                             </tr>
                                             <tr class="bg-light-primary">
                                                 <td colspan="3" class="text-right fw-bold" style="color: #dc2626;">
                                                     {{ __('Due Amount') }}
                                                     <button type="button" class="btn btn-xs btn-success ml-2 py-1 px-2 font-weight-bold" id="btn_pay_remaining_due" style="font-size: 11px; border-radius: 4px;">
                                                         <i class="fa fa-credit-card"></i> Pay Remaining Due (<span id="due_badge_val">৳0.00</span>)
                                                     </button>
                                                 </td>
                                                 <td>
                                                     <input type="number" step="any" id="total_due" name="total_due"
                                                         value="{{ $invoice->total_due }}" class="form-control text-center text-danger font-weight-bold" style="font-size: 16px; background-color: #fef2f2; border: 1px solid #fca5a5;" readonly>
                                                 </td>
                                                 <td class="text-right"></td>
                                             </tr>
                                             <tr class="bg-light-primary">
                                                 <td colspan="3" class="text-right fw-bold" style="color: #16a34a;">{{ __('Change / Refund Amount') }}</td>
                                                 <td>
                                                     <input type="number" step="any" id="change_amount" name="change_amount"
                                                         value="{{ number_format($invoice->change_amount ?? 0, 2, '.', '') }}" class="form-control text-center text-success font-weight-bold" style="font-size: 16px; background-color: #f0fdf4; border: 1px solid #86efac;" readonly>
                                                 </td>
                                                 <td class="text-right"></td>
                                             </tr>
                                             @php
                                                 $isMultiAccount = isset($existingBankAmounts) && count($existingBankAmounts) > 1;
                                             @endphp
                                             <tr class="bg-light-primary payment-account-row">
                                                 <td colspan="3" class="text-right fw-bold align-middle">
                                                     <div class="d-flex align-items-center justify-content-end flex-wrap" style="gap: 12px;">
                                                         <span class="mr-1 text-dark"><i class="fa fa-university text-primary mr-1"></i> {{ __('Payment Account') }}:</span>
                                                         <label class="custom-control custom-radio custom-control-inline mb-0 cursor-pointer" style="display: inline-flex;">
                                                             <input type="radio" id="exPaymentTypeSingle" name="payment_type" value="pos" class="custom-control-input payment-type-radio" {{ !$isMultiAccount ? 'checked' : '' }}>
                                                             <span class="custom-control-label font-weight-bold" for="exPaymentTypeSingle">{{ __('Single Account') }}</span>
                                                         </label>
                                                         <label class="custom-control custom-radio custom-control-inline mb-0 cursor-pointer" style="display: inline-flex;">
                                                             <input type="radio" id="exPaymentTypeMulti" name="payment_type" value="checking" class="custom-control-input payment-type-radio" {{ $isMultiAccount ? 'checked' : '' }}>
                                                             <span class="custom-control-label font-weight-bold text-primary" for="exPaymentTypeMulti">{{ __('Multiple Account') }}</span>
                                                         </label>
                                                     </div>
                                                 </td>
                                                 <td>
                                                     <div id="single-account-container" style="{{ $isMultiAccount ? 'display: none;' : '' }}">
                                                         <select name="bank_id" id="exchange_bank_id" class="form-control font-weight-bold" style="height: 38px; font-size: 14px;">
                                                             @foreach ($bank_accounts as $bank)
                                                                 <option value="{{ $bank->id }}" {{ ($selectedBankId == $bank->id) ? 'selected' : '' }}>
                                                                     {{ $bank->bank_name }}
                                                                 </option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                     <div id="single-account-placeholder" class="text-center font-weight-bold text-primary py-1" style="{{ !$isMultiAccount ? 'display: none;' : '' }}">
                                                         <small><i class="fa fa-sliders"></i> {{ __('Multiple Selected') }}</small>
                                                     </div>
                                                 </td>
                                                 <td class="text-right"></td>
                                             </tr>
                                             <tr id="multi-account-container" class="bg-light-primary" style="{{ !$isMultiAccount ? 'display: none;' : '' }}">
                                                 <td colspan="5" class="p-3" style="background: #f1f5f9; border: 1px dashed #94a3b8; border-radius: 8px;">
                                                     <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                                                         <label class="font-weight-bold text-dark mb-0" style="font-size: 13px;">
                                                             <i class="fa fa-sliders text-primary mr-1"></i> {{ __('Multiple Bank Accounts Allocation') }}
                                                         </label>
                                                         <span class="badge badge-primary px-2 py-1" style="font-size: 12px;">
                                                             {{ __('Allocated in Banks') }}: <strong id="multi_allocated_label">৳0.00</strong>
                                                         </span>
                                                     </div>
                                                     <div class="row">
                                                         @foreach ($bank_accounts as $bank)
                                                             <div class="col-md-4 col-sm-6 mb-2">
                                                                 <div class="d-flex align-items-center justify-content-between p-2 rounded bg-white shadow-sm border">
                                                                     <span class="font-weight-bold text-dark text-truncate mr-2" style="font-size: 12px;" title="{{ $bank->bank_name }}">
                                                                         {{ $bank->bank_name }}
                                                                     </span>
                                                                     <input type="number" step="any" min="0" 
                                                                         name="amounts[{{ $bank->id }}]" 
                                                                         class="form-control edit-bank-amount font-weight-bold text-center" 
                                                                         data-bank-id="{{ $bank->id }}"
                                                                         value="{{ isset($existingBankAmounts[$bank->id]) ? number_format($existingBankAmounts[$bank->id], 2, '.', '') : '0.00' }}"
                                                                         placeholder="0.00" 
                                                                         style="max-width: 110px; height: 32px; font-size: 13px;">
                                                                 </div>
                                                             </div>
                                                         @endforeach
                                                     </div>
                                                 </td>
                                             </tr>
                                         </tfoot>
                                     </table>
                                 </div>
                                 <footer class="footerpos mt-1 px-1 flex justify-end">
                                     <button class="w-auto border-0 focus:outline-none transition-all duration-300 hover:scale-[1.03] active:scale-[0.98]">
                                         <div class="footerpos_right text-center !rounded-[5px] px-8 py-2.5 flex items-center justify-center gap-2 shadow-sm hover:shadow-md transition-all duration-300 bg-emerald-600 hover:bg-emerald-500">
                                             <input type="hidden" name="customer_id" id="" value="{{$item->invoice->customer_id}}">
                                             <i class="feather icon-refresh-cw text-lg"></i>
                                             <span class="text-base font-bold uppercase tracking-wider"> {{ __('Update') }} </span>
                                         </div>
                                     </button>
                                 </footer>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Select the input field when the page loads
        window.onload = function() {
            var inputField = document.getElementById('product_search');
            inputField.select();
        };
    </script>
    <script>
        // Page Load
        var empty = '';
        // $('body').addClass('toggle-menu');
        $('#product_search').blur();

        var localData = localStorage.getItem('exchng-items') ? JSON.parse(localStorage.getItem('exchng-items')) : [];

        function showList() {
            if (localData.length <= 0) {
                $("#tbody");
            } else {
                localData.forEach((item, index) => {
                    domPrepend(item, index);
                });
            }
        }

        showList();
        estimatedAmount();

        var cartList = [];

        // Helper Functions
        function empty_field_check(placeholder) {
            // console.log(typeof placeholder);
            if (typeof placeholder == NaN) {
                placeholder = 0;
            } else if (placeholder == null) {
                placeholder = 0;
            } else if (placeholder.trim() == "") {
                placeholder = 0;
            } else if (placeholder == 'null') {
                placeholder = 0;
            }
            return placeholder;
        }

        function to_sub_unit(main_val, sub_val, related_by, has_sub_unit) {
            if (has_sub_unit == 'true') {
                return (main_val * related_by) + sub_val;
            }
            return main_val;


        }

        function convert_to_main_and_sub(quantity, has_sub_unit, related_by) {
            var main_qty = 0;
            var main_qty_as_sub = 0;
            var sub_qty = 0;

            main_qty = parseInt(quantity);

            if (has_sub_unit == "true" && quantity != 0 && related_by != 0) {
                main_qty = parseInt(quantity / related_by);
                main_qty_as_sub = main_qty * related_by;
                sub_qty = quantity - main_qty_as_sub;
            }

            return {
                'main_qty': main_qty,
                'sub_qty': sub_qty
            };
        }

        function calculate_sub_total(main_qty, sub_qty, unit_price, related_by, has_sub_unit, discount) {
            let sub_unit_price = 0;
            if (has_sub_unit == "true" && related_by != 0) {
                sub_unit_price = parseFloat(unit_price / related_by);
            }
            let main_price = main_qty * unit_price;
            let sub_price = sub_qty * sub_unit_price;
            let total = parseFloat(main_price + sub_price);
            // console.log(discount);
            // discount = total*discount/100;

            let discountAmount = 0;
            if ((typeof discount === 'string' || discount instanceof String) && discount.includes("%")) {
                let removed_percent_discount = discount.replace('%', '');
                discount = parseFloat(removed_percent_discount);
                discountAmount = Math.round(total * (discount / 100));
                console.log(discountAmount);
            } else {
                discountAmount = parseFloat(discount);
            }

            // Apply discount (Assuming discount is a flat amount)
            total -= discountAmount;

            return total.toFixed(2);
        }
        $(document).on('keyup change', '.product_discount', function(e) {
            let discount = $(this).val();
            // let discount = parseFloat($(this).val());
            // console.log(discount);
            let row = $(this).closest('tr');
            let main_qty = parseInt(row.find('.main_qty').val()) || 0;
            let sub_qty = parseInt(row.find('.sub_qty').val()) || 0;
            let unit_price = parseFloat(row.find('.rate').val()) || 0;
            let related_by = parseInt(row.find('.main_qty').attr('data-related')) || 1;
            let has_sub_unit = row.find('.has_sub_unit').val();

            let sub_total = calculate_sub_total(main_qty, sub_qty, unit_price, related_by, has_sub_unit, discount);
            row.find('.sub_total').val(sub_total);
            estimatedAmount();
        });

        // Manage Addition and Removal from LocalStorage
        function pExist(pid) {
            let ldata = localStorage.getItem('exchng-items') ? JSON.parse(localStorage.getItem('exchng-items')) : [];
            return ldata.some(function(el) {
                return el.product.id === pid
            });
        }

        function storedata(data) {
            if (localStorage.getItem('exchng-items') != null) {
                cartList = JSON.parse(localStorage.getItem('exchng-items'))
                cartList.push(data);
            } else {
                cartList.push(data);
            }
            localStorage.setItem('exchng-items', JSON.stringify(cartList));
        }

        function addProductToCard(data) {
            storedata(data);
            var x = 0;
            domPrepend(data, x++);
            estimatedAmount();
        }

        // Search Product
        $("#product_search").autocomplete({
            source: function(req, res) {
                let url = "{{ route('product-search') }}";
                $.get(url, {
                    req: req.term
                }, (data) => {
                    res($.map(data, function(item) {
                        return {
                            id: item.id,
                            value: item.name + " " + item.barcode,
                            price: item.selling_price
                        }
                    })); // end res

                });
            },
            select: function(event, ui) {

                $(this).val(ui.item.value);
                $("#search_product_id").val(ui.item.id);
                let url = "{{ route('search-product-id', 'my_id') }}".replace('my_id', ui.item.id);
                $.get(url, (data) => {
                    // console.log(product);
                    // check stock
                    if (data.stock_qty <= 0) {
                        iziToast.warning({
                            title: "This product is Stock out. Please Purchases the Product.",
                            position: "topRight",
                        });
                        return false;
                    }


                    if (pExist(data.product.id) == true) {
                        iziToast.warning({
                            title: "Please Increase the quantity.",
                            position: "topRight",
                        });
                    } else {
                        addProductToCard(data);
                    }
                });

                $(this).val('');

                return false;
            },
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');

                }
            },
            minLength: 0
        });

        // Manage Cart items
        $(document).on('click', '.product', function() {
            let productId = $(this).attr('data-value');
            let url = "{{ route('pos-product-id', 'my_id') }}".replace('my_id', productId);
            $.get(url, data => {
                // check stock
                if (data.stock_qty <= 0) {
                    iziToast.warning({
                        title: "This product is Stock out. Please Purchases the Product.",
                        position: "topRight",
                    });
                    return false;
                }

                if (pExist(data.product.id) == true) {
                    iziToast.warning({
                        title: "Please Increase the quantity.",
                        position: "topRight",
                    });
                } else {
                    addProductToCard(data);
                }
            }); // Load Data to cart

        });


        $(document).on('click', '.remove-btn', function() {
            let itemIndex = $(this).attr('data-value');
            localData.splice(itemIndex, 1);
            localStorage.removeItem('exchng-items');
            localStorage.setItem('exchng-items', JSON.stringify(localData))
            $(this).parents('tr').remove();
            estimatedAmount();
        });

        $("#clearList").on('click', function() {
            localStorage.removeItem('exchng-items');
            $("#tbody").html(empty);
            estimatedAmount();
        });



        function domPrepend(data = null, index = null) {
            var name = data.product.name;
            var quantity_data = '';
            // console.log(data);
            if (data.product.unit.related_unit == null) {
                // alert("NO SUB UNIT");
                quantity_data =
                    `<input type="text" class="has_sub_unit" hidden value="false">
                        <label class="ml-2 mr-2" style="padding-top: 5px;">${data.product.unit.name}:</label>
                        <input type="number" value="1" class="form-control col main_qty" name="main_qty[]" 
                        data-value="${data.stock_qty}" data-related="${data.product.unit.related_value}" 
                        onkeydown="return event.keyCode !== 190" min="0">

                        <input type="hidden" value="0" class="form-control col sub_qty mr-1" name="sub_qty[]"  
                        min="0" max="">
                        `;
            } else {
                // alert("SUB UNIT");
                quantity_data =
                    `<input type="text" class="has_sub_unit" hidden value="true">
                        <input type="text" class="conversion" hidden value="${data.product.unit.related_value}">

                        <label class="mr-1 ml-1" style="padding-top: 5px;">${data.product.unit.name}:</label>
                        <input type="number" value="1" class="form-control col main_qty mr-1" name="main_qty[]" 
                        data-value="${data.stock_qty}" data-related="${data.product.unit.related_value}" 
                        onkeydown="return event.keyCode !== 190" min="0">

                        <label class="mr-1" style="padding-top: 5px;">${data.product.unit.related_unit.name}:</label>
                        <input type="number" value="0" class="form-control col sub_qty mr-1" name="sub_qty[]"  
                        onkeydown="return event.keyCode !== 190" min="0" max="${data.product.unit.related_value-1}">`;
            }

            let dom = `
                <tr id="tbody_tr">
                    <td class="table_data_style_left">
                    ${data.product.name + " - " + data.product.barcode}
                    
                    <input type="hidden" value="${data.product.id}" name="product_id[]" />
                    </td>
                    <td>
                        <div class="form-row" style="min-width: 100px;">
                            ${quantity_data}
                        </div>
                    </td>
                    <td>
                    <input type="number" style="min-width: 100px;" value="${data.product.selling_price}" class="form-control rate" name="rate[]" />
                    </td>
                    
                    <td>
                    <input type="number" style="min-width: 100px;" readonly name="sub_total[]" class="form-control sub_total" value="${data.product.selling_price}"/>
                    </td>
                    <td class="table_data_style_right">
                    <a href="#" class="remove-btn item-index" data-value="${index}"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            `;
            $("#tbody").prepend(dom);
        }

        function handle_change(obj) {
            var main_val = parseInt(empty_field_check(obj.parents('tr').find('.main_qty').val()));
            var sub_val = parseInt(empty_field_check(obj.parents('tr').find('.sub_qty').val()));
            var pro_discount = parseInt(empty_field_check(obj.parents('tr').find('.product_discount').val()));
            let related_by = parseInt(empty_field_check(obj.parents('tr').find('.main_qty').attr('data-related')));
            var has_sub_unit = obj.parents('tr').find('.has_sub_unit').val();
            let converted_sub = to_sub_unit(main_val, sub_val, related_by, has_sub_unit);
            let stock = obj.parents('tr').find('.main_qty').attr('data-value');

            // alert(converted_sub);

            if (stock < converted_sub) {
                // put the max stock
                var converted;
                if (has_sub_unit == "true") {
                    converted = convert_to_main_and_sub(stock, has_sub_unit, related_by);
                    obj.parents('tr').find('.main_qty').val(converted.main_qty);
                    obj.parents('tr').find('.sub_qty').val(converted.sub_qty);
                } else {
                    converted = convert_to_main_and_sub(stock, has_sub_unit, related_by);
                    obj.parents('tr').find('.main_qty').val(converted.main_qty);
                }

                let price = obj.parents('tr').find('.rate').val();
                price = parseFloat(price);

                let subTotal = calculate_sub_total(converted.main_qty, converted.sub_qty, price, related_by, has_sub_unit, pro_discount);

                obj.parents('tr').find('.sub_total').val(subTotal);
                estimatedAmount();

                iziToast.warning({
                    title: "Not Enough Stock.",
                    position: "topRight",
                });
            } else {
                let price = obj.parents('tr').find('.rate').val();
                price = parseFloat(price);
                let subTotal = calculate_sub_total(main_val, sub_val, price, related_by, has_sub_unit, pro_discount);
                obj.parents('tr').find('.sub_total').val(subTotal);
                estimatedAmount();
            }
        }

        // main_qty
        $(document).on('keyup change', '.main_qty', function(e) {
            handle_change($(this));
        });

        //sub_qty change
        $(document).on('keyup change', '.sub_qty', function(e) {
            handle_change($(this));
        });

        // rate change
        $(document).on('keyup change', '.rate', function(e) {
            handle_change($(this));
            return;
        });

        //estimatedAmount function
        function estimatedAmount() {
            var sum = 0;

            $(".sub_total").each(function() {
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
            });
            $("input[name='estimated_amount']").val(sum);
            totalCalculate();
        }

        // Other Calculations - discount
        $(document).on(
            "keyup change",
            "input[name='discount_amount']",
            function() {
                totalCalculate();
            }
        );


        function totalCalculate() {
            let discount = $(".discount_amount").val();
            let estimated_amount = parseFloat(
                $("input[name='estimated_amount']").val()
            );

            discount = empty_field_check(discount);


            let discountAmount = 0;
            if ((typeof discount === 'string' || discount instanceof String) && discount.includes("%")) {
                let removed_percent_discount = discount.replace('%', '');
                discount = parseFloat(removed_percent_discount);
                discountAmount = Math.round($(".estimated_amount").val() * (discount / 100));
            } else {
                discountAmount = parseFloat(discount);
            }

            let total_amount = estimated_amount - discountAmount;

            $("#grand_total").text(total_amount.toFixed(2));
            $(".sub_total").text(estimated_amount.toFixed(2));
            $(".discount_amount").text(discountAmount.toFixed(2));
            $(".discount").val(discountAmount.toFixed(2));
            $(".payable_amount").text(total_amount.toFixed(2));
            let pay = $("#payable_amount").val(total_amount.toFixed(2));

            // Recalculate Paid, Due, and Change Amount without overwriting previous paid amount
            let paidVal = $("#total_paid").val();
            let paid = parseFloat(paidVal);
            if (isNaN(paid)) {
                paid = {{ (float)($invoice->total_paid ?? 0) }};
                $("#total_paid").val(paid.toFixed(2));
            }
            let due = total_amount - paid;
            let change = paid - total_amount;
            if (due < 0) due = 0;
            if (change < 0) change = 0;
            $("#total_due").val(due.toFixed(2));
            $("#change_amount").val(change.toFixed(2));
            $("#due_badge_val").text("৳" + due.toFixed(2));

            if (due > 0.01) {
                $("#btn_pay_remaining_due").show();
            } else {
                $("#btn_pay_remaining_due").hide();
            }
        }

        $(document).on("keyup change input", "#total_paid", function() {
            let total_amount = parseFloat($("#payable_amount").val()) || 0;
            let paid_amount = parseFloat($(this).val()) || 0;
            let due = total_amount - paid_amount;
            let change = paid_amount - total_amount;
            if (due < 0) due = 0;
            if (change < 0) change = 0;
            $("#total_due").val(due.toFixed(2));
            $("#change_amount").val(change.toFixed(2));
            $("#due_badge_val").text("৳" + due.toFixed(2));

            if (due > 0.01) {
                $("#btn_pay_remaining_due").show();
            } else {
                $("#btn_pay_remaining_due").hide();
            }
        });

        $(document).on("click", "#btn_pay_remaining_due, #btn_pay_full", function() {
            let total_amount = parseFloat($("#payable_amount").val()) || 0;
            $("#total_paid").val(total_amount.toFixed(2));
            $("#total_paid").trigger("input");
            iziToast.success({
                title: "{{ __('Payment Updated') }}",
                message: "{{ __('Full payment recorded') }} (৳" + total_amount.toFixed(2) + "). {{ __('Due amount is now ৳0.00.') }}",
                position: "topRight",
            });
        });

        $(document).on("click", "#btn_pay_reset", function() {
            let initialPaid = {{ (float)($invoice->total_paid ?? 0) }};
            $("#total_paid").val(initialPaid.toFixed(2));
            $("#total_paid").trigger("input");

            // Reset multiple account values if open
            $(".edit-bank-amount").each(function() {
                let bankId = $(this).data("bank-id");
                let initVal = 0;
                @if(isset($existingBankAmounts))
                    let existingMap = @json($existingBankAmounts);
                    if (existingMap && existingMap[bankId]) {
                        initVal = parseFloat(existingMap[bankId]);
                    }
                @endif
                $(this).val(initVal.toFixed(2));
            });
            recalcMultiAccounts();
        });

        // Toggle Single Account vs Multiple Account
        $(document).on("change", ".payment-type-radio", function() {
            if ($(this).val() === "checking") {
                $("#single-account-container").hide();
                $("#single-account-placeholder").show();
                $("#multi-account-container").slideDown(200);
                
                // If all multi-account inputs are 0, initialize the selected single bank with current total_paid
                let currentTotal = recalcMultiAccounts();
                let paidVal = parseFloat($("#total_paid").val()) || 0;
                if (currentTotal <= 0 && paidVal > 0) {
                    let selBankId = $("#exchange_bank_id").val();
                    let targetInput = $(".edit-bank-amount[data-bank-id='" + selBankId + "']");
                    if (targetInput.length) {
                        targetInput.val(paidVal.toFixed(2));
                    } else {
                        $(".edit-bank-amount").first().val(paidVal.toFixed(2));
                    }
                    recalcMultiAccounts();
                }
            } else {
                $("#multi-account-container").slideUp(200);
                $("#single-account-placeholder").hide();
                $("#single-account-container").show();
            }
        });

        function recalcMultiAccounts() {
            let total = 0;
            $(".edit-bank-amount").each(function() {
                let val = parseFloat($(this).val()) || 0;
                total += val;
            });
            $("#multi_allocated_label").text("৳" + total.toFixed(2));
            return total;
        }

        $(document).on("keyup change input", ".edit-bank-amount", function() {
            let total = recalcMultiAccounts();
            $("#total_paid").val(total.toFixed(2));
            $("#total_paid").trigger("input");
        });

        // If Pay Remaining Due or Pay Full is clicked while in Multiple Account mode:
        $(document).on("click", "#btn_pay_remaining_due, #btn_pay_full", function() {
            if ($("input[name='payment_type']:checked").val() === "checking") {
                let totalPaid = parseFloat($("#total_paid").val()) || 0;
                let currentAllocated = recalcMultiAccounts();
                let diff = totalPaid - currentAllocated;
                if (diff > 0.009) {
                    // Put the difference in the first input that has money, or first bank
                    let activeInput = $(".edit-bank-amount").filter(function() { return (parseFloat($(this).val()) || 0) > 0; }).first();
                    if (!activeInput.length) {
                        activeInput = $(".edit-bank-amount").first();
                    }
                    let currentVal = parseFloat(activeInput.val()) || 0;
                    activeInput.val((currentVal + diff).toFixed(2));
                    recalcMultiAccounts();
                }
            }
        });

        $(document).ready(function() {
            recalcMultiAccounts();
        });

        // ===================order modal===================
        //payment_modal_btn
        $("#payment_modal_btn").on("click", function() {
            //date
            var date = $("#date").val();
            if (date == '') {
                //Walking Customer Can't to Create a Due
                iziToast.warning({
                    title: "Please select a date.",
                    position: "topRight",
                });
                return false;
            }
            //customer_id
            var customer_id = $("#customer_id").val();
            if (customer_id == '') {
                //Walking Customer Can't to Create a Due
                iziToast.warning({
                    title: "Please select a customer.",
                    position: "topRight",
                });
                return false;
            }
            //order_modal_obj
            if ($.trim($('.name').val()) == '') {
                iziToast.warning({
                    title: "Please select at least one product",
                    position: "topRight",
                });
                return false;
            }
            // count of tr in cart_list table
            var count = $("#tbody").find("tr#tbody_tr").length;
            $(".total_item").text(count);
            //get customer name from id="customer_id"
            var customer_name = $("#customer_id").find("option:selected").text();
            $("#payment_modal").find("#customer_name").text(customer_name);
            var customer_id = $("#customer_id").val();
            $("#payment_modal").find("input[name=customer_id]").val(customer_id);
            //show payment_modal
            $("#payment_modal").modal("show");
        });

        //.full_pay_btn
        $(".full_pay_btn").on("click", function() {
            var payable_amount = $("#grand_total").text();
            payable_amount = parseFloat(payable_amount);
            payable_amount = payable_amount.toFixed(2);

            $(".pay_amount").val(payable_amount);
            $("#paid_amount").val(payable_amount);
            $(".paid_amount").text(payable_amount);
            $("#due_amount").val('0.00');
            $(".due_amount").text('0.00');
        });

        //.full_due_btn
        $(".full_due_btn").on("click", function() {
            var payable_amount = $("#grand_total").text();
            payable_amount = parseFloat(payable_amount);
            payable_amount = payable_amount.toFixed(2);

            $(".pay_amount").val('0.00');
            $("#due_amount").val(payable_amount);
            $(".due_amount").text(payable_amount);
            $("#paid_amount").val('0.00');
            $(".paid_amount").text('0.00');
        });

        // Product Search
        $(document).on("change", "#getProductsByCat", function() {
            var cat_id = $(this).val();
            $.ajax({
                url: "{{ route('posProducts') }}",
                type: "GET",
                data: {
                    cat_id: cat_id
                },
                success: function(data) {
                    $("#products").html(data);
                    // console.log(data)
                },
                error: function() {
                    alert('Error !');
                }
            });
        });

        $("#checkout").on("click", function() {
            localStorage.clear();
        });
    </script>
@endpush
