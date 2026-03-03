<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wallet Management') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
 
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
 
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
 
            <!-- Info Enkripsi -->
            <div class="mb-6 bg-blue-50 dark:bg-blue-900/50 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">🔒 Informasi Enkripsi</h3>
                <p class="text-sm text-blue-800 dark:text-blue-200">
                    Virtual Account dan Balance dienkripsi menggunakan AES-256-CBC encryption.
                    Data akan otomatis dienkripsi saat disimpan dan didekripsi saat ditampilkan.
                </p>
                <a href="{{ route('wallet.debug') }}"
                    class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800 underline">
                    Lihat Debug Info (Enkripsi/Dekripsi)
                </a>
            </div>
 
            @if ($wallet)
                <!-- Display existing wallet -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Wallet Anda
                        </h3>
 
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Virtual Account Number (Decrypted)
                                </label>
                                <p
                                    class="mt-1 text-lg font-mono text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                    {{ $wallet->virtual_account }}
                                </p>
                            </div>
 
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Balance (Decrypted)
                                </label>
                                <p
                                    class="mt-1 text-lg font-mono text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                    Rp {{ number_format($wallet->balance, 2, ',', '.') }}
                                </p>
                            </div>
 
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Encrypted At
                                </label>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $wallet->encrypted_at ? $wallet->encrypted_at->format('d M Y H:i:s') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
 
                <!-- Update Form -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Update Wallet
                        </h3>
 
                        <form method="POST" action="{{ route('wallet.update') }}">
                            @csrf
                            @method('PATCH')
 
                            <div class="mb-4">
                                <label for="virtual_account"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Virtual Account Number
                                </label>
                                <input type="text" name="virtual_account" id="virtual_account"
                                    value="{{ old('virtual_account', $wallet->virtual_account) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                            </div>
 
                            <div class="mb-4">
                                <label for="balance"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Balance
                                </label>
                                <input type="number" name="balance" id="balance"
                                    value="{{ old('balance', $wallet->balance) }}" step="0.01" min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                            </div>
 
                            <div class="flex items-center gap-4">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
 
                <!-- Delete Form -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Hapus Wallet
                        </h3>
 
                        <form method="POST" action="{{ route('wallet.destroy') }}"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus wallet?');">
                            @csrf
                            @method('DELETE')
 
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Hapus Wallet
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Create Form -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Buat Wallet Baru
                        </h3>
 
                        <form method="POST" action="{{ route('wallet.store') }}">
                            @csrf
 
                            <div class="mb-4">
                                <label for="virtual_account"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Virtual Account Number
                                </label>
                                <input type="text" name="virtual_account" id="virtual_account"
                                    value="{{ old('virtual_account') }}" placeholder="Contoh: 8887700001234567"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Masukkan nomor virtual account yang akan dienkripsi dengan AES-256
                                </p>
                            </div>
 
                            <div class="mb-4">
                                <label for="balance"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Balance (Saldo Awal)
                                </label>
                                <input type="number" name="balance" id="balance" value="{{ old('balance', '0') }}"
                                    step="0.01" min="0" placeholder="0.00"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Masukkan saldo awal yang akan dienkripsi dengan AES-256
                                </p>
                            </div>
 
                            <div class="flex items-center gap-4">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Buat Wallet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>