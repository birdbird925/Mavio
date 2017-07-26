<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Notifications\ContactMessage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'contact']]);
    }

    public function index()
    {
        return view('contact');
    }

    public function contact(Request $request)
    {
        $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required'
        ]);

        $users = User::all();
        $data = [
            'name' => request('name'),
            'email' => request('email'),
            'message' => request('message')
        ];

        foreach($users as $admin)
            $admin->notify(new ContactMessage($data));

        session()->flash('status', 'Thanks for contacting us.');
        return redirect('contact');
    }

    public function messages()
    {
        return view('admin.message.index');
    }

    public function reply($id)
    {
        $notification = DB::select('select read_at, data from notifications where id = ? LIMIT 1', [$id]);
        if($notification[0]->read_at == '')
            DB::table('notifications')
                ->where('id', $id)
                ->update(['read_at' => Carbon::now()]);

        return redirect()->back();
    }
}
