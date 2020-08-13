<?php


namespace App\Helpers;


trait ControllerHelper
{

    private $__DefaultFormView  = "layouts.simples.simple_form";

    /**
     * @param $result
     * @param null $successMessage
     * @param null $errorMessage
     * @return \Illuminate\Http\RedirectResponse
     */
    private function resultRedirect($result, $successMessage = null, $errorMessage = null)
    {
        $successMessage = ($successMessage === null) ? trans("basic.messages.success") : $successMessage;
        $errorMessage = ($errorMessage === null) ? [trans("basic.messages.error")] : $errorMessage;

        return ($result)
            ? redirect()->back()->with("message", $successMessage)
            : redirect()->back()->withErrors($errorMessage);
    }
}
