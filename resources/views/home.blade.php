<x-layout>
    @section('title', 'Home')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
    
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success" >
                                <p>{{ $message }}</p>
                            </div>
                        @endif
    
                        {{ __('Welcome ' . Auth::user()->firstName . ' !') }}
                    </div>
                </div>
                
                @if(Auth::user()->hasRole('User'))
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive mailbox-messages">
                                    <table class="table table-hover" id="tableInbox">
                                    <tbody>
                                        <tr style="cursor:pointer;" onclick="openMail(2009290001,'OPENING+OF+CLASSES+FOR+THE+1ST+SEMESTER%2C+SY+2020-2021','noreply%40sis','September+29%2C+2020')"  data-toggle="modal" data-target="#modal-msg">
                                            <td class="mailbox-name"><a href="#">noreply@bis</a></td>
                                            <td class="mailbox-subject">OPENING OF CLASSES FOR THE 1ST SEMESTER, SY 2020-2021<br/>  
                                            </td>
                                            <td class="mailbox-date">September 29, 2020</td>
                                        </tr>
                                        <tr style="cursor:pointer;" onclick="openMail(2006180003,'+PUPSIS+Advisory%3A+Changing+of+Password','noreply%40sis','June+18%2C+2020')"  data-toggle="modal" data-target="#modal-msg">
                                            <td class="mailbox-name"><a href="#">noreply@bis</a></td>
                                            <td class="mailbox-subject"> PUPbis Advisory: Changing of Password<br/>
                                            </td>
                                            <td class="mailbox-date">June 18, 2020</td>
                                        </tr>
                                        <tr style="cursor:pointer;" onclick="openMail(2006180002,'PUPbis+Advisory%3A+Changing+of+Password','noreply%40bis','June+18%2C+2020')"  data-toggle="modal" data-target="#modal-msg">
                                            <td class="mailbox-name"><a href="#">noreply@bis</a></td>
                                            <td class="mailbox-subject">PUPbis Advisory: Changing of Password<br/>
                                            </td>
                                            <td class="mailbox-date">June 18, 2020</td>
                                        </tr>
                                        <tr style="cursor:pointer;" onclick="openMail(2006180001,'PUPbis+Advisory%3A+Changing+of+Password','noreply%40bis','June+18%2C+2020')"  data-toggle="modal" data-target="#modal-msg">
                                            <td class="mailbox-name"><a href="#">noreply@bis</a></td>
                                            <td class="mailbox-subject">PUPSIS Advisory: Changing of Password<br/>
                                            </td>
                                            <td class="mailbox-date">June 18, 2020</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-layout>

