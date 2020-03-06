<div class="page-header my-availability">
    <h2>
        <!-- @lang('strings.new.sp_availability')  -->
            <a class="btn btn-success" href="{{ route('frontend.user.availability.create') }}"> @lang('strings.new.availability_add_new')</a>
    </h2>
    <table class="table skill-table">
    	<thead>
    		<tr>
    			<th>@lang('strings.new.day')</th>
    			<th>@lang('strings.new.from')</th>
    			<th>@lang('strings.new.to')</th>    			
    		</tr>
    	</thead>
    	<tbody>
    		@if(!empty($timeslot->monday) && empty($timeslot->monday->close) )
	    		<tr>
	    			<td>@lang('strings.new.monday')</td>
	    			<td>{{ $timeslot->monday->from }}</td>
	    			<td>{{ $timeslot->monday->to }}</td> 
	    		</tr>
	    	@else
	    		<tr>
	    			<td>@lang('strings.new.monday')</td>
	    			<td colspan="2">Close</td>
	    		</tr>
    		@endif

    		@if(!empty($timeslot->tuesday) && empty($timeslot->tuesday->close) )
	    		<tr>
	    			<td>@lang('strings.new.tuesday')</td>
	    			<td>{{ $timeslot->tuesday->from }}</td>
	    			<td>{{ $timeslot->tuesday->to }}</td> 
	    		</tr>
	    	@else
	    		<tr>
	    			<td>@lang('strings.new.tuesday')</td>
	    			<td colspan="2">Close</td>
	    		</tr>
    		@endif

    		@if(!empty($timeslot->wednesday) && empty($timeslot->wednesday->close) )
	    		<tr>
	    			<td>@lang('strings.new.wednesday')</td>
	    			<td>{{ $timeslot->wednesday->from }}</td>
	    			<td>{{ $timeslot->wednesday->to }}</td> 
	    		</tr>
	    	@else
	    		<tr>
	    			<td>@lang('strings.new.wednesday')</td>
	    			<td colspan="2">Close</td>
	    		</tr>
    		@endif

    		@if(!empty($timeslot->thursday) && empty($timeslot->thursday->close) )
	    		<tr>
	    			<td>@lang('strings.new.thursday')</td>
	    			<td>{{ $timeslot->thursday->from }}</td>
	    			<td>{{ $timeslot->thursday->to }}</td> 
	    		</tr>
	    	@else
	    		<tr>
	    			<td>@lang('strings.new.thursday')</td>
	    			<td colspan="2">Close</td>
	    		</tr>
    		@endif

    		@if(!empty($timeslot->friday) && empty($timeslot->friday->close))
	    		<tr>
	    			<td>@lang('strings.new.friday')</td>
	    			<td>{{ $timeslot->friday->from }}</td>
	    			<td>{{ $timeslot->friday->to }}</td> 
	    		</tr>
	    	@else
	    		<tr>
	    			<td>@lang('strings.new.friday')</td>
	    			<td colspan="2">Close</td>
	    		</tr>
    		@endif

    		@if(!empty($timeslot->saturday) && empty($timeslot->saturday->close) )
	    		<tr>
	    			<td>@lang('strings.new.saturday')</td>
	    			<td>{{ $timeslot->saturday->from }}</td>
	    			<td>{{ $timeslot->saturday->to }}</td> 
	    		</tr>
	    	@else
	    		<tr>
	    			<td>@lang('strings.new.saturday')</td>
	    			<td colspan="2">Close</td>
	    		</tr>
    		@endif

    		@if(!empty($timeslot->sunday) && empty($timeslot->sunday->close) )
	    		<tr>
	    			<td>@lang('strings.new.sunday')</td>
	    			<td>{{ $timeslot->sunday->from }}</td>
	    			<td>{{ $timeslot->sunday->to }}</td> 
	    		</tr>
	    	@else
	    		<tr>
	    			<td>@lang('strings.new.sunday')</td>
	    			<td colspan="2">Close</td>
	    		</tr>
    		@endif

    	</tbody>
    </table>
</div>

