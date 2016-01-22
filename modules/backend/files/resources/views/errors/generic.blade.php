@extends('Backend::bootstrap')

@section('content')
    <?php $count = count($exception->getAllPrevious()); ?>
    <?php $total = $count + 1; ?>
    @foreach ($exception->toArray() as $position => $e)
        <?php $ind = $count - $position + 1; ?>
        <h2>
            <span>{{ $ind }}/{{ $total }}</span>
            <span>{{ $e['class'] }}</span>
        </h2>
    @endforeach
@endsection