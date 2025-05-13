<x-app-layout>
    <section class="py-16 md:py-24">
        <div class="container mx-auto px-6 flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-primary-600 to-secondary-600 py-6 px-8">
                        <div class="flex justify-center">
                            <img src="{{ asset('img/favicon.png') }}" alt="Hekimport Logo" class="h-14 w-auto">
                        </div>
                        <h2 class="text-2xl font-bold text-white text-center mt-4 font-heading">Şifre Sıfırlama</h2>
                        <p class="text-center text-white/80 mt-1">Yeni Şifre Belirleyin</p>
                    </div>
                    
                    <div class="p-8">
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-posta Adresi</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input 
                                        id="email" 
                                        type="email" 
                                        name="email" 
                                        value="{{ old('email', $request->email) }}" 
                                        required 
                                        autofocus 
                                        autocomplete="username"
                                        class="block w-full pl-12 rounded-lg border-gray-300 shadow-sm transition duration-200
                                        focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50
                                        @error('email') border-red-500 bg-red-50 @enderror"
                                    />
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Yeni Şifre</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input 
                                        id="password" 
                                        type="password" 
                                        name="password" 
                                        required 
                                        autocomplete="new-password" 
                                        class="block w-full pl-12 rounded-lg border-gray-300 shadow-sm transition duration-200
                                        focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50
                                        @error('password') border-red-500 bg-red-50 @enderror"
                                    />
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Şifre Tekrarı</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input 
                                        id="password_confirmation" 
                                        type="password" 
                                        name="password_confirmation" 
                                        required 
                                        autocomplete="new-password" 
                                        class="block w-full pl-12 rounded-lg border-gray-300 shadow-sm transition duration-200
                                        focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                                    />
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <button 
                                    type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md 
                                    text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700
                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 transform hover:-translate-y-0.5"
                                >
                                    Şifreyi Sıfırla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
