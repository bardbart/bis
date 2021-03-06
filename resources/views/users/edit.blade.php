<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        .container-1, .container-2, .container-3{
            margin: 0 auto;
            /* border: 1px solid black; */
            width: 100%;
            text-align: start;
        }
        .container-1{
            text-align: center;
        }
        .flex-box-container-1, .flex-box-container-2, .flex-box-container-3{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            /* border: 1px solid black; */
            justify-content: space-around;
            padding: 10px;
        }
        .flex-box-container-1{
            flex-direction: column;
        }
        .flex-box-container-2 div label {
            cursor: pointer;
            margin-bottom: 20px;
        }
        .flex-box-container-2 div label input[type=checkbox] {
            display: none;
        }
        .flex-box-container-2 div label span {
            background: white;
            padding: 5px 5px;
            color: #555;
            border-radius: 20px;
            transition: 0.5s;
            user-select:none;
            overflow: hidden;
            border: 2px solid #0275d8;
            
        }
        .flex-box-container-2 div label span:before {
            width: 100%; 
            height: 50%;
            background: rgba(184, 179, 179, 0.1);
        }
        .flex-box-container-2 div label input[type=checkbox]:checked ~ span {
            background: #0275d8;
            color: white;
            
        }
    </style>
</head>
<body>
    <div class="wrap-container">
        <form method="POST" action="{{ route('users.update', $user->id) }}" >
            @csrf
            @method('PUT')

            <div class="container-1">
                <h3 class="text-start ms-3" for="role" >{{ __('Role') }}</h3>
                <div class="flex-box-container-1">
                    <div>
                        <select name="roles" multiple="multiple" class="form-select form-select-md mb-2">
                            @foreach ( $roles as $role )
                                <option @if ($userRole[0] == $role) return selected @endif value="{{ $role }}">{{ $role }}</option>                                            
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="container-2">
                <h3 class="text-start ms-3" for="permission" >{{ __('Permissions') }}</h3>
                <div class="flex-box-container-2">
                    <div>
                        <input name="permission[]" type="hidden" checked value="null">
                        @foreach ( $permission as $permission )
                            <label>
                                <input @if(in_array($permission->name,$userPermissions)) return checked @endif value="{{$permission->name}}" name="permission[]" type="checkbox">
                                <span>{{ $permission->name}}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="container-3">
                <div class="flex-box-container-3">
                    <div>
                        <button  type="submit" class="btn btn-success" >
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </div>
        
        </form>
    </div>
</body>
</html>