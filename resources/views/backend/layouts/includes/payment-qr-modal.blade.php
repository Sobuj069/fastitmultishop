<!-- ===== PAYMENT SECTION / BANGLA QR MODAL ===== -->
<div class="modal fade" id="paymentQrModal" tabindex="-1" role="dialog" aria-labelledby="paymentQrModalLabel" aria-hidden="true" style="z-index: 10050;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 480px; margin: 1.5rem auto;">
        <div class="modal-content" style="border: none; border-radius: 24px; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(16px); box-shadow: 0 25px 60px rgba(0,0,0,0.5); color: #fff; overflow: hidden;">
            
            {{-- Modal Header --}}
            <div class="modal-header px-4 py-3 border-0 d-flex align-items-center justify-content-between" style="background: rgba(255, 255, 255, 0.04); border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;">
                <div class="d-flex align-items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold text-sm border border-blue-500/30">
                        <i class="fa-solid fa-qrcode"></i>
                    </span>
                    <div>
                        <h5 class="modal-title font-bold text-base m-0 text-white" id="paymentQrModalLabel">
                            {{ __('Payment Section') }}
                        </h5>
                        <p class="text-xs text-slate-400 m-0">NRB Bank Bangla QR • Scan & Pay</p>
                    </div>
                </div>
                <button type="button" class="close text-slate-400 hover:text-white transition-colors" data-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 28px; line-height: 1; opacity: 0.8; padding: 0 5px; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body p-3 p-sm-4 text-center">
                
                {{-- View Toggle Tabs --}}
                <div class="d-flex justify-content-center mb-3">
                    <div class="bg-slate-800/80 p-1 rounded-xl d-inline-flex border border-slate-700/60" role="tablist">
                        <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all payment-tab-btn active" id="tabDigitalBtn" onclick="switchPaymentQrTab('digital')" style="color: #fff; background: #2563eb;">
                            <i class="fa-solid fa-wand-magic-sparkles mr-1"></i> {{ __('Digital Standee') }}
                        </button>
                        <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all payment-tab-btn text-slate-400 hover:text-white" id="tabPhotoBtn" onclick="switchPaymentQrTab('photo')" style="background: transparent;">
                            <i class="fa-solid fa-image mr-1"></i> {{ __('Original Photo') }}
                        </button>
                    </div>
                </div>

                {{-- TAB 1: Digital Card (Pixel-Perfect Recreation of Physical Card) --}}
                <div id="paymentQrDigitalView" class="payment-qr-view">
                    <div id="printablePaymentStandee" class="nrb-standee-card text-left position-relative mx-auto" style="max-width: 380px; background: linear-gradient(180deg, #0b4ea2 0%, #06397e 100%); border-radius: 22px; padding: 10px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.2); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        
                        {{-- Top White Header with NRB Bank & Bangla QR logos --}}
                        <div class="d-flex align-items-center justify-content-between px-3 py-2 bg-white rounded-top" style="border-radius: 14px 14px 4px 4px; border-bottom: 3px solid #dc2626;">
                            {{-- NRB Bank Brand --}}
                            <div class="d-flex align-items-center" style="gap: 8px;">
                                {{-- 4-diamond star logo --}}
                                <svg width="26" height="26" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <polygon points="50,5 62,38 50,50 38,38" fill="#dc2626" />
                                    <polygon points="50,95 62,62 50,50 38,62" fill="#dc2626" />
                                    <polygon points="5,50 38,38 50,50 38,62" fill="#0b4ea2" />
                                    <polygon points="95,50 62,38 50,50 62,62" fill="#0b4ea2" />
                                    <circle cx="50" cy="50" r="5" fill="#10b981" />
                                </svg>
                                <div style="line-height: 1.1;">
                                    <div style="font-size: 16px; font-weight: 900; color: #0b4ea2; letter-spacing: -0.3px;">NRB Bank<span style="color:#dc2626;">.</span></div>
                                    <div style="font-size: 8.5px; font-weight: 600; color: #334155;">Not Just Another Bank</div>
                                </div>
                            </div>

                            {{-- Bangla QR Logo --}}
                            <div class="text-right" style="line-height: 1.1;">
                                <div style="font-size: 9px; font-weight: 900; color: #dc2626; letter-spacing: 1px;">BANGLA</div>
                                <div style="display: inline-flex; align-items: center; justify-content: center; border: 2px solid #059669; border-radius: 4px; padding: 1px 4px; color: #059669; font-weight: 900; font-size: 10px; letter-spacing: 0.5px;">
                                    QR
                                </div>
                            </div>
                        </div>

                        {{-- Inner White Card Container --}}
                        <div class="bg-white my-2 p-3 text-center" style="border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                            
                            {{-- Bengali Headline --}}
                            <div class="mb-2" style="color: #0b4ea2; font-size: 12.5px; font-weight: 800; line-height: 1.35; padding: 0 4px;">
                                যে কোনো ব্যাংক অ্যাপ অথবা MFS থেকে স্ক্যান করে পেমেন্ট করুন
                            </div>

                            {{-- High-Resolution QR Code with Center NRB Bank Logo --}}
                            <div class="position-relative d-inline-block p-1 bg-white" style="border: 1px solid #e2e8f0; border-radius: 14px;">
                                <img src="{{ asset('uploads/nrb_bangla_qr_with_logo.png') }}" 
                                     alt="FAST IT NRB Bank Bangla QR" 
                                     class="img-fluid" 
                                     style="width: 240px; height: 240px; display: block; border-radius: 8px;">
                            </div>

                            {{-- Merchant Info (Exact text from standee) --}}
                            <div class="mt-2" style="color: #0f172a;">
                                <div style="font-size: 18px; font-weight: 900; letter-spacing: 0.5px; color: #0f172a; text-transform: uppercase;">
                                    FAST IT
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-2 my-1">
                                    <span style="font-size: 17px; font-weight: 800; color: #0b4ea2; letter-spacing: 0.5px;">
                                        01784159071
                                    </span>
                                    <button type="button" onclick="copyPaymentNumber('01784159071')" class="btn btn-sm py-0 px-1 text-slate-400 hover:text-blue-600" title="Copy Number" style="background: none; border: none; font-size: 12px; cursor: pointer;">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                                <div style="font-size: 11px; font-weight: 600; color: #475569; line-height: 1.35; max-width: 280px; margin: 0 auto;">
                                    1/A, Senpara Parbata Shah Ali Plaza Office Space-1417, Mirpur-10, Dhaka
                                </div>
                            </div>
                        </div>

                        {{-- Standee Footer Area --}}
                        <div class="d-flex align-items-center justify-content-between px-2 pt-1 pb-1" style="color: #ffffff;">
                            {{-- Left side call center info --}}
                            <div style="flex: 1;">
                                <div style="font-size: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.95; margin-bottom: 3px;">
                                    24 HOURS CALL CENTER
                                </div>
                                <div class="d-flex align-items-center" style="gap: 8px; font-size: 14px;">
                                    <i class="fa-brands fa-whatsapp" style="border: 1px solid rgba(255,255,255,0.6); border-radius: 50%; padding: 3px; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;"></i>
                                    <i class="fa-solid fa-globe" style="border: 1px solid rgba(255,255,255,0.6); border-radius: 50%; padding: 3px; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;"></i>
                                    <i class="fa-brands fa-facebook-f" style="border: 1px solid rgba(255,255,255,0.6); border-radius: 50%; padding: 3px; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;"></i>
                                </div>
                            </div>

                            {{-- Center Divider --}}
                            <div style="width: 1px; height: 38px; background: rgba(255,255,255,0.3); margin: 0 8px;"></div>

                            {{-- Right side phone & web --}}
                            <div class="text-right" style="flex: 1.2; line-height: 1.15;">
                                <div style="font-size: 20px; font-weight: 900; letter-spacing: 0.5px; color: #ffffff;">
                                    16568
                                </div>
                                <div style="font-size: 8px; opacity: 0.88; font-weight: 500;">
                                    +88 09666456000<br>
                                    www.nrbbankbd.com<br>
                                    www.facebook.com/nrbbankbd
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- TAB 2: Original Physical Card Photo --}}
                <div id="paymentQrPhotoView" class="payment-qr-view" style="display: none;">
                    <div class="mx-auto text-center" style="max-width: 380px;">
                        <img src="{{ asset('uploads/nrb_bank_qr_card.png') }}" 
                             alt="Original NRB Bank Bangla QR Card" 
                             class="img-fluid rounded-2xl shadow-lg border border-slate-700/60" 
                             style="max-height: 480px; object-fit: contain; width: 100%;">
                    </div>
                </div>

                {{-- Compatible Apps Badges --}}
                <div class="mt-3 pt-2 text-center" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <p class="text-xs text-slate-400 mb-2 font-medium">
                        <i class="fa-solid fa-shield-halved text-emerald-400 mr-1"></i>
                        {{ __('Accepted Apps: bKash, Nagad, Rocket, Cellfin, NRB Bank, Citytouch & All Bangla QR Apps') }}
                    </p>
                </div>

            </div>

            {{-- Modal Footer Actions --}}
            <div class="modal-footer px-4 py-3 border-0 d-flex align-items-center justify-content-between" style="background: rgba(255, 255, 255, 0.04); border-top: 1px solid rgba(255, 255, 255, 0.08) !important;">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" onclick="printPaymentStandee()" class="btn btn-sm btn-outline-light rounded-xl font-bold px-3 py-2 text-xs d-flex align-items-center gap-1.5 hover:bg-white hover:text-slate-900 transition-all">
                        <i class="fa-solid fa-print"></i> {{ __('Print Standee') }}
                    </button>
                    <a href="{{ asset('uploads/nrb_bangla_qr_with_logo.png') }}" download="FAST_IT_Bangla_QR.png" class="btn btn-sm btn-outline-light rounded-xl font-bold px-3 py-2 text-xs d-flex align-items-center gap-1.5 hover:bg-white hover:text-slate-900 transition-all">
                        <i class="fa-solid fa-download"></i> {{ __('Download') }}
                    </a>
                </div>
                <button type="button" class="btn btn-sm btn-primary rounded-xl font-bold px-4 py-2 text-xs shadow-md" data-dismiss="modal">
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
    function switchPaymentQrTab(tab) {
        const digitalView = document.getElementById('paymentQrDigitalView');
        const photoView = document.getElementById('paymentQrPhotoView');
        const digitalBtn = document.getElementById('tabDigitalBtn');
        const photoBtn = document.getElementById('tabPhotoBtn');

        if (tab === 'digital') {
            if (digitalView) digitalView.style.display = 'block';
            if (photoView) photoView.style.display = 'none';
            if (digitalBtn) {
                digitalBtn.classList.add('active');
                digitalBtn.style.background = '#2563eb';
                digitalBtn.style.color = '#fff';
            }
            if (photoBtn) {
                photoBtn.classList.remove('active');
                photoBtn.style.background = 'transparent';
                photoBtn.style.color = '#94a3b8';
            }
        } else {
            if (digitalView) digitalView.style.display = 'none';
            if (photoView) photoView.style.display = 'block';
            if (photoBtn) {
                photoBtn.classList.add('active');
                photoBtn.style.background = '#2563eb';
                photoBtn.style.color = '#fff';
            }
            if (digitalBtn) {
                digitalBtn.classList.remove('active');
                digitalBtn.style.background = 'transparent';
                digitalBtn.style.color = '#94a3b8';
            }
        }
    }

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
