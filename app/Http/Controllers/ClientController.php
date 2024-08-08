<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\ClientController as PassportClientController;
use Laravel\Passport\Passport;

class ClientController extends PassportClientController
{
    // Get all of the clients for the authenticated user.
    public function forUser(Request $request)
    {
        $userId = $request->user()->getAuthIdentifier();

        $clients = $this->clients->activeForUser($userId);

        if (Passport::$hashesClientSecrets) {
            return $clients;
        }

        return view('admin.clients.index', compact('clients'));
    }

    // Redirect to create client page.
    public function create()
    {
        return view('admin.clients.create');
    }

    // Store a new client.
    public function store(Request $request)
    {
        $this->validation->make($request->all(), [
            'name' => 'required|max:191',
            'redirect' => ['required', $this->redirectRule],
            'confidential' => 'boolean',
        ])->validate();

        $client = $this->clients->create(
            $request->user()->getAuthIdentifier(),
            $request->name,
            $request->redirect,
            null,
            false,
            false,
            (bool) $request->input('confidential', true)
        );

        if (Passport::$hashesClientSecrets) {
            return ['plainSecret' => $client->plainSecret] + $client->toArray();
        }

        return redirect()->route('admin.clients.index')->with('success', 'Client creato correttamente');
    }

    // Delete the given client.
    public function destroy(Request $request, $clientId)
    {
        $client = $this->clients->findForUser($clientId, $request->user()->getAuthIdentifier());

        if (!$client) {
            return redirect()->route('admin.clients.index')->withErrors('Errore, client non trovato!');
        }

        $this->clients->delete($client);

        return redirect()->route('admin.clients.index')->with('success', 'Client eliminato correttamente!');
    }
}
