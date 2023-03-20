<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta lang="fa">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
@if (! empty($title))
<h1>{{ $title }}</h1>
@endif

@if (! empty($content))
<p>{{ $content }}</p>
@endif
<hr>

<p>Thank you,</p>
@if (! empty($sender))
<p>{{ $sender }}</p>
@endif
</body>
</html>
