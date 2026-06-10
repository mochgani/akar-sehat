@if(!empty($siteSettings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset('storage/'.$siteSettings['favicon']) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/'.$siteSettings['favicon']) }}">
@elseif(!empty($siteSettings['logo']))
    <link rel="icon" type="image/png" href="{{ asset('storage/'.$siteSettings['logo']) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/'.$siteSettings['logo']) }}">
@else
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><line x1='50' y1='15' x2='14' y2='85' stroke='%23382A21' stroke-width='4'/><line x1='50' y1='15' x2='86' y2='85' stroke='%23382A21' stroke-width='4'/><path d='M 14 85 Q 50 65 50 55 Q 50 65 86 85' stroke='%23C86A44' stroke-width='4' fill='none'/><circle cx='50' cy='15' r='7' fill='%23382A21'/><circle cx='38' cy='38' r='7' fill='%23382A21'/><circle cx='26' cy='61' r='7' fill='%23382A21'/><circle cx='14' cy='85' r='7' fill='%23382A21'/><circle cx='62' cy='38' r='7' fill='%23382A21'/><circle cx='74' cy='61' r='7' fill='%23382A21'/><circle cx='86' cy='85' r='7' fill='%23382A21'/><circle cx='50' cy='55' r='7' fill='%23C86A44'/></svg>">
@endif
