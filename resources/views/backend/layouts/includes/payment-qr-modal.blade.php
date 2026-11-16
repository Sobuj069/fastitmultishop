<!-- ===== PAYMENT SECTION / BANGLA QR MODAL (WHITE THEME SIMPLE) ===== -->
<div class="modal fade" id="paymentQrModal" tabindex="-1" role="dialog" aria-labelledby="paymentQrModalLabel" aria-hidden="true" style="z-index: 10050;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 440px; margin: 1.5rem auto;">
        <div class="modal-content" style="border: 1px solid #e2e8f0; border-radius: 22px; background: #ffffff; box-shadow: 0 20px 45px rgba(0, 0, 0, 0.14); color: #0f172a; overflow: hidden;">
            
            {{-- Modal Header (White Theme) --}}
            <div class="modal-header px-4 py-3 border-0 d-flex align-items-center justify-content-between" style="background: #ffffff; border-bottom: 1px solid #f1f5f9 !important; display: flex; align-items: center; justify-content: space-between;">
                <div class="d-flex align-items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                    <span class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm border border-blue-100" style="width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16" style="width: 16px; height: 16px;">
                            <path d="M2 2h2v2H2z"/>
                            <path d="M6 0v6H0V0zM1 1v4h4V1zm7 0h2v1H8zm3 0h1v2h-1zm2 1h1v1h-1zm2 0h1v1h-1zM9 3h1v1H9zm1 1h1v1h-1zm2 0h1v1h-1zm3 0h1v1h-1zm-4 1h1v1h-1zm2 0h1v1h-1zm-6 2h1v1H7zm1 0h1v1H8zm1 0h1v1H9zm3 0h1v1h-1zm1 0h1v1h-1zm2 0h1v1h-1zm-9 1h1v1H7zm1 0h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm3 0h1v1h-1zM0 10v6h6v-6zm1 1v4h4v-4zm1 1h2v2H2zm8-2h1v1h-1zm1 0h1v2h-1zm3 0h2v1h-2zm-2 1h1v1h-1zm3 0h1v1h-1zm-4 1h2v1h-2zm3 0h1v1h-1zm-2 1h1v1h-1zm2 0h2v1h-2zm-3 1h1v1h-1zm1 0h1v1h-1zm2 0h1v2h-1zm-3 1h2v1h-2zm-8-3v2h2v-2zm1-7v2h2V4zm-7 6v2h2v-2zm10-7h2v2h-2zm-1 6h2v2h-2zm-6 0h2v2H4zm1 7h2v2H5zm10-1h1v1h-1zm-3-1h1v1h-1zm-1 1h1v1h-1zm1 1h1v1h-1zm2-1h1v1h-1zm-3-3h1v1h-1zm-1 1h1v1h-1zm3-1h1v1h-1z"/>
                            <path d="M10 0v6h6V0zm5 1v4h-4V1zm-3 1h2v2h-2z"/>
                        </svg>
                    </span>
                    <div>
                        <h5 class="modal-title font-bold text-base m-0 text-slate-800" id="paymentQrModalLabel" style="color: #0f172a; font-weight: 700; margin: 0; font-size: 15px;">
                            {{ __('Payment Section') }}
                        </h5>
                        <p class="text-xs text-slate-500 m-0" style="color: #64748b; font-size: 11px; margin: 0;">NRB Bank Bangla QR • Scan & Pay</p>
                    </div>
                </div>
                <button type="button" class="close text-slate-400 hover:text-slate-700 transition-colors" data-dismiss="modal" onclick="closePaymentQrModal()" aria-label="Close" style="background: none; border: none; font-size: 26px; line-height: 1; color: #64748b; opacity: 0.8; padding: 0 4px; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Modal Body (White / Soft Light Gray Theme) --}}
            <div class="modal-body p-3 p-sm-4 text-center" style="background: #f8fafc; padding: 1rem;">
                
                {{-- Dynamic License Expiry Alert (If Expiring or Expired) --}}
                @php
                    $licenseInfo = function_exists('get_license_info') ? get_license_info() : null;
                @endphp

                @if(!empty($licenseInfo) && ($licenseInfo['is_expiring'] || $licenseInfo['is_expired']))
                    <div class="mb-3 p-3 text-left position-relative mx-auto rounded-xl shadow-sm" style="max-width: 370px; border: 1px solid {{ $licenseInfo['is_expired'] ? '#fecaca' : '#fde68a' }}; background: {{ $licenseInfo['is_expired'] ? '#fef2f2' : '#fffbeb' }}; border-radius: 14px; text-align: left;">
                        <div class="d-flex align-items-center gap-2 mb-1" style="display: flex; align-items: center; gap: 6px; color: {{ $licenseInfo['is_expired'] ? '#991b1b' : '#92400e' }}; font-weight: 700; font-size: 13px; margin-bottom: 4px;">
                            <svg fill="currentColor" viewBox="0 0 20 20" style="width: 16px; height: 16px; flex-shrink: 0;">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>
                                @if($licenseInfo['is_expired'])
                                    {{ __('License Expired') }}
                                @else
                                    {{ __('License Expiring Soon') }} ({{ $licenseInfo['days_left'] }} {{ App::getLocale() == 'bn' ? 'দিন বাকি' : ($licenseInfo['days_left'] == 1 ? 'Day Left' : 'Days Left') }})
                                @endif
                            </span>
                        </div>
                        <p style="font-size: 11.5px; color: {{ $licenseInfo['is_expired'] ? '#b91c1c' : '#b45309' }}; margin: 0; line-height: 1.45; font-weight: 500;">
                            {{ $licenseInfo['warning_message'] }}
                        </p>
                        <div style="margin-top: 8px; padding-top: 6px; border-top: 1px dashed {{ $licenseInfo['is_expired'] ? '#fca5a5' : '#fcd34d' }}; display: flex; align-items: center; justify-content: space-between; font-size: 10.5px; color: #475569;">
                            <span>{{ __('Plan') }}: <strong style="color: #0f172a; text-transform: uppercase;">{{ $licenseInfo['plan_type'] }}</strong></span>
                            <span>{{ __('Expires') }}: <strong style="color: #0f172a;">{{ $licenseInfo['expires_at'] }}</strong></span>
                        </div>
                    </div>
                @endif

                {{-- Physical Standee Design (Clean & Pixel Perfect) --}}
                <div id="printablePaymentStandee" class="nrb-standee-card text-left position-relative mx-auto" style="max-width: 370px; background: linear-gradient(180deg, #0b4ea2 0%, #06397e 100%); border-radius: 20px; padding: 10px; box-shadow: 0 10px 25px rgba(11, 78, 162, 0.22); border: 1px solid rgba(255, 255, 255, 0.3); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    
                    {{-- Top White Header with NRB Bank & Bangla QR logos --}}
                    <div class="d-flex align-items-center justify-content-between px-3 py-2 bg-white rounded-top" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #ffffff; border-radius: 14px 14px 4px 4px; border-bottom: 3px solid #dc2626;">
                        {{-- NRB Bank Brand --}}
                        <div class="d-flex align-items-center" style="display: flex; align-items: center; gap: 8px;">
                            {{-- 4-diamond star logo --}}
                            <svg width="24" height="24" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <polygon points="50,5 62,38 50,50 38,38" fill="#dc2626" />
                                <polygon points="50,95 62,62 50,50 38,62" fill="#dc2626" />
                                <polygon points="5,50 38,38 50,50 38,62" fill="#0b4ea2" />
                                <polygon points="95,50 62,38 50,50 62,62" fill="#0b4ea2" />
                                <circle cx="50" cy="50" r="5" fill="#10b981" />
                            </svg>
                            <div style="line-height: 1.1;">
                                <div style="font-size: 15px; font-weight: 900; color: #0b4ea2; letter-spacing: -0.3px;">NRB Bank<span style="color:#dc2626;">.</span></div>
                                <div style="font-size: 8px; font-weight: 600; color: #334155;">Not Just Another Bank</div>
                            </div>
                        </div>

                        {{-- Bangla QR Logo --}}
                        <div class="text-right" style="text-align: right; line-height: 1.1;">
                            <div style="font-size: 9px; font-weight: 900; color: #dc2626; letter-spacing: 0.5px;">BANGLA</div>
                            <div style="display: inline-flex; align-items: center; justify-content: center; border: 2px solid #059669; border-radius: 4px; padding: 1px 4px; color: #059669; font-weight: 900; font-size: 9.5px; letter-spacing: 0.5px;">
                                QR
                            </div>
                        </div>
                    </div>

                    {{-- Inner White Card Container --}}
                    <div class="bg-white my-2 p-3 text-center" style="background: #ffffff; margin: 8px 0; padding: 12px; border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); text-align: center;">
                        
                        {{-- Bengali Headline --}}
                        <div class="mb-2" style="color: #0b4ea2; font-size: 12px; font-weight: 800; line-height: 1.35; padding: 0 4px; margin-bottom: 8px;">
                            যে কোনো ব্যাংক অ্যাপ অথবা MFS থেকে স্ক্যান করে পেমেন্ট করুন
                        </div>

                        {{-- High-Resolution QR Code with Center NRB Bank Logo --}}
                        <div class="position-relative d-inline-block p-1 bg-white" style="display: inline-block; padding: 4px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;">
                            <img src="{{ asset('uploads/nrb_bangla_qr_with_logo.png') }}" 
                                 alt="FAST IT NRB Bank Bangla QR" 
                                 class="img-fluid" 
                                 style="width: 220px; height: 220px; display: block; border-radius: 6px; margin: 0 auto;">
                        </div>

                        {{-- Merchant Info (Exact text from standee) --}}
                        <div class="mt-2" style="margin-top: 8px; color: #0f172a;">
                            <div style="font-size: 17px; font-weight: 900; letter-spacing: 0.5px; color: #0f172a; text-transform: uppercase;">
                                FAST IT
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-2 my-1" style="display: flex; align-items: center; justify-content: center; gap: 8px; margin: 4px 0;">
                                <span style="font-size: 16px; font-weight: 800; color: #0b4ea2; letter-spacing: 0.5px;">
                                    01784159071
                                </span>
                                <button type="button" onclick="copyPaymentNumber('01784159071')" class="btn btn-sm py-0 px-1 text-slate-400 hover:text-blue-600" title="Copy Number" style="background: none; border: none; font-size: 13px; cursor: pointer; color: #64748b; padding: 0 4px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                </button>
                            </div>
                            <div style="font-size: 10.5px; font-weight: 600; color: #475569; line-height: 1.35; max-width: 280px; margin: 0 auto;">
                                1/A, Senpara Parbata Shah Ali Plaza Office Space-1417, Mirpur-10, Dhaka
                            </div>
                        </div>
                    </div>

                    {{-- Standee Footer Area --}}
                    <div class="d-flex align-items-center justify-content-between px-2 pt-1 pb-1" style="display: flex; align-items: center; justify-content: space-between; padding: 4px 8px; color: #ffffff;">
                        {{-- Left side call center info --}}
                        <div style="flex: 1;">
                            <div style="font-size: 7.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.95; margin-bottom: 2px;">
                                24 HOURS CALL CENTER
                            </div>
                            <div class="d-flex align-items-center" style="display: flex; align-items: center; gap: 6px; font-size: 12px;">
                                <a href="https://wa.me/8801784159071" target="_blank" style="color: #ffffff; text-decoration: none;" title="WhatsApp">
                                    <span style="border: 1px solid rgba(255,255,255,0.6); border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    </span>
                                </a>
                                <a href="https://fastit.com.bd" target="_blank" style="color: #ffffff; text-decoration: none;" title="Website">
                                    <span style="border: 1px solid rgba(255,255,255,0.6); border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>
                                    </span>
                                </a>
                                <a href="https://www.facebook.com/fastit.com.bd" target="_blank" style="color: #ffffff; text-decoration: none;" title="Facebook">
                                    <span style="border: 1px solid rgba(255,255,255,0.6); border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.688 5H18V0h-3.808C10.596 0 9 1.583 9 4.615V8z"/></svg>
                                    </span>
                                </a>
                            </div>
                        </div>

                        {{-- Center Divider --}}
                        <div style="width: 1px; height: 34px; background: rgba(255,255,255,0.3); margin: 0 6px;"></div>

                        {{-- Right side phone & web --}}
                        <div class="text-right" style="text-align: right; flex: 1.2; line-height: 1.15;">
                            <div style="font-size: 18px; font-weight: 900; letter-spacing: 0.5px; color: #ffffff;">
                                16568
                            </div>
                            <div style="font-size: 7.5px; opacity: 0.88; font-weight: 500;">
                                +88 09666456000<br>
                                www.nrbbankbd.com<br>
                                www.facebook.com/nrbbankbd
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Compatible Apps Badges --}}
                <div class="mt-3 pt-2 text-center" style="margin-top: 12px; padding-top: 8px; border-top: 1px solid #e2e8f0; text-align: center;">
                    <p class="text-xs text-slate-500 m-0 font-medium" style="color: #64748b; font-size: 11px; margin: 0;">
                        <span style="color: #10b981; font-weight: 700;">✓</span>
                        {{ __('Accepted Apps: bKash, Nagad, Rocket, Cellfin, NRB Bank & All Bangla QR Apps') }}
                    </p>
                </div>

            </div>

            {{-- Modal Footer Actions (White Theme) --}}
            <div class="modal-footer px-4 py-3 border-0 d-flex align-items-center justify-content-between" style="background: #ffffff; border-top: 1px solid #f1f5f9 !important; display: flex; align-items: center; justify-content: space-between; padding: 12px 16px;">
                <div class="d-flex align-items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                    <button type="button" onclick="printPaymentStandee()" class="btn btn-sm btn-light border rounded-xl font-bold px-3 py-2 text-xs d-flex align-items-center gap-1.5 hover:bg-slate-100 transition-all" style="color: #334155; background: #f8fafc; border: 1px solid #cbd5e1 !important; border-radius: 12px; font-size: 12px; font-weight: 700; padding: 6px 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        {{ __('Print Standee') }}
                    </button>
                    <a href="{{ asset('uploads/nrb_bangla_qr_with_logo.png') }}" download="FAST_IT_Bangla_QR.png" class="btn btn-sm btn-light border rounded-xl font-bold px-3 py-2 text-xs d-flex align-items-center gap-1.5 hover:bg-slate-100 transition-all" style="color: #334155; background: #f8fafc; border: 1px solid #cbd5e1 !important; border-radius: 12px; font-size: 12px; font-weight: 700; padding: 6px 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        {{ __('Download') }}
                    </a>
                </div>
                <button type="button" class="btn btn-sm btn-primary rounded-xl font-bold px-4 py-2 text-xs shadow-sm" data-dismiss="modal" onclick="closePaymentQrModal()" style="background: #2563eb; color: #ffffff; border: none; border-radius: 12px; font-size: 12px; font-weight: 700; padding: 6px 16px; cursor: pointer;">
                    {{ __('Done') }}
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Universal Styles for Payment QR Modal & Printing Standee --}}
<style>
#paymentQrModal.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 10050;
    overflow-x: hidden;
    overflow-y: auto;
    outline: 0;
}
#paymentQrModal.modal:not(.show) {
    display: none;
}
#paymentQrModal.modal.show {
    display: flex !important;
    align-items: center;
    justify-content: center;
}
#paymentQrModal .modal-dialog {
    margin: 1.5rem auto;
    max-width: 440px;
    width: 94%;
    pointer-events: auto;
}
@media (max-width: 576px) {
    #paymentQrModal .modal-dialog {
        max-width: 96%;
        margin: 0.75rem auto;
    }
}
@media print {
    body * {
        visibility: hidden !important;
    }
    #printablePaymentStandee, #printablePaymentStandee * {
        visibility: visible !important;
    }
    #printablePaymentStandee {
        position: fixed !important;
        left: 50% !important;
        top: 50% !important;
        transform: translate(-50%, -50%) !important;
        width: 380px !important;
        box-shadow: none !important;
        border: 1px solid #ccc !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}
</style>

{{-- Universal Scripts for Payment QR Modal --}}
<script>
    function openPaymentQrModal() {
        var modal = document.getElementById('paymentQrModal');
        if (!modal) return;

        if (typeof jQuery !== 'undefined' && typeof jQuery.fn.modal !== 'undefined') {
            $('#paymentQrModal').modal('show');
        } else {
            modal.classList.add('show');
            modal.style.display = 'flex';
            modal.setAttribute('aria-modal', 'true');
            modal.removeAttribute('aria-hidden');

            var backdrop = document.getElementById('paymentQrModalBackdrop');
            if (!backdrop) {
                backdrop = document.createElement('div');
                backdrop.id = 'paymentQrModalBackdrop';
                backdrop.className = 'modal-backdrop fade show';
                backdrop.style.cssText = 'position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.65); z-index: 10040; backdrop-filter: blur(2px);';
                backdrop.onclick = closePaymentQrModal;
                document.body.appendChild(backdrop);
            }
            document.body.classList.add('modal-open');
        }
    }

    function closePaymentQrModal() {
        var modal = document.getElementById('paymentQrModal');
        if (!modal) return;

        if (typeof jQuery !== 'undefined' && typeof jQuery.fn.modal !== 'undefined') {
            $('#paymentQrModal').modal('hide');
        }

        modal.classList.remove('show');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        modal.removeAttribute('aria-modal');

        var backdrop = document.getElementById('paymentQrModalBackdrop');
        if (backdrop) {
            backdrop.remove();
        }
        document.body.classList.remove('modal-open');
    }

    // Close on Escape key press
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            closePaymentQrModal();
        }
    });

    function copyPaymentNumber(number) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(number).then(function() {
                showCopyToast(number);
            }).catch(function() {
                fallbackCopyText(number);
            });
        } else {
            fallbackCopyText(number);
        }
    }

    function fallbackCopyText(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showCopyToast(text);
        } catch (err) {}
        document.body.removeChild(textArea);
    }

    function showCopyToast(number) {
        if (typeof iziToast !== 'undefined') {
            iziToast.success({
                title: 'Copied!',
                message: number + ' copied to clipboard',
                position: 'topRight'
            });
        } else if (typeof toastMagic !== 'undefined') {
            toastMagic.success('Number copied: ' + number);
        } else {
            alert('Copied to clipboard: ' + number);
        }
    }

    function printPaymentStandee() {
        window.print();
    }
</script>
