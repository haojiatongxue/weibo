<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        // 除了此处指定的动作('show','create','store')以外，所有其他动作都必须登录用户才能访问
        $this->middleware('auth',[
            'except' => ['show','create','store','index']
        ]);

        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|unique:users,name|max:50',
            'email'=>'required|email|unique:users,email|max:255',
            'password'=>'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开启一段新的旅程～');
        return redirect()->route('users.show',[$user]);
    }

    public function index(){
        // $users = User::all();
        $users = User::paginate(6);
        return view('users.index',compact('users'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update',$user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'required|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','个人资料更新成功！');

        // $user->update([
        //     'name' => $request->name,
        //     'password' => bcrypt($request->password),
        // ]);

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        // 对删除操作进行授权验证
        $this->authorize('destroy',$user);
        
        // 可以的话则进行删除操作
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
    }
}
