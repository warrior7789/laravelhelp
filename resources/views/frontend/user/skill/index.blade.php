@extends('frontend.layouts.app')

@section('title', app_name() . ' | '. __('strings.new.spskill'))

@section('content')
    <div class="full-part-skill">
        <div class="container">    
            <div class="page-header my-skill add-skill">
                <h2>
                    @lang('strings.new.skill_list')
                        <a class="btn btn-success" href="{{ route('frontend.user.spskill.create') }}"> @lang('strings.new.skill_add_new')</a>
                </h2>
            </div>
           
            <table class="table table-bordered skill-table" data-form="deleteForm">
                <tr>
                    <th>@lang('strings.new.no')</th>
                    <th>@lang('strings.new.skill')</th>            
                    <th>@lang('strings.new.price')</th>            
                    <th>@lang('strings.new.status')</th>
                    <th width="280px">@lang('strings.new.action')</th>
                </tr>
                @foreach ($Spskills as $Spskill)
                <tr>
                    <td>{{ ++$i }} </td>
                    <td>{{ $Spskill->Skill->name}}</td>
                    <td>
                        @if($Spskill->show_price =="hour")
                            {{ $Spskill->price_per_hour}} {{ $Spskill->Currency->symbol}} /  @lang('strings.new.hour')

                        @else
                             {{ $Spskill->price_per_day}} {{ $Spskill->Currency->symbol}} /  @lang('strings.new.day')

                        @endif

                    </td>
                    <td>
                        @if($Spskill->status)
                            @lang('strings.new.enable')
                        @else
                            @lang('strings.new.disable')
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-primary skill-b" href="{{ route('frontend.user.spskill.edit',$Spskill->id) }}">@lang('strings.new.edit')</a>
                        

                        {!! Form::model($Spskill, ['method' => 'post', 'route' => ['frontend.user.spskill.delete', $Spskill->id], 'class' =>'form-inline form-delete']) !!}
                            {!! Form::hidden('id', $Spskill->id) !!}
                            {!! Form::submit(__('strings.new.delete'), ['class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </table>
          
            {!! $Spskills->links() !!}

            <div class="modal" id="confirm">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Confirmation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you, want to delete?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-primary" id="delete-btn">Delete</button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
    $('table[data-form="deleteForm"]').on('click', '.form-delete', function(e){
        e.preventDefault();
        var $form=$(this);
        $('#confirm').modal({ backdrop: 'static', keyboard: false })
            .on('click', '#delete-btn', function(){
                $form.submit();
            });
    });
    </script>
@endpush