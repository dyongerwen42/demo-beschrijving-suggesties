<div>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 py-8 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 font-sans">
            
            <div class="flex justify-center mb-6">
                <img src="https://de-reclamefabriek.nl/wp-content/themes/drf-mathijs/images/logo.png" alt="Logo De Reclamefabriek" class="h-12 sm:h-16"/>
            </div>

            <h1 class="text-3xl sm:text-4xl font-bold text-center text-slate-800 dark:text-slate-100 mb-10 sm:mb-12">
                AI Product Beschrijving Verbeteraar
            </h1>

            {{-- Wizard Progress Bar --}}
            <div class="mb-12">
                @php
                    $steps = [
                        1 => ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>', 'label' => '1. Product Selectie'],
                        2 => ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>', 'label' => '2. AI Instructie'],
                        3 => ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>', 'label' => '3. Resultaten & Opslaan']
                    ];
                @endphp
                <div class="flex items-start">
                    @foreach ($steps as $stepNumber => $stepDetails)
                        <div class="step-item flex-1 relative flex flex-col items-center group">
                            <div class="relative z-10 flex flex-col items-center">
                                <span class="flex items-center justify-center w-10 h-10 {{ $currentStep >= $stepNumber ? 'bg-sky-500 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400' }} rounded-full lg:h-12 lg:w-12 shrink-0 ring-4 {{ $currentStep === $stepNumber ? 'ring-sky-300 dark:ring-sky-500/70' : ($currentStep > $stepNumber ? 'ring-sky-200 dark:ring-sky-600/50' : 'ring-transparent') }} transition-all duration-300 ease-in-out group-hover:ring-sky-300 dark:group-hover:ring-sky-500/60">
                                    {!! $stepDetails['icon'] !!}
                                </span>
                                <p class="mt-2 text-xs font-semibold {{ $currentStep >= $stepNumber ? 'text-sky-600 dark:text-sky-300' : 'text-slate-500 dark:text-slate-400' }} w-32 text-center transition-colors duration-300 ease-in-out group-hover:text-sky-600 dark:group-hover:text-sky-300">{{ $stepDetails['label'] }}</p>
                            </div>
                            
                            {{-- Line connecting to the next step icon --}}
                            @if (!$loop->last)
                                <div class="absolute top-5 left-1/2 w-full h-1 {{ $currentStep > $stepNumber ? 'bg-sky-500' : 'bg-slate-300 dark:bg-slate-600' }} -z-0 transition-colors duration-300 ease-in-out"
                                     style="transform: translateY(-50%);">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Session Feedback Messages --}}
            <div class="space-y-4 mb-6">
                @if (session()->has('message')) <div class="p-4 text-sm text-green-700 bg-green-100 rounded-xl dark:bg-green-900 dark:text-green-200 border border-green-300 dark:border-green-700 shadow-lg flex items-center space-x-3"><svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> <span>{{ session('message') }}</span></div> @endif
                @if (session()->has('error')) <div class="p-4 text-sm text-red-700 bg-red-100 rounded-xl dark:bg-red-900 dark:text-red-200 border border-red-300 dark:border-red-700 shadow-lg flex items-center space-x-3"><svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-10a1 1 0 00-2 0v4a1 1 0 102 0V8zm-1 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg> <span>{{ session('error') }}</span></div> @endif
                @if (session()->has('info')) <div class="p-4 text-sm text-blue-700 bg-blue-100 rounded-xl dark:bg-blue-900 dark:text-blue-200 border border-blue-300 dark:border-blue-700 shadow-lg flex items-center space-x-3"><svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-6a1 1 0 00-2 0v3a1 1 0 102 0v-3zm-1-4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg> <span>{{ session('info') }}</span></div> @endif
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl p-6 sm:p-8 md:p-10">
                
                {{-- STEP 1: Product Selection --}}
                @if ($currentStep === 1)
                    <div class="space-y-10">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-100 mb-2">Stap 1: Productselectie</h2>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Kies eerst categorieën om de productlijst te filteren. Selecteer daarna de producten voor AI-verbetering.</p>
                        </div>

                        <div class="p-6 bg-slate-50 dark:bg-slate-700/40 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                            <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-200 mb-4">Filter op Categorieën</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                @forelse ($availableCategories as $category)
                                    <div class="relative">
                                        <input type="checkbox" id="category-{{ $category['id'] }}" value="{{ $category['id'] }}"
                                               wire:model.live="selectedCategoryIds"
                                               class="peer absolute opacity-0 h-full w-full cursor-pointer inset-0">
                                        <label for="category-{{ $category['id'] }}"
                                               class="flex items-center justify-center text-sm font-medium text-center p-3 h-full rounded-lg border-2 transition-all duration-150 ease-in-out 
                                                      cursor-pointer text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-700 border-slate-300 dark:border-slate-600 
                                                      hover:border-sky-400 dark:hover:border-sky-500 hover:text-sky-600 dark:hover:text-sky-300 
                                                      peer-checked:border-sky-500 dark:peer-checked:border-sky-400 peer-checked:bg-sky-50 dark:peer-checked:bg-sky-600/30 peer-checked:text-sky-600 dark:peer-checked:text-sky-200 peer-checked:ring-2 peer-checked:ring-sky-500/50 dark:peer-checked:ring-sky-400/50">
                                            {{ $category['name'] }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-slate-500 dark:text-slate-400 col-span-full text-center py-3">Geen categorieën beschikbaar.</p>
                                @endforelse
                            </div>
                        </div>

                        <div wire:loading.flex wire:target="selectedCategoryIds" class="w-full flex-col items-center justify-center p-8 text-slate-500 dark:text-slate-400">
                            <svg class="animate-spin h-10 w-10 text-sky-600 dark:text-sky-400 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="mt-3 text-sm font-medium">Producten laden...</p>
                        </div>

                        <div wire:loading.remove wire:target="selectedCategoryIds">
                            <div class="flex flex-wrap justify-between items-center mb-4 gap-4">
                                <h3 class="text-xl font-semibold text-slate-700 dark:text-slate-200">
                                    Gevonden Producten
                                </h3>
                                @if ($totalProductsInFilter > 0 && !empty($selectedCategoryIds))
                                    <div class="flex items-center">
                                        <label for="toggleAllFiltered" class="flex items-center space-x-3 cursor-pointer text-sm text-slate-700 dark:text-slate-300 p-2.5 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg border border-slate-300 dark:border-slate-600 shadow-sm">
                                            <input type="checkbox" id="toggleAllFiltered" 
                                                   wire:model.live="toggleAllFiltered"
                                                   class="h-4 w-4 rounded border-slate-300 dark:border-slate-500 text-sky-600 shadow-sm focus:ring-2 focus:ring-offset-0 focus:ring-sky-500 dark:focus:ring-sky-600 dark:bg-slate-700 dark:checked:bg-sky-500 dark:checked:border-sky-500">
                                            <span>Selecteer alle ({{ $totalProductsInFilter }})</span>
                                        </label>
                                    </div>
                                @endif
                            </div>

                            @if ($fetchedProducts && $fetchedProducts->total() > 0)
                                <div class="space-y-4 max-h-[32rem] overflow-y-auto border border-slate-200 dark:border-slate-700 p-4 rounded-lg shadow-inner bg-slate-50 dark:bg-slate-800/30 custom-scrollbar">
                                    @foreach ($fetchedProducts as $product)
                                        <label for="product-{{ $product->id }}" 
                                               class="flex items-start space-x-4 p-4 rounded-xl transition-all duration-150 ease-in-out cursor-pointer 
                                                      {{ in_array((string)$product->id, $selectedProductIdsForProcessing) 
                                                          ? 'bg-sky-50 dark:bg-sky-500/20 border-2 border-sky-400 dark:border-sky-500 shadow-lg transform scale-[1.02]' 
                                                          : 'bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-600/70 hover:border-slate-400 dark:hover:border-slate-500 hover:shadow-md' }}">
                                            <input type="checkbox" id="product-{{ $product->id }}" value="{{ $product->id }}"
                                                   wire:model.live="selectedProductIdsForProcessing"
                                                   class="mt-1 h-5 w-5 rounded border-slate-400 dark:border-slate-500 text-sky-600 shadow-sm focus:ring-2 focus:ring-offset-0 focus:ring-sky-500 dark:focus:ring-sky-600 dark:bg-slate-600 dark:checked:bg-sky-600 dark:checked:border-sky-600">
                                            <div class="flex-grow">
                                                <span class="font-semibold text-slate-800 dark:text-slate-100 block">{{ $product->name }}</span>
                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">ID: {{ $product->id }}</p>
                                                <p class="text-sm text-slate-600 dark:text-slate-300 mt-1 line-clamp-2">{{ $product->description }}</p>
                                                @if($product->category)
                                                    <div class="mt-2">
                                                        <span class="text-xs bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 px-2.5 py-1 rounded-full font-medium">{{ $product->category->name }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                 <div class="mt-6 flex flex-wrap justify-between items-center gap-4">
                                    <p class="text-sm text-slate-600 dark:text-slate-400">
                                        {{ count($selectedProductIdsForProcessing) }} product(en) geselecteerd.
                                        @if($fetchedProducts->count() > 0)
                                            <span class="ml-1 md:ml-2">Pagina {{ $fetchedProducts->currentPage() }} van {{ $fetchedProducts->lastPage() }} ({{ $fetchedProducts->count() }} van {{ $fetchedProducts->total() }} producten op deze pagina)</span>
                                        @elseif($totalProductsInFilter > 0)
                                            <span class="ml-1 md:ml-2"> (Totaal {{ $totalProductsInFilter }} producten in filter)</span>
                                        @endif
                                    </p>
                                    @if ($fetchedProducts->hasPages())
                                      {{ $fetchedProducts->links('livewire::tailwind') }}
                                    @endif
                                </div>
                                @error('selectedProductIdsForProcessing') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            @elseif (!empty($selectedCategoryIds))
                                <div class="text-center py-12 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl">
                                    <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                      <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-semibold text-slate-800 dark:text-slate-100">Geen producten gevonden</h3>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Er zijn geen producten die voldoen aan de geselecteerde categorie(ën).</p>
                                  </div>
                            @else
                                 <div class="text-center py-12 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl">
                                    <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-semibold text-slate-800 dark:text-slate-100">Selecteer Categorieën</h3>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kies een of meer categorieën om producten te filteren en te selecteren.</p>
                                  </div>
                            @endif
                        </div>
                        
                        <div class="mt-10 pt-8 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                            <button wire:click="nextStep" wire:loading.attr="disabled"
                                    @if(empty($selectedProductIdsForProcessing)) disabled @endif
                                    class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 text-white text-sm font-semibold rounded-lg shadow-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="nextStep">Volgende: AI Instructie</span>
                                <span wire:loading wire:target="nextStep" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Laden...
                                </span>
                                <svg wire:loading.remove wire:target="nextStep" class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>
                    </div>
                @endif

                {{-- STAP 2: AI Instructie Verfijnen --}}
                @if ($currentStep === 2)
                    <div class="space-y-10">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-100 mb-2">Stap 2: AI Instructie Verfijnen</h2>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Geef een duidelijke instructie voor de AI. Dit helpt om de productbeschrijvingen van de <strong class="font-semibold text-sky-600 dark:text-sky-400">{{ count($selectedProductIdsForProcessing) }}</strong> geselecteerde product(en) optimaal te verbeteren.</p>
                        </div>
                        
                        @if(!empty($tonePresets))
                        <div class="p-6 bg-slate-50 dark:bg-slate-700/40 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                            <h3 class="text-md font-semibold text-slate-700 dark:text-slate-200 mb-4">Kies een stijl (preset):</h3>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($tonePresets as $preset)
                                    <button type="button" wire:click="$set('rewriteInstruction', '{{ addslashes($preset) }}')"
                                            title="Pas '{{ $preset }}' toe als instructie"
                                            class="px-4 py-2 text-xs font-medium text-sky-700 bg-sky-100 rounded-lg hover:bg-sky-200 focus:ring-2 focus:outline-none focus:ring-sky-300 dark:bg-sky-600/70 dark:text-sky-100 dark:hover:bg-sky-500/70 dark:focus:ring-sky-600 transition-all duration-150 ease-in-out shadow hover:shadow-md">
                                        {{ $preset }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <div> 
                            <label for="rewriteInstruction" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Of typ je eigen instructie:</label>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Voorbeelden: "Herschrijf wervend en focus op unieke voordelen", "Maak de toon formeler en professioneel", "Voeg relevante emojis toe en maak het speelser"</p>
                            <textarea wire:model.lazy="rewriteInstruction" id="rewriteInstruction" rows="6" maxlength="500"
                                      class="mt-1 block w-full shadow-sm sm:text-sm border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('rewriteInstruction') border-red-500 dark:border-red-400 ring-1 ring-red-500 dark:ring-red-400 @enderror"
                                      placeholder="Voer hier je instructie in..."></textarea>
                            <div class="flex justify-between items-center mt-2">
                                @error('rewriteInstruction') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @else <span>&nbsp;</span> @enderror
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ strlen($rewriteInstruction ?? '') }}/500 tekens</p>
                            </div>
                        </div>

                        <div class="mt-10 pt-8 border-t border-slate-200 dark:border-slate-700 flex justify-between items-center">
                            <button wire:click="previousStep" wire:loading.attr="disabled"
                                    class="inline-flex items-center px-6 py-3 bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-semibold rounded-lg shadow-md hover:bg-slate-300 dark:hover:bg-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition-all duration-150 ease-in-out">
                                <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                Vorige
                            </button>
                            <button wire:click="nextStep" wire:loading.attr="disabled"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 text-white text-sm font-semibold rounded-lg shadow-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="nextStep, processProductsWithAI">Start AI Verwerking</span>
                                <span wire:loading wire:target="nextStep, processProductsWithAI" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Verwerken met AI...
                                </span>
                                <svg wire:loading.remove wire:target="nextStep, processProductsWithAI" class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>
                    </div>
                @endif

                {{-- STAP 3: Resultaten en Opslaan --}}
                @if ($currentStep === 3)
                    <div class="space-y-10">
                         <div>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-100 mb-2">Stap 3: Resultaten & Opslaan</h2>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Controleer de AI-suggesties. De originele beschrijving wordt ernaast getoond. Sla de wijzigingen op als je tevreden bent.</p>
                        </div>

                        <div wire:loading.flex wire:target="processProductsWithAI" class="w-full flex-col items-center justify-center p-8 min-h-[300px] text-slate-500 dark:text-slate-400">
                            <svg class="animate-spin h-12 w-12 text-sky-600 dark:text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="mt-4 text-sm font-medium">Productbeschrijvingen worden verwerkt door AI...</p>
                            <p class="text-xs mt-1">Dit kan even duren, afhankelijk van het aantal producten.</p>
                        </div>

                        <div wire:loading.remove wire:target="processProductsWithAI" class="space-y-6 max-h-[40rem] overflow-y-auto p-1 -mr-3 pr-3 custom-scrollbar">
                            @forelse ($aiProcessedProducts as $productId => $data)
                                <div class="p-6 rounded-xl shadow-lg {{ ($data['error'] ?? false) ? 'bg-red-50 dark:bg-red-700/20 border border-red-200 dark:border-red-500/50' : 'bg-white dark:bg-slate-700/40 border border-slate-200 dark:border-slate-700' }}">
                                    <h3 class="font-semibold text-lg text-slate-800 dark:text-slate-100 mb-4 pb-3 border-b border-slate-200 dark:border-slate-600">{{ $data['product_name'] }}</h3>
                                    @if ($data['error'] ?? false)
                                        <div class="flex items-start p-4 bg-red-100 dark:bg-red-500/20 rounded-lg text-red-700 dark:text-red-300">
                                            <svg class="h-5 w-5 mr-3 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293A1 1 0 0010.707 7.293L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                            <p class="text-sm font-medium">Fout bij AI verwerking: <span class="font-normal block sm:inline mt-1 sm:mt-0">{{ $data['error_message'] }}</span></p>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                            <div class="prose prose-sm dark:prose-invert max-w-none">
                                                <h4 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Originele Beschrijving</h4>
                                                <div class="p-3.5 rounded-lg bg-slate-100 dark:bg-slate-800/70 min-h-[150px] text-slate-700 dark:text-slate-300 leading-relaxed break-words shadow-inner">
                                                    {{ $data['original_description'] ?: '-' }}
                                                </div>
                                            </div>
                                            <div class="prose prose-sm dark:prose-invert max-w-none">
                                                <h4 class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wider mb-1.5">AI Suggestie</h4>
                                                <div class="p-3.5 rounded-lg bg-green-50 dark:bg-green-700/20 border border-green-200 dark:border-green-600/50 min-h-[150px] text-green-800 dark:text-green-200 leading-relaxed break-words shadow-inner">
                                                    {{ $data['ai_suggestion'] ?: '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div wire:loading.remove wire:target="processProductsWithAI" class="text-center py-12 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl">
                                    <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-semibold text-slate-800 dark:text-slate-100">Geen Producten Verwerkt</h3>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Er zijn geen producten verwerkt. Ga terug en start de AI verwerking.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-10 pt-8 border-t border-slate-200 dark:border-slate-700 flex justify-between items-center">
                            <button wire:click="previousStep" wire:loading.attr="disabled"
                                    class="inline-flex items-center px-6 py-3 bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-semibold rounded-lg shadow-md hover:bg-slate-300 dark:hover:bg-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition-all duration-150 ease-in-out">
                                <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                Vorige
                            </button>
                            <button wire:click="submitWizard" wire:loading.attr="disabled"
                                    @if(empty($aiProcessedProducts) || collect($aiProcessedProducts)->every(fn($p) => ($p['error'] ?? true) || empty($p['ai_suggestion']))) disabled @endif
                                    class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white text-sm font-semibold rounded-lg shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-150 ease-in-out">
                                    <span wire:loading.remove wire:target="submitWizard">Verbeterde Beschrijvingen Opslaan</span>
                                    <span wire:loading wire:target="submitWizard" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Opslaan...
                                    </span>
                                <svg wire:loading.remove wire:target="submitWizard" class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" /></svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div> {{-- End main content card --}}
        </div> {{-- End max-w-4xl container --}}
    </div> {{-- End min-h-screen background container --}}

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0; /* slate-200 for light mode */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1; /* slate-300 for light mode hover */
        }
        html.dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569; /* slate-600 for dark mode */
        }
        html.dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #334155; /* slate-700 for dark mode hover */
        }
    </style>
</div> {{-- Single Root Element Ends --}}