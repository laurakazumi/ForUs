<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\DonationItem;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function create()
    {
        return view('campaign.create');
    }

    public function campanhas()
    {
        return view('campaign.campanhas');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cep' => 'required',
            'numero' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'campaignName' => 'required',
            'donationType' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'donationItems' => 'required|array|min:1',
            'donationItems.*' => 'required|string',
        ]);

        $campaign = Campaign::create($request->all());

        foreach ($request->donationItems as $item) {
            DonationItem::create([
                'campaign_id' => $campaign->id,
                'item_name' => $item,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Campanha criada com sucesso!');
    }

    public function edit($id)
    {
        $campaign = Campaign::with('donationItems')->find($id);

        if (!$campaign) {
            return redirect()->route('dashboard')->with('error', 'Campanha não encontrada!');
        }

        return view('campaign.edit', compact('campaign'));
    }

    public function expandir($id)
    {
        $campaign = Campaign::with('donationItems')->find($id);

        if (!$campaign) {
            return redirect()->route('dashboard')->with('error', 'Campanha não encontrada!');
        }

        return view('campaign.expandir', compact('campaign'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cep' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'complemento' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'campaignName' => 'required',
            'donationType' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'donationItems' => 'required|array',
            'donationItems.*' => 'required|string'
        ]);

        $campaign = Campaign::findOrFail($id);
        $campaign->update($data);

        // Atualizar ou criar itens de doação
        DonationItem::where('campaign_id', $campaign->id)->delete();
        foreach ($data['donationItems'] as $item) {
            DonationItem::create([
                'campaign_id' => $campaign->id,
                'item_name' => $item
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Campanha atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $campaign = Campaign::with('donationItems')->find($id);

        if (!$campaign) {
            return redirect()->route('dashboard')->with('error', 'Campanha não encontrada!');
        }

        // Deletar os itens de doação associados
        foreach ($campaign->donationItems as $item) {
            $item->delete();
        }

        // Deletar a campanha
        $campaign->delete();

        return redirect()->route('dashboard')->with('success', 'Campanha deletada com sucesso!');

    }
}
