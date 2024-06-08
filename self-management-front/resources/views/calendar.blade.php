@vite(['resources/css/calendar.css', 'resources/js/app.js'])
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<a href="{{ route('top') }}">トップへ戻る</a>
<h1>
    日報
</h1>
<div class="d-flex justify-content-between">
    <a href="{{ route('calendar.show', [ 'record_date' => $previousMonth->format('Y-m-d') ]) }}">前月</a>
    <div class="text-center">
        <strong>{{$thisMonth->format('Y年n月')}}</strong>
    </div>
    <a href="{{ route('calendar.show', [ 'record_date' => $nextMonth->format('Y-m-d') ]) }}">翌月</a>
</div>
<div>{{ $calendarContents->user_id }}</div>
<div class="my-3">
    <div class="calendar-grid">
        @foreach(['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'] as $weekName)
        <div class="week-block">
            {{$weekName}}
        </div>
        @endforeach
        @foreach($calendarDays as $calendarDay)
            @if($calendarDay['show'])
                <div class="day-block">
                    <button class="button-day" type="button" data-date="{{$calendarDay['date']->format('Y-m-d')}}">{{$calendarDay['date']->format('j')}}</button>
                </div>
            @else
                <div class="day-block"></div>
            @endif
        @endforeach
    </div>
</div>

<div id="input_pluralBox">
    <div id="input_plural">
        <input type="text" class="form-control" placeholder="カテゴリー" required>
        <input type="text" class="form" placeholder="内容" required>
        <input type="text" class="form" placeholder="時間" required>
        <input type="text" class="form" placeholder="分" required>
        <input type="button" value="＋" class="add pluralBtn">
        <input type="button" value="－" class="del pluralBtn">
    </div>
</div>
<div>
    <textarea name="test1" cols="30" rows="5"></textarea>
</div>
