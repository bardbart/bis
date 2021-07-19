<x-layout>
    @section('title', 'Services')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Services Management</h2>
            </div>
            <div style="padding-bottom: 10px">
                <a href="{{ route('services.create') }}">Add a new service &rarr;</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Name of Service</th>
                <th>Type of Service</th>
                {{-- <th width="280px">Action</th> --}}
            </tr>
        </thead>
        @foreach ($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                @if($service->serviceId == 1)
                    <td>{{ $service->docType }}</td>
                    <td>Document</td>
                @elseif($service->serviceId == 2)
                    <td>{{ $service->complainType }}</td>
                    <td>Complaint</td> 
                @endif
            </tr>
        @endforeach
    </table>
    <p class="text-center text-primary"><small>By Team Bard</small></p>
</x-layout>