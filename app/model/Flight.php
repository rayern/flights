<?php

namespace App\Models;

use App\Models\Model as BaseModel;
use Database;

class Flight extends BaseModel{
    use Filterable;
    protected $table = 'users';
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'photo',
        'gender',
        'thumb',
    ];

    protected $filterable = [
        'gender',
        'fullname' => ['LIKE' => '%{fullname}%'],
    ];

    public function show(Request $request){
        $this->user->enableQueryLog();
        //$user = $this->user->select(['id', 'fullname', 'email', 'thumb'])where(['id', $request->id])->get();
        Log::info($this->user->getQueryLog());
        if (isApi()) {
            return Response::toJson($user);
        }

        return template('admin', 'admin.users.show', compact('user'));
    }
}