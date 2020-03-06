<div class="page-header my-skill">
    <h2>
        <!-- @lang('strings.new.skill_list') -->
            <a class="btn btn-success" href="{{ route('frontend.user.spskill.create') }}"> @lang('strings.new.skill_add_new')</a>
    </h2>
</div>

@if($Spskills->count())
    <div class="row">
        @foreach ($Spskills as $Spskill)
            @php
                $offer = 0;
                $originalprice = 0;
                $now = date("Y-m-d");
                $now = strtotime($now);

                if($Spskill->show_price =="hour"){
                    $final_price = $Spskill->price_per_hour;
                    $day_hour = __('strings.new.hour');                            
                }else{
                    $final_price = $Spskill->price_per_day; 
                    $day_hour = __('strings.new.day');                       
                }
                if((!empty($Spskill->offer_start_date)) && (!empty($Spskill->offer_end_date)) && (!empty($Spskill->offer_discount)))
                {
                    $originalprice = $final_price;
                    $offer_start = strtotime($Spskill->offer_start_date);
                    $offer_end = strtotime($Spskill->offer_end_date);
                    if($offer_start  <= $now  &&  $now  <= $offer_end){
                        $final_price = (float) ($final_price - (($final_price *$Spskill->offer_discount)/100 ) );
                        $offer=1;
                    }
                }
            @endphp
            <div class="col-md-3 services-skill">
                @if(!empty($Spskill->Skill->avatar))
                    <img src="/storage/skills/{{ $Spskill->Skill->avatar }}" alt="Image" class="img-fluid">
                @endif
                @if(!empty($offer))
                    <span class="services-offer-price">{{ $Spskill->offer_discount }}  %OFF</span>
                @endif
                <div class="services-skill-name">{{ $Spskill->Skill->name }}</div>
                <div class="services-skill-tags">{{ $Spskill->tags }}</div>
                @if(!empty($offer))
                    <span class="services-original-price-strike"><strike>{{ $originalprice}} {{ $Spskill->Currency->symbol}} / {{ $day_hour }}</strike>
                    </span>
                    <span class="services-net-amount">{{ $final_price}} {{ $Spskill->Currency->symbol}} / {{ $day_hour }}</span>
                @else
                    <span class="services-original-price">{{ $final_price}} {{ $Spskill->Currency->symbol}} / {{ $day_hour }}</span>
                @endif
                <div class="actions">
                    <a class="btn btn-primary skill-b" href="{{ route('frontend.user.spskill.edit',$Spskill->id) }}"><i class="fa fa-edit"></i></a>
                    {!! Form::model($Spskill, ['method' => 'post', 'route' => ['frontend.user.spskill.delete', $Spskill->id], 'class' =>'form-inline form-delete']) !!}
                        {!! Form::hidden('id', $Spskill->id) !!}
                        <a class="delete-skill btn btn-danger" href="javascript:;"><i class="fa fa-trash"></i></a>
                    {!! Form::close() !!}
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="photo-gallary">
        <h3 class="no-skill">No Skills Added!</h3>
    </div>
@endif
   
<table class="table table-bordered skill-table d-none" data-form="deleteForm">
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

    