<!DOCTYPE html>
<html>

<head>
    <title>Barcode Print</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 2px;
            text-align: center;
        }

        .barcode {
            width: 160px;
            text-align: center;
            display: inline-block;
            vertical-align: top;
            margin: 2px;
            padding: 4px 2px;
            line-height: 1.2;
            page-break-inside: avoid;
            box-sizing: border-box;
        }

        .barcode div, 
        .barcode p, 
        .barcode strong {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2 !important;
        }

        svg {
            width: 95% !important;
            height: 28px !important;
            display: block;
            margin: 2px auto !important;
            padding: 0 !important;
            color-adjust: exact !important;
            -webkit-print-color-adjust: exact !important;
        }

        .company-name {
            font-size: 13px;
            font-weight: bold;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2 !important;
            text-transform: uppercase;
        }

        .product-code {
            font-size: 11px;
            font-weight: bold;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2 !important;
            letter-spacing: 0.5px;
        }

        .product-name {
            font-size: 12px;
            font-weight: bold;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2 !important;
        }

        .product-variation {
            font-size: 10px;
            font-weight: bold;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2 !important;
        }

        .product-rate {
            font-size: 12px;
            font-weight: bold;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2 !important;
        }

        .product-rate strong {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2 !important;
        }

        .product-rate .discount-price {
            text-decoration: line-through;
            color: red;
            font-size: 11px;
        }

        .product-rate .final-price {
            color: #000;
            font-size: 13px;
            display: block;
        }

        .product-vat {
            font-size: 8px;
            font-weight: bold;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.1 !important;
        }

        @media print {
            @page {
                margin: 0;
                padding: 0;
            }
            
            body {
                margin: 0;
                padding: 2px;
            }
            
            .barcode {
                margin: 2px;
                padding: 4px 2px;
            }
            
            svg {
                width: 95% !important;
                height: 28px !important;
                display: block !important;
                margin: 2px auto !important;
                padding: 0 !important;
                color-adjust: exact !important;
                -webkit-print-color-adjust: exact !important;
            }
        }
    </style>
</head>

<body onload="window.print()">

    @php
        use Picqer\Barcode\BarcodeGeneratorSVG;
        $generator = new BarcodeGeneratorSVG();
    @endphp

    @foreach ($printItems as $item)
        @for ($i = 0; $i < $item['qty']; $i++)
            @php
                $full_code = $item['product']->barcode;
                if (!empty($item['variation'])) {
                    $full_code .= '' . $item['variation']->id;
                }
                $discount = (float)($item['product']->discount ?? 0);
                $finalPrice = (float)($item['product']->selling_price ?? 0);
                
                // Regular Sale Price before discount (e.g. 2150.00)
                if (!empty($item['product']->dis_selling_price) && (float)$item['product']->dis_selling_price > $finalPrice) {
                    $regularPrice = (float)$item['product']->dis_selling_price;
                } elseif ($discount > 0) {
                    $regularPrice = $finalPrice + $discount;
                } else {
                    $regularPrice = $finalPrice;
                }
                
                $currency = empty(get_setting('com_currency')) ? 'BDT' : get_setting('com_currency');
            @endphp
            <div class="barcode">
                @if ($settings['b_company'] ?? true)
                    <div class="company-name">
                        {{ $item['company'] }}
                    </div>
                @endif
                
                {!! $generator->getBarcode((string) $full_code, $generator::TYPE_CODE_128, 1.5, 32) !!}
                
                <div class="product-code">
                    {{ $full_code }}
                </div>
                
                @if ($settings['b_name'] ?? true)
                    <div class="product-name">
                        {{ $item['product']->name }}
                    </div>
                @endif
                
                @if (!empty($item['variation']) && ($settings['b_variation'] ?? true))
                    <div class="product-variation">
                        ({{ $item['variation']->size?->size }} - {{ $item['variation']->color?->color }})
                    </div>
                @endif
                
                @if ($settings['b_price'] ?? true)
                    <div class="product-rate">
                        @if ($discount > 0 && $regularPrice > $finalPrice)
                            <strong>
                                Price: <span class="discount-price">{{ number_format($regularPrice, 2) }} {{ $currency }}</span>
                                <span class="final-price">{{ number_format($finalPrice, 2) }} {{ $currency }}</span>
                            </strong>
                        @else
                            <strong>
                                Price: {{ number_format($finalPrice, 2) }} {{ $currency }}
                            </strong>
                        @endif
                    </div>
                    @if (!empty($settings['b_vat']))
                        <div class="product-vat">
                            (including VAT)
                        </div>
                    @endif
                @endif
            </div>
        @endfor
    @endforeach

</body>

</html>