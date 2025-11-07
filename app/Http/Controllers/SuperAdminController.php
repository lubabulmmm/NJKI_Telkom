<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Bandwidth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\InvestmentArchive;

class SuperadminController extends Controller
{
    // Show all bandwidth data with pagination and search functionality
    public function showBandwidthData(Request $request)
{
    $perPage = $request->get('perPage', 15);
    $page = $request->get('page', 1);
    $search = $request->get('search', '');

    // Get all items with their bandwidths, ordered by item name and bandwidth value
    $itemsQuery = Item::with(['bandwidths' => function($query) {
        $query->orderBy('bw', 'asc');
    }])
    ->orderBy('nama_barang', 'asc');

    // Apply search filter if provided
    if (!empty($search)) {
        $itemsQuery->where(function($query) use ($search) {
            // Search in item name
            $query->where('nama_barang', 'like', '%' . $search . '%')
                  // Or search in bandwidth values
                  ->orWhereHas('bandwidths', function($q) use ($search) {
                      $q->where('bw', 'like', '%' . $search . '%')
                        ->orWhere('price', 'like', '%' . $search . '%');
                  });
        });
    }

    $items = $itemsQuery->get();

    // Flatten the collection to get all bandwidth entries
    $allBandwidths = collect();
    foreach ($items as $item) {
        foreach ($item->bandwidths as $bandwidth) {
            $allBandwidths->push([
                'item' => $item,
                'bandwidth' => $bandwidth
            ]);
        }
    }

    // Filter the collection based on search if needed (additional client-side filtering)
    if (!empty($search)) {
        $allBandwidths = $allBandwidths->filter(function($entry) use ($search) {
            return stripos($entry['item']->nama_barang, $search) !== false ||
                   stripos($entry['bandwidth']->bw, $search) !== false ||
                   stripos($entry['bandwidth']->price, $search) !== false;
        });
    }

    // Sort the flattened collection by item name first, then by bandwidth value
    $sortedBandwidths = $allBandwidths->sortBy([['item.nama_barang', 'asc'], ['bandwidth.bw', 'asc']]);

    // Create a paginator for the sorted bandwidth collection
    $offset = ($page - 1) * $perPage;
    $bandwidthPaginator = new LengthAwarePaginator(
        $sortedBandwidths->slice($offset, $perPage)->values(),
        $sortedBandwidths->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('superadmin.bandwidth.index', [
        'bandwidthItems' => $bandwidthPaginator,
        'perPage' => $perPage,
        'request' => $request,
        'search' => $search
    ]);
}

    // Show form to add bandwidth for a specific item
    public function create()
    {
        // Get all items to display in the dropdown for selecting an item
        $items = Item::all();
        return view('superadmin.bandwidth.create', compact('items'));
    }

    // Store new bandwidth in the database
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'item_id' => 'required|exists:items,id',  // Ensure item exists
            'bw' => 'required|integer',
            'price' => 'required|integer',
        ]);

        // Create a new Bandwidth record
        $bandwidth = new Bandwidth();
        $bandwidth->item_id = $request->item_id;
        $bandwidth->bw = $request->bw;
        $bandwidth->price = $request->price;
        $bandwidth->created_at = now();
        $bandwidth->updated_at = now();
        $bandwidth->save();

        // Redirect back to the bandwidth list with a success message
        return redirect()->route('superadmin.bandwidth')->with('success', 'Data Bandwidth berhasil ditambahkan!');
    }
// Show form to edit bandwidth data for a specific item
// Show form to edit bandwidth data for a specific item
public function edit($itemId, $bandwidthId)
{
    // Fetch the item and bandwidth based on their IDs
    $item = Item::findOrFail($itemId);
    $bandwidth = Bandwidth::findOrFail($bandwidthId);

    // Get all items to populate the item dropdown
    $items = Item::all();

    // Pass the data to the view
    return view('superadmin.bandwidth.edit', compact('item', 'bandwidth', 'items'));
}


public function update(Request $request, $itemId, $bandwidthId)
{
    // Validate the form data
    $request->validate([
        'bw' => 'required|integer',
        'price' => 'required|integer',
        'item_id' => 'required|exists:items,id',  // Ensure the item exists
    ]);

    // Fetch the bandwidth record to update
    $bandwidth = Bandwidth::findOrFail($bandwidthId);

    // Update the bandwidth record with the new values
    $bandwidth->bw = $request->bw;
    $bandwidth->price = $request->price;
    $bandwidth->item_id = $request->item_id; // Ensure the item_id is updated as well
    $bandwidth->save();  // Save the updated bandwidth record

    // Redirect back with a success message
    return redirect()->route('superadmin.bandwidth')->with('success', 'Bandwidth updated successfully!');
}

public function delete($itemId, $bandwidthId)
{
    // Find the bandwidth record to delete
    $bandwidth = Bandwidth::findOrFail($bandwidthId);
    // Ensure the bandwidth belongs to the specified item
    if ($bandwidth->item_id != $itemId) {
        return redirect()->route('superadmin.bandwidth')->with('error', 'Invalid bandwidth record!');
    }
    // Delete the bandwidth record
    $bandwidth->delete();

    // Redirect back with a success message
    return redirect()->route('superadmin.bandwidth')->with('success', 'Bandwidth deleted successfully!');
}

    // Show all user data with pagination
    public function showUserData(Request $request)
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');

        // Fetch all users with pagination and search filter
        $usersQuery = User::whereRaw('LOWER(role) != ?', ['superadmin']);

        if (!empty($search)) {
            $usersQuery->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        $users = $usersQuery->orderBy('name', 'asc')->paginate($perPage);

        return view('superadmin.users.index', [
            'users' => $users,
            'search' => $search,
            'perPage' => $perPage
        ]);
    }

    public function showAddUserForm()
    {
        return view('superadmin.users.create');
    }

    // Store a new user in the database
public function storeUser(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Create the new user with role fixed to 'user' without any possibility to change
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => 'user', // Role is hardcoded as 'user'
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('superadmin.users')->with('success', 'User added successfully.');
}

// SuperadminController.php

public function editUser($id)
{
    // Fetch the user to edit
    $user = User::findOrFail($id);

    // Pass the user data to the edit view
    return view('superadmin.users.edit', compact('user'));
}

public function updateUser(Request $request, $id)
{
    // Validate the updated data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Find the user and update their data
    $user = User::findOrFail($id);
    $user->name = $request->name;
    $user->email = $request->email;
    // Role remains unchanged as 'user'

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('superadmin.users')->with('success', 'User updated successfully.');
}

// Delete a user
public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('superadmin.users')->with('success', 'User deleted successfully.');
}

    // Show all items data with pagination and search
    public function showItemsData(Request $request)
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');

        $itemsQuery = Item::query();
        if (!empty($search)) {
            $itemsQuery->where('nama_barang', 'like', '%' . $search . '%');
        }

        $items = $itemsQuery->orderBy('nama_barang', 'asc')->paginate($perPage);

        return view('superadmin.items.index', [
            'items' => $items,
            'search' => $search,
            'perPage' => $perPage
        ]);
    }

    // Show form to create a new item
    public function showAddItemForm()
    {
        return view('superadmin.items.create');
    }

    // Store new item in the database
    public function storeItem(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
        ]);

        Item::create([
            'nama_barang' => $validatedData['nama_barang'],
        ]);

        return redirect()->route('superadmin.items')->with('success', 'Item added successfully.');
    }

    // Show the form for editing an existing item
    public function showEditItemForm($id)
    {
        $item = Item::findOrFail($id);
        return view('superadmin.items.edit', compact('item'));
    }

    // Update the item
    public function updateItem(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
        ]);

        $item = Item::findOrFail($id);
        $item->update([
            'nama_barang' => $validatedData['nama_barang'],
        ]);

        return redirect()->route('superadmin.items')->with('success', 'Item updated successfully.');
    }

    // Delete an item
    public function deleteItem($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('superadmin.items')->with('success', 'Item deleted successfully.');
    }

    public function showDashboard()
    {
        // Fetch the count of all users excluding superadmins
        $usersCount = User::where('role', '!=', 'superadmin')->count();
        $itemsCount = Item::count();
        $bandwidthsCount = Bandwidth::count();
        // Return the dashboard view with the users count
        return view('superadmin.dashboard', [
            'usersCount' => $usersCount,  // Pass the number of users to the view
            'itemsCount' => $itemsCount,  // Pass the number of items to the view
            'bandwidthsCount' => $bandwidthsCount,
            'calculationsCount' => InvestmentArchive::count(), // Pastikan ini ada
        'viableCount' => InvestmentArchive::where('is_viable', true)->count(),
        'nonViableCount' => InvestmentArchive::where('is_viable', false)->count(),
        'recentCalculations' => InvestmentArchive::with('user')
            ->latest()
            ->take(5)
            ->get()  // Pass the number of bandwidths to the view
        ]);
    }
}
