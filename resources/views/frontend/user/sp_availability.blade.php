
@extends('frontend.layouts.app')

@section('content')
    <div class="container available-parent">
        <div class="page-header my-availability">
            <h2>
                @lang('strings.new.sp_availability')        
            </h2>
        </div>

   
        {{ Form::model($model, array('route' => array('frontend.user.availability.create') ,'files' => true)) }}
            
            <input type="hidden" name="id" value="{{ !empty($model->id) ? $model->id : '' }}">

            <table class="table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>@lang('strings.new.from')</th>
                        <th>@lang('strings.new.to')</th>
                        <th>@lang('strings.new.close')</th>
                    </tr>                
                </thead>
                <tbody>
                    <tr>
                        <td>@lang('strings.new.monday')</td>
                        <td><input type = "text" name="monday[from]" class = "form-control date" value="{{ !empty($timeslot->monday->from) ? $timeslot->monday->from : '' }}" ></td>
                        <td><input type = "text" name="monday[to]" class = "form-control date"  value="{{ !empty($timeslot->monday->to) ? $timeslot->monday->to : '' }}"></td>
                        <td><input type ="checkbox" name="monday[close]" value="1" {{ !empty($timeslot->monday->close) ? "checked" : '' }}  >@lang('strings.new.close') </td>
                    </tr>


                    <tr>
                        <td>@lang('strings.new.tuesday')</td>
                        <td><input type = "text" name="tuesday[from]" class = "form-control date"  value="{{ !empty($timeslot->tuesday->from) ? $timeslot->tuesday->from : '' }}"></td>
                        <td><input type = "text" name="tuesday[to]" class = "form-control date"   value="{{ !empty($timeslot->tuesday->to) ? $timeslot->tuesday->to : '' }}"></td>
                        <td><input type ="checkbox" name="tuesday[close]" value="1" {{ !empty($timeslot->tuesday->close) ? "checked" : '' }} >@lang('strings.new.close') </td>
                    </tr>

                     <tr>
                        <td>@lang('strings.new.wednesday')</td>
                        <td><input type = "text" name="wednesday[from]" class = "form-control date"  value="{{ !empty($timeslot->wednesday->from) ? $timeslot->wednesday->from : '' }}"></td>
                        <td><input type = "text" name="wednesday[to]" class = "form-control date"   value="{{ !empty($timeslot->wednesday->to) ? $timeslot->wednesday->to : '' }}"></td>
                        <td><input type ="checkbox" name="wednesday[close]" value="1" {{ !empty($timeslot->wednesday->close) ? "checked" : '' }} >@lang('strings.new.close') </td>
                    </tr>

                     <tr>
                        <td>@lang('strings.new.thursday')</td>
                        <td><input type = "text" name="thursday[from]" class = "form-control date" value="{{ !empty($timeslot->thursday->from) ? $timeslot->thursday->from : '' }}"></td>
                        <td><input type = "text" name="thursday[to]" class = "form-control date"  value="{{ !empty($timeslot->thursday->to) ? $timeslot->thursday->to : '' }}"></td>
                        <td><input type ="checkbox" name="thursday[close]" value="1" {{ !empty($timeslot->thursday->close) ? "checked" : '' }}>@lang('strings.new.close') </td>
                    </tr>

                     <tr>
                        <td>@lang('strings.new.friday')</td>
                        <td><input type = "text" name="friday[from]" class = "form-control date" value="{{ !empty($timeslot->friday->from) ? $timeslot->friday->from : '' }}"></td>
                        <td><input type = "text" name="friday[to]" class = "form-control date"  value="{{ !empty($timeslot->friday->to) ? $timeslot->friday->to : '' }}"></td>
                        <td><input type ="checkbox" name="friday[close]" value="1" {{ !empty($timeslot->friday->close) ? "checked" : '' }}>@lang('strings.new.close') </td>
                    </tr>

                     <tr>
                        <td>@lang('strings.new.saturday')</td>
                        <td><input type = "text" name="saturday[from]" class = "form-control date" value="{{ !empty($timeslot->saturday->from) ? $timeslot->saturday->from : '' }}" ></td>
                        <td><input type = "text" name="saturday[to]" class = "form-control date"  value="{{ !empty($timeslot->saturday->to) ? $timeslot->saturday->to : '' }}" ></td>
                        <td><input type ="checkbox" name="saturday[close]" value="1" {{ !empty($timeslot->saturday->close) ? "checked" : '' }} >@lang('strings.new.close') </td>
                    </tr>
                    <tr>
                        <td>@lang('strings.new.sunday')</td>
                        <td><input type = "text" name="sunday[from]" class = "form-control date" value="{{ !empty($timeslot->sunday->from) ? $timeslot->sunday->from : '' }}"></td>
                        <td><input type = "text" name="sunday[to]" class = "form-control date"  value="{{ !empty($timeslot->sunday->to) ? $timeslot->sunday->to : '' }}"></td>
                        <td><input type ="checkbox" name="sunday[close]" value="1" {{ !empty($timeslot->sunday->close) ? "checked" : '' }}>@lang('strings.new.close') </td>
                    </tr>
                </tbody>
            </table>
       
                {{ Form::submit(!empty($model->id)?__('strings.new.update'):__('strings.new.create'),$attributes = array('class' => 'btn btn-success')) }}
                <a href="{{ route('frontend.user.account') }}" class="btn btn-danger"> @lang('strings.new.cancel')</a>

            {{ Form::close() }}
    </div>
@endsection

@push('after-styles')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endpush

@push('after-scripts')
   <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
    $('.date').timepicker({
        timeFormat: 'h:mm p',
        interval: 30,
        // minTime: '10',
        // maxTime: '6:00pm',
        // defaultTime: '10:30',
        // startTime: '09:00',
        dynamic: true,
        dropdown: true,
        scrollbar: true
    });
    </script>
@endpush