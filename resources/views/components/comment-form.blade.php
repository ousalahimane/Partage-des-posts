@auth

<div class="mt-4">
   <h5>{{__('to post comments!')}}</h5>
   <form action="{{ $action }}" method="POST">
       @csrf 
       <textarea class="form-control" name="content" id="content" rows="3"></textarea>
       <div class="d-grid my-4">   
           <x-errors myClass="warning"></x-errors>
           <button class="btn btn-primary" type="submit">{{__('Add comment')}}</button>
       </div>
   </form>
</div>

   @else
   <p><a href="{{route('login')}}" class="btn btn-info btn-sm my-3">Sign In to comment a post</a></p>
@endauth  
  