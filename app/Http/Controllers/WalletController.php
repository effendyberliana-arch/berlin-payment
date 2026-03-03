<?php
 
namespace App\Http\Controllers;
 
use App\Models\Wallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
 
class WalletController extends Controller
{
    /**
     * Display form untuk membuat wallet
     */
    public function index(Request $request): View
    {
        $wallet = Wallet::where('user_id', $request->user()->id)->first();
 
        return view('wallet.index', [
            'wallet' => $wallet,
        ]);
    }
 
    /**
     * Store wallet baru dengan enkripsi
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'virtual_account' => ['required', 'string', 'max:255'],
            'balance' => ['required', 'numeric', 'min:0'],
        ]);
 
        // Cek apakah user sudah punya wallet
        $existingWallet = Wallet::where('user_id', $request->user()->id)->first();
 
        if ($existingWallet) {
            return back()->with('error', 'Anda sudah memiliki wallet');
        }
 
        // Buat wallet baru (akan otomatis terenkripsi melalui mutator)
        $wallet = Wallet::create([
            'user_id' => $request->user()->id,
            'virtual_account' => $validated['virtual_account'],
            'balance' => $validated['balance'],
        ]);
 
        return redirect()->route('wallet.index')->with('success', 'Wallet berhasil dibuat');
    }
 
    /**
     * Update wallet
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'virtual_account' => ['required', 'string', 'max:255'],
            'balance' => ['required', 'numeric', 'min:0'],
        ]);
 
        $wallet = Wallet::where('user_id', $request->user()->id)->firstOrFail();
 
        // Update akan otomatis mengenkripsi data melalui mutator
        $wallet->update([
            'virtual_account' => $validated['virtual_account'],
            'balance' => $validated['balance'],
        ]);
 
        return redirect()->route('wallet.index')->with('success', 'Wallet berhasil diperbarui');
    }
 
    /**
     * Hapus wallet
     */
    public function destroy(Request $request): RedirectResponse
    {
        $wallet = Wallet::where('user_id', $request->user()->id)->firstOrFail();
        $wallet->delete();
 
        return redirect()->route('wallet.index')->with('success', 'Wallet berhasil dihapus');
    }
 
    /**
     * Show debugging info untuk melihat enkripsi/dekripsi
     */
    public function debug(Request $request): View
    {
        $wallet = Wallet::where('user_id', $request->user()->id)->first();
 
        $debugInfo = null;
        if ($wallet) {
            $debugInfo = [
                'decrypted' => [
                    'virtual_account' => $wallet->virtual_account,
                    'balance' => $wallet->balance,
                ],
                'encrypted' => [
                    'virtual_account' => $wallet->getRawVirtualAccount(),
                    'balance' => $wallet->getRawBalance(),
                ],
                'encrypted_at' => $wallet->encrypted_at?->format('Y-m-d H:i:s'),
            ];
        }
 
        return view('wallet.debug', [
            'wallet' => $wallet,
            'debugInfo' => $debugInfo,
        ]);
    }
}