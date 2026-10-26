<!-- ===== PAYMENT SECTION / BANGLA QR MODAL (WHITE THEME SIMPLE) ===== -->
<div class="modal fade" id="paymentQrModal" tabindex="-1" role="dialog" aria-labelledby="paymentQrModalLabel" aria-hidden="true" style="z-index: 10050;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 440px; margin: 1.5rem auto;">
        <div class="modal-content" style="border: 1px solid #e2e8f0; border-radius: 22px; background: #ffffff; box-shadow: 0 20px 45px rgba(0, 0, 0, 0.14); color: #0f172a; overflow: hidden;">
            
            {{-- Modal Header (White Theme) --}}
            <div class="modal-header px-4 py-3 border-0 d-flex align-items-center justify-content-between" style="background: #ffffff; border-bottom: 1px solid #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                    </span>
                    <div>
                        <h5 class="modal-title font-bold text-base m-0 text-slate-800" id="paymentQrModalLabel" style="color: #0f172a; font-weight: 700;">
                            {{ __('Payment Section') }}
                        </h5>
                        <p class="text-xs text-slate-500 m-0" style="color: #64748b; font-size: 11px;">NRB Bank Bangla QR • Scan & Pay</p>
                    </div>
                </div>
                <button type="button" class="close text-slate-400 hover:text-slate-700 transition-colors" data-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 26px; line-height: 1; color: #64748b; opacity: 0.8; padding: 0 4px; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Modal Body (White / Soft Light Gray Theme) --}}
            <div class="modal-body p-3 p-sm-4 text-center" style="background: #f8fafc;">
                
                {{-- Physical Standee Design (Clean & Pixel Perfect) --}}
                <div id="printablePaymentStandee" class="nrb-standee-card text-left position-relative mx-auto" style="max-width: 370px; background: linear-gradient(180deg, #0b4ea2 0%, #06397e 100%); border-radius: 20px; padding: 10px; box-shadow: 0 10px 25px rgba(11, 78, 162, 0.22); border: 1px solid rgba(255, 255, 255, 0.3); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    
                    {{-- Top White Header with NRB Bank & Bangla QR logos --}}
                    <div class="d-flex align-items-center justify-content-between px-3 py-2 bg-white rounded-top" style="border-radius: 14px 14px 4px 4px; border-bottom: 3px solid #dc2626;">
                        {{-- NRB Bank Brand --}}
                        <div class="d-flex align-items-center" style="gap: 8px;">
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
                        <div class="text-right" style="line-height: 1.1;">
                            <div style="font-size: 9px; font-weight: 900; color: #dc2626; letter-spacing: 0.5px;">BANGLA</div>
                            <div style="display: inline-flex; align-items: center; justify-content: center; border: 2px solid #059669; border-radius: 4px; padding: 1px 4px; color: #059669; font-weight: 900; font-size: 9.5px; letter-spacing: 0.5px;">
                                QR
                            </div>
                        </div>
                    </div>

                    {{-- Inner White Card Container --}}
                    <div class="bg-white my-2 p-3 text-center" style="border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                        
                        {{-- Bengali Headline --}}
                        <div class="mb-2" style="color: #0b4ea2; font-size: 12px; font-weight: 800; line-height: 1.35; padding: 0 4px;">
                            যে কোনো ব্যাংক অ্যাপ অথবা MFS থেকে স্ক্যান করে পেমেন্ট করুন
                        </div>

                        {{-- High-Resolution QR Code with Center NRB Bank Logo --}}
                        <div class="position-relative d-inline-block p-1 bg-white" style="border: 1px solid #e2e8f0; border-radius: 12px;">
                            <img src="{{ asset('uploads/nrb_bangla_qr_with_logo.png') }}" 
                                 alt="FAST IT NRB Bank Bangla QR" 
                                 class="img-fluid" 
                                 style="width: 220px; height: 220px; display: block; border-radius: 6px;">
                        </div>

                        {{-- Merchant Info (Exact text from standee) --}}
                        <div class="mt-2" style="color: #0f172a;">
                            <div style="font-size: 17px; font-weight: 900; letter-spacing: 0.5px; color: #0f172a; text-transform: uppercase;">
                                FAST IT
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-2 my-1">
                                <span style="font-size: 16px; font-weight: 800; color: #0b4ea2; letter-spacing: 0.5px;">
                                    01784159071
                                </span>
                                <button type="button" onclick="copyPaymentNumber('01784159071')" class="btn btn-sm py-0 px-1 text-slate-400 hover:text-blue-600" title="Copy Number" style="background: none; border: none; font-size: 13px; cursor: pointer; color: #64748b;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px; display: inline-block;">
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
                    <div class="d-flex align-items-center justify-content-between px-2 pt-1 pb-1" style="color: #ffffff;">
                        {{-- Left side call center info --}}
                        <div style="flex: 1;">
                            <div style="font-size: 7.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.95; margin-bottom: 2px;">
                                24 HOURS CALL CENTER
                            </div>
                            <div class="d-flex align-items-center" style="gap: 6px; font-size: 12px;">
                                <i class="fa fa-whatsapp" style="border: 1px solid rgba(255,255,255,0.6); border-radius: 50%; padding: 2px; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 10px;"></i>
                                <i class="fa fa-globe" style="border: 1px solid rgba(255,255,255,0.6); border-radius: 50%; padding: 2px; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 10px;"></i>
                                <i class="fa fa-facebook" style="border: 1px solid rgba(255,255,255,0.6); border-radius: 50%; padding: 2px; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 10px;"></i>
                            </div>
                        </div>

                        {{-- Center Divider --}}
                        <div style="width: 1px; height: 34px; background: rgba(255,255,255,0.3); margin: 0 6px;"></div>

                        {{-- Right side phone & web --}}
                        <div class="text-right" style="flex: 1.2; line-height: 1.15;">
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
                <div class="mt-3 pt-2 text-center" style="border-top: 1px solid #e2e8f0;">
                    <p class="text-xs text-slate-500 m-0 font-medium" style="color: #64748b; font-size: 11px;">
                        <span style="color: #10b981; font-weight: 700;">✓</span>
                        {{ __('Accepted Apps: bKash, Nagad, Rocket, Cellfin, NRB Bank & All Bangla QR Apps') }}
                    </p>
                </div>

            </div>

            {{-- Modal Footer Actions (White Theme) --}}
            <div class="modal-footer px-4 py-3 border-0 d-flex align-items-center justify-content-between" style="background: #ffffff; border-top: 1px solid #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" onclick="printPaymentStandee()" class="btn btn-sm btn-light border rounded-xl font-bold px-3 py-2 text-xs d-flex align-items-center gap-1.5 hover:bg-slate-100 transition-all" style="color: #334155; background: #f8fafc; border: 1px solid #cbd5e1 !important;">
                        <i class="fa fa-print mr-1"></i> {{ __('Print Standee') }}
                    </button>
                    <a href="{{ asset('uploads/nrb_bangla_qr_with_logo.png') }}" download="FAST_IT_Bangla_QR.png" class="btn btn-sm btn-light border rounded-xl font-bold px-3 py-2 text-xs d-flex align-items-center gap-1.5 hover:bg-slate-100 transition-all" style="color: #334155; background: #f8fafc; border: 1px solid #cbd5e1 !important;">
                        <i class="fa fa-download mr-1"></i> {{ __('Download') }}
                    </a>
                </div>
                <button type="button" class="btn btn-sm btn-primary rounded-xl font-bold px-4 py-2 text-xs shadow-sm" data-dismiss="modal" style="background: #2563eb; border: none;">
                    {{ __('Done') }}
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Styles for Printing Standee --}}
<style>
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

{{-- Scripts for Payment QR Modal --}}
<script>
    function copyPaymentNumber(number) {
        navigator.clipboard.writeText(number).then(function() {
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
        });
    }

    function printPaymentStandee() {
        window.print();
    }
</script>
