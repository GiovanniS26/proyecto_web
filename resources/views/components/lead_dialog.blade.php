@props(['statuses'])

<div {{ $attributes->merge(['class' => 'relative z-10']) }}>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen flex justify-center items-center">
        <div <div class="flex h-auto items-end justify-center text-center sm:items-center sm:p-0 w-1/2">>
            <div
                class="relative max-h-[80vh] px-8 py-4 transform overflow-auto rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                <form id="lead_form" class="flex flex-col bg-white rounded-lg gap-4 m-0" method="POST">
                    @csrf
                    <div class="flex flex-col gap-4">
                        <h1 class="font-bold font-5xl">Datos del Lead</h1>


                        <!-- Status Select -->
                        <div class="flex flex-col">
                            <label class="font-bold" for="status_id">Status</label>
                            <select class="border-grey-300 border-2 rounded p-1" name="status_id" id="status_id" required>
                                @foreach ($statuses as $status) 
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="lead_submit_dialog" type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto">Enviar</button>
                        <button id="lead_close_dialog" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>