<?php

namespace App\Http\Controllers;

use App\Forms\UserForm;
use App\Helpers\ControllerHelper;
use App\Repository\UsersRepository;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    use ControllerHelper;

    /**
     * @var UsersRepository
     */
    private $UsersRepository;

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->UsersRepository = app(UsersRepository::class);
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view("users.index", [
            "title" => "Користувачі",
            "card_title" => "Користувачі",
            "dataTable" => $this->UsersRepository->getAll(),
        ]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return Factory|View
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(UserForm::class, [
            "method" => "POST",
            "url" => route("users.store")
        ]);

        $form->remove(["avatar"]);

        return view($this->__DefaultFormView, [
            "title" => "Стоврення користувача",
            "card_title" => "Стоврення користувача",
            "form" => $form,
        ]);
    }


    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        Validator::make($request->input(), ["name" => "required", "email" => "required|email|unique:users,email", "password" => "required|confirmed"])->validate();

        $result = $user->store($request->except(["_token", "password_confirmation"]));
        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return Factory|View
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $model = $this->UsersRepository->getForEdit($id);
        $form = $formBuilder->create(UserForm::class, [
            "method" => "PUT",
            "url" => route("users.update", $id),
            "model" => $model
        ]);

        $form->remove(["password", "password_confirmation"]);

        return view($this->__DefaultFormView, [
            "title" => "Редагування користувача - " . $model->name,
            "card_title" => "Редагування користувача - " . $model->name,
            "form" => $form,
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        Validator::make($request->input(), ["name" => "required", "email" => "required|email|unique:users,email, $id"])->validate();

        $UserModel = new User();

        if ($request->has("avatar")) {
            $UserModel->upload_avatar($id, $request->file("avatar"));
        }

        $result = $UserModel->store($request->except(["_token", "password_confirmation"]), $id);
        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return Factory|View
     */
    public function resetPasswordForm($id, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(UserForm::class, [
            "method" => "POST",
            "url" => route("users.resetPassword", $id),
        ]);
        $form->remove(["email", "name", "avatar"]);

        $user = User::whereId($id)->first();

        return view($this->__DefaultFormView, [
            "title" => "Заміна паролю користувачу - " . $user->name,
            "card_title" => "Заміна паролю користувачу - " . $user->name,
            "form" => $form,
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function resetPassword($id, Request $request, User $user)
    {
        Validator::make($request->input(), ["password" => "required|confirmed"])->validate();

        $result = $user->store($request->except(["_token", "password_confirmation"]), $id);
        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $CoefficientModel = User::find($id);
        $result = $CoefficientModel->delete();

        return $this->resultRedirect($result);
    }
}
