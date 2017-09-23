<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\user;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        
        return view('users.index', [
            'users' => $users,
            ]);
    }
    public function show($id)
    {
        
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        $count_microposts = $user->microposts()->count();
        
        $data = [
            'user' => $user,
            'microposts' => $microposts,
            ];
            
        $data += $this->counts($user);
        
        return view('users.show', $data);
    }
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);
        
        $data = [
            'user' => $user,
            'users' => $followings,
        ];
        
        $data += $this->counts($user);
        
        return view('users.followings', $data);
    }
    
    public function followers($id)
    {
        
        
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);
        
        
        $data = [
            
            'user' => $user,
            'users' => $followers,
        ];
        
        $data += $this->counts($user);
        
        return view('users.followers', $data);
    }
    
    
    //追加：お気に入りリスト
    public function favors($id)
    {
        $user = User::find($id);
        $microposts = $user->favors()->paginate(10);
        
        //ダメだった$microposts = $favors->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
        
       
        $data = [
            'user' => $user,
            'microposts' => $microposts,
            //ダメだった'microposts' => $microposts,
        ];
        
        // ↑をmicropostsに変更したら、users/favors.blade.phpでも呼び出す際の変数名を変更する必要あり
        
        // タブの中のバッジのカウント数を表示させるための処理
        $data += $this->counts($user);
        
        return view('users.favors', $data);
    }
    
}