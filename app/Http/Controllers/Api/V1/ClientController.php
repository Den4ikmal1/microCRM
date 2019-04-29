<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\ClientCreateRequest;
use App\Http\Requests\Clients\ClientUpdateRequest;
use App\Models\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index()
    {
        return Client::paginate();
    }

    public function show(Client $client)
    {
        return $client;
    }

    public function store(ClientCreateRequest $request)
    {
        return Client::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    public function update(ClientUpdateRequest $request, Client $client)
    {
        $client->fill($request->except(['password']));
        if (Arr::get($request->all(), 'password'))
            $client->password = Hash::make($request->password);
        $client->save();
        return $client;
    }

    public function delete(Client $client)
    {
        if($client->delete())
            return response()->json([], 204);
    }
}