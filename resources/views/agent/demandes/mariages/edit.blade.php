@extends('agent.layouts.template')

@section('content')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Modern card with subtle shadow -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <!-- Sleek header with your blue color -->
            <div class="px-6 py-5 "  style="background-color: #0033c4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-white">Mettre à jour l'état de la demande</h2>
                        <p class="text-blue-100 mt-1">Gestion des extraits de mariage</p>
                    </div>
                    <div class="bg-blue-500/20 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Form Container with modern spacing -->
            <div class="p-6 md:p-8">
                <form action="{{ route('agent.demandes.wedding.update', $mariage->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('POST')

                    <!-- Applicant Field with modern styling -->
                    <div class="space-y-2">
                        <label for="nomDefunt" class="block text-sm font-medium text-gray-600">Nom du demandeur</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 "  style="color: #0033c4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="nomDefunt" 
                                   class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0033c4] focus:border-[#0033c4] transition duration-200" 
                                   value="{{ $mariage->user ? $mariage->user->name .' '.$mariage->user->prenom : 'Demandeur inconnu' }}" 
                                   disabled>
                        </div>
                    </div>

                    <!-- Status Selection with modern dropdown -->
                    <div class="space-y-2">
                        <label for="etat" class="block text-sm font-medium text-gray-600">État de la demande</label>
                        <div class="relative">
                            <select name="etat" id="etat" 
                                    class="appearance-none block w-full px-4 py-3 pr-10 bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0033c4] focus:border-[#0033c4] transition duration-200" >
                                @foreach($etats as $etat)
                                    <option value="{{ $etat }}" {{ $mariage->etat == $etat ? 'selected' : '' }} class="py-2">
                                        {{ ucfirst($etat) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Action buttons with modern spacing and hover effects -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-white  hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0033c4] transition duration-200" style="background-color: red">
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white  hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"  style="background-color: #0033c4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection