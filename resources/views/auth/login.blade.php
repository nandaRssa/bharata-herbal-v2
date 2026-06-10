<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 font-semibold text-sm text-emerald-800 bg-emerald-50 border border-emerald-100 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full border border-slate-200 rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 transition duration-200 bg-slate-50/50 focus:bg-white text-slate-800 font-medium placeholder-slate-400" placeholder="admin@bharata.id">
            </div>
            @if($errors->has('email'))
                <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full border border-slate-200 rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 transition duration-200 bg-slate-50/50 focus:bg-white text-slate-800 font-medium placeholder-slate-400" placeholder="••••••••">
            </div>
            @if($errors->has('password'))
                <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative flex items-center justify-center w-5 h-5 rounded border border-slate-300 bg-white group-hover:border-emerald-500 transition-colors">
                    <input id="remember_me" type="checkbox" name="remember" class="peer sr-only">
                    <svg class="w-3.5 h-3.5 text-white bg-emerald-600 rounded-sm opacity-0 peer-checked:opacity-100 transition-opacity absolute inset-0 m-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="ms-3 text-sm font-medium text-slate-600 select-none">Ingat saya di perangkat ini</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 rounded-xl font-bold text-white text-sm shadow-lg shadow-emerald-900/20 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex justify-center items-center gap-2" style="background: var(--primary);">
                Masuk ke Dashboard
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </form>
</x-guest-layout>
