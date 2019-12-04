<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $tasks = $user->tasks()->orderBy('created_at','desc')->paginate(10);
        
        $data = [
            'user' =>$user,
            'tasks' => $tasks,
        ];
        
        $data += $this->counts($user);
        
        return view('users.show', $data);
    }
}
