@if(session()->has('message'))
    @php
        $message = session()->get('message');
    @endphp
    <div class="alert {{$message['type']}}" role="alert">
        <span>{{$message['content']}}</span>
    </div>
@endif
