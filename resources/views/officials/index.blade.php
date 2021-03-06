
<x-layout>
 
        <style>
            .float-end:hover
            {
                color:rgb(253, 135, 155);
            }
        </style>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @section('title', 'Officials')
    <div class="wrap-container">
        <div class="container-1">
            <div class="flex-box-container-1">
                <h1>Barangay Officials</h1>
                @if (Auth::user()->hasRole('Admin'))
                    <div style="padding-bottom: 10px">
                        <a class="@if (!Auth::user()->can('barangay-official-create') || $off === 11)
                            return btn disabled
                        @endif" href="{{ route('officials.create') }}">Add a new official &rarr;</a>
                    </div>
                @endif
                
                {{-- <div style="border: 2px solid black"> --}}
                    @foreach ($officials as $official)
                    <div style="display: flex; justify-content:space-between">

                        <div>
                            <div class="float-start" style="margin-right: 50px">
                                <img style="height: 200px !important; width: 200px !important;"src="{{ asset('images/officials/' . $official->imagePath) }}" alt="">
                            </div>

                            <div class="float-end">
                                <h4>
                                    {{ $official->firstName . ' ' . $official->middleName . ' ' . $official->lastName }}
                                </h4>
                                <span >
                                    {{ $official->position }}
                                </span>
                            </div>  
                            
                        </div>


                        
                            
                            @if (Auth::user()->hasRole('Admin'))
                                <div class="float-end"> 
                                    <a class="@if (!Auth::user()->can('barangay-official-edit'))
                                        return btn disabled
                                    @endif" style="margin-left: 13px" href="{{ route('officials.edit',$official->id) }}">
                                    Edit &rarr;
                                    </a>
        
                                    <form action="{{ route('officials.destroy', $official->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('Are you sure you want to delete this Official?')" style="color:red" class="btn btn-link @if (!Auth::user()->can('barangay-official-delete'))
                                            return disabled
                                        @endif" type="submit"> Delete &rarr;</button>
                                    </form>
                                </div> 
                            @endif
    
                            
    
                        </div>
                        <div>
                            <hr class="mt-4 mb-8">
                        </div>
                    @endforeach
                    {{-- </div> --}}
                    
            </div>
        </div>
    </div>

</x-layout>
    
