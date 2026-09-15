<h1>New {{ $leadType }}</h1>

<p>A new opportunity has been submitted through the Stellar Surge website.</p>

<dl>
    @foreach ($details as $label => $value)
        <dt><strong>{{ $label }}</strong></dt>
        <dd>{{ $value ?: 'Not provided' }}</dd>
    @endforeach
</dl>