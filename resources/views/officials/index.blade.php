
<x-layout>

    @section('title', 'Officials')
    <div class="wrap-container">
        <div class="container-1">
            <div class="flex-box-container-1">
                <h1>Barangay Officials</h1>
                <div style="padding-bottom: 10px">
                    <a href="{{ route('officials.create') }}">Add a new official &rarr;</a>
                </div>
                
                
                {{-- <div style="border: 2px solid black"> --}}
                    @foreach ( $officials as $official)
                        <div style="display: flex; justify-content:space-between">
                            
                            
                            
                            <div>
                                <div class="float-start" style="margin-right: 50px">
                                    <img style="height: 288px; weight: 288px"src="{{ asset('images/officials/' . $official->imagePath) }}" alt="">
                                </div>
    
                                <div class="float-end">
                                    <h4 >
                                        <a href="#">
                                            {{ $official->firstName . ' ' . $official->middleName . ' ' . $official->lastName }}
                                        </a>
                                    </h4>
                                    <span >
                                        {{ $official->description }}
                                    </span>
                                </div>
                    
                            </div>
    
                            <div class="float-end"> 
                                <a style="margin-left: 13px" href="{{ route('officials.edit',$official->id) }}">
                                Edit &rarr;
                                </a>
    
                                <form action="{{ route('officials.destroy', $official->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button style="color:red" class="btn btn-link" type="submit"> Delete &rarr;</button>
                                </form>
                            </div>
    
                            
    
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
    
