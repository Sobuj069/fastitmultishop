@extends('backend.layouts.master')
@section('page-title', __('Stock Transfer'))

@push('css')
    <style>
        .invoice-contentbar {
            margin: 0 !important;
            padding: 20px;
            margin-bottom: 60px;
        }

        .cart-container {
            padding-top: 20px !important;
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
            background-color: transparent !important;
            padding: 12px 10px;
            display: flex;
            align-items: center;
        }

        .footerpos .footerpos_left div {
            font-size: 20px;
            color: #333;
            font-weight: 700;
        }

        .checkout-btn {
            background-color: #10b981 !important;
            color: white !important;
            padding: 10px 35px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkout-btn:hover {
            background-color: #059669 !important;
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: white !important;
        }

        .productcss {
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

        .ecommerce-sortbyd {
            margin-top: 0px !important;
        }
    </style>
@endpush

@section('invoice')

    @if ($userBranchId == 1)
        @if ($filterBranchId != null)
            <div class="invoice-contentbar">
                <div class="row">
                    <!-- Start col -->
                    <div class="col-md-12">
                        <div class="card card_top">
                            <form action="{{ route('transfer.store') }}" id="payment_form" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="cart-container">
                                        <div class="cart-head">
                                            <div class="row align-items-center ecommerce-sortbyd">
                                            <!-- Start col -->
                                            <div class="col-md-6">
                                                <label for="unit_id" class="form-label fw-bold">{{ __('From *') }}</label>
                                                @if ($userBranchId == 1)
                                                    @php
                                                        $branch_name = App\Models\Branch::where(
                                                            'id',
                                                            $filterBranchId,
                                                        )->first();
                                                    @endphp
                                                    <input readonly class="form-control" type="text"
                                                        value="{{ $branch_name->name }}">
                                                    <input type="hidden" name="from_branch_id" id="from_branch_id"
                                                        value="{{ $filterBranchId }}">
                                                @else
                                                    <input readonly class="form-control" type="text"
                                                        value="{{ auth()->user()->branch->name }}">
                                                    <input type="hidden" name="from_branch_id" class="form-control"
                                                        value="{{ auth()->user()->branch_id }}">
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="unit_id" class="form-label fw-bold">{{ __('To *') }}</label>
                                                <select class="select2 to_branch_id" name="to_branch_id" id="to_branch_id">
                                                    <option selected value="">{{ __('Select Branch') }}</option>
                                                    @foreach ($allBranch as $branch)
                                                        @if ($userBranchId == 1)
                                                            @if ($filterBranchId != $branch->id)
                                                                <option value="{{ $branch->id }}">{{ $branch->name }}
                                                                </option>
                                                            @endif
                                                        @else
                                                            @if (auth()->user()->branch_id != $branch->id)
                                                                <option value="{{ $branch->id }}">{{ $branch->name }}
                                                                </option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row align-items-center ecommerce-sortby mt-3">
                                            <!-- Start col -->
                                            <div class="col-md-6">
                                                <label for="unit_id" class="form-label fw-bold">{{ __('Date *') }}</label>
                                                <input type="date" class="form-control" id="date"
                                                    value="{{ date('Y-m-d') }}" name="date" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="unit_id" class="form-label fw-bold">{{ __('Note') }}</label>
                                                <textarea class="form-control" placeholder="{{ __('Enter Your Note') }} " name="note"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend ">
                                                <span class="input-group-text barcod_style" id="basic-addon1"><i
                                                        class="fa fa-barcode"></i></span>
                                            </div>
                                            <input type="text" id="product_search" class="form-control"
                                                placeholder="{{ __('Type & Barcode') }}" aria-label="{{ __('Type & Barcode') }}"
                                                onkeydown="return event.keyCode !== 13" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="cart-head">
                                        <div class="table-responsive">
                                            <table class="table table-striped text-center">
                                                <thead class="header_bg">
                                                    <tr>
                                                        <th class="header_style_left" width="17%">{{ __('Product') }}</th>
                                                        <th width="20%">{{ __('Variation') }}</th>
                                                        <th width="15%">{{ __('Rate') }}</th>
                                                        <th width="29%">{{ __('Transfer Quantity') }}</th>
                                                        <th width="29%">{{ __('Sub Total') }}</th>
                                                        <th class="header_style_right">{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">

                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-light-primary">
                                                        <td colspan="4" class="text-right fw-bold" style="font-size: 18px; vertical-align: middle;">{{ __('Grand Total') }}:</td>
                                                        <td colspan="2" class="text-left">
                                                            <div id="grand_total" style="font-size: 20px; font-weight: 800; color: #10b981;">0.00</div>
                                                            <input type="hidden" name="estimated_amount" value="0" class="estimated_amount">
                                                            <input type="hidden" name="payable_amount" id="payable_amount" value="">
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="footerpos mt-1 w-full px-1">
                                            <button type="button" class="checkout-btn" id="checkout">
                                                {{ __('Transfer Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="invoice-contentbar text-center">
                <div class="row">
                    <div class="col-md-12 text-center mt-5">
                        <h2 class="text-danger">{{ __('Please Select Branch') }}</h2>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="invoice-contentbar">
            <div class="row">
                <!-- Start col -->
                <div class="col-md-12">
                    <div class="card card_top">
                        <form action="{{ route('transfer.store') }}" id="payment_form" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="cart-container">
                                    <div class="cart-head">
                                        <div class="row align-items-center ecommerce-sortbyd">
                                            <!-- Start col -->
                                            <div class="col-md-6">
                                                <label for="unit_id" class="form-label fw-bold">{{ __('From *') }}</label>
                                                @if ($userBranchId == 1)
                                                    @php
                                                        $branch_name = App\Models\Branch::where(
                                                            'id',
                                                            $filterBranchId,
                                                        )->first();
                                                    @endphp
                                                    <input readonly class="form-control" type="text"
                                                        value="{{ $branch_name->name }}">
                                                    <input type="hidden" name="from_branch_id" id="from_branch_id"
                                                        value="{{ $filterBranchId }}">
                                                @else
                                                    <input readonly class="form-control" type="text"
                                                        value="{{ auth()->user()->branch->name }}">
                                                    <input type="hidden" name="from_branch_id" id="from_branch_id" class="form-control"
                                                        value="{{ auth()->user()->branch_id }}">
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="unit_id" class="form-label fw-bold">{{ __('To *') }}</label>
                                                <select class="select2 to_branch_id" name="to_branch_id" id="to_branch_id">
                                                    <option selected value="">{{ __('Select Branch') }}</option>
                                                    @foreach ($allBranch as $branch)
                                                        @if ($userBranchId == 1)
                                                            @if ($filterBranchId != $branch->id)
                                                                <option value="{{ $branch->id }}">{{ $branch->name }}
                                                                </option>
                                                            @endif
                                                        @else
                                                            @if (auth()->user()->branch_id != $branch->id)
                                                                <option value="{{ $branch->id }}">{{ $branch->name }}
                                                                </option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row align-items-center ecommerce-sortby mt-3">
                                            <!-- Start col -->
                                            <div class="col-md-6">
                                                <label for="unit_id" class="form-label fw-bold">{{ __('Date *') }}</label>
                                                <input type="date" class="form-control" id="date"
                                                    value="{{ date('Y-m-d') }}" name="date" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="unit_id" class="form-label fw-bold">{{ __('Note') }}</label>
                                                <textarea class="form-control" placeholder="{{ __('Enter Your Note') }} " name="note"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend ">
                                                <span class="input-group-text barcod_style" id="basic-addon1"><i
                                                        class="fa fa-barcode"></i></span>
                                            </div>
                                            <input type="text" id="product_search" class="form-control"
                                                placeholder="{{ __('Type & Barcode') }}" aria-label="{{ __('Type & Barcode') }}"
                                                onkeydown="return event.keyCode !== 13" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="cart-head">
                                        <div class="table-responsive">
                                            <table class="table table-striped text-center">
                                                <thead class="header_bg">
                                                    <tr>
                                                        <th class="header_style_left" width="17%">{{ __('Product') }}</th>
                                                        <th width="20%">{{ __('Variation') }}</th>
                                                        <th width="15%">{{ __('Rate') }}</th>
                                                        <th width="29%">{{ __('Transfer Quantity') }}</th>
                                                        <th width="29%">{{ __('Sub Total') }}</th>
                                                        <th class="header_style_right">{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">

                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-light-primary">
                                                        <td colspan="4" class="text-right fw-bold" style="font-size: 18px; vertical-align: middle;">{{ __('Grand Total') }}:</td>
                                                        <td colspan="2" class="text-left">
                                                            <div id="grand_total" style="font-size: 20px; font-weight: 800; color: #10b981;">0.00</div>
                                                            <input type="hidden" name="estimated_amount" value="0" class="estimated_amount">
                                                            <input type="hidden" name="payable_amount" id="payable_amount" value="">
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="footerpos mt-1 w-full px-1">
                                            <button type="button" class="checkout-btn" id="checkout">
                                                {{ __('Transfer Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('js')
    <script>
        // Polyfill for iziToast using ToastMagic
        if (typeof iziToast === 'undefined') {
            window.iziToast = {
                success: function(obj) { 
                    if (typeof toastMagic !== 'undefined') toastMagic.success(obj.message || obj.title || obj);
                    else console.log('Success:', obj.title || obj);
                },
                error: function(obj) { 
                    if (typeof toastMagic !== 'undefined') toastMagic.error(obj.message || obj.title || obj);
                    else console.error('Error:', obj.title || obj);
                },
                warning: function(obj) { 
                    if (typeof toastMagic !== 'undefined') toastMagic.warning(obj.message || obj.title || obj);
                    else console.warn('Warning:', obj.title || obj);
                },
                info: function(obj) { 
                    if (typeof toastMagic !== 'undefined') toastMagic.info(obj.message || obj.title || obj);
                    else console.info('Info:', obj.title || obj);
                }
            };
        }

        $(document).ready(function() {
            // Auto update quantity when IMEIs are selected
            $(document).on('change', 'select[name^="imei"]', function() {
                let row = $(this).closest('tr');
                let selectedCount = $(this).val() ? $(this).val().length : 0;
                let qtyInput = row.find('.quantity-input');
                if (qtyInput.length > 0) {
                    qtyInput.val(selectedCount);
                    qtyInput.trigger('change');
                } else {
                    let mainQty = row.find('.main_qty');
                    mainQty.val(selectedCount).trigger('change');
                }
            });
        });

        // Page Load & LocalStorage handling
        var empty = '';
        var localData = [];
        try {
            var storedItems = localStorage.getItem('transfer-items');
            if (storedItems) {
                localData = JSON.parse(storedItems) || [];
            }
        } catch(e) {
            localData = [];
        }

        function showList() {
            $("#tbody").html(empty);
            if (Array.isArray(localData) && localData.length > 0) {
                localData.forEach((item, index) => {
                    try {
                        if (item && item.product) {
                            domPrepend(item, index, item.variation_code || null);
                        }
                    } catch(err) {
                        console.error("Error loading stored item:", err);
                    }
                });
            }
        }

        showList();
        estimatedAmount();

        var cartList = [];

        // Helper Functions
        function empty_field_check(placeholder) {
            if (placeholder === null || typeof placeholder === 'undefined' || isNaN(placeholder)) {
                return 0;
            }
            let val = placeholder.toString().trim();
            if (val === "" || val === 'null' || val === 'NaN') {
                return 0;
            }
            return placeholder;
        }

        function parseQuantityInput(input, related_by) {
            input = (input || '').toString().trim();

            if (input === '' || isNaN(input)) {
                return { main_qty: 0, sub_qty: 0 };
            }

            let main_qty = 0;
            let sub_qty = 0;

            let parts = input.split('.');
            main_qty = parseInt(parts[0]) || 0;

            if (parts.length > 1) {
                let decimalPart = parts[1].replace(/[^0-9]/g, '');
                sub_qty = parseInt(decimalPart) || 0;

                if (isNaN(sub_qty)) sub_qty = 0;

                if (related_by && sub_qty >= related_by) {
                    main_qty += Math.floor(sub_qty / related_by);
                    sub_qty = sub_qty % related_by;
                }
            }

            return {
                main_qty: main_qty,
                sub_qty: sub_qty
            };
        }

        function to_sub_unit(main_val, sub_val, related_by, has_sub_unit) {
            if (has_sub_unit == 'true' || has_sub_unit === true) {
                return (main_val * related_by) + sub_val;
            }
            return main_val;
        }

        function convert_to_main_and_sub(quantity, has_sub_unit, related_by) {
            var main_qty = 0;
            var main_qty_as_sub = 0;
            var sub_qty = 0;

            main_qty = parseInt(quantity);

            if ((has_sub_unit == "true" || has_sub_unit === true) && quantity != 0 && related_by != 0) {
                main_qty = parseInt(quantity / related_by);
                main_qty_as_sub = main_qty * related_by;
                sub_qty = quantity - main_qty_as_sub;
            }

            return {
                'main_qty': main_qty,
                'sub_qty': sub_qty
            };
        }

        function calculate_sub_total(main_qty, sub_qty, unit_price, related_by, has_sub_unit, discount = 0) {
            var sub_unit_price = 0;
            if ((has_sub_unit == "true" || has_sub_unit === true) && related_by != 0) {
                sub_unit_price = parseFloat(unit_price / related_by);
            }
            var main_price = main_qty * unit_price;
            var sub_price = sub_qty * sub_unit_price;
            var subtotal = main_price + sub_price;

            if (typeof discount === 'string' && discount.includes("%")) {
                let percent = parseFloat(discount.replace('%', '')) || 0;
                subtotal = subtotal - (subtotal * (percent / 100));
            } else {
                discount = parseFloat(discount) || 0;
                subtotal = subtotal - discount;
            }

            return parseFloat(subtotal).toFixed(2);
        }

        function parseStockQty(stockText, has_sub_unit, related_by = 1) {
            if (!stockText && stockText !== 0) return 0;

            if (typeof stockText === 'object' && stockText.available_stock !== undefined) {
                return parseFloat(stockText.available_stock) || 0;
            }

            if (typeof stockText === 'string') {
                let mainMatch = stockText.match(/(\d+(?:\.\d+)?)/);
                let subMatch = stockText.match(/(\d+(?:\.\d+)?)\s*[a-zA-Z]+$/);

                let main = mainMatch ? parseFloat(mainMatch[1]) : 0;
                let sub = subMatch ? parseFloat(subMatch[1]) : 0;

                if (has_sub_unit && related_by > 0) {
                    return main + (sub / related_by);
                }

                return main;
            }

            return parseFloat(stockText) || 0;
        }

        function addProductToCard(data, weight = null, variation_code = null) {
            if (!data || !data.product) return false;

            // Check if product with the same variation already exists
            let existingRow = $("#tbody tr").filter(function() {
                return $(this).find("input[name='product_id[]']").val() == data.product.id &&
                    $(this).find("select[name='variation_id[]']").val() == variation_code;
            });

            if (existingRow.length > 0) {
                // Existing product quantity increase
                let qtyInput = existingRow.find(".quantity-input");
                let mainQtyHidden = existingRow.find(".main_qty");
                let subQtyHidden = existingRow.find(".sub_qty");

                let currentQty = parseFloat(mainQtyHidden.val()) || 1;
                let newQty = currentQty + 1;

                qtyInput.val(newQty);
                mainQtyHidden.val(newQty);
                subQtyHidden.val(0);

                let rate = parseFloat(existingRow.find(".rate").val()) || 0;
                let discount = existingRow.find(".product_discount").val() || '0';
                let has_sub_unit = existingRow.find('.has_sub_unit').val();
                let related_by = parseInt(existingRow.find('.quantity-input').attr('data-related')) || 1;
                let newSubtotal = calculate_sub_total(newQty, 0, rate, related_by, has_sub_unit, discount);

                existingRow.find(".sub_total").val(newSubtotal);
                existingRow.find(".sub_total_text").text(newSubtotal);

                estimatedAmount();

                iziToast.success({
                    title: "{{ __('Quantity increased') }}",
                    position: "topRight",
                });
                return true;
            } else {
                let stockText = data.stock_qty;
                let has_sub_unit = (data.product.unit && data.product.unit.related_unit != null);
                let related_by = (data.product.unit && data.product.unit.related_value) ? data.product.unit.related_value : 1;
                let stockQty = parseStockQty(stockText, has_sub_unit, related_by);

                if (data.product.is_service == 0 && stockQty <= 0) {
                    iziToast.warning({
                        title: "{{ __('This product is Stock out in selected branch.') }}",
                        position: "topRight",
                    });
                    return false;
                }

                let index = localData.length;
                localData.push({
                    product: data.product,
                    stock_qty: data.stock_qty,
                    variations: data.variations || [],
                    variation_code: variation_code
                });

                try {
                    localStorage.setItem('transfer-items', JSON.stringify(localData));
                } catch(e) {}

                domPrepend(data, index, variation_code);

                let tr = $("#tbody tr:first");

                let main_qty = 1;
                let sub_qty = 0;

                if (weight !== null && weight !== '') {
                    let has_sub_unit_val = tr.find('.has_sub_unit').val();
                    let related_by_val = parseInt(tr.find('.main_qty').attr('data-related')) || 1000;
                    let gram = parseFloat(weight);

                    if (gram < 10 && related_by_val == 1000) {
                        gram = gram / 1000;
                    }

                    main_qty = gram / related_by_val;
                    sub_qty = 0;
                }

                tr.find('.main_qty').val(main_qty);
                tr.find('.sub_qty').val(sub_qty);
                tr.find('.quantity-input').val(main_qty);

                let rate = parseFloat(tr.find(".rate").val()) || 0;
                let discount = tr.find(".product_discount").val() || '0';
                let has_sub_unit_val = tr.find('.has_sub_unit').val();
                let related_by_val = parseInt(tr.find('.quantity-input').attr('data-related')) || 1;
                let subtotal = calculate_sub_total(main_qty, sub_qty, rate, related_by_val, has_sub_unit_val, discount);

                tr.find(".sub_total").val(subtotal);
                tr.find(".sub_total_text").text(subtotal);

                estimatedAmount();
                return true;
            }
        }

        // Direct Barcode Scanner and Search Handler
        function handleDirectBarcodeScan(rawBarcode, $input) {
            let term = (rawBarcode || '').toString().trim();
            if (!term) return;

            let from_branch_id = $('#from_branch_id').val() || $('input[name="from_branch_id"]').val();
            let url = "{{ route('sc-product-search') }}";

            $.get(url, { req: term, branch_id: from_branch_id }, function(data) {
                if (!data || data.length === 0) {
                    iziToast.error({
                        title: "{{ __('Not Found') }}",
                        message: "{{ __('No product found for barcode / search:') }} " + term,
                        position: "topRight"
                    });
                    if ($input && $input.length) $input.val('').focus();
                    return;
                }

                let target = data.find(item => item.barcode && item.barcode.toString().trim().toLowerCase() === term.toLowerCase()) || data[0];

                let detailsUrl = "{{ route('sc-search-product-id', 'my_id') }}".replace('my_id', target.id);
                $.get(detailsUrl, { branch_id: from_branch_id }, function(fullData) {
                    let stockText = fullData.stock_qty;
                    let has_sub_unit = (fullData.product.unit && fullData.product.unit.related_unit != null);
                    let related_by = (fullData.product.unit && fullData.product.unit.related_value) ? fullData.product.unit.related_value : 1;
                    let stockQty = parseStockQty(stockText, has_sub_unit, related_by);

                    if (fullData.product.is_service == 0 && stockQty <= 0) {
                        iziToast.warning({
                            title: "{{ __('This product is Stock out in selected branch.') }}",
                            position: "topRight",
                        });
                        if ($input && $input.length) $input.val('').focus();
                        return false;
                    }

                    addProductToCard(fullData);

                    if ($input && $input.length) {
                        $input.val('').focus();
                    }
                }).fail(function() {
                    iziToast.error({
                        title: "{{ __('Error') }}",
                        message: "{{ __('Failed to load product details.') }}",
                        position: "topRight"
                    });
                });
            }).fail(function() {
                iziToast.error({
                    title: "{{ __('Error') }}",
                    message: "{{ __('Search failed.') }}",
                    position: "topRight"
                });
            });
        }
        window.handleDirectBarcodeScan = handleDirectBarcodeScan;

        // Enter key on #product_search
        $(document).on('keydown', '#product_search', function(e) {
            if (e.keyCode === 13 || e.key === 'Enter') {
                e.preventDefault();
                e.stopPropagation();
                let term = $(this).val().trim();
                if (term) {
                    handleDirectBarcodeScan(term, $(this));
                }
                return false;
            }
        });

        // Global barcode scanner listener (hardware scanner gun support)
        let barcodeBuffer = '';
        let barcodeLastKeyTime = 0;
        $(document).on('keydown keypress', function(e) {
            if ($('.modal.show, .select2-container--open').length > 0) return;
            let target = $(e.target);
            if (target.is('input:not(#product_search), textarea, select') && target.attr('id') !== 'product_search') {
                return;
            }
            if (target.attr('id') === 'product_search') {
                return;
            }

            let currentTime = new Date().getTime();
            if (e.key === 'Enter' || e.keyCode === 13) {
                if (barcodeBuffer.length >= 2 && (currentTime - barcodeLastKeyTime < 300)) {
                    e.preventDefault();
                    e.stopPropagation();
                    let scannedCode = barcodeBuffer.trim();
                    barcodeBuffer = '';
                    handleDirectBarcodeScan(scannedCode, $('#product_search').first());
                    return false;
                }
                barcodeBuffer = '';
            } else if (e.type === 'keydown' && e.key && e.key.length === 1) {
                if (currentTime - barcodeLastKeyTime > 150) {
                    barcodeBuffer = '';
                }
                barcodeBuffer += e.key;
                barcodeLastKeyTime = currentTime;
            }
        });

        // Autocomplete on #product_search
        var scanned_term = '';
        $("#product_search").autocomplete({
            source: function(req, res) {
                let term = (req.term || '').trim();
                if (!term) {
                    res([]);
                    return;
                }
                scanned_term = term;
                let url = "{{ route('sc-product-search') }}";
                let from_branch_id = $('#from_branch_id').val() || $('input[name="from_branch_id"]').val();

                $.get(url, {
                    req: term,
                    branch_id: from_branch_id
                }, function(data) {
                    if (data && data.length > 0) {
                        res($.map(data, function(item) {
                            let stockDisplay = item.stock_qty_text || item.stock_qty;
                            return {
                                id: item.id,
                                label: item.name + " (" + (item.purchase_price || 0) + " {{ empty(get_setting('com_currency')) ? 'TK' : get_setting('com_currency') }}) [Stock: " + stockDisplay + "] - " + (item.barcode || ''),
                                value: item.name + " " + (item.barcode || ''),
                                price: item.purchase_price,
                                barcode: item.barcode || ''
                            };
                        }));
                    } else {
                        res([]);
                    }
                }).fail(function() {
                    res([]);
                });
            },
            select: function(event, ui) {
                let $input = $(this);
                $input.val(ui.item.value);

                let url = "{{ route('sc-search-product-id', 'my_id') }}".replace('my_id', ui.item.id);
                let from_branch_id = $('#from_branch_id').val() || $('input[name="from_branch_id"]').val();

                $.get(url, { branch_id: from_branch_id }, function(data) {
                    let stockText = data.stock_qty;
                    let has_sub_unit = (data.product.unit && data.product.unit.related_unit != null);
                    let related_by = (data.product.unit && data.product.unit.related_value) ? data.product.unit.related_value : 1;
                    let stockQty = parseStockQty(stockText, has_sub_unit, related_by);

                    if (data.product.is_service == 0 && stockQty <= 0) {
                        iziToast.warning({
                            title: "{{ __('This product is Stock out in selected branch.') }}",
                            position: "topRight",
                        });
                        return false;
                    }

                    addProductToCard(data);
                    if ($input && $input.length) {
                        $input.focus();
                    }
                });

                $input.val('');
                return false;
            },
            response: function(event, ui) {
                if (!ui.content || ui.content.length === 0) return;

                if (ui.content.length === 1) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    return;
                }

                if (scanned_term) {
                    let exactMatch = ui.content.find(item => item.barcode && item.barcode.toString().trim().toLowerCase() === scanned_term.toLowerCase());
                    if (exactMatch) {
                        ui.item = exactMatch;
                        $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                        $(this).autocomplete('close');
                        return;
                    }
                }
            },
            minLength: 1,
            delay: 150
        });

        // Remove row
        $(document).on('click', '.remove-btn', function() {
            let itemIndex = $(this).attr('data-value');
            if (itemIndex !== undefined && itemIndex !== '') {
                localData.splice(parseInt(itemIndex), 1);
                try {
                    localStorage.setItem('transfer-items', JSON.stringify(localData));
                } catch(e) {}
            }
            $(this).closest('tr').remove();
            estimatedAmount();
        });

        // DOM Prepend function
        function domPrepend(data = null, index = null, variation_code = null) {
            if (!data || !data.product) return;
            var name = data.product.name || '';
            var quantity_data = '';
            var variation_data = '';
            var imei_section = '';
            let main_qty_val = 1;
            let sub_qty_val = 0;

            let unitName = (data.product.unit && data.product.unit.name) ? data.product.unit.name : 'pcs';
            let relatedValue = (data.product.unit && data.product.unit.related_value) ? data.product.unit.related_value : 1;
            let hasSubUnit = (data.product.unit && data.product.unit.related_unit != null);

            if (data.product.imei == 1 || data.product.imei == '1') {
                let options = '';
                if (data.imeis && data.imeis.length > 0) {
                    data.imeis.forEach(imei => {
                        let serialStr = (typeof imei === 'object' && imei !== null) ? (imei.serial || '') : imei;
                        if (serialStr) {
                            options += `<option value="${serialStr}">${serialStr}</option>`;
                        }
                    });
                }
                imei_section = `
                    <div class="mt-2 text-left">
                        <small class="text-danger font-weight-bold">{{ __('Select IMEIs') }}</small>
                        <select name="imei[${index}][]" class="form-control select2 mt-1" multiple>
                            ${options}
                        </select>
                    </div>
                `;
            }

            let displayStock = '';
            if (typeof data.stock_qty === 'object' && data.stock_qty !== null && data.stock_qty.available_stock !== undefined) {
                displayStock = data.stock_qty.available_stock;
            } else {
                displayStock = data.stock_qty || 0;
            }

            if (data.variations && data.variations.length > 0) {
                variation_data += `<input type="text" class="has_size" data-has-size="true" hidden>
                <select name="variation_id[]" class="form-control size" required>
                <option value="">{{ __('Select Variation') }}</option>`;

                $.each(data.variations, function(idx, value) {
                    if (parseFloat(value.stock) <= 0) return;
                    let selected = (variation_code && parseInt(variation_code) === value.id) ? "selected" : "";
                    variation_data += `<option stock='${value.stock}' value='${value.id}' ${selected}>
                    ${value.size || ''} - ${value.color || ''} [Stock: ${value.stock}]</option>`;
                });

                variation_data += '</select>';
            } else {
                variation_data = `<input type="text" class="has_size" data-has-size="false" hidden>
                <input type="hidden" name="variation_id[]">`;
            }

            let purchasePrice = parseFloat(data.product.purchase_price) || 0;
            let initialSubtotal = calculate_sub_total(
                1,
                0,
                purchasePrice,
                relatedValue,
                hasSubUnit ? "true" : "false"
            );

            if (data.product.is_service == 0) {
                if (!hasSubUnit) {
                    quantity_data = `
                        <input type="text" class="has_sub_unit" hidden value="false">
                        <label class="ml-2 mr-2" style="padding-top: 5px;">${unitName}:</label>
                        <input type="text" class="form-control quantity-input" value="${main_qty_val}" 
                            placeholder="e.g., 5" 
                            data-related="${relatedValue}" 
                            data-stock="${displayStock}">
                        <input type="hidden" class="main_qty" name="main_qty[]" value="1">
                        <input type="hidden" class="sub_qty" name="sub_qty[]" value="0">`;
                } else {
                    quantity_data = `
                        <input type="text" class="has_sub_unit" hidden value="true">
                        <input type="text" class="conversion" hidden value="${relatedValue}">
                        <label class="mr-4 ml-1" style="padding-top: 5px;">${unitName}:</label>
                        <input type="text" class="form-control quantity-input" value="${main_qty_val}" 
                            placeholder="e.g., 5" 
                            data-related="${relatedValue}" 
                            data-stock="${displayStock}">
                        <input type="hidden" class="main_qty" name="main_qty[]" value="1">
                        <input type="hidden" class="sub_qty" name="sub_qty[]" value="0">`;
                }
            } else {
                quantity_data = `
                    <label class="ml-2 mr-2" style="padding-top: 5px;">pcs:</label>
                    <input type="number" value="1" class="form-control col main_qty" 
                        name="main_qty[]" onkeydown="return event.keyCode !== 190" min="0">`;
            }

            let dom = `
                <tr id="tbody_tr">
                    <td class="table_data_style_left" style="min-width: 100px;">
                        ${data.product.name + " - " + (data.product.barcode || '') } (${displayStock})
                        ${imei_section}
                        <input type="hidden" class="name" 
                            value="${name.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '')}" name="name[]" />
                        <input type="hidden" value="${data.product.id}" name="product_id[]" />
                    </td>
                    <td style="min-width: 120px;">
                        ${variation_data}
                    </td>
                    <td>
                        <input type="number" step="any" style="min-width: 100px;" 
                            value="${purchasePrice}" 
                            class="form-control rate" name="rate[]" />
                    </td>
                    <td>
                        <div class="form-row" style="min-width: 100px;">
                            ${quantity_data}
                        </div>
                    </td>
                    <td hidden>
                        <input type="text" style="min-width: 100px;" 
                            class="form-control product_discount" 
                            name="product_discount[]" value="0" placeholder="Discount" />
                    </td>
                    <td>
                        <input type="number" step="any" style="min-width: 100px;" readonly 
                            name="sub_total[]" class="form-control sub_total" 
                            value="${initialSubtotal}"/>
                    </td>
                    <td class="table_data_style_right">
                        <a href="javascript:void(0)" class="remove-btn item-index" data-value="${index}">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            `;

            $("#tbody").prepend(dom);
            $('.select2').select2();
        }

        function parseStockText(stockText, has_sub_unit, related_by = 1) {
            if (!stockText && stockText !== 0) return 0;

            if (!has_sub_unit || has_sub_unit === "false") {
                return parseFloat(stockText) || 0;
            }

            if (typeof stockText === 'object' && stockText.available_stock !== undefined) {
                return parseFloat(stockText.available_stock) || 0;
            }

            if (typeof stockText === 'string') {
                let numbers = stockText.match(/\d+(\.\d+)?/g);
                let main = numbers && numbers[0] ? parseFloat(numbers[0]) : 0;
                let sub = numbers && numbers[1] ? parseFloat(numbers[1]) : 0;
                return main + (sub / related_by);
            }

            return parseFloat(stockText) || 0;
        }

        $(document).on('keyup change', '.quantity-input', function(e) {
            let row = $(this).closest('tr');
            let input = $(this).val();
            let related_by = parseInt($(this).attr('data-related')) || 1;
            let has_sub_unit = row.find('.has_sub_unit').val();

            let variation_select = row.find('select[name="variation_id[]"]');
            let stock = 0;

            if (variation_select.length > 0 && variation_select.val()) {
                let selectedOption = variation_select.find('option:selected');
                let variationStock = parseFloat(selectedOption.attr('stock')) || 0;
                stock = (has_sub_unit === "true" || has_sub_unit === true) ? variationStock * related_by : variationStock;
            } else {
                let stockText = $(this).attr('data-stock');
                let stock_qty = parseStockText(stockText, has_sub_unit, related_by);
                stock = stock_qty * related_by;
            }

            let quantities = parseQuantityInput(input, related_by);
            let total_quantity = to_sub_unit(
                quantities.main_qty,
                quantities.sub_qty,
                related_by,
                has_sub_unit
            );

            if (stock > 0 && stock < total_quantity) {
                iziToast.warning({
                    title: "{{ __('Not Enough Stock in branch.') }}",
                    position: "topRight",
                });

                let converted = convert_to_main_and_sub(stock, has_sub_unit, related_by);
                quantities.main_qty = converted.main_qty;
                quantities.sub_qty = converted.sub_qty;

                $(this).val(
                    quantities.main_qty +
                    (quantities.sub_qty > 0 ?
                        '.' + quantities.sub_qty.toString().padStart(3, '0').substring(0, 3) :
                        '')
                );
            }

            row.find('.main_qty').val(quantities.main_qty);
            row.find('.sub_qty').val(quantities.sub_qty);

            handle_change($(this));
        });

        function handle_change(obj) {
            let row = obj.closest('tr');

            let main_val = parseInt(empty_field_check(row.find('.main_qty').val())) || 0;
            let sub_val = parseInt(empty_field_check(row.find('.sub_qty').val())) || 0;

            let related_by = parseInt(row.find('.quantity-input').attr('data-related')) || 1;
            let has_sub_unit = row.find('.has_sub_unit').val();

            let variation_select = row.find('select[name="variation_id[]"]');
            let stock = 0;

            if (variation_select.length > 0 && variation_select.val()) {
                let selectedOption = variation_select.find('option:selected');
                let variationStock = parseFloat(selectedOption.attr('stock')) || 0;
                stock = (has_sub_unit === "true" || has_sub_unit === true) ? variationStock * related_by : variationStock;
            } else {
                let stockText = row.find('.quantity-input').attr('data-stock');
                let stock_qty = parseStockText(stockText, has_sub_unit, related_by);
                stock = stock_qty * related_by;
            }

            let converted_sub = to_sub_unit(main_val, sub_val, related_by, has_sub_unit);

            if (stock > 0 && stock < converted_sub) {
                iziToast.warning({
                    title: "{{ __('Not Enough Stock in branch.') }}",
                    position: "topRight",
                });

                let converted = convert_to_main_and_sub(stock, has_sub_unit, related_by);
                main_val = converted.main_qty;
                sub_val = converted.sub_qty;
                row.find('.main_qty').val(main_val);
                row.find('.sub_qty').val(sub_val);
            }

            let price = parseFloat(row.find('.rate').val()) || 0;
            let subTotal = calculate_sub_total(main_val, sub_val, price, related_by, has_sub_unit);

            row.find('.sub_total').val(subTotal);
            estimatedAmount();
        }

        $(document).on('keyup change', '.rate', function(e) {
            handle_change($(this));
        });

        $(document).on('keyup change', '.main_qty', function(e) {
            handle_change($(this));
        });

        $(document).on('change', 'select[name="variation_id[]"]', function() {
            handle_change($(this));
        });

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

        function totalCalculate() {
            let estimated_amount = parseFloat($("input[name='estimated_amount']").val()) || 0;
            $("#grand_total").text(estimated_amount.toFixed(2));
            $("#payable_amount").val(estimated_amount.toFixed(2));
        }

        // Checkout button
        $("#checkout").on("click", function() {
            var toBranch = $("#to_branch_id").val();
            if (!toBranch) {
                iziToast.warning({
                    title: "{{ __('Please select Destination (To) Branch.') }}",
                    position: "topRight",
                });
                $('#to_branch_id').select2('open');
                return false;
            }

            var rowCount = $("#tbody").find("tr").length;
            if (rowCount === 0) {
                iziToast.warning({
                    title: "{{ __('Please add at least one product to transfer.') }}",
                    position: "topRight",
                });
                $('#product_search').focus();
                return false;
            }

            try {
                localStorage.removeItem('transfer-items');
            } catch(e) {}
            
            $("#payment_form").submit();
        });
    </script>
@endpush
