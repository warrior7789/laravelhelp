@extends('frontend.layouts.app')

@section('title', app_name() . ' | '. __('strings.new.feedback'))

@section('content')   

@push('after-styles')
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-stars.css') }}" rel="stylesheet">
@endpush 
    <div class="container">
        
        
        <div class="row">
            <div class="page-content offset-md-3 col-md-6">
                <div class="page-header">
                    <div class="row">
                        
                        <div class="col-md-4 col-4">
                             @if(!empty($touser_profile_image))
                                <img class="feedback-user" src="/storage/{{ $touser_profile_image }}">
                            @else
                                <img src="/storage/avtars/dummy.png">
                            @endif
                        </div>
                        <div class="col-md-8 col-8">
                            <h2 class="title-cards">@lang('strings.new.add_feedback_for') {{ ucwords($touserName) }}</h2>
                        </div>

                    </div>
                </div>
                
                {{ Form::model($model, array('route' => array('frontend.user.feedback.create') ,'files' => true)) }} 
                    <div class="form-group">
                        <!-- Rating -->
                        <label for="sp_skill_id">@lang('strings.new.skill')</label>
                        <select class='sp_skill_box form-control' id='sp_skill_id' name="sp_skill_id">
                            <option value="" >Please Select Skill</option>
                            @if(!empty($Sproskills))   
                                @foreach ($Sproskills as $key => $skdata)
                                    @if(!empty($skdata->Skill))
                                        @if((!empty($skdata->Skill->name)) && (!empty($skdata->Skill->id)))
                                            <option value="{{ $skdata->Skill->id }}" >{{ $skdata->Skill->name }}</option>
                                        @endif
                                    @endif
                                @endforeach
                            @endif                    
                        </select>                   
                    </div>

                    <div class="form-group">
                        <label for="from_user_name">@lang('labels.frontend.user.profile.name')</label>
                        <input type="text" name="from_user_name" id="from_user_name" class="form-control sti" value="{{ $fromusrname }}" readonly="readonly">
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-6">
                            <div class="form-group">
                                <!-- Rating -->
                                <label for="value_for_money">@lang('strings.new.value_for_money')</label>
                                <select class='value_for_money_rating' id='value_for_money_rating'>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    
                                </select>
                                <input type="hidden" name="value_for_money" id="value_for_money" value="1">
                            </div>
                        
                            <div class="form-group">
                                <!-- Rating -->
                                <label for="quality_of_work">@lang('strings.new.quality_of_work')</label>
                                <select class='quality_of_work_rating' id='quality_of_work_rating'>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    
                                </select>
                                <input type="hidden" name="quality_of_work" id="quality_of_work" value="1">
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="form-group">
                                <!-- Rating -->
                                <label for="relation_with_customer">@lang('strings.new.relation_with_customer')</label>
                                <select class='relation_with_customer_rating' id='relation_with_customer_rating'>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    
                                </select>
                                <input type="hidden" name="relation_with_customer" id="relation_with_customer" value="1">
                            </div>              

                            <div class="form-group">
                                <!-- Rating -->
                                <label for="performance">@lang('strings.new.performance')</label>
                                <select class='performance_rating' id='performance_rating' data-id='rating'>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    
                                </select>
                                <input type="hidden" name="performance" id="performance" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review">@lang('strings.new.review')</label>
                        <textarea id="review" class="form-control" name="review"></textarea>
                    </div>

                    <input type="hidden" name="from_userid" id="from_userid" value="{{ $fromuserId }}">
                    <input type="hidden" name="to_userid" id="to_userid" value="{{ $touserId }}">
                    
                    <input type="hidden" name="slug" id="slug" value="{{ $slug }}">
                    
                    {{ Form::submit(__('strings.new.give_feedback'),$attributes = array('class' => 'btn btn-primary submitbtn')) }}
                    <button type="button" class="btn btn-primary submitbtn"><a href="{{ $back }}">@lang('strings.new.back')</a></button>       
                   
                {{ Form::close() }}
            </div>



        </div>
    </div>

@endsection

@push('after-scripts')
    <script src="{{ asset('js/jquery.barrating.min.js') }}" defer></script>
    <script type="text/javascript">
        $(function() {
            $('.value_for_money_rating').barrating({
                theme: 'fontawesome-stars',
                onSelect: function(value, text, event) {
                    $('#value_for_money').val(value);
                }
            });

            $('.quality_of_work_rating').barrating({
                theme: 'fontawesome-stars',
                onSelect: function(value, text, event) {
                    $('#quality_of_work').val(value);
                }
            });

            $('.relation_with_customer_rating').barrating({
                theme: 'fontawesome-stars',
                onSelect: function(value, text, event) {
                    $('#relation_with_customer').val(value);
                }
            });

            $('.performance_rating').barrating({
                theme: 'fontawesome-stars',
                onSelect: function(value, text, event) {
                    $('#performance').val(value);
                }
            });
        });
      
        </script>

        <!-- Set rating -->
        <script type='text/javascript'>
            $(document).ready(function(){               
                //$('#rating').barrating('set',3);
            });                            
        </script>
@endpush