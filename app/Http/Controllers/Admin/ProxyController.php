<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProxyRequest;
use App\Models\Proxy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    use AdminAccessMiddleware;

    public function __construct()
    {
        $this->middleware($this->makeIsAdminMiddleware())->except('index');
    }

    public function index()
    {
        $proxies = Proxy::all();

        return view('admin.proxy.index', compact('proxies'));
    }

    public function createForm()
    {
        return view('admin.proxy.create');
    }

    public function editForm(Proxy $proxy)
    {
        return view('admin.proxy.edit', compact('proxy'));
    }

    public function create(StoreProxyRequest $request)
    {

        $proxy = new Proxy();
        $proxy->fill(array_merge($request->validated(), [
            'auth' => $request->has('auth'),
        ]));

        if (!$this->checkProxy($proxy)) {
            return back()->withInput()->with('message', [
                'type' => 'error',
                'content' => 'Proxy is not working'
            ]);
        }

        $proxy->save();

        return redirect()->route('admin.proxy')
            ->with('message', [
                'type' => 'success',
                'content' => 'Proxy created successfully',
            ]);
    }

    public function update(Proxy $proxy, StoreProxyRequest $request)
    {
        $proxy->fill(array_merge($request->validated(), [
            'auth' => $request->has('auth'),
        ]));

        if (!$this->checkProxy($proxy)) {
            return back()->withInput()->with('message', [
                'type' => 'error',
                'content' => 'Proxy is not working'
            ]);
        }

        $proxy->save();

        return redirect()->route('admin.proxy')
            ->with('message', [
                'type' => 'success',
                'content' => 'Proxy updated successfully',
            ]);
    }

    public function toggleProxyStatus(Proxy $proxy)
    {
        if (!$this->checkProxy($proxy)) {
            return back()->withInput()->with('message', [
                'type' => 'error',
                'content' => 'Proxy is not working'
            ]);
        }

        $proxy->update([
            'enabled' => !$proxy->enabled,
        ]);

        return redirect()->route('admin.proxy')
            ->with('message', [
                'type' => 'success',
                'content' => 'Proxy status updated successfully',
            ]);
    }

    public function destroy(Proxy $proxy)
    {
        $proxy->delete();

        return redirect()->route('admin.proxy')
            ->with('message', [
                'type' => 'success',
                'content' => 'Proxy deleted successfully',
            ]);
    }

    public function checkProxy(Proxy $proxy): bool
    {
        try {
            $response = Http::timeout(10)
                ->withOptions([
                    'proxy' => $proxy->toUrl()
                ])
                ->get('http://lumtest.com/myip.json');

            $body = $response->json();

            return $response->ok() && !is_null($body) && Arr::has($body, 'ip');

        } catch (Exception $e) {
            return false;
        }
    }
}
