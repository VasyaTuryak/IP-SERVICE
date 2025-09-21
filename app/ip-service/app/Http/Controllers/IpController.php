<?php

namespace App\Http\Controllers;

use App\Exports\IpAddressExport;
use App\Http\Requests\IpAddressRequest;
use App\Models\IpAddress;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\IpAddress as IpAddressResource;

class IpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return IpAddressResource::collection(IpAddress::paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IpAddressRequest $request)
    {

        $ipAddress = $request->input('ip');

        if (IpAddress::where('ip', $ipAddress)->exists()) {
            return response()->json(['message' => 'this IP address already exist']);
        }

        $response = Http::get(
            "http://ip-api.com/json/{$ipAddress}?fields=status,query,country,city"
        )->json($key = null, $default = null);

        if ($response['status'] === 'success') {

            $newIp = new IpAddress();
            $newIp->ip = $ipAddress;
            $newIp->country = $response['country'];
            $newIp->city = $response['city'];
            $newIp->save();

            return response()->json([
                'message' => 'The IP address is successfully saved.',
                'data' => $response
            ]);
        } else {
            return response()->json(['error' => $response], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(IpAddressRequest $request)
    {
        $ipAddress = $request->input('ip');
        $ipCollection = IpAddress::firstWhere('ip', $ipAddress);

        if ($ipCollection) {
            return new IpAddressResource($ipCollection);
        } else {
            return response()->json(['error' => 'This IP address does not exist in data base.'], 401);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IpAddressRequest $request, string $id)
    {
        $newIpAddress=$request->ip;

        if (IpAddress::where('ip', $newIpAddress)->exists()) {
            return response()->json(['message' => 'This IP address already exist']);
        }

        $response = Http::get(
            "http://ip-api.com/json/{$newIpAddress}?fields=status,query,country,city"
        )->json($key = null, $default = null);

        if ($response['status'] === 'success') {

            $UpdatedIp = IpAddress::find($id);
            $UpdatedIp ->ip = $newIpAddress;
            $UpdatedIp ->country = $response['country'];
            $UpdatedIp ->city = $response['city'];
            $UpdatedIp ->save();

            return response()->json([
                'message' => 'The IP address is successfully updated',
                'data' => $response
            ]);
        } else {
            return response()->json(['error' => $response], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ip)
    {
        $ipCollection = IpAddress::firstWhere('ip', $ip);

        if ($ipCollection) {
            $ipCollection->delete();
            return response()->json(['message' => "IP address {$ip} successfully was deleted"]);
        } else {
            return response()->json(['error' => 'This IP address does not exist in data base.'], 401);
        }
    }

    public function export()
    {
        return Excel::download(new IpAddressExport, 'IpAddresses-' . now()->format('Y-m-d H:i:s') . '-.xlsx');
    }
}
