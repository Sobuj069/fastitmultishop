@extends('backend.layouts.master')
@section('section-title', __('CRM'))
@section('page-title', __('Customer Rewards & Loyalty Settings'))

@section('action-button')
    <a href="{{ route('customer.index') }}" class="btn add_list_btn">
        <i class="mr-2 feather icon-users"></i>
        {{ __('Customer List') }}
    </a>
@endsection

@push('css')
<style>
    .reward-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease-in-out;
    }
    .reward-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
    }
    .reward-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 700;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .reward-body {
        padding: 24px;
    }
    .calc-box {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 16px;
    }
    .calc-result-pill {
        display: inline-block;
        padding: 6px 14px;
        background: #0ea5e9;
        color: #ffffff;
        border-radius: 20px;
        font-weight: 700;
        font-size: 14px;
    }
    
    /* Dark Mode Overrides */
    .dark-theme .reward-card,
    body.dark-theme .reward-card {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    .dark-theme .reward-header,
    body.dark-theme .reward-header {
        border-bottom-color: #334155 !important;
        color: #f8fafc !important;
    }
    .dark-theme .calc-box,
    body.dark-theme .calc-box {
        background: #0f172a !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    .dark-theme .form-control,
    body.dark-theme .form-control {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('customer.loyalty.setting.update') }}" method="POST">
            @csrf
            
            <div class="row">
                {{-- Point Earning Section --}}
                <div class="col-lg-6 mb-4">
                    <div class="reward-card h-100">
                        <div class="reward-header text-primary">
                            <i class="feather icon-plus-circle font-weight-bold" style="font-size: 20px;"></i>
                            <span>{{ __('1. Point Earning Rule (পয়েন্ট অর্জন নীতি)') }}</span>
                        </div>
                        <div class="reward-body">
                            <p class="text-muted mb-4" style="font-size: 13.5px;">
                                {{ __('Define how much customers need to spend on sales/invoices to earn loyalty points.') }}
                            </p>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark mb-1">
                                    {{ __('Spending Amount') }} ({{ empty(get_setting('com_currency')) ? '৳' : get_setting('com_currency') }}) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text font-weight-bold">{{ empty(get_setting('com_currency')) ? '৳' : get_setting('com_currency') }}</span>
                                    </div>
                                    <input type="number" step="any" min="1" class="form-control font-weight-bold" id="loyalty_spend_per_point" name="loyalty_spend_per_point" value="{{ old('loyalty_spend_per_point', $spendPerPoint) }}" required>
                                </div>
                                <small class="form-text text-muted">{{ __('Amount in Taka a customer must purchase (e.g., 100).') }}</small>
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-dark mb-1">
                                    {{ __('Points Earned per Spending') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" step="any" min="0.01" class="form-control font-weight-bold" id="loyalty_point_per_spend" name="loyalty_point_per_spend" value="{{ old('loyalty_point_per_spend', $pointPerSpend) }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text font-weight-bold">{{ __('Points (pts)') }}</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">{{ __('Points awarded for the above spending amount (e.g., 1).') }}</small>
                            </div>

                            <div class="calc-box">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="font-weight-bold" style="font-size: 13px;">{{ __('Earning Summary:') }}</span>
                                    <span class="badge badge-primary px-2 py-1">{{ __('Active Formula') }}</span>
                                </div>
                                <div class="text-dark font-weight-bold" style="font-size: 14px;" id="earningSummaryText">
                                    Every <strong>{{ $spendPerPoint }} {{ empty(get_setting('com_currency')) ? '৳' : get_setting('com_currency') }}</strong> spent = <strong>{{ $pointPerSpend }} Point(s)</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Point Redemption Section --}}
                <div class="col-lg-6 mb-4">
                    <div class="reward-card h-100">
                        <div class="reward-header text-success">
                            <i class="feather icon-gift font-weight-bold" style="font-size: 20px;"></i>
                            <span>{{ __('2. Point Redemption Rule (পয়েন্ট ভাঙ্গানো / রিডিম নীতি)') }}</span>
                        </div>
                        <div class="reward-body">
                            <p class="text-muted mb-4" style="font-size: 13.5px;">
                                {{ __('Define the monetary discount value of each point when a customer redeems points during checkout.') }}
                            </p>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark mb-1">
                                    {{ __('1 Point Equivalent Value') }} ({{ empty(get_setting('com_currency')) ? '৳' : get_setting('com_currency') }}) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text font-weight-bold">{{ empty(get_setting('com_currency')) ? '৳' : get_setting('com_currency') }}</span>
                                    </div>
                                    <input type="number" step="any" min="0.01" class="form-control font-weight-bold" id="loyalty_point_rate" name="loyalty_point_rate" value="{{ old('loyalty_point_rate', $pointRate) }}" required>
                                </div>
                                <small class="form-text text-muted">{{ __('Discount value in Taka for 1 point redeemed (e.g., 0.75 or 1.00).') }}</small>
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-dark mb-1">
                                    {{ __('Minimum Points Required to Redeem') }}
                                </label>
                                <div class="input-group">
                                    <input type="number" step="any" min="0" class="form-control font-weight-bold" id="loyalty_min_redeem_points" name="loyalty_min_redeem_points" value="{{ old('loyalty_min_redeem_points', $minRedeemPoints) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text font-weight-bold">{{ __('Points') }}</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">{{ __('Leave 0 if there is no minimum threshold requirement.') }}</small>
                            </div>

                            <div class="calc-box">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="font-weight-bold" style="font-size: 13px;">{{ __('Redemption Summary:') }}</span>
                                    <span class="badge badge-success px-2 py-1">{{ __('Active Rate') }}</span>
                                </div>
                                <div class="text-dark font-weight-bold" style="font-size: 14px;" id="redemptionSummaryText">
                                    <strong>100 Points</strong> = <strong>{{ number_format(100 * $pointRate, 2) }} {{ empty(get_setting('com_currency')) ? '৳' : get_setting('com_currency') }}</strong> discount
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Live Interactive Simulator / Calculator --}}
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="reward-card">
                        <div class="reward-header text-warning">
                            <i class="feather icon-zap font-weight-bold" style="font-size: 20px;"></i>
                            <span>{{ __('Live Calculator & Preview (লাইভ টেস্ট ও হিসেব)') }}</span>
                        </div>
                        <div class="reward-body">
                            <div class="row align-items-center">
                                <div class="col-md-5 mb-3 mb-md-0">
                                    <label class="font-weight-bold mb-1">{{ __('Sample Purchase Amount:') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ empty(get_setting('com_currency')) ? '৳' : get_setting('com_currency') }}</span>
                                        </div>
                                        <input type="number" id="test_spend" class="form-control font-weight-bold" value="1000">
                                    </div>
                                    <div class="mt-2 text-primary font-weight-bold" style="font-size: 14px;">
                                        ➔ Customer will earn: <span id="test_earned_pts" class="badge badge-primary px-2 py-1 font-weight-bold">10</span> Points
                                    </div>
                                </div>
                                <div class="col-md-2 text-center d-none d-md-block">
                                    <div style="font-size: 24px; color: #cbd5e1;"><i class="feather icon-repeat"></i></div>
                                </div>
                                <div class="col-md-5">
                                    <label class="font-weight-bold mb-1">{{ __('Sample Redeem Points:') }}</label>
                                    <div class="input-group">
                                        <input type="number" id="test_points" class="form-control font-weight-bold" value="50">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ __('Points') }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-success font-weight-bold" style="font-size: 14px;">
                                        ➔ Discount amount: <span id="test_discount_val" class="badge badge-success px-2 py-1 font-weight-bold">37.50</span> {{ empty(get_setting('com_currency')) ? '৳' : get_setting('com_currency') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="row">
                <div class="col-lg-12 text-right">
                    <button type="submit" class="btn save_btn px-4 py-2" style="font-size: 15px; border-radius: 8px;">
                        <i class="feather icon-check-circle mr-1"></i> {{ __('Save Reward Settings') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        var currency = "{{ empty(get_setting('com_currency')) ? '৳' : get_setting('com_currency') }}";

        function updateSummaries() {
            var spend = parseFloat($('#loyalty_spend_per_point').val()) || 1;
            var points = parseFloat($('#loyalty_point_per_spend').val()) || 1;
            var rate = parseFloat($('#loyalty_point_rate').val()) || 0.75;
            var minRedeem = parseFloat($('#loyalty_min_redeem_points').val()) || 0;

            // Update Earning text
            $('#earningSummaryText').html('Every <strong>' + spend + ' ' + currency + '</strong> spent = <strong>' + points + ' Point(s)</strong>');

            // Update Redemption text
            var sampleVal = (100 * rate).toFixed(2);
            var minText = minRedeem > 0 ? ' (Min redeem: ' + minRedeem + ' pts)' : '';
            $('#redemptionSummaryText').html('<strong>100 Points</strong> = <strong>' + sampleVal + ' ' + currency + '</strong> discount' + minText);

            // Update live calculator
            var testSpend = parseFloat($('#test_spend').val()) || 0;
            var testEarned = Math.floor(testSpend / spend) * points;
            $('#test_earned_pts').text(testEarned);

            var testPts = parseFloat($('#test_points').val()) || 0;
            var testDiscount = (testPts * rate).toFixed(2);
            $('#test_discount_val').text(testDiscount);
        }

        $('#loyalty_spend_per_point, #loyalty_point_per_spend, #loyalty_point_rate, #loyalty_min_redeem_points, #test_spend, #test_points').on('input change', updateSummaries);

        updateSummaries();
    });
</script>
@endpush
