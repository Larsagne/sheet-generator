<html>
<head>
    <style>
        * {
            font-size: 12px;
            line-height: 1;
            margin: 0;
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 12px 0;
            border-top: 1px solid;
            border-bottom: 1px solid;
            border-color: #000;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid;
            border-color: #000;
            padding: 4px 0
        }
        footer .pagenum:before {
            content: counter(page);
        }
        body {
            margin: 80px 0 36px 0;
            font-family: DejaVu Sans;
        }
        h1 {
            margin: 0;
            font-size: 18px;
        }
        h2 {
            margin: 0;
            font-size: 16px;
        }
        table {
            width: 100%
        }
        @page {
            margin: 10px 40px !important;
        }
        sup, sub {
            font-size: 8px;
        }
        .custom-sub {
            font-size: 8px;
        }
    </style>
    <title>{{ $sheet->title }} - {{ $sheet->artist }}</title>
</head>
<body>
<header>
    <table>
        <tr>
            <td style="width: 85%">
                <h1>{{ $sheet->title }}</h1>
                <p>{{ $sheet->artist }}</p>
            </td>
            <td>
                <table>
                    <tr>
                        <td><strong>Tonart:</strong></td>
                        <td style="text-align: right">{{ $sheet->key }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tempo:</strong></td>
                        <td style="text-align: right">{{ $sheet->tempo }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</header>
<footer>
    <table>
        <tr>
            <td style="width: 33.3%">
                {{ $sheet->updated_at->format('d.m.Y') }}
            </td>
            <td style="width: 33.3%; text-align: center">Seite <span class="pagenum"></span></td>
            <td style="width: 33.3%; text-align: right">
                Sheet von <span style="font-style: italic">{{ $sheet->user->name }}</span>
            </td>
        </tr>
    </table>
</footer>

<main>
    <div>
        @foreach($sheet->parts as $part)

            <div style="padding: 8px 0; border-bottom: 1px solid #000">
                @if(request()->get('lyrics'))
                    <table>
                        <tr>
                            <td style="width: 15%; vertical-align: top"><strong>{{ $part->name }}:</strong></td>

                            <td style="width: 50%; vertical-align: top">
                                @if ($part->lyrics)
                                    {!! str_replace("\n", '<br/>', $part->lyrics) !!}
                                @else
                                    @php
                                        $measureCount = 0;
                                        foreach ($part->sequences as $sequence) {
                                           $measureCount = $measureCount + count($sequence['measures']);
                                        }
                                    @endphp

                                    Instrumental (<span style="font-style: italic">{{ $measureCount }} Takte</span>)
                                @endif
                            </td>
                        </tr>
                    </table>
                @else
                    <table>
                        <tr>
                            <td style="width: 50%; padding-right: 10px; vertical-align: top;">
                                <div>
                                    <strong>{{ $part->name }}</strong>
                                </div>
                                <div>
                                    {!! str_replace("\n", '<br/>', $part->description) !!}
                                </div>
                                @foreach($part->sequences as $key => $sequence)
                                    @if ($sequence->description)
                                        <div
                                            style="@if($loop->first && !$part->description) margin-top: 0;@else margin-top: 8px;@endif">
                                        <span
                                            style="font-style: italic">{{ $key + 1 }} . Akkordfolge: </span>{!! str_replace("\n", '<br/>', $sequence->description) !!}
                                        </div>
                                    @endif
                                @endforeach
                            </td>
                            <td style="width: 50%; padding-left: 10px; vertical-align: top;">
                                <table>
                                    @foreach($part->sequences as $key => $sequence)
                                        <tr>
                                            <td style="width: 32px; vertical-align: top;"><strong>{{ $sequence->quantity }}
                                                    x:</strong></td>
                                            <td>
                                                @foreach($sequence->measures as $measure)
                                                    @php
                                                        $sup = ['b', '#', 1, 2, 3, 4, 5, 6, 7, 8, 9, 'add', '+', '°', 'maj', 'dim', '(sus)', '(', ')'];
                                                        $sub = ['sus'];
                                                        $chords = $measure['chords'];
                                                        foreach ($sup as $key) {
                                                            $chords = str_replace($key, '<sup>'. $key .'</sup>', $chords);
                                                        }
                                                        foreach ($sub as $key) {
                                                            $chords = str_replace($key, '<span class="custom-sub">'. $key .'</span>', $chords);
                                                        }
                                                        $chords = str_replace('H', 'B', $chords);
                                                        $chords = str_replace('_', ' ', $chords);
                                                        $chords = str_replace('-', '&mdash;', $chords);
                                                    @endphp
                                                    <span>{!! $chords !!}</span>
                                                    @if (!$loop->last)
                                                        <span style="padding: 0 1px;">|</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    </table>
                @endif
            </div>
        @endforeach
    </div>
</main>
</body>
</html>
