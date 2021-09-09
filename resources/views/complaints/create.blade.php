<x-layout>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    @section('title', 'Record Complaint')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="float-start">
                            <h2>Record Complaint</h2>
                        </div>
                        <div class="float-end">
                            <a class="btn btn-primary" href="{{ route('home') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" style="background-color: rgb(253, 135, 155);">{{ __('Complaint Form') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
                                @csrf

                                <b>Complainant</b><br>
                                {{-- <input type="radio" id="inside" name="from" onclick="showComplainant()">
                                <label>Inside the barangay</label><br>

                                <input type="radio" id="outside" name="from" onclick="showComplainant()">
                                <label>Outside the barangay</label><br> --}}

                                {{-- <div id="complainant" style="display: none"> --}}
                                    {{-- <b>Inside</b><br> --}}
                                    <div class="form-group row my-1">
                                        <label for="complainantId" class="col-md-4 col-form-label text-md-right">{{ __('Complainant Name*') }}</label>
                                        
                                        <div class="col-md-6">
                                            {{-- <input type="text" id="complainant" name="complainant" placeholder="Search" class="form-control"> --}}
                                            {{-- <select id="complainantId" name="complainantId" class="form-select" multiple size="5" autofocus>
                                                <option selected>--Select Registered User--</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->firstName. ' '. $user->lastName }}</option>
                                            @endforeach
                                            </select> --}} 
                                            <select id="complainantId" name="complainantId" class="form-control">
                                                <option value>--Select Registered User--</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->firstName. ' '. $user->lastName }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                {{-- </div> --}}

                                {{-- <div id="otherComplainant" style="display: none">
                                    <b>Outside</b><br>
                                    <div class="form-group row my-1">
                                        <label for="lastName" class="col-md-4 col-form-label text-md-right">{{ __('Last Name*') }}</label>
                                        
                                        <div class="col-md-6">
                                            <input  id="lastName" type="text" class="form-control" name="lastName" placeholder="Enter Last Name..." autofocus>
                                        </div>
                                    </div>
                
                                    <div class="form-group row my-1">
                                        <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name*') }}</label>
                                        
                                        <div class="col-md-6">
                                            <input  id="firstName" type="text" class="form-control" name="firstName" placeholder="Enter First Name..." autofocus>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row my-1">
                                        <label for="houseNo" class="col-md-4 col-form-label text-md-right">{{ __('House Number*') }}</label>
                                        
                                        <div class="col-md-6">
                                            <input  id="houseNo" type="text" class="form-control" name="houseNo" placeholder="Enter House Number..." autofocus>
                                        </div>
                                    </div>
    
                                    <div class="form-group row my-1">
                                        <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Street*') }}</label>
                                        
                                        <div class="col-md-6">
                                            <input  id="street" type="text" class="form-control" name="street" placeholder="Enter Street..." autofocus>
                                        </div>
                                    </div>
                                </div> --}}

                                <hr>
                                <b>Respondent</b>
                                <div class="form-group row my-1">
                                    <label for="respondents" class="col-md-4 col-form-label text-md-right">{{ __('Respondent') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="respondents" type="text" class="form-control" @error('respondents') is-invalid @enderror placeholder="Enter Respondent here..." name="respondents" required>
                                        @error('respondents')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="form-group row my-1">
                                    <label for="respondentsAdd" class="col-md-4 col-form-label text-md-right">{{ __("Other Respondents") }}</label>
                                    
                                    <div class="col-md-6">
                                        <textarea class="form-control" @error('respondents') is-invalid @enderror placeholder="Enter Other Respondents here..." name="respondentsAdd" id="respondentsAdd" cols="30" rows="2" required></textarea>
                                    </div>
                                </div> --}}

                                <div class="form-group row my-1">
                                    <label for="respondentsAdd" class="col-md-4 col-form-label text-md-right">{{ __("Respondent's Address") }}</label>
                                    
                                    <div class="col-md-6">
                                        <textarea class="form-control" @error('respondents') is-invalid @enderror placeholder="Enter Respondent's Address here..." name="respondentsAdd" id="respondentsAdd" cols="30" rows="2" required></textarea>
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group row my-1">
                                    <label for="complainDetails" class="col-md-4 col-form-label text-md-right"><b>{{ __('Complaint Details') }}</b></label>
                                    
                                    <div class="col-md-6">
                                        <textarea class="form-control" placeholder="Enter details here..." name="compDetails" id="compDetails" cols="30" rows="4" required></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4 ">
                                        <button onclick="return confirm('Are your inputs correct?')" type="submit" class="btn btn-success" >
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>
                                @if ($errors->any()) 
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                @endif
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script>
         $(document).ready(function () {
            $('select').selectize({
                sortField: 'text'
            });
        });
    </script>

    {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">
    </script> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" ></script> --}}
    
    {{-- <script type="text/javascript">
        var path = "{{ route('autocomplete') }}";

        $('#complainant').typeahead({
            source: function (query, process) {
                return $.get(path, {query: query}, function (data){
                    return process(data);
                });
            }
        });
    </script> --}}

    {{-- <script>
        function showComplainant() {
            if (document.getElementById('inside').checked) 
            {
                document.getElementById('complainant').style.display = 'block';
                document.getElementById('otherComplainant').style.display = 'none';
            }
            else if (document.getElementById('outside').checked) 
            {
                document.getElementById('otherComplainant').style.display = 'block';
                document.getElementById('complainant').style.display = 'none';
            }
        }            
    </script> --}}
</x-layout>