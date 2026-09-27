<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::with('user')->get();
        return view('admin.customer.index', compact('customer'));
    }
    public function create()
    {
        return view('admin.customer.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
        ]);
        Customer::create([
            'id_user' => $user->id,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ]);
        return redirect()->route('customer.index')
            ->with('success', 'Create data baru berhasil!!');
    }
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.show', compact('customer'));
    }
    public function edit($id)
    {
        $customer = Customer::with('user')->findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
    }
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required',
            'alamat' => 'required',
        ]);
        $customer->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $customer->update([
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);
        return redirect()->route('customer.index')
            ->with('success', 'Data customer berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $user = $customer->user;
        $nama = $user->name;
        $customer->delete();
        if ($user) {
            $user->delete();
        }
        return redirect()->route('customer.index')
            ->with('success', 'Data customer berhasil dihapus');
    }
}