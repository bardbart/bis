<head>
    <style>
        .container 
        {
            /* max-width:1200px; */
            margin: 0 auto;
            /* display: flex; */
            border: 5px solid black;
            width: 100%;
            text-align: center;
        }

        .container-3 div{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            border: 1px solid black;
            justify-content: space-around;
            /* padding: 10px; */

        }


        .container-3 div label{
            /* margin: 20px; */
        }
        .container div label
        {
            cursor: pointer;
            

        }
        .container div label input[type=checkbox]
        {

            display: none;
            
        }

        .container div label span
        {
            
            /* position: relative;
            display: inline-block; */
            background: white;
            padding: 5px 5px;
            color: #555;
            /* text-shadow: 0 1px 4px rgba(0,0,0,.5); */
            border-radius: 20px;
            transition: 0.5s;
            user-select:none;
            overflow: hidden;
            border: 2px solid rgb(56, 193, 114);
        }
        .container div label span:before
        {
            /* content: ''; */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%; 
            height: 50%;
            background: rgba(184, 179, 179, 0.1);
        }
        .container div label input[type=checkbox]:checked ~ span
        {
            background: rgb(56, 193, 114);
            color: white;

        }

    </style>
</head>


<body>
<div class="container">
    <form method="POST" action="{{ route('users.update', $user->id) }}" >
        @csrf
        @method('PUT')
        <div class="container-1">
            <div class="flex-box-1"></div>
        </div>
        <div class="form-group row">
            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
            
            <div class="col-md-6">
                <select name="roles" multiple="multiple" class="custom-select custom-select-md mb-3">
               


                        @foreach ( $roles as $role )
                            <option @if ($userRole[0] == $role) return selected @endif value="{{ $role }}">{{ $role }}</option>                                            
                        @endforeach
                </select>
            </div>
            
        </div>

            
    
                
                    

                      
                <div class="container-3">
                    <div>
                        @foreach ( $permissions as $permission )
                        <label>
                            
                            <input type="checkbox">
                            <span>{{ $permission->name}}</span>
                            
                        </label>
                        @endforeach
                    </div>
                </div>
                            


                       
                    

            {{-- </div>
            
        </div> --}}

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4 ">
                <button  type="submit" class="btn btn-primary" >
                    {{ __('Submit') }}
                </button>
            </div>
        </div>

        
    </form>
</div>
</body>

                    

