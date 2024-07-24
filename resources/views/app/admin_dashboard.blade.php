<script>
    console.log(@json($projects))
</script>
<x-app-layout>
    <div class="h-full pl-32 pr-4 pt-24 overflow-auto">
        <div class="rounded bg-white p-4">
            <div class="container mx-auto mt-8">

                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold">Dashboard</h1>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-2">Proyectos</h2>
                        <p class="text-gray-700 text-xl">{{$projects}}</p>
                    </div>
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-2">Tareas Pendientes</h2>
                        <p class="text-gray-700 text-xl">{{$tasks}}</p>
                    </div>
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-2">Clientes</h2>
                        <p class="text-gray-700 text-xl">{{$clients}}</p>
                    </div>
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-2">Tickets</h2>
                        <p class="text-gray-700 text-xl">{{$tickets}}</p>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="mt-8 bg-gray-100 p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-4">Leads Recientes</h2>
                    <ul class="divide-y divide-gray-200">
                        @foreach ($leads as $lead)
                        <li class="py-4 flex">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{$lead->name}}</p>
                                <p class="text-sm font-medium text-gray-900">{{$lead->email}}</p>
                                <p class="text-sm text-gray-500">{{$lead->status->name}}</p>
                            </div>
                        </li>
                        @endforeach
                        
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>