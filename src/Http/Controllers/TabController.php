<?php

namespace Selene\Modules\BookingModule\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\BookingModule\Http\Requests\StoreBookingTabRequest;
use Selene\Modules\BookingModule\Http\Requests\UpdateBookingTabRequest;
use Selene\Modules\BookingModule\Models\Tab;
use Selene\Modules\DashboardModule\ZdrojowaTable;

/**
 * Class BookingController
 * @package Selene\Modules\BookingModule\Http\Controllers
 */
class TabController extends Controller
{
    public function index()
    {
        return view('BookingModule::tabs.index');
    }

    public function ajax(Request $request)
    {
        return ZdrojowaTable::response(Tab::query(), $request);
    }

    public function add()
    {
        return view('BookingModule::tabs.edit');
    }

    public function edit(Tab $tab)
    {
        return view('BookingModule::tabs.edit', ['tab' => $tab]);
    }

    public function store(StoreBookingTabRequest $request)
    {
        $tab = $this->save($request);
        if ($tab) {
            $request->session()->flash('alert-success', 'Pomyślnie dodano nową zakładkę w booking engine!');
            return redirect()->route('BookingModule::editTab', ['tab' => $tab]);
        }

        $request->session()->flash('alert-error', 'Ooops. Try again.');
        return redirect()->back();
    }

    public function update(UpdateBookingTabRequest $request, Tab $tab)
    {
        if ($this->save($request, $tab)) {
            $request->session()->flash('alert-success', 'Pomyślnie zaktualizowano zakładkę!');
        } else {
            $request->session()->flash('alert-error', 'Ooops. Try again.');
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param Tab|null $tab
     * @return bool|Tab
     */
    private function save(Request $request, Tab $tab = null)
    {
        if ($request->has('logo_file')) {
            $file     = $request->file('logo_file');
            $filename = md5(uniqid($file->getClientOriginalName(), true));
            $path     = $file->move(
                'storage/booking/tabs/',
                $filename . '.' . $file->getClientOriginalExtension()
            )->getPathName();

            $request->merge(['logo' => $path]);
        }

        $request->merge(['post' => $request->has('post')]);

        if ($tab === null) {
            return Tab::create($request->all());
        }
        return $tab->update($request->all());
    }

    public function destroy(Tab $tab, Request $request)
    {
        try {
            $tab->delete();
            $request->session()->flash('alert-success', 'Zakładka is deleted');
        } catch (Exception $e) {
            $request->session()->flash('alert-error', 'Error: ' . $e->getMessage());
        }
    }
}
