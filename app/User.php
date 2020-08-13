<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function store($data, $id = null) {
        $model = clone  $this;

        if ($id != null) {
            $model = $this->where("id", $id)->first();
        }

        if (isset($data["password"])) {
            $data["password"] = Hash::make($data["password"]);
        }

        $model->fill($data);
        return $model->save();
    }

    public function upload_avatar ($id, UploadedFile $file) {
        $fileName = $id.".".$file->extension();
        $path = Storage::disk("local")-> putFileAs(config("my.users.avatar.path"), $file, $fileName);

        $user = $this->where("id", $id)->first();
        $user->avatar = $path;
        return $user->save();
    }

    public function adminlte_image()
    {
        if (!session()->has("user.avatar")) {
            $avatar = User::whereId(Auth::id())->first();
            session(["user.avatar" => $avatar->avatar]);
        }
        return Storage::url(session()->get("user.avatar"));
    }

}
