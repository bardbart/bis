<x-layout>
    @section('title', 'Document Information')
    <div class="container">
        <div class="row justify-content-center">
          @if ($message = Session::get('success'))
            <div class="alert alert-success" >
              <p>{{ $message }}</p>
            </div>
           @endif

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header 
                        @if ($result)
                            return bg-success 
                        @else 
                            return bg-danger
                        @endif">
                            <b class="text-light">Document Information</b></div>
                    <div class="card-body">
                        @if ($result)
                            <p class="card-text">
                                <b class="text-success">This document was originally came from us and is authentic.</b>
                                <i class="fas fa-check-circle text-success"></i>
                            </p>
                        @else 
                            <p class="card-text">
                                <b class="text-danger">This document does not match any record from us.</b> 
                                <i class="fas fa-exclamation-circle text-danger"></i>
                            </p> 
                        @endif
                    <hr>
                    <a onclick="history.back()" class="btn btn-primary float-end">Back</a>
                    </div>
                </div>
            </div>
                          
        </div>
    </div>
</x-layout>